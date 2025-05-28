<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../login/login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - PSTU Healthcare</title>
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="../admin_navbar/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

  <?php include('../admin_navbar/admin_sidebar.php'); ?>

  <main class="main-content">
    <h1>Welcome Admin</h1>
    <p>Here is a quick overview of the system's status.</p>

    <section class="cards">
      <div class="card">
        <h3>Total Patients</h3>
        <p>325</p>
      </div>
      <div class="card">
        <h3>Total Doctors</h3>
        <p>42</p>
      </div>
      <div class="card">
        <h3>Appointments Today</h3>
        <p>76</p>
      </div>
      <div class="card">
        <h3>Reports</h3>
        <p>12</p>
      </div>
    </section>

    <section class="charts">
      <div class="chart-container">
        <h3>Appointments by Department</h3>
        <canvas id="pieChart"></canvas>
      </div>

      <div class="chart-container">
        <h3>Daily Patient Visits (This Week)</h3>
        <canvas id="barChart"></canvas>
      </div>
    </section>
  </main>

  <script>88888*
    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: ['Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics', 'Others'],
        datasets: [{
          data: [25, 15, 20, 10, 30],
          backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#6366f1'],
        }]
      }
    });

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
          label: 'Patients',
          data: [30, 45, 38, 50, 60, 20, 15],
          backgroundColor: '#3b82f6'
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>

</body>

</html>