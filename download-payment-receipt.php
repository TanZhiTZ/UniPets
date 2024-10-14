<?php
require_once('TCPDF-main/tcpdf.php');
require_once('config/constants.php');

$orderId = $_GET['orderId'];

$sql = "SELECT * FROM purchaseorder WHERE orderId= '$orderId'";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if($count>0)
{
    while($row=mysqli_fetch_assoc($res))
    {
        $userName = $row['userName'];
        $orderDate = $row['orderDate'];
        $totalAmount = $row['totalAmount'];
        $paymentMethod = $row['paymentMethod'];
    }
}else {
    die('Payment not found');
}

$pdf = new TCPDF();
$pdf->AddPage();

// Set title and metadata
$pdf->SetTitle('Payment Receipt');
$pdf->SetAuthor('UniPets');
$pdf->SetMargins(20, 20, 20);

// Add the receipt content
$html = '
<style>

        /* Receipt Container */
        .receipt-container {
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px 40px;
            width: 500px;
            max-width: 100%;
            text-align: center;
        }

        /* Header Styles */
        .receipt-container h1 {
            color: #0056b3;
            font-size: 28px;
            margin-bottom: 20px;
            border-bottom: 2px solid #dcdcdc;
            padding-bottom: 10px;
        }

        .receipt-container p {
            margin: 10px 0;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        /* Strong Emphasis */
        .receipt-container p strong {
            color: #0056b3;
        }

        /* Thank You Note */
        .receipt-container .thank-you {
            margin-top: 30px;
            font-size: 18px;
            font-style: italic;
            color: #333;
        }

        /* Footer Note */
        .receipt-container .footer-note {
            margin-top: 20px;
            font-weight: bold;
            color: #444;
        }

        /* For Smaller Screens */
        @media screen and (max-width: 600px) {
            .receipt-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <h1>Payment Receipt</h1>
    <p><strong>Name:</strong> ' . $userName . '</p>
    <p><strong>Payment ID:</strong> ' . $orderId . '</p>
    <p><strong>Payment Amount:</strong> $' . number_format($totalAmount, 2) . '</p>
    <p><strong>Payment Date:</strong> ' . $orderDate . '</p>
    <p><strong>Payment Method:</strong> ' . $paymentMethod . '</p>

    <p class="thank-you">Thank you for your purchase!</p>

    <img class="login-logo" src="img/UniPets.jpg" alt="main_logo" width="235"/>
    <p class="footer-note">UniPets - Pet Adoption Platform</p>
</div>

</body>
</html>
';

// Write the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF for download
$pdf->Output('payment_receipt_' . $orderId . '.pdf', 'D');
?>
