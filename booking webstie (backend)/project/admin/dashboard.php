<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard - Sha Stay Admin</title>

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

   <section class="dashboard">

      <h1 class="heading">Dashboard Overview</h1>

      <div class="box-container">

         <div class="box">
            <?php
               $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ? LIMIT 1");
               $select_profile->execute([$admin_id]);
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <h3>Welcome back!</h3>
            <p style="font-weight: 600; color: var(--primary-gold);"><?= $fetch_profile['name']; ?></p>
            <a href="update.php" class="btn">update profile</a>
         </div>

         <div class="box">
            <?php
               // Net Revenue Calculation
               $select_revenue = $conn->prepare("SELECT SUM(total_price) AS total_revenue FROM `bookings` WHERE status IN ('confirmed', 'completed')");
               $select_revenue->execute();
               $fetch_revenue = $select_revenue->fetch(PDO::FETCH_ASSOC);
               $net_revenue = $fetch_revenue['total_revenue'] ? $fetch_revenue['total_revenue'] : 0;
            ?>
            <h3>$<?= number_format($net_revenue); ?></h3>
            <p>Net Revenue (Confirmed)</p>
            <a href="bookings.php" class="btn">View Bookings</a>
         </div>

         <div class="box">
            <?php
               $select_bookings = $conn->prepare("SELECT * FROM `bookings`");
               $select_bookings->execute();
               $count_bookings = $select_bookings->rowCount();
            ?>
            <h3><?= $count_bookings; ?></h3>
            <p>Total Bookings</p>
            <a href="bookings.php" class="btn">Manage Bookings</a>
         </div>

         <div class="box">
            <?php
               $select_rooms = $conn->prepare("SELECT * FROM `rooms`");
               $select_rooms->execute();
               $count_rooms = $select_rooms->rowCount();
            ?>
            <h3><?= $count_rooms; ?></h3>
            <p>Active Room Types</p>
            <a href="rooms.php" class="btn">Manage Rooms</a>
         </div>

         <div class="box">
            <?php
               $select_messages = $conn->prepare("SELECT * FROM `messages`");
               $select_messages->execute();
               $count_messages = $select_messages->rowCount();
            ?>
            <h3><?= $count_messages; ?></h3>
            <p>Total Messages</p>
            <a href="messages.php" class="btn">View Messages</a>
         </div>

         <div class="box">
            <?php
               $select_admins = $conn->prepare("SELECT * FROM `admins`");
               $select_admins->execute();
               $count_admins = $select_admins->rowCount();
            ?>
            <h3><?= $count_admins; ?></h3>
            <p>Admin Accounts</p>
            <a href="admins.php" class="btn">Manage Admins</a>
         </div>

      </div>

      <!-- Recent lists -->
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(45rem, 1fr)); gap: 3rem; margin-top: 2rem;">
         
         <!-- Recent Bookings Table -->
         <div style="background: var(--card-bg); border: var(--glass-border); padding: 3rem; border-radius: 1.2rem;">
            <h2 style="font-size: 2.2rem; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem;"><i class="fas fa-history" style="color: var(--primary-gold); margin-right: 1rem;"></i> Recent Bookings</h2>
            <div style="overflow-x: auto;">
               <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 1.4rem;">
                  <thead>
                     <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-light);">
                        <th style="padding: 1.2rem;">Guest</th>
                        <th style="padding: 1.2rem;">Check In</th>
                        <th style="padding: 1.2rem;">Amount</th>
                        <th style="padding: 1.2rem;">Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $select_recent_bookings = $conn->prepare("SELECT * FROM `bookings` ORDER BY check_in DESC LIMIT 4");
                        $select_recent_bookings->execute();
                        if($select_recent_bookings->rowCount() > 0){
                           while($b_row = $select_recent_bookings->fetch(PDO::FETCH_ASSOC)){
                              echo '<tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">';
                              echo '<td style="padding: 1.2rem;">'.htmlspecialchars($b_row['name']).'</td>';
                              echo '<td style="padding: 1.2rem;">'.$b_row['check_in'].'</td>';
                              echo '<td style="padding: 1.2rem; font-weight:600; color:var(--primary-gold);">$'.number_format($b_row['total_price']).'</td>';
                              echo '<td style="padding: 1.2rem;"><span class="badge '.$b_row['status'].'">'.$b_row['status'].'</span></td>';
                              echo '</tr>';
                           }
                        } else {
                           echo '<tr><td colspan="4" style="padding: 2rem; text-align:center; color:var(--text-muted);">No bookings yet!</td></tr>';
                        }
                     ?>
                  </tbody>
               </table>
            </div>
         </div>

         <!-- Recent Messages -->
         <div style="background: var(--card-bg); border: var(--glass-border); padding: 3rem; border-radius: 1.2rem;">
            <h2 style="font-size: 2.2rem; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem;"><i class="fas fa-envelope-open" style="color: var(--primary-gold); margin-right: 1rem;"></i> Recent Messages</h2>
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
               <?php
                  $select_recent_msgs = $conn->prepare("SELECT * FROM `messages` LIMIT 3");
                  $select_recent_msgs->execute();
                  if($select_recent_msgs->rowCount() > 0){
                     while($m_row = $select_recent_msgs->fetch(PDO::FETCH_ASSOC)){
                        echo '<div style="background: rgba(255,255,255,0.03); border: var(--glass-border); padding: 1.5rem; border-radius: 0.8rem;">';
                        echo '<div style="display:flex; justify-content:space-between; margin-bottom: 0.8rem;">';
                        echo '<span style="font-weight:600; color:var(--text-light);">'.htmlspecialchars($m_row['name']).'</span>';
                        echo '<span style="color:var(--text-muted); font-size:1.2rem;">'.$m_row['number'].'</span>';
                        echo '</div>';
                        echo '<p style="font-size:1.3rem; line-height: 1.4; color: var(--text-muted); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">'.htmlspecialchars($m_row['message']).'</p>';
                        echo '</div>';
                     }
                  } else {
                     echo '<p style="color:var(--text-muted); padding: 2rem; text-align:center;">No contact messages yet!</p>';
                  }
               ?>
            </div>
         </div>

      </div>

   </section>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>