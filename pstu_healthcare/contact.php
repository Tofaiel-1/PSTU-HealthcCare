<?php
$success = "";
$error = "";

// Include the DB connection
include './db_config.php'; // ✅ update the correct path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name    = htmlspecialchars(trim($_POST['name']));
  $email   = htmlspecialchars(trim($_POST['email']));
  $subject = htmlspecialchars(trim($_POST['subject']));
  $message = htmlspecialchars(trim($_POST['message']));

  if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
      $success = "✅ Thank you! Your message has been sent successfully.";
    } else {
      $error = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
  } else {
    $error = "⚠️ Please fill in all the fields.";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Contact Us - PSTU Healthcare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="navStyle.css">
  <link rel="stylesheet" href="footer.css">
  <style>
    .call-button {
      display: inline-block;
      background-color: #28a745;
      color: white;
      font-size: 18px;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .call-button:hover {
      background-color: #218838;
    }

    body,
    html {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f4f8;
      height: 100%;
    }

    h2 {
      text-align: center;
      padding: 30px 0 10px;
      color: #1e293b;
    }

    .contact-flex {
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: flex-start;
      padding: 10px;
      flex-wrap: wrap;
    }

    .form-section,
    .map-section {
      flex: 1 1 400px;
      max-width: 600px;
      padding: 20px 20px 20px;
      box-sizing: border-box;
    }

    .map-section {
      padding: 0px 20px 0px;
    }

    .form-section {
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .form-control:focus {
      border-color: #198754;
      box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, .25);
    }

    .map-section iframe {
      width: 100%;
      height: 100%;
      min-height: 500px;
      border: 0;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    @media (max-width: 992px) {
      .contact-flex {
        flex-direction: column;
        align-items: stretch;
      }

      .form-section,
      .map-section {
        max-width: 100%;
        margin-bottom: 30px;
      }
    }
  </style>
</head>

<body>
  <?php include('navbar.php'); ?>

  <h2>Contact PSTU Healthcare</h2>
  <!-- Call Us Button -->
  <a href="tel:+8801707490998" class="call-button">📞 Call Us Now</a>


  <div class="contact-flex">
    <!-- Form Section -->
    <div class="form-section">
      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" action="contact.php">
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" name="name" class="form-control" placeholder="Your full name">
        </div>
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="example@domain.com">
        </div>
        <div class="mb-3">
          <label class="form-label">Subject</label>
          <input type="text" name="subject" class="form-control" placeholder="Subject of your message">
        </div>
        <div class="mb-3">
          <label class="form-label">Your Message</label>
          <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..."></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">Send Message</button>
      </form>
    </div>

    <!-- Map Section -->
    <div class="map-section">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3687.0401402636476!2d90.37983407475406!3d22.465125836901887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30aacf2fd022293d%3A0x44b93eed1a792d51!2sHealth%20Care%20Center%2C%20PSTU!5e0!3m2!1sen!2sbd!4v1748059875607!5m2!1sen!2sbd"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>

</html>