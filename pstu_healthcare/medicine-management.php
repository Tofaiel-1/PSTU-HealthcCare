<?php
session_start();
require_once './db_config.php';

$result = $conn->query("SELECT * FROM medicine ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Available Medicines | PSTU HealthCare</title>
  <link rel="stylesheet" href="./navStyle.css">
  <link rel="stylesheet" href="./footer.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1000px;
      margin: 30px auto;
      padding: 20px;
      background: #ffffff;
      border-radius: 8px;
      min-height: 100vh;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .medicine-header {
      text-align: center;
      color: #007bff;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
    }

    th,
    td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .no-data {
      text-align: center;
      padding: 20px;
      font-style: italic;
      color: #888;
    }
  </style>
</head>

<body>

  <?php include('navbar.php'); ?>

  <div class="container">
    <h1 class="medicine-header">Available Medicines</h1>

    <?php if ($result && $result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity Available</th>
            <th>Price (TK)</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['description']) ?></td>
              <td><?= $row['quantity'] ?></td>
              <td><?= number_format($row['price'], 2) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="no-data">No medicines found.</div>
    <?php endif; ?>
  </div>
  <?php include 'footer.php'; ?>

</body>

</html>