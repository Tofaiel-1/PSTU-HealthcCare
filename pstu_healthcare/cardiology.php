<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cardiology Department - PSTU Healthcare</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #f4f9fb;
      color: #333;
    }

    header {
      background-color: #007B8F;
      padding: 20px;
      text-align: center;
      color: white;
    }

    header h1 {
      margin: 0;
    }

    .hero {
      background: url('C:\xampp\htdocs\pstu_healthcare\cardiology.png') center/cover no-repeat;
      height: 300px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .hero h2 {
      color: white;
      background-color: rgba(0, 0, 0, 0.5);
      padding: 20px 40px;
      border-radius: 10px;
      font-size: 2.5em;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .section-title {
      font-size: 28px;
      margin-bottom: 20px;
      border-left: 6px solid #007B8F;
      padding-left: 15px;
    }

    .description {
      line-height: 1.7;
      margin-bottom: 30px;
    }

    .services {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .service-card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      flex: 1 1 300px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .service-card h4 {
      color: #007B8F;
      margin-bottom: 10px;
    }

    footer {
      background-color: #007B8F;
      color: white;
      text-align: center;
      padding: 20px;
      margin-top: 40px;
    }
  </style>
</head>

<body>

  <header>
    <h1>PSTU Healthcare</h1>
  </header>

  <div class="hero">
    <h2>Cardiology Department</h2>
  </div>

  <div class="container">
    <h3 class="section-title">About Our Cardiology Division</h3>
    <p class="description">
      Our Cardiology Department provides comprehensive care for all types of heart conditions using the latest diagnostics, treatments, and preventative measures. Led by experienced cardiologists, we ensure personalized and compassionate care for each patient.
    </p>

    <h3 class="section-title">What We Offer</h3>
    <div class="services">
      <div class="service-card">
        <h4>Cardiac Check-up</h4>
        <p>Routine heart examinations to monitor and maintain heart health.</p>
      </div>
      <div class="service-card">
        <h4>ECG and Echocardiography</h4>
        <p>Advanced diagnostic tools for accurate heart condition detection.</p>
      </div>
      <div class="service-card">
        <h4>Hypertension & Cholesterol Management</h4>
        <p>Monitoring and treatment plans for high blood pressure and cholesterol.</p>
      </div>
      <div class="service-card">
        <h4>Emergency Cardiac Care</h4>
        <p>24/7 emergency services with trained specialists on standby.</p>
      </div>
      <div class="service-card">
        <h4>Cardiac Rehabilitation</h4>
        <p>Post-treatment programs to help patients recover and stay heart-healthy.</p>
      </div>
    </div>
  </div>

  <footer>
    &copy; <?php echo date('Y'); ?> PSTU Healthcare. All rights reserved.
  </footer>

</body>

</html>