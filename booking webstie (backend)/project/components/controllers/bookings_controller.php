<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60*60*24*30, '/');
   header('location:index.php');
   exit();
}

if(isset($_POST['cancel'])){

   $booking_id = clean_input($_POST['booking_id']);

   $verify_booking = $conn->prepare("SELECT * FROM `bookings` WHERE booking_id = ? AND status IN ('pending', 'confirmed')");
   $verify_booking->execute([$booking_id]);

   if($verify_booking->rowCount() > 0){
      $cancel_booking = $conn->prepare("UPDATE `bookings` SET status = 'cancelled' WHERE booking_id = ?");
      $cancel_booking->execute([$booking_id]);
      $success_msg[] = 'Booking cancelled successfully!';
   }else{
      $warning_msg[] = 'Booking already cancelled or completed!';
   }
   
}

$select_bookings = $conn->prepare("SELECT b.*, r.name AS room_name, r.image AS room_image FROM `bookings` b LEFT JOIN `rooms` r ON b.room_id = r.id WHERE b.user_id = ? ORDER BY b.check_in DESC");
$select_bookings->execute([$user_id]);

?>
