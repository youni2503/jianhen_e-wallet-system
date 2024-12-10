<?php include 'header.php';

// Fetch transaction data
$sql = "SELECT ewallet_transaction.*, employee.employee_name, employee.employee_id 
FROM ewallet_transaction 
LEFT JOIN employee ON ewallet_transaction.emp_id = employee.emp_id
WHERE ewallet_transaction.vendor_id = '$uid'
ORDER BY ewallet_transaction.transaction_id DESC";
$result = mysqli_query($connection, $sql);

// Fetch vendor wallet balance
$sql_vendor = "SELECT vendor_ewallet_balance FROM Vendors WHERE vendor_id = '$uid'";
$result_vendor = mysqli_query($connection, $sql_vendor);
$row_vendor = mysqli_fetch_assoc($result_vendor); // Fetch the row as an associative array
?>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <a href="#" style="text-decoration: none;">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Ewallet Balance
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            RM <?php echo $row_vendor['vendor_ewallet_balance'] ?? '0.00'; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-archive fa-2x text-gray-300"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Transaction History</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List of Transactions</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort" style="text-align: left;">#</th>
                            <th style="text-align: left;">Employee</th>
                            <th style="text-align: left;">Total Amount</th>
                            <th style="text-align: left;">Date & Time</th>
                            <th style="text-align: left;">QR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td style="text-align: left;">
                                    <?php echo $row['employee_name']; ?><br>
                                    <?php echo $row['employee_id']; ?>
                                </td>
                                <td style="text-align: left;">RM <?php echo $row['transaction_amount']; ?></td>
                                <td style="text-align: left;"><?php echo $row['transaction_datetime']; ?></td>
                                <td style="text-align: left;"><?php echo $row['qr'] ? $row['qr'] : 'N/A'; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include 'footer.php'; ?>
