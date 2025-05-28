<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'patient') {
  header("Location: ../../login.php");
  exit();
}

require_once '../../db_config.php';

// Fetch patient's appointments
$patient_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT a.id, u.full_name AS doctor_name, a.appointment_date, a.time_slot 
                        FROM appointments a 
                        JOIN users u ON a.doctor_id = u.id
                        WHERE a.patient_id = ?
                        ORDER BY a.appointment_date ASC, a.time_slot ASC");
$stmt->bind_param('i', $patient_id);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];
while ($row = $result->fetch_assoc()) {
  $appointments[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Your Appointments</title>
  <link rel="stylesheet" href="../patient_navbar/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 0;
      margin: 0;
      background: #f4f4f4;
      display: flex;
    }

    .content {
      flex: 1;
      padding: 20px;
    }

    .container {
      /* max-width: 900px; */
      margin: 20px 20px 20px 300px;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px #ccc;
    }

    h1 {
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    table,
    th,
    td {
      border: 1px solid #ddd;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
    }

    th {
      background: #007bff;
      color: white;
    }

    a.action-btn {
      padding: 5px 10px;
      margin-right: 5px;
      text-decoration: none;
      border-radius: 4px;
      font-size: 14px;
    }

    .edit-btn {
      background-color: #ffc107;
      color: black;
    }

    .delete-btn {
      background-color: #dc3545;
      color: white;
    }

    .delete-btn:hover {
      background-color: #bd2130;
    }

    .edit-btn:hover {
      background-color: #e0a800;
    }
  </style>
</head>

<body>

    <?php include '../patient_navbar/patient_navbar.php'; ?>


  <!-- Main Content -->
  <div class="content">
    <div class="container">
      <h1>Your Appointments</h1>

      <table>
        <thead>
          <tr>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time Slot</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($appointments) === 0): ?>
            <tr>
              <td colspan="4" style="text-align:center;">No appointments found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($appointments as $app): ?>
              <tr>
                <td><?= htmlspecialchars($app['doctor_name']) ?></td>
                <td><?= htmlspecialchars($app['appointment_date']) ?></td>
                <td><?= htmlspecialchars($app['time_slot']) ?></td>
                <td>
                  <a href="edit_appointment.php?id=<?= $app['id'] ?>" class="action-btn edit-btn">Edit</a>
                  <a href="delete_appointment.php?id=<?= $app['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    const params = new URLSearchParams(window.location.search);
    if (params.get('success') === '1') {
      alert('✅ Your appointment was booked successfully!');
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  </script>

</body>

</html>