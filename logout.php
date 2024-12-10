<?php
include 'connection.php';
session_start();
unset($_SESSION['id']);
unset($_SESSION['name']);
echo "<script>alert('Logout Successfully!'); window.location.href='index.php'</script>";
?>