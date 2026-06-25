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

   $verify_delete = $conn->prepare("SELECT * FROM `messages` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_bookings = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
      $delete_bookings->execute([$delete_id]);
      $success_msg[] = 'Message deleted!';
   }else{
      $warning_msg[] = 'Message deleted already!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages - Sha Stay Admin</title>

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

      <h1 class="heading">Messages Inbox</h1>

      <div class="box-container">

      <?php
         $select_messages = $conn->prepare("SELECT * FROM `messages`");
         $select_messages->execute();
         if($select_messages->rowCount() > 0){
            while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box message-card" style="display: flex; flex-direction: column; justify-content: space-between;">
         <div>
            <h3 style="font-size: 2.2rem; color: var(--primary-gold); font-family: 'Cormorant', serif; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0.8rem; margin-bottom: 1.5rem;">
               <i class="fas fa-user" style="margin-right: 1rem;"></i> <?= htmlspecialchars($fetch_messages['name']); ?>
            </h3>
            <p style="margin-bottom: 0.8rem; font-size:1.4rem;"><i class="fas fa-envelope" style="color:var(--primary-gold); width: 2.5rem;"></i> <span><?= htmlspecialchars($fetch_messages['email']); ?></span></p>
            <p style="margin-bottom: 1.5rem; font-size:1.4rem;"><i class="fas fa-phone" style="color:var(--primary-gold); width: 2.5rem;"></i> <span><?= htmlspecialchars($fetch_messages['number']); ?></span></p>
            
            <p style="font-size:1.4rem; line-height: 1.6; color:var(--text-muted); background: rgba(255,255,255,0.03); border: var(--glass-border); padding: 1.5rem; border-radius: 0.8rem; margin-bottom: 2rem;">
               <?= nl2br(htmlspecialchars($fetch_messages['message'])); ?>
            </p>
         </div>
         
         <form action="" method="POST" style="margin-top: auto; width: 100%;">
            <input type="hidden" name="delete_id" value="<?= $fetch_messages['id']; ?>">
            <input type="submit" value="delete message" onclick="return confirm('delete this message?');" name="delete" class="delete-btn" style="width: 100%; margin-top: 0; padding: 1.2rem;">
         </form>
      </div>
      <?php
         }
      }else{
      ?>
      <div class="box" style="text-align: center; grid-column: 1 / -1; padding: 5rem 2rem;">
         <p style="font-size: 1.8rem; color:var(--text-muted);">No messages in your inbox!</p>
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