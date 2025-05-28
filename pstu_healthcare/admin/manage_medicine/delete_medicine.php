<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../../login/login.php");
  exit();
}
require_once '../../db_config.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $stmt = $conn->prepare("DELETE FROM medicine WHERE id = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();
}
header("Location: manage_medicine.php");
exit();
