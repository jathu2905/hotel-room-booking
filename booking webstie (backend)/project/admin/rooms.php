<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
   exit();
}

// Add Room logic
if(isset($_POST['add_room'])){
   $id = create_unique_id();
   $name = clean_input($_POST['name']);
   $type = clean_input($_POST['type']);
   $price = clean_input($_POST['price']);
   $description = clean_input($_POST['description']);
   $capacity_adults = clean_input($_POST['capacity_adults']);
   $capacity_childs = clean_input($_POST['capacity_childs']);
   $total_rooms = clean_input($_POST['total_rooms']);
   $amenities = clean_input($_POST['amenities']);
   $status = 'available';

   // Image Upload Handler
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = create_unique_id().'.'.$ext;
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_size = $_FILES['image']['size'];
   $image_folder = '../images/'.$rename;

   // Check if room name exists already
   $verify_room = $conn->prepare("SELECT * FROM `rooms` WHERE name = ?");
   $verify_room->execute([$name]);

   if($verify_room->rowCount() > 0){
      $warning_msg[] = 'Room name already exists!';
   }else{
      if($image_size > 5000000){
         $warning_msg[] = 'Image size is too large (Max 5MB)!';
      }else{
         $insert_room = $conn->prepare("INSERT INTO `rooms` (id, name, type, price, image, description, capacity_adults, capacity_childs, total_rooms, amenities, status) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
         $insert_room->execute([$id, $name, $type, $price, $rename, $description, $capacity_adults, $capacity_childs, $total_rooms, $amenities, $status]);
         move_uploaded_file($image_tmp_name, $image_folder);
         $success_msg[] = 'New room added successfully!';
      }
   }
}

// Edit Room logic
if(isset($_POST['edit_room'])){
   $room_id = clean_input($_POST['room_id']);
   $name = clean_input($_POST['name']);
   $type = clean_input($_POST['type']);
   $price = clean_input($_POST['price']);
   $description = clean_input($_POST['description']);
   $capacity_adults = clean_input($_POST['capacity_adults']);
   $capacity_childs = clean_input($_POST['capacity_childs']);
   $total_rooms = clean_input($_POST['total_rooms']);
   $amenities = clean_input($_POST['amenities']);
   $status = clean_input($_POST['status']);

   $update_room = $conn->prepare("UPDATE `rooms` SET name = ?, type = ?, price = ?, description = ?, capacity_adults = ?, capacity_childs = ?, total_rooms = ?, amenities = ?, status = ? WHERE id = ?");
   $update_room->execute([$name, $type, $price, $description, $capacity_adults, $capacity_childs, $total_rooms, $amenities, $status, $room_id]);
   $success_msg[] = 'Room details updated!';

   // Optional Image update
   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   
   if(!empty($image)){
      $ext = pathinfo($image, PATHINFO_EXTENSION);
      $rename = create_unique_id().'.'.$ext;
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_size = $_FILES['image']['size'];
      $image_folder = '../images/'.$rename;

      if($image_size > 5000000){
         $warning_msg[] = 'Image size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE `rooms` SET image = ? WHERE id = ?");
         $update_image->execute([$rename, $room_id]);
         move_uploaded_file($image_tmp_name, $image_folder);
         
         // Delete old image if it was uploaded and not a default system image
         if($old_image != '' && file_exists('../images/'.$old_image) && !in_array($old_image, ['home-img-1.jpg', 'gallery-img-5.jpg', 'home-img-3.jpg', 'gallery-img-3.webp'])){
            unlink('../images/'.$old_image);
         }
         $success_msg[] = 'Room image updated!';
      }
   }
}

// Delete Room logic
if(isset($_POST['delete_room'])){
   $room_id = clean_input($_POST['room_id']);
   $room_id = filter_var($room_id, FILTER_SANITIZE_STRING);

   $select_room = $conn->prepare("SELECT * FROM `rooms` WHERE id = ? LIMIT 1");
   $select_room->execute([$room_id]);
   
   if($select_room->rowCount() > 0){
      $room_data = $select_room->fetch(PDO::FETCH_ASSOC);
      $room_image = $room_data['image'];
      
      $delete_room = $conn->prepare("DELETE FROM `rooms` WHERE id = ?");
      $delete_room->execute([$room_id]);
      
      // Delete image if not a seeded system image
      if($room_image != '' && file_exists('../images/'.$room_image) && !in_array($room_image, ['home-img-1.jpg', 'gallery-img-5.jpg', 'home-img-3.jpg', 'gallery-img-3.webp'])){
         unlink('../images/'.$room_image);
      }
      $success_msg[] = 'Room type deleted successfully!';
   }else{
      $warning_msg[] = 'Room already deleted!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Rooms Manager - Sha Stay Admin</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

<div class="admin-container">

   <!-- Add Room Form Section -->
   <section class="add-rooms" style="margin-bottom: 5rem;">
      <h1 class="heading">Add New Room Type</h1>
      <div class="form-container" style="min-height: auto;">
         <form action="" method="post" enctype="multipart/form-data" style="width: 100%; max-width: 80rem; text-align: left;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(35rem, 1fr)); gap: 2rem;">
               <div>
                  <p>Room Name <span>*</span></p>
                  <input type="text" name="name" placeholder="e.g. Deluxe Suite" required class="box">
                  
                  <p>Room Type <span>*</span></p>
                  <select name="type" required class="box" style="background: rgba(255,255,255,0.05); color: var(--text-light);">
                     <option value="Deluxe A/C">Deluxe A/C</option>
                     <option value="Standard A/C">Standard A/C</option>
                     <option value="Executive A/C">Executive A/C</option>
                     <option value="Luxury Suite">Luxury Suite</option>
                  </select>
                  
                  <p>Price per Night ($) <span>*</span></p>
                  <input type="number" name="price" placeholder="e.g. 150" required min="1" class="box">
                  
                  <p>Total Inventory Units <span>*</span></p>
                  <input type="number" name="total_rooms" placeholder="e.g. 10" required min="1" class="box">
               </div>
               <div>
                  <p>Max Adults Capacity <span>*</span></p>
                  <input type="number" name="capacity_adults" placeholder="e.g. 2" required min="1" class="box">
                  
                  <p>Max Children Capacity <span>*</span></p>
                  <input type="number" name="capacity_childs" placeholder="e.g. 1" required min="0" class="box">
                  
                  <p>Amenities (comma separated) <span>*</span></p>
                  <input type="text" name="amenities" placeholder="e.g. AC, WiFi, TV, Minibar" required class="box">
                  
                  <p>Room Image <span>*</span></p>
                  <input type="file" name="image" accept="image/*" required class="box" style="padding-top: 1rem;">
               </div>
            </div>
            <p style="margin-top: 1rem;">Description <span>*</span></p>
            <textarea name="description" placeholder="Enter short room type description..." required class="box" style="height: 10rem; resize: none;"></textarea>
            
            <input type="submit" value="add room type" name="add_room" class="btn" style="width: 100%; padding: 1.4rem; margin-top: 1rem;">
         </form>
      </div>
   </section>

   <!-- Existing Rooms Section -->
   <section class="grid">
      <h1 class="heading">Existing Rooms</h1>
      
      <div class="box-container" style="grid-template-columns: repeat(auto-fit, minmax(35rem, 1fr)); gap: 3rem;">
         <?php
            $select_rooms = $conn->prepare("SELECT * FROM `rooms`");
            $select_rooms->execute();
            if($select_rooms->rowCount() > 0){
               while($fetch_room = $select_rooms->fetch(PDO::FETCH_ASSOC)){
         ?>
         <div class="box" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
               <div style="height: 22rem; width: 100%; position: relative;">
                  <img src="../images/<?= $fetch_room['image']; ?>" alt="room thumbnail" style="height: 100%; width: 100%; object-fit: cover;">
                  <span style="position: absolute; top: 1.5rem; right: 1.5rem; background: var(--darker-bg); border: var(--glass-border); padding: 0.6rem 1.2rem; border-radius: 0.5rem; color: var(--primary-gold); font-weight: 700; font-size: 1.5rem;">
                     $<?= $fetch_room['price']; ?>/night
                  </span>
               </div>
               
               <div style="padding: 2.5rem;">
                  <h3 style="font-size: 2.4rem; color: var(--text-light); margin-bottom: 1rem;"><?= $fetch_room['name']; ?></h3>
                  <p style="font-size: 1.3rem; line-height: 1.5; color: var(--text-muted); margin-bottom: 2rem;"><?= $fetch_room['description']; ?></p>
                  
                  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 1.3rem; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 1.5rem; margin-bottom: 2rem;">
                     <p>Type: <span style="color:var(--text-light);"><?= $fetch_room['type']; ?></span></p>
                     <p>Units: <span style="color:var(--text-light);"><?= $fetch_room['total_rooms']; ?></span></p>
                     <p>Adults: <span style="color:var(--text-light);"><?= $fetch_room['capacity_adults']; ?></span></p>
                     <p>Childs: <span style="color:var(--text-light);"><?= $fetch_room['capacity_childs']; ?></span></p>
                     <p style="grid-column: 1 / -1;">Status: <span class="badge" style="background: <?= ($fetch_room['status']=='available')?'rgba(34,197,94,0.15)':'rgba(239,68,68,0.15)'; ?>; color: <?= ($fetch_room['status']=='available')?'#22c55e':'#ef4444'; ?>;"><?= $fetch_room['status']; ?></span></p>
                  </div>
               </div>
            </div>
            
            <div style="padding: 0 2.5rem 2.5rem 2.5rem; display: flex; gap: 1.5rem;">
               <!-- Edit Button toggling inline Edit form -->
               <button onclick="document.getElementById('edit_box_<?= $fetch_room['id']; ?>').style.display='block'" class="option-btn" style="flex: 1; padding: 1.2rem;"><i class="fas fa-edit"></i> Edit</button>
               
               <form action="" method="post" style="flex: 1;">
                  <input type="hidden" name="room_id" value="<?= $fetch_room['id']; ?>">
                  <button type="submit" name="delete_room" onclick="return confirm('Delete this room type?');" class="delete-btn" style="width:100%; padding: 1.2rem; margin-top:0;"><i class="fas fa-trash-alt"></i> Delete</button>
               </form>
            </div>

            <!-- Inline Overlay Modal for Editing -->
            <div id="edit_box_<?= $fetch_room['id']; ?>" style="display:none; position: fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.85); backdrop-filter:blur(8px); z-index: 2000; overflow-y: auto; padding: 4rem 2rem;">
               <div style="max-width: 75rem; margin: 4rem auto; background: var(--dark-bg); border: var(--glass-border); padding: 4rem 3rem; border-radius: 1.2rem; position: relative;">
                  <span onclick="document.getElementById('edit_box_<?= $fetch_room['id']; ?>').style.display='none'" style="position: absolute; top: 2rem; right: 2rem; font-size: 2.5rem; color: var(--text-muted); cursor: pointer;"><i class="fas fa-times"></i></span>
                  
                  <h2 style="font-size: 2.8rem; color: var(--primary-gold); margin-bottom: 3rem; text-align:center;">Edit Room: <?= $fetch_room['name']; ?></h2>
                  
                  <form action="" method="post" enctype="multipart/form-data" style="text-align: left; background:transparent; padding:0; border:none; width:100%;">
                     <input type="hidden" name="room_id" value="<?= $fetch_room['id']; ?>">
                     <input type="hidden" name="old_image" value="<?= $fetch_room['image']; ?>">
                     
                     <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr)); gap: 2rem;">
                        <div>
                           <p>Room Name</p>
                           <input type="text" name="name" value="<?= $fetch_room['name']; ?>" required class="box">
                           
                           <p>Room Type</p>
                           <select name="type" required class="box" style="background: rgba(255,255,255,0.05); color: var(--text-light);">
                              <option value="Deluxe A/C" <?= ($fetch_room['type']=='Deluxe A/C')?'selected':''; ?>>Deluxe A/C</option>
                              <option value="Standard A/C" <?= ($fetch_room['type']=='Standard A/C')?'selected':''; ?>>Standard A/C</option>
                              <option value="Executive A/C" <?= ($fetch_room['type']=='Executive A/C')?'selected':''; ?>>Executive A/C</option>
                              <option value="Luxury Suite" <?= ($fetch_room['type']=='Luxury Suite')?'selected':''; ?>>Luxury Suite</option>
                           </select>
                           
                           <p>Price per Night ($)</p>
                           <input type="number" name="price" value="<?= $fetch_room['price']; ?>" required min="1" class="box">
                           
                           <p>Total Inventory Units</p>
                           <input type="number" name="total_rooms" value="<?= $fetch_room['total_rooms']; ?>" required min="1" class="box">

                           <p>Room Status</p>
                           <select name="status" required class="box" style="background: rgba(255,255,255,0.05); color: var(--text-light);">
                              <option value="available" <?= ($fetch_room['status']=='available')?'selected':''; ?>>Available</option>
                              <option value="unavailable" <?= ($fetch_room['status']=='unavailable')?'selected':''; ?>>Unavailable</option>
                           </select>
                        </div>
                        <div>
                           <p>Max Adults Capacity</p>
                           <input type="number" name="capacity_adults" value="<?= $fetch_room['capacity_adults']; ?>" required min="1" class="box">
                           
                           <p>Max Children Capacity</p>
                           <input type="number" name="capacity_childs" value="<?= $fetch_room['capacity_childs']; ?>" required min="0" class="box">
                           
                           <p>Amenities (comma separated)</p>
                           <input type="text" name="amenities" value="<?= $fetch_room['amenities']; ?>" required class="box">
                           
                           <p>Replace Room Image (optional)</p>
                           <input type="file" name="image" accept="image/*" class="box" style="padding-top: 1rem;">
                        </div>
                     </div>
                     <p style="margin-top: 1rem;">Description</p>
                     <textarea name="description" required class="box" style="height: 10rem; resize: none;"><?= $fetch_room['description']; ?></textarea>
                     
                     <button type="submit" name="edit_room" class="btn" style="width: 100%; padding: 1.4rem; margin-top: 1rem;">save updates</button>
                  </form>
               </div>
            </div>
         </div>
         <?php
               }
            } else {
               echo '<p class="empty" style="text-align:center; width:100%; font-size:1.8rem;">No rooms added yet!</p>';
            }
         ?>
      </div>
   </section>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>
