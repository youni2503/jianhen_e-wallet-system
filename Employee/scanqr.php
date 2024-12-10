<?php include 'header.php';
?>

<style>
    /* Center the container vertically and horizontally */
.container-fluid {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh; /* Full viewport height */
}

.app-content .row {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tile {
    text-align: center;
    max-width: 500px; /* Optional: Limits the width of the content */
}

</style>

  <!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Centered Content Row -->
    <div class="row">
        <main class="app-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <h2>Scan QR Code to Make Payment</h2>
                        <hr />
                        <div>
                            <a href="scan.php" id="startScanBtn" class="btn btn-primary">Start Scanning QR Code</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

</div>
<?php include 'footer.php';?>