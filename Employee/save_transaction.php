<?php
    session_start();
    require_once('../connection.php');
    date_default_timezone_set('Asia/Kuala_Lumpur');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['qrData'])) {
        $uid = $_SESSION['id'];
        $qr_data = $_POST['qrData'];

        $sql_emp = "SELECT * FROM employee WHERE emp_id= '$uid'";
        $result_emp = mysqli_query($connection, $sql_emp);
        $row_emp = mysqli_fetch_array($result_emp);



            $random_code = $qr_data;

            $sql_qr = "SELECT * FROM qrpay WHERE random_code = '$random_code' AND status = 'pending' AND validity > NOW()";
            $result_qr = mysqli_query($connection, $sql_qr);
            $row_qr = mysqli_fetch_array($result_qr);

            if ($row_qr == '') {
                echo 0;
                exit();
            }

            $amount = $row_qr['amount'];
            $ewalletbalance = $row_emp['employee_ewallet_balance'];

            if($ewalletbalance < $amount){
                echo 1;
                exit();
            }

            $newbalance = $ewalletbalance - $amount;

      

            $updateBalanceQuery = "UPDATE employee SET employee_ewallet_balance = ? WHERE emp_id = ?";
            $stmt = $connection->prepare($updateBalanceQuery);
            $stmt->bind_param("di", $newbalance, $uid);
            $stmt->execute();

            $updatePaymentQuery = "UPDATE qrpay SET payer_id = ?,pay_date = NOW(),status = 'completed' WHERE random_code = ?";
            $stmt = $connection->prepare($updatePaymentQuery);
            $stmt->bind_param("is", $uid, $random_code);
            $stmt->execute();

            $vendor_id = $row_qr['vendor_id'];

            $updateVendorQuery = "UPDATE Vendors SET vendor_ewallet_balance = vendor_ewallet_balance + ? WHERE vendor_id = ?";
            $stmt = $connection->prepare($updateVendorQuery);
            $stmt->bind_param("di", $amount, $vendor_id);
            $stmt->execute();


            $stmt = $connection->prepare("INSERT INTO ewallet_transaction (transaction_amount, transaction_datetime, vendor_id, emp_id,qr) VALUES (?, now(), ?, ?,?)");
            $stmt->bind_param("diis", $amount, $vendor_id, $uid,$random_code);
            $stmt->execute();
            

                echo 2;
                exit();
    } else {
        echo 0;
        echo 'Invalid request.';
    }
