<?php
session_start();
require_once '../../db_config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'message' => 'Method not allowed']);
  exit();
}

// Check user is logged in and doctor
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'doctor') {
  http_response_code(403);
  echo json_encode(['success' => false, 'message' => 'Unauthorized']);
  exit();
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['id'], $input['status'])) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => 'Invalid input']);
  exit();
}

$appointment_id = intval($input['id']);
$new_status = $input['status'];
$doctor_id = $_SESSION['user_id'];

// Validate status
$valid_statuses = ['Pending', 'Completed', 'Cancelled'];
if (!in_array($new_status, $valid_statuses)) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => 'Invalid status']);
  exit();
}

// Update status only if this appointment belongs to the logged-in doctor
$sql = "UPDATE appointments SET status = ? WHERE id = ? AND doctor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $new_status, $appointment_id, $doctor_id);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => 'Database error']);
}

$stmt->close();
$conn->close();
