<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        .html5-qrcode-element {
            font-family: Arial, sans-serif;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            margin: 10px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .html5-qrcode-element:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .html5-qrcode-element:active {
            background-color: #004494;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div id="qr-reader"></div>

    <script type="text/javascript">
        let html5QrcodeScanner;

        const barcodeReader = {
            pauseScan: function (freeze = true) {
                const state = html5QrcodeScanner.getState();
                if (state === Html5QrcodeScannerState.SCANNING) {
                    html5QrcodeScanner.pause(freeze);
                }
            },
            resumeScan: function () {
                const state = html5QrcodeScanner.getState();
                if (state === Html5QrcodeScannerState.PAUSED) {
                    html5QrcodeScanner.resume();
                }
            },
            onScanSuccess: function (decodedText, result) {
                barcodeReader.pauseScan();
                setTimeout(() => {
                    barcodeReader.resumeScan();
                }, 1200);
                barcodeReader.qrCodeSuccessHandler(decodedText);
            },
            qrCodeSuccessHandler: function (qrCodeMessage) {
                // Perform additional actions (e.g., send to server)
                recordTransaction(qrCodeMessage);
            }
        };

        function onScanError(errorMessage) {
            // handle scan error
            //console.error(errorMessage);
        }

        function recordTransaction(qrData) {
            $.ajax({
                url: 'save_transaction.php',
                type: 'POST',
                data: { qrData: qrData },
                success: function(response) {

        
                    var data = parseInt(response.replace(/\s+/g, ''));
         
                    switch (data) {
                        case 0:
                            alert('Invalid QRCODE!');
                            break;
                        case 1:
                            alert('Whoops! You dont have Sufficient Amount!');
                            break;
                        case 2:
                            alert('Payment Success!');
                            window.location.href = "paymentsuccess.php?qrcode="+qrData;
                            break;
                        default:
                            alert('Invalid QRCODE!');
                            break;
                    }
                },
                error: function(xhr, status, error) {
                    alert('Whoops! Error!');
                   console.error('Error saving payment:', error);
                }
            });
        }

        const startScanner = () => {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }

            const config = { fps: 10, qrbox: { width: 400, height: 400 }, rememberLastUsedCamera: true,  supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]};
            html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", config, false);
            html5QrcodeScanner.render(barcodeReader.onScanSuccess, onScanError);
        };

        document.addEventListener('DOMContentLoaded', () => {
            startScanner();
        });
    </script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
