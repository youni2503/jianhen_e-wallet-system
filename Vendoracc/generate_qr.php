<?php
session_start();
include '../connection.php'; // Database connection
require '../vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

//QR code details and expiry
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $vendor_id = $_SESSION['id'];
    $expiry_time = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    $random_code = bin2hex(random_bytes(11));

    // Set QR code options
    $options = new QROptions([
        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
        'eccLevel' => QRCode::ECC_L,
        'scale' => 10,
    ]);

    // Define file path to save the QR code image
    $qrcode_image_path = "qrcode/" . uniqid() . ".png"; // Ensure this directory is writable

    // Generate and save the QR code image with the random code as its data
    (new QRCode($options))->render($random_code, $qrcode_image_path);

    // Insert record into the database
    $stmt = $connection->prepare("INSERT INTO qrpay (qrcode, amount, validity, vendor_id,random_code) VALUES (?, ?, ?, ?,?)");
    $stmt->bind_param("sdsis", $qrcode_image_path, $amount, $expiry_time, $vendor_id,$random_code);
    $stmt->execute();

    // Response with QR code details
    echo json_encode([
        'qrcode' => $qrcode_image_path,
        'amount' => $amount,
        'validity' => $expiry_time,
        'random_code' => $random_code
    ]);
}
