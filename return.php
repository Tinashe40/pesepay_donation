<?php
require_once 'vendor/autoload.php';
require_once 'db.php';

use Codevirtus\Payments\Pesepay;

// Pesepay credentials
$integrationKey = 'a111f17c-982f-48dc-898d-03362af64ac4';
$encryptionKey = '09c4d8c3ce324b578b7efc6e6cdf470d';

// Initialize Pesepay instance
$pesepay = new Pesepay($integrationKey, $encryptionKey);

// Get reference number from return URL
if (!isset($_GET['reference_number'])) {
  error_log("Reference number not found in return URL");
  die("Reference number not provided.");
}

$referenceNumber = $_GET['reference_number'];
error_log("Captured Reference Number: $referenceNumber"); // Debugging


// Fetch transaction details from the database
$stmt = $pdo->prepare("SELECT * FROM donations WHERE reference_number = :reference_number");
$stmt->execute([':reference_number' => $referenceNumber]);
$donation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$donation) {
    die("Transaction not found.");
}

// Check payment status with Pesepay
$response = $pesepay->checkPayment($referenceNumber);

// Extract payment status
$transactionStatus = $response->success() ? ($response->paid() ? "Successful" : "Pending") : "Failed";
?>

<!DOCTYPE html>
<html>

<head>
  <title>Payment Details</title>
</head>

<body>
  <h1>Payment Details</h1>
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>Field</th>
      <th>Value</th>
    </tr>
    <tr>
      <td>Amount</td>
      <td><?php echo htmlspecialchars($donation['amount'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <td>Currency</td>
      <td><?php echo htmlspecialchars($donation['currency'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <td>Payment Reason</td>
      <td><?php echo htmlspecialchars($donation['reason'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <td>Reference Number</td>
      <td><?php echo htmlspecialchars($donation['reference_number'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <td>Transaction Status</td>
      <td><?php echo htmlspecialchars($transactionStatus, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <td>Date</td>
      <td><?php echo htmlspecialchars($donation['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
  </table>

  <a href="index.php">Go Back to Donate</a>
</body>

</html>