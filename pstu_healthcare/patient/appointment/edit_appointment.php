<?php
session_start();
require_once '../../db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'patient') {
  header("Location: ../../login.php");
  exit();
}

$appointment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];
$error = '';
$success = false;

// Fetch existing appointment
$stmt = $conn->prepare("SELECT a.*, u.full_name AS doctor_name FROM appointments a
                        JOIN users u ON a.doctor_id = u.id
                        WHERE a.id = ? AND a.patient_id = ?");
$stmt->bind_param("ii", $appointment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();
$stmt->close();

if (!$appointment) {
  echo "<p>Invalid appointment or access denied.</p>";
  exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_date = trim($_POST['appointment_date'] ?? '');
  $new_time = trim($_POST['time_slot'] ?? '');

  if ($new_date && $new_time) {
    $doctor_id = $appointment['doctor_id'];

    // Normalize time format in case of trailing spaces
    $new_time = date("h:i A", strtotime($new_time));

    // Check if the time slot is already taken
    $check_stmt = $conn->prepare("SELECT id FROM appointments 
                                  WHERE doctor_id = ? AND appointment_date = ? AND time_slot = ? AND id != ?");
    $check_stmt->bind_param("issi", $doctor_id, $new_date, $new_time, $appointment_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
      $error = "❌ This time slot is already booked for the selected date.";
    } else {
      // Proceed to update appointment
      $stmt = $conn->prepare("UPDATE appointments SET appointment_date = ?, time_slot = ? 
                              WHERE id = ? AND patient_id = ?");
      $stmt->bind_param("ssii", $new_date, $new_time, $appointment_id, $user_id);
      if ($stmt->execute()) {
        $success = true;
      } else {
        $error = "❌ Failed to update appointment.";
      }
      $stmt->close();
    }

    $check_stmt->close();
  } else {
    $error = "❌ All fields are required.";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Appointment</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background: #f4f4f4;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 0 10px #ccc;
    }

    h2 {
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-top: 10px;
    }

    input,
    select {
      padding: 8px;
      font-size: 16px;
      margin-top: 5px;
    }

    .btn {
      margin-top: 20px;
      padding: 10px;
      background: #007bff;
      color: white;
      border: none;
      font-size: 16px;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn:hover {
      background: #0056b3;
    }

    .message {
      margin-top: 15px;
      color: green;
      font-weight: bold;
    }

    .error {
      color: red;
      margin-top: 15px;
    }

    a {
      display: inline-block;
      margin-top: 15px;
      text-decoration: none;
      color: #007bff;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>

  <div class="container">
    <h2>Edit Appointment</h2>

    <p><strong>Doctor:</strong> <?= htmlspecialchars($appointment['doctor_name']) ?></p>

    <?php if ($success): ?>
      <p class="message">✅ Appointment updated successfully.</p>
      <a href="appointment.php">← Back to Appointments</a>
    <?php else: ?>
      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form method="post">
        <label for="appointment_date">Date</label>
        <input type="date" id="appointment_date" name="appointment_date" required value="<?= htmlspecialchars($appointment['appointment_date']) ?>">

        <label for="time_slot">Time Slot</label>
        <select id="time_slot" name="time_slot" required>
          <option value="">Select a time</option>
          <?php
          $time_slots = ["09:00 AM", "10:00 AM", "11:00 AM", "01:00 PM", "02:00 PM", "03:00 PM", "04:00 PM"];
          foreach ($time_slots as $slot) {
            $selected = $appointment['time_slot'] === $slot ? 'selected' : '';
            echo "<option value=\"$slot\" $selected>$slot</option>";
          }
          ?>
        </select>

        <button type="submit" class="btn">Update Appointment</button>
      </form>

      <a href="appointment.php">← Cancel and go back</a>
    <?php endif; ?>
  </div>

</body>

</html>