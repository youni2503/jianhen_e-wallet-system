<?php
session_start();
include '../connection.php';
$uid = $_SESSION['id'];

$id = mysqli_real_escape_string($connection, $_POST['id']);
$employee_ewallet_balance = mysqli_real_escape_string($connection ,$_POST['employee_ewallet_balance']);

$update = "UPDATE employee 
SET employee_ewallet_balance = '$employee_ewallet_balance'
WHERE emp_id = '$id'";        

mysqli_query($connection, $update);

echo "<script>alert('Ewallet Credit balance has been updated!'); window.location.href='index.php'</script>";
?>