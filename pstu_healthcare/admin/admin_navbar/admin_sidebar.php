<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="./style.css">

<aside class="sidebar">
  <a href="../../index.php" style="text-decoration: none; color: white;">
    <h2>Admin Panel</h2>
  </a>
  <nav>
    <a href="../admin_dashboard/admin_dashboard.php" class="<?php echo $current_page == 'admin_dashboard.php' ? 'active' : ''; ?>">
      <!-- Dashboard Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        viewBox="0 0 16 16" style="margin-right:6px;">
        <path d="M3 13h3v-3H3v3zm0-5h3V5H3v3zm5 5h5v-3H8v3zm0-5h5V5H8v3z" />
      </svg>
      Dashboard
    </a>

    <a href="../manage_patient/manage_patient.php" class="<?php echo $current_page == 'manage_patient.php' ? 'active' : ''; ?>">
      <!-- Patient Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        viewBox="0 0 16 16" style="margin-right:6px;">
        <path d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1a5 5 0 0 0-5 5v1h10v-1a5 5 0 0 0-5-5z" />
      </svg>
      Manage Patients
    </a>

    <a href="../manage_doctors/manage_doctors.php" class="<?php echo $current_page == 'manage_doctors.php' ? 'active' : ''; ?>">
      <!-- Doctor Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        viewBox="0 0 16 16" style="margin-right:6px;">
        <path d="M8 0a5 5 0 1 1 0 10A5 5 0 0 1 8 0zm0 9a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" />
        <path d="M14 14s-1-4-6-4-6 4-6 4v1h12v-1z" />
      </svg>
      Manage Doctors
    </a>

    <a href="../manage_medicine/manage_medicine.php" class="<?php echo $current_page == 'manage_medicine.php' ? 'active' : ''; ?>">
      <!-- Medicine Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        class="bi bi-capsule" viewBox="0 0 16 16" style="margin-right:6px;">
        <path
          d="M1.5 8a4.5 4.5 0 0 1 7.5-3.5l3 3a4.5 4.5 0 1 1-6.364 6.364l-3-3A4.5 4.5 0 0 1 1.5 8zm2.121 0L7.5 11.879a3.5 3.5 0 0 0 4.95-4.95L6.571 3.05a3.5 3.5 0 0 0-4.95 4.95z" />
      </svg>
      Manage Medicines
    </a>

    <a href="../all-appointments/all-appointments.php" class="<?php echo $current_page == 'all-appointments.php' ? 'active' : ''; ?>">
      <!-- Appointment Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        viewBox="0 0 16 16" style="margin-right:6px;">
        <path
          d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h.5A1.5 1.5 0 0 1 15 2.5v11A1.5 1.5 0 0 1 13.5 15h-11A1.5 1.5 0 0 1 1 13.5v-11A1.5 1.5 0 0 1 2.5 1H3V.5a.5.5 0 0 1 .5-.5zM2 3v10.5a.5.5 0 0 0 .5.5H3V3H2z" />
      </svg>
      Appointments
    </a>

    <a href="#" class="<?php echo $current_page == '#' ? 'active' : ''; ?>">
      <!-- Report Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        viewBox="0 0 16 16" style="margin-right:6px;">
        <path d="M3 1h10a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm9 12V3H4v10h8z" />
        <path d="M6 7h4v1H6V7z" />
      </svg>
      Reports
    </a>

    <a href="../view_messages/view_messages.php" class="<?php echo $current_page == 'view_messages.php' ? 'active' : ''; ?>">
      <!-- Message Icon -->
      <span style="margin-right:6px;">📨</span> View Messages
    </a>

    <a href="../../logout.php" class="logout-btn">
      <!-- Logout Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        viewBox="0 0 16 16" style="margin-right:6px;">
        <path d="M6 12v-2H2V6h4V4l5 4-5 4z" />
        <path d="M14 14V2h-4v2h2v8h-2v2h4z" />
      </svg>
      Logout
    </a>
  </nav>
</aside>