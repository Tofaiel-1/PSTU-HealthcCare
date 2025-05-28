<?php
session_start();
require_once '../../db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'patient') {
  header("Location: ../../login.php");
  exit();
}

if (isset($_GET['id'])) {
  $appointment_id = intval($_GET['id']);
  $user_id = $_SESSION['user_id'];

  // Ensure appointment belongs to logged-in user
  $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ? AND patient_id = ?");
  $stmt->bind_param("ii", $appointment_id, $user_id);
  $stmt->execute();
  $stmt->close();
}

header("Location: appointment.php");
exit();
