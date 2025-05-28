<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'patient') {
  header("Location: ../login.php");
  exit();
}

require_once '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_appointment'])) {
  $patient_id = $_SESSION['user_id'];
  $doctor_id = intval($_POST['doctor_id']);
  $appointment_date = $_POST['appointment_date'];
  $time_slot = $_POST['time_slot'];

  // Check if doctor already booked at this slot
  $check_stmt = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND time_slot = ?");
  $check_stmt->bind_param('iss', $doctor_id, $appointment_date, $time_slot);
  $check_stmt->execute();
  $check_stmt->bind_result($count);
  $check_stmt->fetch();
  $check_stmt->close();

  if ($count > 0) {
    $msg = "❌ This time slot is already booked for the selected doctor on this date. Please choose another slot.";
  } else {
    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, time_slot, status) VALUES (?, ?, ?, ?, ?)");
    $status = 'Pending';
    $stmt->bind_param('iisss', $patient_id, $doctor_id, $appointment_date, $time_slot, $status);
    if ($stmt->execute()) {
      // Redirect to appoints.php with success message
      header("Location: ../patient/appointment/appointment.php?success=1");
      exit();
    } else {
      $msg = "❌ Failed to book appointment.";
    }
    $stmt->close();
  }
}

// Get distinct specializations
$specs_result = $conn->query("SELECT DISTINCT specialization FROM users WHERE role='doctor' ORDER BY specialization ASC");
$specializations = [];
while ($row = $specs_result->fetch_assoc()) {
  $specializations[] = $row['specialization'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Book Appointment</title>
  <style>
    /* Same CSS styling as before */
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px #ccc;
    }

    h1 {
      text-align: center;
    }

    label {
      display: block;
      margin-top: 10px;
    }

    input,
    select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
    }

    button {
      margin-top: 15px;
      background: #007bff;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background: #0056b3;
    }

    .msg {
      margin-top: 10px;
      font-weight: bold;
      color: red;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Book an Appointment</h1>

    <?php if (!empty($msg)): ?>
      <div class="msg"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form method="POST" id="appointmentForm">
      <label for="specialization">Select Specialization:</label>
      <select id="specialization" name="specialization" required>
        <option value="">--Choose specialization--</option>
        <?php foreach ($specializations as $spec): ?>
          <option value="<?= htmlspecialchars($spec) ?>"><?= htmlspecialchars($spec) ?></option>
        <?php endforeach; ?>
      </select>

      <label for="doctor_id">Select Doctor:</label>
      <select id="doctor_id" name="doctor_id" required>
        <option value="">--Choose a doctor--</option>
      </select>

      <label for="appointment_date">Select Date:</label>
      <input type="date" id="appointment_date" name="appointment_date" required min="<?= date('Y-m-d') ?>" />

      <label for="time_slot">Select Time Slot:</label>
      <select id="time_slot" name="time_slot" required>
        <option value="09:00 AM">09:00 AM</option>
        <option value="10:00 AM">10:00 AM</option>
        <option value="11:00 AM">11:00 AM</option>
        <option value="12:00 PM">12:00 PM</option>
        <option value="02:00 PM">02:00 PM</option>
        <option value="03:00 PM">03:00 PM</option>
        <option value="04:00 PM">04:00 PM</option>
      </select>

      <button type="submit" name="book_appointment">Book Appointment</button>
    </form>
  </div>

  <script>
    document.getElementById('specialization').addEventListener('change', function() {
      const spec = this.value;
      const doctorSelect = document.getElementById('doctor_id');
      doctorSelect.innerHTML = '<option value="">Loading...</option>';

      if (!spec) {
        doctorSelect.innerHTML = '<option value="">--Choose a doctor--</option>';
        return;
      }

      fetch('get_doctors.php?specialization=' + encodeURIComponent(spec))
        .then(response => response.json())
        .then(data => {
          doctorSelect.innerHTML = '<option value="">--Choose a doctor--</option>';
          if (data.length === 0) {
            doctorSelect.innerHTML = '<option value="">No doctors available</option>';
            return;
          }
          data.forEach(function(doc) {
            const option = document.createElement('option');
            option.value = doc.id;
            option.textContent = doc.full_name;
            doctorSelect.appendChild(option);
          });
        })
        .catch(() => {
          doctorSelect.innerHTML = '<option value="">Error loading doctors</option>';
        });
    });
  </script>
</body>

</html>