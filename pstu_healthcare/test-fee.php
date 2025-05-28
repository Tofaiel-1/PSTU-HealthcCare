<?php
$selected_tests = [];
$total_fee = 0;
$payment_method = "";

$test_fees = [
  "Blood Test" => 300,
  "Urine Test" => 250,
  "X-Ray" => 500,
  "ECG" => 400,
  "CT Scan" => 2000,
  "MRI" => 3000,
  "Ultrasound" => 700,
  "Glucose Test" => 200,
  "Cholesterol Test" => 350,
  "Liver Function Test" => 600,
  "Kidney Function Test" => 550,
  "Thyroid Test" => 450,
  "Hemoglobin Test" => 150,
  "Dengue Test" => 800,
  "Malaria Test" => 500,
  "COVID-19 Test" => 1000,
  "Pregnancy Test" => 300
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $selected_tests = $_POST['tests'] ?? [];
  $payment_method = $_POST['payment_method'] ?? "";

  foreach ($selected_tests as $test) {
    if (isset($test_fees[$test])) {
      $total_fee += $test_fees[$test];
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="navStyle.css">
  <link rel="stylesheet" href="footer.css">
  <title>PSTU Healthcare - Test Fees & Payment</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: rgb(105, 149, 194);
    }

    .container {
      max-width: 700px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 6px 20px rgba(136, 158, 179, 0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #198754;
    }

    form label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    .test-list {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-top: 10px;
    }

    .test-list label {
      font-weight: normal;
    }

    .payment-section {
      margin-top: 20px;
    }

    .result-box {
      margin-top: 30px;
      background: rgb(110, 157, 172);
      padding: 20px;
      border-left: 5px solid #198754;
      border-radius: 5px;
    }

    button {
      background: #198754;
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 5px;
      margin-top: 20px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background: #146c43;
    }

    .back-button {
      margin-top: 30px;
      display: inline-block;
      background-color: #0d6efd;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
    }

    .back-button:hover {
      background-color: #0b5ed7;
    }
  </style>
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="container">
    <h2>Test Fees & Payment</h2>
    <form method="POST" action="">
      <label>Select Tests:</label>
      <div class="test-list">
        <?php foreach ($test_fees as $test => $fee): ?>
          <label>
            <input type="checkbox" name="tests[]" value="<?= $test ?>"
              <?= in_array($test, $selected_tests) ? 'checked' : '' ?>>
            <?= $test ?> (৳<?= $fee ?>)
          </label>
        <?php endforeach; ?>
      </div>

      <div class="payment-section">
        <label>Select Payment Method:</label>
        <label><input type="radio" name="payment_method" value="Cash" <?= $payment_method == "Cash" ? 'checked' : '' ?>> Cash</label>
        <label><input type="radio" name="payment_method" value="bKash" <?= $payment_method == "bKash" ? 'checked' : '' ?>> bKash</label>
        <label><input type="radio" name="payment_method" value="Nagad" <?= $payment_method == "Nagad" ? 'checked' : '' ?>> Nagad</label>
        <label><input type="radio" name="payment_method" value="Card" <?= $payment_method == "Card" ? 'checked' : '' ?>> Card</label>
      </div>

      <button type="submit">Calculate Fee</button>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
      <div class="result-box">
        <h4>Total Selected Tests: <?= count($selected_tests) ?></h4>
        <ul>
          <?php foreach ($selected_tests as $test): ?>
            <li><?= $test ?> - ৳<?= $test_fees[$test] ?></li>
          <?php endforeach; ?>
        </ul>
        <p><strong>Total Fee:</strong> ৳<?= $total_fee ?></p>
        <p><strong>Payment Method:</strong> <?= htmlspecialchars($payment_method) ?></p>
      </div>
    <?php endif; ?>
  </div>
  <?php include('footer.php'); ?>
</body>

</html>