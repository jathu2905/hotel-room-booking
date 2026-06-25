<?php
include 'components/controllers/bookings_controller.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>bookings</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>


<section class="bookings">

   <h1 class="heading">my bookings</h1>

   <div class="box-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(32rem, 1fr)); gap: 2.5rem; align-items: start;">

   <?php
      if($select_bookings->rowCount() > 0){
         while($fetch_booking = $select_bookings->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box" style="display: flex; flex-direction: column; overflow: hidden; border-radius: 1.2rem; background: var(--card-bg); border: var(--glass-border); padding: 0;">
      <?php if (!empty($fetch_booking['room_image'])) { ?>
         <div style="height: 20rem; width: 100%; position: relative;">
            <img src="images/<?= $fetch_booking['room_image']; ?>" alt="room image" style="height: 100%; width: 100%; object-fit: cover;">
            <div class="badge <?= $fetch_booking['status']; ?>" style="position: absolute; top: 1.5rem; right: 1.5rem; margin-bottom: 0;">
               <?= $fetch_booking['status']; ?>
            </div>
         </div>
      <?php } else { ?>
         <div style="padding: 2rem 2.5rem 0 2.5rem; display: flex; justify-content: flex-end;">
            <div class="badge <?= $fetch_booking['status']; ?>" style="margin-bottom: 0;">
               <?= $fetch_booking['status']; ?>
            </div>
         </div>
      <?php } ?>
      <div style="padding: 2.5rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
         <div>
            <h3 style="font-size: 2.4rem; color: var(--primary-gold); margin-bottom: 1.5rem; font-family: 'Cormorant', serif;">
               <?= $fetch_booking['room_name'] ? $fetch_booking['room_name'] : 'Luxury Room'; ?>
            </h3>
            <p style="margin-bottom: 0.8rem; font-size:1.4rem;">booking id : <span style="color: var(--text-light);"><?= $fetch_booking['booking_id']; ?></span></p>
            <p style="margin-bottom: 0.8rem; font-size:1.4rem;">name : <span style="color: var(--text-light);"><?= $fetch_booking['name']; ?></span></p>
            <p style="margin-bottom: 0.8rem; font-size:1.4rem;">email : <span style="color: var(--text-light);"><?= $fetch_booking['email']; ?></span></p>
            <p style="margin-bottom: 0.8rem; font-size:1.4rem;">number : <span style="color: var(--text-light);"><?= $fetch_booking['number']; ?></span></p>
            <p style="margin-bottom: 0.8rem; font-size:1.4rem;">check in : <span style="color: var(--text-light);"><?= $fetch_booking['check_in']; ?></span></p>
            <p style="margin-bottom: 0.8rem; font-size:1.4rem;">check out : <span style="color: var(--text-light);"><?= $fetch_booking['check_out']; ?></span></p>
            <p style="margin-bottom: 0.8rem; font-size:1.4rem;">rooms count : <span style="color: var(--text-light);"><?= $fetch_booking['rooms']; ?></span></p>
            <p style="margin-bottom: 0.8rem; font-size:1.4rem;">guests : <span style="color: var(--text-light);"><?= $fetch_booking['adults']; ?> adults, <?= $fetch_booking['childs']; ?> childs</span></p>
            
            <p style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.5rem; margin-top: 1.5rem; font-weight: 600; font-size: 1.6rem; color: var(--text-muted);">
               Net Price : <span style="color: var(--primary-gold); font-size: 2.2rem; font-weight:700;">$<?= number_format($fetch_booking['total_price']); ?></span>
            </p>
         </div>
         
         <?php if ($fetch_booking['status'] == 'pending' || $fetch_booking['status'] == 'confirmed') { ?>
            <form action="" method="POST" style="margin-top: 2rem; width: 100%;">
               <input type="hidden" name="booking_id" value="<?= $fetch_booking['booking_id']; ?>">
               <input type="submit" value="cancel booking" name="cancel" class="btn" onclick="return confirm('cancel this booking?');" style="width: 100%; border-radius: 0.5rem; background: #ef4444; color: #fff; margin-top: 0; padding: 1.2rem;">
            </form>
         <?php } ?>
      </div>
   </div>
   <?php
     }
   }else{
   ?>   
   <div class="box" style="text-align: center; width: 100%; grid-column: 1 / -1; padding: 5rem 2rem;">
      <p style="padding-bottom: 1.5rem; text-transform:capitalize; font-size: 2rem;">no bookings found!</p>
      <a href="index.php#rooms" class="btn">book new room</a>
   </div>
   <?php
   }
   ?>
   </div>

</section>





<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>