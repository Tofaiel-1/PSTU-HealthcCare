<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Healthcare Facilities & Treatments</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="navStyle.css">
  <link rel="stylesheet" href="footer.css">
  <a href="http://localhost/pstu_healthcare/index.php" style="text-decoration: none; color: white;">
    <!-- Notice Bar -->
    <div style="background-color: #f8d775; padding: 10px; font-size: 16px; color: #333; display: flex; justify-content: space-between; flex-wrap: wrap;">
      <marquee behavior="scroll" direction="left" scrollamount="5" style="flex: 1;">
        🏥 Free health check-up camp on June 10 at University Hall • 💉 Get vaccinated and protect yourself • 🍎 Eat fruits and stay hydrated this summer • 👩‍⚕️ World Health Day awareness program on July 7 • 🧠 Mental health matters – reach out for help
      </marquee>
      <div id="datetime" style="white-space: nowrap; margin-left: 10px; font-weight: bold;"></div>
    </div>
    <link rel="stylesheet" href="navStyle.css">


    <style>
      body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f9fd;
        color: #333;
      }


      section {
        padding: 40px 10px;
      }

      /* Dropdown Styling */
      .facility-dropdown-section {
        text-align: center;
      }

      .dropdown {
        display: inline-block;
        position: relative;
      }

      .dropdown-toggle {
        background-color: #0069d9;
        color: #fff;
        padding: 14px 26px;
        font-size: 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }

      .dropdown-toggle span {
        font-size: 14px;
        margin-left: 8px;
      }

      .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        width: 260px;
        top: 55px;
        left: 0;
        z-index: 1000;
      }

      .dropdown-menu a {
        display: block;
        padding: 12px 10px;
        color: #333;
        text-decoration: none;
        font-size: 16px;
        border-bottom: 1px solid #eee;
        transition: background 0.3s;
      }

      .dropdown-menu a:hover {
        background-color: #f1f1f1;
      }

      .dropdown:hover .dropdown-menu {
        display: block;
      }

      /* Treatment Categories */
      .treatment-categories-section {
        background-color: #f5faff;
        border-radius: 10px;
        text-align: center;
      }

      .section-title {
        font-size: 28px;
        margin-bottom: 30px;
        color: #007bff;
      }

      .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        padding: 0 10%;
      }

      .category-card {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
        font-size: 18px;
        font-weight: 500;
        color: #444;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
      }

      .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        background-color: #e6f0ff;
      }

      footer {
        margin-top: 50px;
        text-align: center;
        padding: 20px;
        background-color: #eee;
        font-size: 14px;
      }

      @media screen and (max-width: 600px) {
        .dropdown-toggle {
          font-size: 16px;
          padding: 10px 20px;
        }

        .section-title {
          font-size: 24px;
        }
      }
    </style>
</head>

<body>

  <?php include('navbar.php'); ?>

  <!-- Facilities Dropdown -->
  <section class="facility-dropdown-section">
    <div class="dropdown">
      <button class="dropdown-toggle">🏥 Our Facilities & Options <span>▼</span></button>
      <div class="dropdown-menu">
        <a href="#">🛏️ 24/7 Emergency Service</a>
        <a href="#">🚑 Ambulance Availability</a>
        <a href="#">🧪 Diagnostic Lab</a>
        <a href="#">💊 In-house Pharmacy</a>
        <a href="#">🩺 Expert Doctors Panel</a>
        <a href="#">📦 Health Check-up Packages</a>
        <a href="#">📞 Telemedicine & Counselling</a>
        <a href="#">📋 Online Appointment Booking</a>
      </div>
    </div>
  </section>

  <!-- Treatment Categories -->
  <section class="treatment-categories-section">
    <h2 class="section-title">🩻 Our Treatment Specialties</h2>
    <div class="category-grid">
      <a href="cardiology.php" class="category-card">
        🫀 Cardiology
      </a>

      <style>
        .category-card {
          display: inline-block;
          text-decoration: none;
          background-color: #007B8F;
          color: white;
          padding: 20px 30px;
          margin: 10px;
          font-size: 20px;
          border-radius: 12px;
          transition: background-color 0.3s ease, transform 0.2s;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
          font-weight: 600;
        }

        .category-card:hover {
          background-color: #005f6e;
          transform: translateY(-2px);
        }

        .category-card:active {
          transform: scale(0.97);
        }
      </style>

      <div class="category-card">🧠 Neurology</div>
      <div class="category-card">🦴 Orthopedics</div>
      <div class="category-card">👶 Pediatrics</div>
      <div class="category-card">👩‍⚕️ Gynecology</div>
      <div class="category-card">🦷 Dental Care</div>
      <div class="category-card">👁️ Eye Care</div>
      <div class="category-card">🏥 General Medicine</div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    &copy; 2025 PSTU Healthcare System. All Rights Reserved.
  </footer>

</body>

</html>