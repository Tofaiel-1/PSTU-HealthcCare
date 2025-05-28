<?php
header('Content-Type: application/json');
require_once '../db_config.php';

$specialization = $_GET['specialization'] ?? '';

if (!$specialization) {
  echo json_encode([]);
  exit;
}

$stmt = $conn->prepare("SELECT id, full_name FROM users WHERE role='doctor' AND specialization = ?");
$stmt->bind_param('s', $specialization);
$stmt->execute();
$result = $stmt->get_result();

$doctors = [];
while ($row = $result->fetch_assoc()) {
  $doctors[] = $row;
}

echo json_encode($doctors);
