<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../login/login.php");
  exit();
}

include('../../db_config.php');

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  // First, check if the user is a patient
  $checkQuery = "SELECT * FROM users WHERE id = $id AND role = 'patient'";
  $checkResult = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    $deleteQuery = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($conn, $deleteQuery)) {
      header("Location: manage_patient.php?msg=deleted");
      exit();
    } else {
      echo "Error deleting patient: " . mysqli_error($conn);
    }
  } else {
    echo "Invalid patient ID or role.";
  }
} else {
  echo "No patient ID provided.";
}
