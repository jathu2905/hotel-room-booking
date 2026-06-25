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

   $verify_delete = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_admin = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
      $delete_admin->execute([$delete_id]);
      $success_msg[] = 'Admin deleted!';
   }else{
      $warning_msg[] = 'Admin deleted already!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Team - Sha Stay Admin</title>

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

      <h1 class="heading">Admin Team</h1>

      <div class="box-container" style="grid-template-columns: repeat(auto-fit, minmax(32rem, 1fr)); gap: 2.5rem;">

      <div class="box" style="text-align: center; display:flex; flex-direction:column; justify-content:center; align-items:center; padding: 4rem 2rem;">
         <p style="font-size: 1.8rem; margin-bottom: 2rem; color:var(--text-muted);">Add new administrator</p>
         <a href="register.php" class="btn" style="padding: 1.2rem 3rem;"><i class="fas fa-user-plus" style="margin-right: 0.8rem;"></i> Register Admin</a>
      </div>

      <?php
         $select_admins = $conn->prepare("SELECT * FROM `admins`");
         $select_admins->execute();
         if($select_admins->rowCount() > 0){
            while($fetch_admins = $select_admins->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box" <?php if($fetch_admins['name'] == 'admin'){ echo 'style="display:none;"'; } ?> style="display:flex; flex-direction:column; justify-content:space-between; padding:3rem;">
         <div>
            <h3 style="font-size: 2.2rem; color: var(--primary-gold); margin-bottom: 1rem;"><i class="fas fa-user-shield" style="margin-right: 1rem;"></i> Admin Profile</h3>
            <p style="font-size:1.6rem; margin-bottom: 2rem;">Name : <span style="color:var(--text-light);"><?= $fetch_admins['name']; ?></span></p>
         </div>
         <form action="" method="POST" style="width: 100%;">
            <input type="hidden" name="delete_id" value="<?= $fetch_admins['id']; ?>">
            <input type="submit" value="delete admin" onclick="return confirm('delete this admin?');" name="delete" class="delete-btn" style="width: 100%; margin-top: 0; padding: 1.2rem;">
         </form>
      </div>
      <?php
            }
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