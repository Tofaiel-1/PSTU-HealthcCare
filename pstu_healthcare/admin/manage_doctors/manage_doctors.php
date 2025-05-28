<!-- manage_doctor.php -->
<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../login/login.php");
  exit();
}
include '../../db_config.php';
$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'doctor'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage Doctors - PSTU Healthcare</title>
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="../admin_navbar/style.css">
  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: white;
      margin: 10% auto;
      padding: 30px;
      border-radius: 8px;
      width: 400px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .close {
      float: right;
      font-size: 24px;
      cursor: pointer;
    }
  </style>
</head>

<body>

  <?php include('../admin_navbar/admin_sidebar.php'); ?>

  <main class="main-content">
    <h1>Manage Doctors</h1>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'added'): ?>
      <script>
        alert("Doctor added successfully!");
      </script>
    <?php endif; ?>

    <div class="top-bar">
      <button class="add-btn" onclick="window.location.href='../add_doctor/add_doctor.php'">➕ Add Doctor</button>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['full_name']) ?></td>
              <td><?= htmlspecialchars($row['specialization']) ?></td>
              <td><?= htmlspecialchars($row['phone']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td>
                <button class="edit-btn" onclick='openEditModal(<?= json_encode($row) ?>)'>✏️ Edit</button>
                <a href="delete_doctor.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Edit Modal -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Edit Doctor</h2>
      <form id="editForm">
        <input type="hidden" name="id" id="edit-id">
        <label>Name:</label>
        <input type="text" name="full_name" id="edit-name" required>
        <label>Email:</label>
        <input type="email" name="email" id="edit-email" required>
        <label>Phone:</label>
        <input type="text" name="phone" id="edit-phone" required>
        <label>Specialization:</label>
        <input type="text" name="specialization" id="edit-specialization" required>
        <label>Qualification:</label>
        <input type="text" name="qualification" id="edit-qualification" required>
        <button type="submit">Update Doctor</button>
      </form>
    </div>
  </div>

  <script>
    function openEditModal(data) {
      document.getElementById('edit-id').value = data.id;
      document.getElementById('edit-name').value = data.full_name;
      document.getElementById('edit-email').value = data.email;
      document.getElementById('edit-phone').value = data.phone;
      document.getElementById('edit-specialization').value = data.specialization;
      document.getElementById('edit-qualification').value = data.qualification;
      document.getElementById('editModal').style.display = 'block';
    }

    function closeModal() {
      document.getElementById('editModal').style.display = 'none';
    }

    document.getElementById('editForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch('update_doctor.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.text())
        .then(data => {
          alert("Doctor updated successfully!");
          location.reload();
        })
        .catch(err => {
          alert("Update failed");
        });
    });
  </script>

</body>

</html>