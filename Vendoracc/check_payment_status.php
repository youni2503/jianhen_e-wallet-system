<?php
session_start();
include '../connection.php';

$vendor_id = $_SESSION['id'];
$random_code = $_POST['random_code'];

$stmt = $connection->prepare("SELECT amount, pay_date FROM qrpay WHERE vendor_id = ? AND status = 'completed' AND random_code = ? ORDER BY pay_date DESC LIMIT 1");
$stmt->bind_param("is", $vendor_id,$random_code);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['status' => 'completed', 'amount' => $row['amount'], 'pay_date' => $row['pay_date']]);
} else {
    echo json_encode(['status' => 'pending']);
}
?>
