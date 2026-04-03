<?php

   $host = "localhost";
   $db_name = "hotel_db";
   $db_user_name = "root";
   $db_user_pass = "";
   
   $conn = new PDO("mysql:host=$host;dbname=$db_name", $db_user_name, $db_user_pass);

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