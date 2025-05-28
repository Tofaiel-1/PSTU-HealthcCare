<?php
session_start();
require_once '../../db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../../login.php");
  exit();
}

// Fetch all appointments with doctor and patient info
$sql = "SELECT a.id, a.appointment_date, a.time_slot,
               d.full_name AS doctor_name,
               p.full_name AS patient_name
        FROM appointments a
        JOIN users d ON a.doctor_id = d.id
        JOIN users p ON a.patient_id = p.id
        ORDER BY a.appointment_date ASC, a.time_slot ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>All Appointments - Admin</title>
  <link rel="stylesheet" href="../admin_navbar/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f4f4f4;
    }

    .wrapper {
      display: flex;
      min-height: 100vh;
    }


    .content {
      flex: 1;
      padding: 30px;
    }

    .container {
      max-width: 1000px;
      margin: 20px 20px 20px 350px;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 0 10px #ccc;
    }

    h2 {
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    a {
      color: #007bff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
    }
  </style>
</head>

<body>

  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
      <?php include '../admin_navbar/admin_sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="content">
      <div class="container">
        <h2>All Appointments</h2>

        <?php if ($result->num_rows > 0): ?>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Time Slot</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['id']) ?></td>
                  <td><?= htmlspecialchars($row['doctor_name']) ?></td>
                  <td><?= htmlspecialchars($row['patient_name']) ?></td>
                  <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                  <td><?= htmlspecialchars($row['time_slot']) ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p>No appointments found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

</body>

</html>