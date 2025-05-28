<?php
// sidebar.php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar">
  <h2>Doctor Panel</h2>
  <nav>
    <a href="../doctor_dashboard/doctor_dashboard.php" class="<?php echo $current_page == 'doctor_dashboard.php' ? 'active' : ''; ?>">
      <!-- Dashboard icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
        <path d="M3 13h3v-3H3v3zm0-5h3V5H3v3zm5 5h5v-3H8v3zm0-5h5V5H8v3z" />
      </svg>
      Dashboard
    </a>
    <a href="../my_appointments/my_appointments.php" class="<?php echo $current_page == 'my_appointments.php' ? 'active' : ''; ?>">
      <!-- Calendar icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h.5A1.5 1.5 0 0 1 15 2.5v11A1.5 1.5 0 0 1 13.5 15h-11A1.5 1.5 0 0 1 1 13.5v-11A1.5 1.5 0 0 1 2.5 1H3V.5a.5.5 0 0 1 .5-.5zM2 3v10.5a.5.5 0 0 0 .5.5H3V3H2z" />
      </svg>
      My Appointments
    </a>
    <a href="patient_records.php" class="<?php echo $current_page == 'patient_records.php' ? 'active' : ''; ?>">
      <!-- Folder icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
        <path d="M9.828 4a.5.5 0 0 1 .354.146l1.292 1.292H14a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.828zM3 5v6h10V7H6.5a.5.5 0 0 1-.354-.146L3 5z" />
      </svg>
      Patient Records
    </a>
    <a href="profile.php" class="<?php echo $current_page == 'profile.php' ? 'active' : ''; ?>">
      <!-- User icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
      </svg>
      Profile
    </a>
    <a href="../../logout.php" class="logout-btn" style="margin-top:auto; padding:12px; text-align:center; background:#e63946; color:white; font-weight:bold; border-radius:5px; text-decoration:none;">
      Logout
    </a>
  </nav>
</aside>