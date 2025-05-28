<?php
session_start();
header('Content-Type: application/json');

require_once '../../db_config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'doctor') {
  echo json_encode(['success' => false, 'message' => 'Unauthorized']);
  exit();
}

$appointment_id = $data['appointment_id'] ?? null;
$patient_id = $data['patient_id'] ?? null;
$prescription = $data['prescription'] ?? '';

if (!$appointment_id || !$patient_id || !$prescription) {
  echo json_encode(['success' => false, 'message' => 'Missing required fields']);
  exit();
}

// Insert or update prescription
$sql = "INSERT INTO prescriptions (appointment_id, patient_id, doctor_id, content, issued_at)
        VALUES (?, ?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE content = VALUES(content), issued_at = NOW()";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $appointment_id, $patient_id, $_SESSION['user_id'], $prescription);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
