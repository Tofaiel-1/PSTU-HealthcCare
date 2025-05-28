<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../login/login.php");
  exit();
}

include '../../db_config.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize inputs
  $full_name = trim($_POST['full_name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $gender = $_POST['gender'];
  $age = intval($_POST['age']);
  $address = trim($_POST['address']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $specialization = trim($_POST['specialization']);
  $qualification = trim($_POST['qualification']);

  // Validation
  if (!$full_name || !$email || !$phone || !$gender || !$age || !$password || !$confirm_password || !$specialization || !$qualification) {
    $error = "Please fill all required fields.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format.";
  } elseif ($password !== $confirm_password) {
    $error = "Passwords do not match.";
  } else {
    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $error = "Email is already registered.";
    } else {
      // Insert into DB
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $role = 'doctor';

      $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, gender, age, address, password, role, specialization, qualification) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssisssss", $full_name, $email, $phone, $gender, $age, $address, $hashed_password, $role, $specialization, $qualification);

      if ($stmt->execute()) {
        // Redirect after success
        header("Location: ../manage_doctors/manage_doctors.php");
        exit();
      } else {
        $error = "Database error: " . $conn->error;
      }
    }
    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Doctor - PSTU Healthcare</title>
  <link rel="stylesheet" href="../admin_navbar/style.css" />
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include('../admin_navbar/admin_sidebar.php'); ?>

  <main class="main-content">
    <h1>Add Doctor</h1>

    <?php if ($error): ?>
      <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="add_doctor.php" method="post" class="form-box" autocomplete="off">
      <div class="form-group">
        <label for="full_name">Full Name *</label>
        <input type="text" name="full_name" id="full_name" required value="<?php echo isset($full_name) ? htmlspecialchars($full_name) : ''; ?>" />
      </div>

      <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" name="email" id="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" />
      </div>

      <div class="form-group">
        <label for="phone">Phone *</label>
        <input type="text" name="phone" id="phone" required value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" />
      </div>

      <div class="form-group">
        <label for="gender">Gender *</label>
        <select name="gender" id="gender" required>
          <option value="" disabled <?php if (!isset($gender)) echo 'selected'; ?>>Select gender</option>
          <option value="Male" <?php if (isset($gender) && $gender === 'Male') echo 'selected'; ?>>Male</option>
          <option value="Female" <?php if (isset($gender) && $gender === 'Female') echo 'selected'; ?>>Female</option>
          <option value="Other" <?php if (isset($gender) && $gender === 'Other') echo 'selected'; ?>>Other</option>
        </select>
      </div>

      <div class="form-group">
        <label for="age">Age *</label>
        <input type="number" name="age" id="age" min="20" max="100" required value="<?php echo isset($age) ? htmlspecialchars($age) : ''; ?>" />
      </div>

      <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" id="address" rows="3"><?php echo isset($address) ? htmlspecialchars($address) : ''; ?></textarea>
      </div>

      <div class="form-group">
        <label for="specialization">Specialization *</label>
        <input type="text" name="specialization" id="specialization" required value="<?php echo isset($specialization) ? htmlspecialchars($specialization) : ''; ?>" />
      </div>

      <div class="form-group">
        <label for="qualification">Qualification *</label>
        <input type="text" name="qualification" id="qualification" required value="<?php echo isset($qualification) ? htmlspecialchars($qualification) : ''; ?>" />
      </div>

      <div class="form-group">
        <label for="password">Password *</label>
        <input type="password" name="password" id="password" required />
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password *</label>
        <input type="password" name="confirm_password" id="confirm_password" required />
      </div>

      <button type="submit">Add Doctor</button>
    </form>
  </main>
</body>

</html>