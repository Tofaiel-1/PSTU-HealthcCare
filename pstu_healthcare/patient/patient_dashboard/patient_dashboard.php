<?php
session_start();
include '../../db_config.php';

// Check login
if (!isset($_SESSION['user_id'])) {
  header("Location: ../../login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$stmt = $conn->prepare("SELECT full_name, email, phone, gender, age, address, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  header("Location: ../../login.php");
  exit();
}

$user = $result->fetch_assoc();

// Only patients allowed here
if ($user['role'] !== 'patient') {
  echo "<h2>Access Denied. This dashboard is for patients only.</h2>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Patient Dashboard - PSTU Healthcare</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../patient_navbar/style.css">
</head>

<body>
  <?php
  include '../patient_navbar/patient_navbar.php'; ?>
  <main class="main-content">
    <section id="dashboard-section" class="content-section">
      <h1 class="main-header">Dashboard</h1>
      <p class="welcome-msg">Welcome back, <strong><?php echo htmlspecialchars($user['full_name']); ?></strong>! Here’s your quick overview.</p>
      <div class="info-cards">
        <div class="card">
          <h3>Upcoming Appointments</h3>
          <p>No upcoming appointments yet. <br> Book your appointment soon!</p>
        </div>
        <div class="card">
          <h3>Recent Medical Record</h3>
          <p>You have no recent medical records.</p>
        </div>
        <div class="card">
          <h3>Pending Bills</h3>
          <p>You have no pending payments.</p>
        </div>
      </div>
    </section>
  </main>

</body>

</html>