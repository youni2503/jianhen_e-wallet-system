<?php

//database connection
date_default_timezone_set("Asia/Kuala_Lumpur");
$host = "localhost"; $uname = "root"; $pass = ""; $name = "ewallet";
$connection = mysqli_connect($host, $uname, $pass, $name);
if(mysqli_connect_errno()){ 
  echo 'Connection Error : ' .mysqli_connect_error();
}

function checkAndUpdateEmployeeCredits($connection) {

  $currentMonth = date('Y-m');
  
  $query = "SELECT emp_id, employee_name, employee_id, employee_email, employee_ewallet_balance FROM employee";
  $result = $connection->query($query);

  while ($employee = $result->fetch_assoc()) {

      //check credit update
      $checkQuery = "SELECT * FROM system_autoreload WHERE employee_id = ? AND DATE_FORMAT(datetime, '%Y-%m') = ?";
      $stmt = $connection->prepare($checkQuery);
      $stmt->bind_param("is", $employee['emp_id'], $currentMonth);
      $stmt->execute();
      $checkResult = $stmt->get_result();

      //increase balance
      if ($checkResult->num_rows == 0) {
          //new user balance
          $newBalance = $employee['employee_ewallet_balance'] +0 ;
          $updateBalanceQuery = "UPDATE employee SET employee_ewallet_balance = ? WHERE emp_id = ?";
          $stmt = $connection->prepare($updateBalanceQuery);
          $stmt->bind_param("di", $newBalance, $employee['emp_id']);
          $stmt->execute();

          //auto reload
          $amount = 200;
          $insertQuery = "INSERT INTO system_autoreload (employee_id, amount, datetime) VALUES (?, ?, NOW())";
          $stmt = $connection->prepare($insertQuery);
          $stmt->bind_param("id", $employee['emp_id'], $amount);
          $stmt->execute();
      }
  }
}

checkAndUpdateEmployeeCredits($connection);
?>