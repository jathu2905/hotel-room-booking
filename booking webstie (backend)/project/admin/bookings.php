<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `bookings` WHERE booking_id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_bookings = $conn->prepare("DELETE FROM `bookings` WHERE booking_id = ?");
      $delete_bookings->execute([$delete_id]);
      $success_msg[] = 'Booking deleted!';
   }else{
      $warning_msg[] = 'Booking deleted already!';
   }

}

if(isset($_POST['update_status'])){

   $booking_id = $_POST['booking_id'];
   $booking_id = filter_var($booking_id, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);

   $update_status = $conn->prepare("UPDATE `bookings` SET status = ? WHERE booking_id = ?");
   $update_status->execute([$status, $booking_id]);
   $success_msg[] = 'Booking status updated successfully!';

}

// Handle filters and search query
$query = "SELECT b.*, r.name AS room_name FROM `bookings` b LEFT JOIN `rooms` r ON b.room_id = r.id WHERE 1=1";
$params = [];

$filter_status = isset($_GET['status']) ? filter_var($_GET['status'], FILTER_SANITIZE_STRING) : '';
$search_query = isset($_GET['search']) ? filter_var($_GET['search'], FILTER_SANITIZE_STRING) : '';

if($filter_status != ''){
   $query .= " AND b.status = ?";
   $params[] = $filter_status;
}

if($search_query != ''){
   $keyword = "%{$search_query}%";
   $query .= " AND (b.name LIKE ? OR b.email LIKE ? OR b.booking_id LIKE ?)";
   $params[] = $keyword;
   $params[] = $keyword;
   $params[] = $keyword;
}

$query .= " ORDER BY b.check_in DESC";
$select_bookings = $conn->prepare($query);
$select_bookings->execute($params);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bookings Manager - Sha Stay Admin</title>

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

   <section class="grid">

      <h1 class="heading">Bookings Manager</h1>

      <!-- Filter and Search Bar -->
      <div class="filter-bar">
         <form action="" method="get">
            <select name="status" onchange="this.form.submit()">
               <option value="">All Statuses</option>
               <option value="pending" <?= ($filter_status == 'pending') ? 'selected' : ''; ?>>Pending</option>
               <option value="confirmed" <?= ($filter_status == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
               <option value="completed" <?= ($filter_status == 'completed') ? 'selected' : ''; ?>>Completed</option>
               <option value="cancelled" <?= ($filter_status == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>
            
            <input type="text" name="search" placeholder="Search guests, email, ID..." value="<?= htmlspecialchars($search_query); ?>" style="width: 25rem;">
            <input type="submit" value="Search" class="btn" style="margin-top: 0; padding: 1rem 2rem;">
         </form>
         
         <?php if($filter_status != '' || $search_query != ''){ ?>
            <a href="bookings.php" class="option-btn" style="margin-top: 0; padding: 1rem 2rem;">Reset Filters</a>
         <?php } ?>
      </div>

      <div class="box-container" style="grid-template-columns: repeat(auto-fit, minmax(36rem, 1fr)); gap: 3rem;">

      <?php
         if($select_bookings->rowCount() > 0){
            while($fetch_bookings = $select_bookings->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box" style="display: flex; flex-direction: column; justify-content: space-between; overflow: hidden;">
         <div>
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 1rem; margin-bottom: 1.5rem;">
               <span style="font-size: 1.3rem; color: var(--primary-gold); font-weight: 600;">ID: <?= $fetch_bookings['booking_id']; ?></span>
               <span class="badge <?= $fetch_bookings['status']; ?>"><?= $fetch_bookings['status']; ?></span>
            </div>
            
            <p>Room Type : <span style="font-weight: 600; color: var(--text-light);"><?= $fetch_bookings['room_name'] ? $fetch_bookings['room_name'] : 'Luxury Room'; ?></span></p>
            <p>Guest Name : <span><?= htmlspecialchars($fetch_bookings['name']); ?></span></p>
            <p>Email : <span><?= htmlspecialchars($fetch_bookings['email']); ?></span></p>
            <p>Phone : <span><?= htmlspecialchars($fetch_bookings['number']); ?></span></p>
            <p>Check In : <span><?= $fetch_bookings['check_in']; ?></span></p>
            <p>Check Out : <span><?= $fetch_bookings['check_out']; ?></span></p>
            <p>Rooms Count : <span><?= $fetch_bookings['rooms']; ?></span></p>
            <p>Guests Count : <span><?= $fetch_bookings['adults']; ?> Adults, <?= $fetch_bookings['childs']; ?> Children</span></p>
            <p style="border-top: 1px solid rgba(255,255,255,0.06); padding-top: 1.5rem; margin-top: 1.5rem; font-weight: 600;">
               Net Price: <span style="color: var(--primary-gold); font-size: 2rem;">$<?= number_format($fetch_bookings['total_price']); ?></span>
            </p>
         </div>

         <div style="border-top: 1px solid rgba(255,255,255,0.06); margin-top: 2rem; padding-top: 1.5rem;">
            <!-- Status Modifier Form -->
            <form action="" method="POST">
               <input type="hidden" name="booking_id" value="<?= $fetch_bookings['booking_id']; ?>">
               <p style="margin-bottom: 0.5rem; font-size: 1.3rem;">Modify Status:</p>
               <select name="status" class="status-select" onchange="this.form.submit()" style="margin-top: 0;">
                  <option value="pending" <?= ($fetch_bookings['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                  <option value="confirmed" <?= ($fetch_bookings['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                  <option value="completed" <?= ($fetch_bookings['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                  <option value="cancelled" <?= ($fetch_bookings['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
               </select>
               <input type="hidden" name="update_status" value="1">
            </form>

            <form action="" method="POST" style="margin-top: 1rem;">
               <input type="hidden" name="delete_id" value="<?= $fetch_bookings['booking_id']; ?>">
               <input type="submit" value="delete booking" onclick="return confirm('Delete this booking permanently?');" name="delete" class="delete-btn" style="width: 100%; margin-top: 0; padding: 1.2rem;">
            </form>
         </div>
      </div>
      <?php
         }
      }else{
      ?>
      <div class="box" style="text-align: center; grid-column: 1 / -1; padding: 5rem 2rem;">
         <p style="font-size: 1.8rem; color:var(--text-muted);">No bookings matching your criteria!</p>
      </div>
      <?php
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