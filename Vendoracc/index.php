<?php 
include 'header.php';

$sql_vendor = "SELECT * FROM Vendors WHERE vendor_id= '$uid'";
$result_vendor = mysqli_query($connection, $sql_vendor);
$row_vendor = mysqli_fetch_array($result_vendor);
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class="h3 mb-0">Hi <b style="color: blue;"><?php echo $_SESSION['name']; ?></b>!</h2>
    </div>

    <div class="row">

    <div class="col-lg-8 offset-lg-2">
    <!-- Amount Input -->
    <form id="qrForm" class="bg-light p-4 rounded shadow-sm">
        <div class="form-group">
            <label for="amount">Enter Amount (RM):</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>
        <button type="button" id="generateQr" class="btn btn-primary btn-block">Generate QR Code</button>
    </form>
</div>

        <!-- QR Code Modal -->
        <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrModalLabel">QR Code for Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="text" name="random_code" id="random_code" hidden>
                    <div class="modal-body text-center">
                        <h3 style="color:blue; font-weight:bold;"><?php echo $row_vendor['vendor_name']; ?></h3>
                        <div id="qrCodeContainer"></div>
                        <p style="font-size: 20px;">Amount: RM <span style="font-weight: bolder; color: red;" id="qrAmount"></span></p>
                        <p>Expires in: <span id="qrValidity"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>

$( document ).ready(function() {
$('#qrModal').on('hidden.bs.modal', function () {
    location.reload();
});
});

//QR Code Generation and Timer
document.getElementById('generateQr').addEventListener('click', function() {
    let amount = document.getElementById('amount').value;

    if (amount) {
        // AJAX request to generate the QR code
        $.ajax({
            url: 'generate_qr.php',
            type: 'POST',
            data: { amount: amount },
            success: function(response) {
                let data = JSON.parse(response);
                document.getElementById('qrAmount').textContent = data.amount;
                document.getElementById('random_code').value = data.random_code;
                document.getElementById('qrCodeContainer').innerHTML = `<img src="${data.qrcode}" style="height:500px; width:auto;" alt="QR Code">`;
                document.getElementById('qrValidity').textContent = "5:00";

                $('#qrModal').modal('show');

                // Start the validity countdown
                startCountdown(data.validity);
            }
        });

        setInterval(checkPaymentStatus, 5000);
    }
});

function startCountdown(expiryTime) {
    let interval = setInterval(function() {
        let timeLeft = calculateTimeLeft(expiryTime);

        if (timeLeft <= 0) {
            document.getElementById('qrValidity').textContent = "Expired";
            clearInterval(interval); // Stop the countdown
        } else {
            document.getElementById('qrValidity').textContent = formatTime(timeLeft);
        }
    }, 1000);
}

function checkPaymentStatus() {
    $.ajax({
        url: 'check_payment_status.php',
        type: 'POST',
        dataType: 'json',
        data: {
        'random_code': document.getElementById('random_code').value
    },
        success: function(response) {
      
            if (response.status === 'completed') {
                alert(`Payment of RM ${response.amount} received on ${response.pay_date}`);
                $('#qrModal').modal('hide');
                location.reload();
            }
        }
    });
}

function calculateTimeLeft(expiryTime) {
    let expiry = new Date(expiryTime).getTime();
    let now = new Date().getTime();
    return Math.floor((expiry - now) / 1000);
}

function formatTime(seconds) {
    let minutes = Math.floor(seconds / 60);
    let secs = seconds % 60;
    return `${minutes}:${secs < 10 ? '0' + secs : secs}`;
}
</script>

<?php include 'footer.php'; ?>