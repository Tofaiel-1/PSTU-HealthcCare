<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../login/login.php");
  exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  // Invalid request
  header("Location: manage_doctors.php");
  exit();
}

include '../../db_config.php';

$doctor_id = intval($_GET['id']);

// Prepare statement to delete doctor
$stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'doctor'");
$stmt->bind_param("i", $doctor_id);

if ($stmt->execute()) {
  $stmt->close();
  $conn->close();
  header("Location: manage_doctors.php");
  exit();
} else {
  $stmt->close();
  $conn->close();
  header("Location: manage_doctors.php");
  exit();
}
