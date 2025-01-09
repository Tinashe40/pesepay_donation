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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Transaction Details</title>
  <style>
  body {
    background-color: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }

  .details-container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 600px;
  }

  h1 {
    font-size: 1.5rem;
    text-align: center;
    margin-bottom: 20px;
  }

  table {
    width: 100%;
    margin-bottom: 20px;
  }

  table th,
  table td {
    padding: 10px;
    text-align: left;
  }

  table th {
    background-color: #007bff;
    color: white;
  }

  table tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  a {
    display: inline-block;
    text-decoration: none;
    color: white;
    background-color: #007bff;
    padding: 10px 20px;
    border-radius: 5px;
    text-align: center;
    margin-top: 10px;
  }

  a:hover {
    background-color: #0056b3;
  }
  </style>
</head>

<body>
  <div class="details-container">
    <h1>Payment Details</h1>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Field</th>
          <th>Value</th>
        </tr>
      </thead>
      <tbody>
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
      </tbody>
    </table>
    <a href="index.php" class="btn btn-primary w-100">Home</a>
  </div>
</body>

</html>