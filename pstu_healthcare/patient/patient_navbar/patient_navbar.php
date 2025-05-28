<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  $current_page = basename($_SERVER['PHP_SELF']);
  ?>
  <aside class="sidebar">
    <a class="header" href="../../index.php">
      <h2>PSTU Health</h2>
    </a>
    <nav>
      <a href="../patient_dashboard/patient_dashboard.php" class="<?php echo $current_page == 'patient_dashboard.php' ? 'active' : ''; ?>">Dashboard</a>
      <a href="../profile/profile.php" class="<?php echo $current_page == 'profile.php' ? 'active' : ''; ?>">Profile</a>
      <a href="../appointment/appointment.php" class="<?php echo $current_page == 'appointment.php' ? 'active' : ''; ?>">Appointments</a>
      <a href="#">Medical Records</a>
      <a href="#">Prescriptions</a>
      <a href="#">Billing & Payments</a>
    </nav>
    <a href="../../logout.php" class="logout-btn">Logout</a>
  </aside>

</body>

</html>