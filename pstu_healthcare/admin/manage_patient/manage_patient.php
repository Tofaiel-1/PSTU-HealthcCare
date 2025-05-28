<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../login/login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage Patients - PSTU Healthcare</title>
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="../admin_navbar/style.css">
</head>

<body>

  <?php include('../admin_navbar/admin_sidebar.php'); ?>

  <main class="main-content">
    <h1>Manage Patients</h1>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include('../../db_config.php');
          $query = "SELECT * FROM users WHERE role='patient'";
          $result = mysqli_query($conn, $query);
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['full_name']}</td>
              <td>{$row['gender']}</td>
              <td>{$row['age']}</td>
              <td>{$row['phone']}</td>
              <td>{$row['email']}</td>
              <td>{$row['address']}</td>
              <td>
                <a href='delete_patient.php?id={$row['id']}' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this patient?')\">🗑️ Delete</a>
              </td>
            </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

</body>

</html>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
  <script>
    alert("Patient deleted successfully!");
  </script>
<?php endif; ?>