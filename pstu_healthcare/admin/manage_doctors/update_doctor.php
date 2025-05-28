<!-- update_doctor.php -->
<?php
include '../../db_config.php';

$id = $_POST['id'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$specialization = $_POST['specialization'];
$qualification = $_POST['qualification'];

$sql = "UPDATE users SET 
        full_name = '$full_name',
        email = '$email',
        phone = '$phone',
        specialization = '$specialization',
        qualification = '$qualification'
        WHERE id = $id AND role = 'doctor'";

if (mysqli_query($conn, $sql)) {
  echo "success";
} else {
  echo "error";
}
?>