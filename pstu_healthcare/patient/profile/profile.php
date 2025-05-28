<?php
session_start();
include '../../db_config.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $full_name = trim($_POST['full_name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $gender = trim($_POST['gender']);
  $age = intval($_POST['age']);
  $address = trim($_POST['address']);

  if (empty($full_name) || empty($email)) {
    $message = "Full Name and Email are required.";
  } else {
    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone=?, gender=?, age=?, address=? WHERE id=?");
    $stmt->bind_param("ssssisi", $full_name, $email, $phone, $gender, $age, $address, $user_id);
    if ($stmt->execute()) {
      $message = "Profile updated successfully.";
    } else {
      $message = "Error updating profile: " . $conn->error;
    }
  }
}

$stmt = $conn->prepare("SELECT full_name, email, phone, gender, age, address FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Patient Profile - PSTU Healthcare</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../patient_navbar/style.css">
</head>

<body>

  <div class="sidebar">
    <?php include '../patient_navbar/patient_navbar.php'; ?>
  </div>

  <div class="content">
    <div class="container">
      <h1>Patient Profile</h1>

      <?php if ($message): ?>
        <p class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
          <?php echo htmlspecialchars($message); ?>
        </p>
      <?php endif; ?>

      <form method="POST" action="">
        <label for="full_name">Full Name *</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required />

        <label for="email">Email *</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required readonly />

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required />

        <label for="gender">Gender</label>
        <select id="gender" name="gender">
          <option value="" <?php if ($user['gender'] == '') echo 'selected'; ?>>Select Gender</option>
          <option value="Male" <?php if ($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
          <option value="Female" <?php if ($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
          <option value="Other" <?php if ($user['gender'] == 'Other') echo 'selected'; ?>>Other</option>
        </select>

        <label for="age">Age</label>
        <input type="number" id="age" name="age" min="0" max="150" value="<?php echo htmlspecialchars($user['age']); ?>" required />

        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3" required><?php echo htmlspecialchars($user['address']); ?></textarea>

        <button type="submit">Save Changes</button>
      </form>
    </div>
  </div>

</body>

</html>