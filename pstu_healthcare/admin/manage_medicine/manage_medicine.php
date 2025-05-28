<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../../login/login.php");
  exit();
}
require_once '../../db_config.php';

// Handle Add Medicine form submission
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_medicine'])) {
  $name = $conn->real_escape_string($_POST['name']);
  $description = $conn->real_escape_string($_POST['description']);
  $quantity = intval($_POST['quantity']);
  $price = floatval($_POST['price']);

  if ($name == '') {
    $msg = "❌ Medicine name is required!";
  } else {
    $stmt = $conn->prepare("INSERT INTO medicine (name, description, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssid', $name, $description, $quantity, $price);
    if ($stmt->execute()) {
      $msg = "✅ Medicine added successfully.";
    } else {
      $msg = "❌ Failed to add medicine.";
    }
    $stmt->close();
  }
}

// Fetch all medicines
$result = $conn->query("SELECT * FROM medicine ORDER BY created_at ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manage Medicine - Admin Dashboard</title>
  <link rel="stylesheet" href="../admin_navbar/style.css" />
  <link rel="stylesheet" href="./style.css" />
  <style>
    .container {
      width: 100%;
      padding: 2rem;
      background: #f9f9f9;
      margin: 20px 10px 20px 310px;
    }

    h1 {
      text-align: center;
      margin-bottom: 1rem;
    }

    form {
      margin-bottom: 2rem;
      background: #fff;
      padding: 1rem;
      border-radius: 6px;
      box-shadow: 0 0 8px #ddd;
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

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    th,
    td {
      padding: 10px 12px;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    .msg {
      margin-bottom: 1rem;
      font-weight: bold;
    }

    .action-btn {
      background-color: #28a745;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-right: 6px;
      font-size: 0.9rem;
      text-decoration: none;
    }

    .action-btn.delete {
      background-color: #dc3545;
    }
  </style>
</head>

<body>
  <div style="display: flex; min-height: 100vh;">
    <?php include('../admin_navbar/admin_sidebar.php'); ?>
    <main class="container">
      <h1>Manage Medicine</h1>

      <?php if ($msg): ?>
        <div class="msg"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <!-- Add Medicine Form -->
      <form method="POST" action="">
        <h2>Add New Medicine</h2>
        <input type="text" name="name" placeholder="Medicine Name" required />
        <textarea name="description" placeholder="Description (optional)" rows="3"></textarea>
        <input type="number" name="quantity" placeholder="Quantity" min="0" value="0" required />
        <input type="number" step="0.01" name="price" placeholder="Price (e.g. 10.99)" min="0" value="0.00" required />
        <button type="submit" name="add_medicine">Add Medicine</button>
      </form>

      <!-- Medicine List Table -->
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
              <td><?= $row['quantity'] ?></td>
              <td><?= number_format($row['price'], 2) ?> Tk</td>
              <td><?= $row['created_at'] ?></td>
              <td>
                <a href="edit_medicine.php?id=<?= $row['id'] ?>" class="action-btn">Edit</a>
                <a href="delete_medicine.php?id=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this medicine?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </main>
  </div>
</body>

</html>