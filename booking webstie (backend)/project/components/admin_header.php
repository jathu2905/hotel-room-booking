<?php
   $current_page = basename($_SERVER['PHP_SELF']);
?>
<div id="menu-btn" class="fas fa-bars"></div>

<header class="header">

   <div class="flex">

      <a href="dashboard.php" class="logo">Sha <span>Stay</span></a>

      <nav class="navbar">
         <a href="dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
         <a href="rooms.php" class="<?= ($current_page == 'rooms.php') ? 'active' : ''; ?>"><i class="fas fa-bed"></i> Manage Rooms</a>
         <a href="bookings.php" class="<?= ($current_page == 'bookings.php') ? 'active' : ''; ?>"><i class="fas fa-calendar-check"></i> Bookings</a>
         <a href="admins.php" class="<?= ($current_page == 'admins.php') ? 'active' : ''; ?>"><i class="fas fa-users-cog"></i> Admin Team</a>
         <a href="messages.php" class="<?= ($current_page == 'messages.php') ? 'active' : ''; ?>"><i class="fas fa-envelope"></i> Messages</a>
         <a href="register.php" class="<?= ($current_page == 'register.php') ? 'active' : ''; ?>"><i class="fas fa-user-plus"></i> Register Admin</a>
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </nav>

   </div>

</header>