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

   $verify_booking = $conn->prepare("SELECT * FROM `bookings` WHERE booking_id = ?");
   $verify_booking->execute([$booking_id]);

   if($verify_booking->rowCount() > 0){
      $delete_booking = $conn->prepare("DELETE FROM `bookings` WHERE booking_id = ?");
      $delete_booking->execute([$booking_id]);
      $success_msg[] = 'booking cancelled successfully!';
   }else{
      $warning_msg[] = 'booking cancelled already!';
   }
   
}

$select_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ?");
$select_bookings->execute([$user_id]);

?>
