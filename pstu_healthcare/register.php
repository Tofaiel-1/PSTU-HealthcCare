<?php
include 'db_config.php';
session_start();

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $full_name = $conn->real_escape_string($_POST['full_name']);
  $email     = $conn->real_escape_string($_POST['email']);
  $phone     = $conn->real_escape_string($_POST['phone']);
  $student_id = $conn->real_escape_string($_POST['student_id']);
  $hall_name  = $conn->real_escape_string($_POST['hall_name']);
  $gender    = $conn->real_escape_string($_POST['gender']);
  $age       = (int)$_POST['age'];
  $address   = $conn->real_escape_string($_POST['address']);
  $password  = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $role      = 'patient';

  if ($password !== $confirm_password) {
    $msg = "❌ Password and Confirm Password do not match!";
  } else {
    $check = $conn->query("SELECT id FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
      $msg = "❌ Email already registered!";
    } else {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $sql = "INSERT INTO users (full_name, email, phone, student_id, hall_name, gender, age, address, password, role)
              VALUES ('$full_name', '$email', '$phone', '$student_id', '$hall_name', '$gender', $age, '$address', '$hashed_password', '$role')";

      if ($conn->query($sql) === TRUE) {
        header("Location: login.php?msg=success");
        exit();
      } else {
        $msg = "❌ Registration failed: " . $conn->error;
      }
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Register - PSTU Healthcare</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <form method="POST">
    <h2>Create Your Patient Account</h2>

    <?php if ($msg) echo "<div class='message'>$msg</div>"; ?>

    <label for="full_name">Full Name</label>
    <input type="text" name="full_name" id="full_name" placeholder="Your full name" required>

    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" placeholder="example@mail.com" required>

    <label for="phone">Phone Number</label>
    <input type="text" name="phone" id="phone" placeholder="+8801234567890" required pattern="\+?[0-9\s\-]{7,15}">

    <label for="student_id">Student ID</label>
    <input type="text" name="student_id" id="student_id" placeholder="e.g. 2020-01-00123" required>

    <label for="hall_name">Hall Name</label>
    <input type="text" name="hall_name" id="hall_name" placeholder="e.g.M.K Ali Hall = e.g. 2020-01-00" required>

    <label for=" gender">Gender</label>
    <select name="gender" id="gender" required>
      <option value="" disabled selected>Select Gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
      <option value="Other">Other</option>
    </select>

    <label for="age">Age</label>
    <input type="number" name="age" id="age" min="1" max="120" required>

    <label for="address">Address</label>
    <input type="text" name="address" id="address" placeholder="Your address" required>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" placeholder="Enter password" required minlength="6">

    <label for="confirm_password">Confirm Password</label>
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required minlength="6">

    <input type="hidden" name="role" value="patient">

    <button type="submit">Register</button>
    <a href="login.php">Already have an account? Login here</a>
  </form>

</body>

</html>