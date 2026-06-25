<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60*60*24*30, '/');
   header('location:index.php');
   exit();
}

if(isset($_POST['check'])){

   $check_in = clean_input($_POST['check_in']);
   $check_out = clean_input($_POST['check_out']);
   $adults = clean_input($_POST['adults']);
   $childs = clean_input($_POST['childs']);
   $rooms = clean_input($_POST['rooms']);

   if(strtotime($check_in) < strtotime(date('Y-m-d'))){
      $warning_msg[] = 'check-in date cannot be in the past!';
   }elseif(strtotime($check_out) <= strtotime($check_in)){
      $warning_msg[] = 'check-out date must be after check-in!';
   }else{
      // Check if any room meets capacity and has availability
      $select_rooms = $conn->prepare("SELECT * FROM `rooms` WHERE status = 'available' AND capacity_adults >= ?");
      $select_rooms->execute([$adults]);
      
      $available_found = false;
      while($room = $select_rooms->fetch(PDO::FETCH_ASSOC)){
         // check bookings overlap
         $check_bookings = $conn->prepare("SELECT SUM(rooms) AS booked_rooms FROM `bookings` WHERE room_id = ? AND status != 'cancelled' AND check_in < ? AND check_out > ?");
         $check_bookings->execute([$room['id'], $check_out, $check_in]);
         $fetch_booked = $check_bookings->fetch(PDO::FETCH_ASSOC);
         $booked_rooms = $fetch_booked['booked_rooms'] ? $fetch_booked['booked_rooms'] : 0;
         
         if(($room['total_rooms'] - $booked_rooms) >= $rooms){
            $available_found = true;
            break;
         }
      }
      
      if($available_found){
         $success_msg[] = 'rooms are available for the selected dates!';
      }else{
         $warning_msg[] = 'no rooms available for the selected dates or capacity!';
      }
   }

}

if(isset($_POST['book'])){

   $booking_id = create_unique_id();
   $name = clean_input($_POST['name']);
   $email = clean_input($_POST['email']);
   $number = clean_input($_POST['number']);
   $rooms = clean_input($_POST['rooms']);
   $check_in = clean_input($_POST['check_in']);
   $check_out = clean_input($_POST['check_out']);
   $adults = clean_input($_POST['adults']);
   $childs = clean_input($_POST['childs']);
   $room_id = clean_input($_POST['room_id']);

   if(strtotime($check_in) < strtotime(date('Y-m-d'))){
      $warning_msg[] = 'check-in date cannot be in the past!';
   }elseif(strtotime($check_out) <= strtotime($check_in)){
      $warning_msg[] = 'check-out date must be after check-in!';
   }else{
      $select_room = $conn->prepare("SELECT * FROM `rooms` WHERE id = ? LIMIT 1");
      $select_room->execute([$room_id]);
      
      if($select_room->rowCount() > 0){
         $room = $select_room->fetch(PDO::FETCH_ASSOC);
         
         if($adults > $room['capacity_adults']){
            $warning_msg[] = 'Selected room capacity exceeded for adults!';
         } else {
            // Check date overlap availability
            $check_bookings = $conn->prepare("SELECT SUM(rooms) AS booked_rooms FROM `bookings` WHERE room_id = ? AND status != 'cancelled' AND check_in < ? AND check_out > ?");
            $check_bookings->execute([$room_id, $check_out, $check_in]);
            $fetch_booked = $check_bookings->fetch(PDO::FETCH_ASSOC);
            $booked_rooms = $fetch_booked['booked_rooms'] ? $fetch_booked['booked_rooms'] : 0;
            
            if(($room['total_rooms'] - $booked_rooms) < $rooms){
               $warning_msg[] = 'No rooms available of this type for the selected dates!';
            } else {
               $verify_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ? AND room_id = ? AND check_in = ? AND check_out = ? AND status != 'cancelled'");
               $verify_bookings->execute([$user_id, $room_id, $check_in, $check_out]);

               if($verify_bookings->rowCount() > 0){
                  $warning_msg[] = 'You have already booked this room for these dates!';
               }else{
                  // Calculate price
                  $nights = (strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24);
                  $total_price = $room['price'] * $rooms * $nights;
                  
                  $book_room = $conn->prepare("INSERT INTO `bookings`(booking_id, room_id, user_id, name, email, number, rooms, check_in, check_out, adults, childs, total_price, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                  $book_room->execute([$booking_id, $room_id, $user_id, $name, $email, $number, $rooms, $check_in, $check_out, $adults, $childs, $total_price, 'pending']);
                  $success_msg[] = 'Room booked successfully! Net Total: $' . $total_price;
               }
            }
         }
      } else {
         $warning_msg[] = 'Invalid room selected!';
      }
   }

}

if(isset($_POST['send'])){

   $id = create_unique_id();
   $name = clean_input($_POST['name']);
   $email = clean_input($_POST['email']);
   $number = clean_input($_POST['number']);
   $message = clean_input($_POST['message']);

   $verify_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $verify_message->execute([$name, $email, $number, $message]);

   if($verify_message->rowCount() > 0){
      $warning_msg[] = 'message sent already!';
   }else{
      $insert_message = $conn->prepare("INSERT INTO `messages`(id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$id, $name, $email, $number, $message]);
      $success_msg[] = 'message sent successfully!';
   }

}

?>
