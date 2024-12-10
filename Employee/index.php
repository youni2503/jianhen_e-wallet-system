<?php include 'header.php';

$sql_emp = "SELECT * FROM employee WHERE emp_id= '$uid'";
$result_emp = mysqli_query($connection, $sql_emp);
$row_emp = mysqli_fetch_array($result_emp);

$sql_total_spending = "SELECT SUM(transaction_amount) as totalspending FROM ewallet_transaction WHERE emp_id = '$uid'";
$result_total_spending  = mysqli_query($connection, $sql_total_spending);
$row_total_spending = mysqli_fetch_array($result_total_spending);

$currentYear = date('Y');
$sql_monthly_spending = "
    SELECT DATE_FORMAT(transaction_datetime, '%Y-%m') AS month, 
           SUM(transaction_amount) AS monthly_total 
    FROM ewallet_transaction 
    WHERE emp_id = '$uid' AND YEAR(transaction_datetime) = '$currentYear'
    GROUP BY month
    ORDER BY month ASC";
$result_monthly_spending = mysqli_query($connection, $sql_monthly_spending);

// Initialize monthly data with zero for each month
$months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
$monthly_totals = array_fill(0, 12, 0);  // Start with zero spending for each month

// Fill in actual spending data from query
while ($row = mysqli_fetch_assoc($result_monthly_spending)) {
    $monthIndex = (int)date('n', strtotime($row['month'])) - 1;  // Get month index (0 for Jan, 11 for Dec)
    $monthly_totals[$monthIndex] = $row['monthly_total'];
}
?>

  <!-- Begin Page Content -->
    <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h2 class="h3 mb-0">Hi <b style="color: blue;"><?php echo $_SESSION['name']; ?></b> !</h2>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <a href="#" style="text-decoration: none;">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Ewallet Balance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">RM <?php echo $row_emp['employee_ewallet_balance']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-archive fa-2x text-gray-300"></i>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
            <a href="#" style="text-decoration: none;">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Spending</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">RM <?php echo $row_total_spending['totalspending']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </a>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Bar Chart Container -->
<div class="container mt-5">
<div class="card shadow h-100 py-2">
<div class="card-body">
    <h3 class="mb-4">Monthly Spending (<?php echo $currentYear; ?>)</h3>
    <canvas id="monthlySpendingChart"></canvas>
</div>
</div>
</div>

</div>
<!-- /.container-fluid -->
</div>
<?php include 'footer.php';?>

<script>
// Data from PHP
const months = <?php echo json_encode($months); ?>;
const monthlyTotals = <?php echo json_encode($monthly_totals); ?>;

// Chart.js to display monthly spending
const ctx = document.getElementById('monthlySpendingChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: months, // Display months from Jan to Dec
        datasets: [{
            label: 'Spending (RM)',
            data: monthlyTotals, // Use totals for each month
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Month'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Total Spending (RM)'
                }
            }
        }
    }
});
</script>