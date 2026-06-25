<?php

   $host = "localhost";
   $db_name = "hotel_db";
   $db_user_name = "root";
   $db_user_pass = "";
   
   $conn = new PDO("mysql:host=$host;dbname=$db_name", $db_user_name, $db_user_pass);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // Self-healing migrations
   try {
      // Create rooms table
      $conn->query("CREATE TABLE IF NOT EXISTS `rooms` (
        `id` varchar(20) NOT NULL,
        `name` varchar(100) NOT NULL,
        `type` varchar(50) NOT NULL,
        `price` int(10) NOT NULL,
        `image` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `capacity_adults` int(2) NOT NULL DEFAULT 2,
        `capacity_childs` int(2) NOT NULL DEFAULT 0,
        `total_rooms` int(3) NOT NULL DEFAULT 10,
        `amenities` varchar(255) NOT NULL DEFAULT 'AC, WiFi, TV, Minibar',
        `status` varchar(20) NOT NULL DEFAULT 'available',
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

      // Seed default rooms if empty
      $check_rooms = $conn->prepare("SELECT * FROM `rooms` LIMIT 1");
      $check_rooms->execute();
      if($check_rooms->rowCount() == 0) {
         $rooms = [
            ['deluxe_ocean_suite', 'Deluxe Ocean Suite', 'Deluxe A/C', 150, 'home-img-1.jpg', 'Experience luxury with spectacular ocean views, standard king beds, and modern amenities.', 2, 1, 10, 'AC, WiFi, TV, Ocean View, Minibar', 'available'],
            ['executive_club', 'Executive Club Room', 'Executive A/C', 220, 'gallery-img-5.jpg', 'Exclusive access to our executive club, spacious lounges, premium views and king-size layout.', 3, 2, 8, 'AC, WiFi, TV, Private Balcony, Minibar', 'available'],
            ['standard_cozy', 'Cozy Standard Room', 'Standard A/C', 90, 'home-img-3.jpg', 'A cozy, comfortable standard room perfect for budget-conscious travellers or quick business trips.', 2, 0, 15, 'AC, WiFi, TV', 'available'],
            ['presidential_villa', 'Presidential Pool Villa', 'Luxury Suite', 450, 'gallery-img-3.webp', 'Ultimate luxury featuring a private infinity pool, dedicated butler service, and panoramic vistas.', 4, 3, 3, 'AC, WiFi, TV, Private Pool, Ocean View, Kitchen, Minibar', 'available']
         ];
         $insert_room = $conn->prepare("INSERT INTO `rooms` (id, name, type, price, image, description, capacity_adults, capacity_childs, total_rooms, amenities, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
         foreach($rooms as $room) {
            $insert_room->execute($room);
         }
      }

      // Check and alter bookings columns
      $check_room_id = $conn->prepare("SHOW COLUMNS FROM `bookings` LIKE 'room_id'");
      $check_room_id->execute();
      if($check_room_id->rowCount() == 0) {
         $conn->query("ALTER TABLE `bookings` ADD `room_id` varchar(20) NOT NULL AFTER `booking_id`");
      }

      $check_total_price = $conn->prepare("SHOW COLUMNS FROM `bookings` LIKE 'total_price'");
      $check_total_price->execute();
      if($check_total_price->rowCount() == 0) {
         $conn->query("ALTER TABLE `bookings` ADD `total_price` int(10) NOT NULL AFTER `childs`");
      }

      $check_status = $conn->prepare("SHOW COLUMNS FROM `bookings` LIKE 'status'");
      $check_status->execute();
      if($check_status->rowCount() == 0) {
         $conn->query("ALTER TABLE `bookings` ADD `status` varchar(20) NOT NULL DEFAULT 'pending' AFTER `total_price`");
      }
   } catch (PDOException $e) {
      // Quietly ignore or handle database structure mismatches during dev setup
   }

   function create_unique_id(){
      $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $rand = array();
      $length = strlen($str) - 1;

      for($i = 0; $i < 20; $i++){
         $n = mt_rand(0, $length);
         $rand[] = $str[$n];
      }
      return implode($rand);
   }

   function clean_input($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   }

?>