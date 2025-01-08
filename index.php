<!DOCTYPE html>
<html>

<head>
  <title>Pesepay Donation</title>
</head>

<body>
  <h1>Make a Donation</h1>
  <form action="process_payment.php" method="POST">
    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" step="0.01" required>
    <br>
    <label for="currency">Currency:</label>
    <select id="currency" name="currency" required>
      <option value="USD">USD</option>
      <option value="ZIG">ZIG</option>
    </select>
    <br>
    <button type="submit">Donate</button>
  </form>
</body>

</html>