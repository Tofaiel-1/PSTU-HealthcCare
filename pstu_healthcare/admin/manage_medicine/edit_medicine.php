<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../../login/login.php");
  exit();
}

require_once '../../db_config.php';

$msg = '';

// Get medicine ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: manage_medicine.php");
  exit();
}

$id = intval($_GET['id']);

// Fetch current medicine data
$stmt = $conn->prepare("SELECT * FROM medicine WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  $stmt->close();
  header("Location: manage_medicine.php");
  exit();
}

$medicine = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_medicine'])) {
  $name = $conn->real_escape_string($_POST['name']);
  $description = $conn->real_escape_string($_POST['description']);
  $quantity = intval($_POST['quantity']);
  $price = floatval($_POST['price']);

  if ($name == '') {
    $msg = "❌ Medicine name is required!";
  } else {
    $stmt = $conn->prepare("UPDATE medicine SET name = ?, description = ?, quantity = ?, price = ? WHERE id = ?");
    $stmt->bind_param('ssidi', $name, $description, $quantity, $price, $id);
    if ($stmt->execute()) {
      $msg = "✅ Medicine updated successfully.";
      // Refresh medicine info after update
      $medicine['name'] = $name;
      $medicine['description'] = $description;
      $medicine['quantity'] = $quantity;
      $medicine['price'] = $price;
    } else {
      $msg = "❌ Failed to update medicine.";
    }
    $stmt->close();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Edit Medicine - Admin Dashboard</title>
  <link rel="stylesheet" href="../admin_navbar/style.css" />
  <link rel="stylesheet" href="./style.css" />
  <style>
    /* Simple styling similar to manage_medicine.php */
    .container {
      max-width: 600px;
      margin: 2rem auto;
      padding: 1rem;
      background: #f9f9f9;
      border-radius: 8px;
      box-shadow: 0 0 10px #ccc;
    }

    h1 {
      text-align: center;
      margin-bottom: 1rem;
    }

    form input,
    form textarea {
      width: 100%;
      padding: 8px 10px;
      margin: 6px 0 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 1rem;
    }

    form button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    form button:hover {
      background-color: #0056b3;
    }

    .msg {
      margin-bottom: 1rem;
      font-weight: bold;
      text-align: center;
    }

    a.back-link {
      display: inline-block;
      margin-bottom: 1rem;
      text-decoration: none;
      color: #007bff;
    }

    a.back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <?php include('../admin_navbar/admin_sidebar.php'); ?>

  <main class="container">
    <a href="manage_medicine.php" class="back-link">&larr; Back to Manage Medicine</a>
    <h1>Edit Medicine</h1>

    <?php if ($msg): ?>
      <div class="msg"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="name">Medicine Name:</label>
      <input type="text" id="name" name="name" value="<?= htmlspecialchars($medicine['name']) ?>" required />

      <label for="description">Description:</label>
      <textarea id="description" name="description" rows="4"><?= htmlspecialchars($medicine['description']) ?></textarea>

      <label for="quantity">Quantity:</label>
      <input type="number" id="quantity" name="quantity" min="0" value="<?= $medicine['quantity'] ?>" required />

      <label for="price">Price (e.g. 10.99):</label>
      <input type="number" id="price" name="price" step="0.01" min="0" value="<?= number_format($medicine['price'], 2, '.', '') ?>" required />

      <button type="submit" name="update_medicine">Update Medicine</button>
    </form>
  </main>
</body>

</html>