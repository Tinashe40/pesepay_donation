<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donation Form</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="hero-section">
    <div class="content">
      <h1>Be the Change Support Others, <br> Make a Difference.</h1>
      <p>
        Every contribution counts. Join us in making a difference by supporting our mission to uplift and empower
        others. Your generosity helps transform lives and brings hope to those in need. Together, let's be the change
        our community deserves.
      </p>
    </div>
    <div class="donation-form">
      <form action="process_payment.php" method="POST">
        <h2>Donate</h2>
        <label for="amount">Amount</label>
        <input type="number" id="amount" name="amount" required placeholder="Enter amount">

        <label for="currency">Select your Currency</label>
        <select id="currency" name="currency" required>
          <option value="">Choose Currency</option>
          <option value="USD">USD</option>
          <option value="ZIG">ZIG</option>
        </select>

        <button type="submit">Donate</button>
      </form>
    </div>
  </div>
</body>

</html>