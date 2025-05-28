<?php
include 'db_config.php';
session_start();

$msg = "";
if (isset($_GET['msg']) && $_GET['msg'] == "success") {
  $msg = "✅ Account created successfully. Please login.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email    = $conn->real_escape_string($_POST['email']);
  $password = $_POST['password'];

  $result = $conn->query("SELECT * FROM users WHERE email='$email'");
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['user_id']    = $row['id'];
      $_SESSION['user_name']  = $row['full_name'];
      $_SESSION['user_role']  = $row['role'];

      // Redirect based on role
      if ($row['role'] === 'admin') {
        header("Location: ./admin/admin_dashboard/admin_dashboard.php");
      } elseif ($row['role'] === 'doctor') {
        header("Location: ./doctor/doctor_dashboard/doctor_dashboard.php");
      } else {
        header("Location: ./patient/patient_dashboard/patient_dashboard.php");
      }
      exit();
    } else {
      $msg = "❌ Incorrect password!";
    }
  } else {
    $msg = "❌ No account found!";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <form method="POST">
    <h2>Login</h2>
    <?php if ($msg): ?>
      <p class="message <?= strpos($msg, '❌') !== false ? 'error' : '' ?>"><?= $msg ?></p>
    <?php endif; ?>

    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <a href="register.php">New user? Register here</a>
  </form>

</body>

</html>