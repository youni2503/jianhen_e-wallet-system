<?php
    session_start();
    require_once('../connection.php');

    $uid = $_SESSION['id'];
    $qrcode = $_GET['qrcode'];

    $sql_emp = "SELECT * FROM employee WHERE emp_id= '$uid'";
    $result_emp = mysqli_query($connection, $sql_emp);
    $row_emp = mysqli_fetch_array($result_emp);


    $sql_qr = "SELECT qrpay.*,Vendors.vendor_name FROM qrpay 
    LEFT JOIN Vendors ON qrpay.vendor_id = Vendors.vendor_id
    WHERE qrpay.random_code = '$qrcode'";
    $result_qr = mysqli_query($connection, $sql_qr);
    $row_qr = mysqli_fetch_array($result_qr);

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
        }
        .receipt-container {
            width: 360px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        .header {
            font-size: 24px;
            color: #4CAF50;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .icon {
            font-size: 50px;
            color: #4CAF50;
            margin-bottom: 15px;
        }
        .detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .label {
            font-size: 16px;
            color: #666;
        }
        .value {
            font-size: 16px;
            font-weight: bold;
        }
        .exit-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #f44336;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .exit-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <div class="icon"> <img src="../Image/Retail360.png" alt="" style="height: 60px; width: 60px;" /></div>
    <div class="header">Payment Successful</div>

    <div class="detail">
        <span class="label">Amount Paid:</span>
        <span class="value">RM <?php echo $row_qr['amount']; ?></span>
    </div>
    <div class="detail">
        <span class="label">Current Ewallet Balance:</span>
        <span class="value">RM <?php echo $row_emp['employee_ewallet_balance']; ?></span>
    </div>
    <div class="detail">
        <span class="label">Vendor Name:</span>
        <span class="value"><?php echo $row_qr['vendor_name']; ?></span>
    </div>
    <div class="detail">
        <span class="label">Date & Time Paid:</span>
        <span class="value"><?php echo $row_qr['pay_date']; ?></span>
    </div>

    <a href="index.php" class="exit-button">Exit</a>
</div>

</body>
</html>
