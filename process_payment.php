<?php
require_once 'vendor/autoload.php';
require_once 'db.php';

use Codevirtus\Payments\Pesepay;

// Pesepay credentials
$integrationKey = 'a111f17c-982f-48dc-898d-03362af64ac4';
$encryptionKey = '09c4d8c3ce324b578b7efc6e6cdf470d';

// Initialize Pesepay instance
$pesepay = new Pesepay($integrationKey, $encryptionKey);
$pesepay->returnUrl = "http://localhost:8000/return.php";
$pesepay->resultUrl = "http://localhost:8000/result.php";

// Fetch donation details
$amount = $_POST['amount'];
$currency = $_POST['currency'];
$paymentReason = 'donation';

// Create transaction
$transaction = $pesepay->createTransaction($amount, $currency, $paymentReason);

// Initiate transaction
$response = $pesepay->initiateTransaction($transaction);

if ($response->success()) {
    // Capture the reference number and poll URL
    $referenceNumber = $response->referenceNumber();
    $redirectUrl = $response->redirectUrl();

    // Debugging: Log reference number and redirect URL
    error_log("Reference Number: $referenceNumber");
    error_log("Redirect URL: $redirectUrl");

    // Save reference number, payment details, and other transaction information in the database
    $stmt = $pdo->prepare("INSERT INTO donations (amount, currency, reason, reference_number, created_at) VALUES (:amount, :currency, :reason, :reference_number, NOW())");
    $stmt->execute([
        ':amount' => $amount,
        ':currency' => $currency,
        ':reason' => $paymentReason,
        ':reference_number' => $referenceNumber,
    ]);

    // Redirect user to Pesepay
    header("Location: $redirectUrl");
    exit;
} else {
    // Error handling
    $errorMessage = $response->message();
    error_log("Pesepay Error: $errorMessage");
    die("Error initiating payment: $errorMessage");
}
?>