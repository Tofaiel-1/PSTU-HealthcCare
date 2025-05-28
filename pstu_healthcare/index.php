<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PSTU Healthcare Management System</title>
  <link rel="stylesheet" href="navStyle.css">
  <link rel="stylesheet" href="footer.css">
  <!-- Notice Bar -->
  <div style="background-color: #f8d775; padding: 10px 20px; font-size: 16px; color: #333; display: flex; justify-content: space-between; flex-wrap: wrap;">
    <marquee behavior="scroll" direction="left" scrollamount="5" style="flex: 1;">
      🏥 Free health check-up camp on June 10 at University Hall • 💉 Get vaccinated and protect yourself • 🍎 Eat fruits and stay hydrated this summer • 👩‍⚕️ World Health Day awareness program on July 7 • 🧠 Mental health matters – reach out for help
    </marquee>
    <div id="datetime" style="white-space: nowrap; margin-left: 10px; font-weight: bold;"></div>
  </div>

  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: #f9fafb;
      color: #1e293b;
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      width: 100%;
      font-size: 16px;
    }



    main {
      flex: 1;
      width: 100%;
      max-width: 1400px;
      margin: 60px auto 40px auto;
      padding: 0 20px;
    }

    /* Hero Section */
    .hero {
      position: relative;
      /* Make sure container is positioned for ::before */
      text-align: center;
      padding: 80px 20px 100px 20px;
      background-image: url("./images/hc.jpg");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      color: white;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgb(59 130 246 / 0.3);
      margin-bottom: 60px;
      overflow: hidden;
      /* ensure rounded corners clip overlay */
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.4);
      border-radius: 20px;
      z-index: 0;
    }

    .hero>* {
      position: relative;
      z-index: 1;
    }

    .hero h2 {
      font-size: 3rem;
      margin-bottom: 20px;
      letter-spacing: 1.5px;
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 700px;
      margin: 0 auto 40px auto;
      line-height: 1.5;
    }

    .btn-primary {
      background-color: white;
      color: #2563eb;
      font-weight: 700;
      padding: 16px 48px;
      font-size: 1.2rem;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      box-shadow: 0 4px 12px rgb(37 99 235 / 0.4);
      transition: background-color 0.3s, color 0.3s;
      display: inline-block;
      user-select: none;
    }

    .btn-primary:hover {
      background-color: #2563eb;
      color: white;
      box-shadow: 0 6px 18px rgb(37 99 235 / 0.7);
    }

    /* Features Section */
    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 40px;
      margin-bottom: 80px;
    }

    .feature-box {
      background: white;
      border-radius: 16px;
      box-shadow: 0 5px 15px rgb(0 0 0 / 0.1);
      padding: 30px 25px;
      text-align: center;
      transition: transform 0.3s ease;
    }

    .feature-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 25px rgb(0 0 0 / 0.15);
    }

    .feature-box h3 {
      color: #2563eb;
      margin-bottom: 16px;
      font-size: 1.3rem;
    }

    .feature-box p {
      color: #475569;
      font-size: 1rem;
      line-height: 1.4;
    }

    /* How It Works Section */
    .how-it-works {
      max-width: 900px;
      margin: 0 auto 80px auto;
      padding: 0 20px;
      text-align: center;
    }

    .how-it-works h2 {
      font-size: 2.4rem;
      color: #2563eb;
      margin-bottom: 40px;
    }

    .steps {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .step {
      background: white;
      box-shadow: 0 5px 15px rgb(0 0 0 / 0.1);
      border-radius: 20px;
      flex: 1 1 260px;
      padding: 30px 20px;
      color: #334155;
      user-select: none;
      transition: transform 0.3s ease;
    }

    .step:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 25px rgb(0 0 0 / 0.15);
    }

    .step-number {
      background: #3b82f6;
      color: white;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      font-weight: 700;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px auto;
      user-select: none;
    }

    .step h3 {
      margin-bottom: 14px;
      color: #2563eb;
    }

    .step p {
      line-height: 1.4;
    }

    /* Why Choose Us */
    .why-choose {
      max-width: 900px;
      margin: 0 auto 80px auto;
      padding: 0 20px;
      text-align: center;
    }

    .why-choose h2 {
      font-size: 2.4rem;
      color: #2563eb;
      margin-bottom: 40px;
    }

    .benefits {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
    }

    .benefit {
      background: white;
      padding: 30px 25px;
      border-radius: 20px;
      box-shadow: 0 5px 15px rgb(0 0 0 / 0.1);
      user-select: none;
      transition: transform 0.3s ease;
    }

    .benefit:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 25px rgb(0 0 0 / 0.15);
    }

    .benefit h3 {
      color: #2563eb;
      margin-bottom: 12px;
    }

    .benefit p {
      color: #475569;
      line-height: 1.4;
    }

    /* FAQ Section */
    .faq-section {
      max-width: 900px;
      margin: 0 auto 80px auto;
      padding: 0 20px;
    }

    .faq-section h2 {
      color: #2563eb;
      font-size: 2.4rem;
      margin-bottom: 40px;
      text-align: center;
    }

    details {
      background: white;
      border-radius: 15px;
      padding: 18px 25px;
      margin-bottom: 20px;
      box-shadow: 0 5px 15px rgb(0 0 0 / 0.1);
      cursor: pointer;
      user-select: none;
      transition: box-shadow 0.3s ease;
    }

    details:hover {
      box-shadow: 0 15px 25px rgb(0 0 0 / 0.15);
    }

    summary {
      font-weight: 700;
      font-size: 1.1rem;
      color: #2563eb;
      outline: none;
      user-select: none;
    }

    details[open] summary::after {
      content: "▲";
      float: right;
      font-size: 0.9rem;
      color: #3b82f6;
      user-select: none;
    }

    summary::after {
      content: "▼";
      float: right;
      font-size: 0.9rem;
      color: #3b82f6;
      user-select: none;
    }

    details p {
      margin-top: 10px;
      color: #475569;
      font-size: 1rem;
      line-height: 1.4;
    }

    /* Responsive */
    @media (max-width: 600px) {
      .steps {
        flex-direction: column;
        gap: 20px;
      }
    }
  </style>
</head>

<body>

  <?php include('navbar.php'); ?>
  

  <main>
    <!-- Hero Section -->
    <section class="hero">
      <h2>Your Health, Our Priority</h2>
      <p>
        Manage appointments, patient records, medicine inventory, and diagnostics
        easily with PSTU Healthcare Management System — designed for hospitals,
        clinics, and healthcare providers.
      </p>
      <a href="register.php" class="btn-primary">Get Started Now</a>
    </section>

    <!-- Features Section -->
    <section class="features">
      <div class="feature-box">
        <h3>Appointment Scheduling</h3>
        <p>Quickly book, view, and manage patient appointments with real-time updates.</p>
      </div>
      <div class="feature-box">
        <h3>Patient Records</h3>
        <p>Maintain secure and detailed medical histories accessible anytime.</p>
      </div>
      </div>
      <div class="feature-box">
        <h3>Medicine Management</h3>
        <p>Track availability, usage, and monthly needs of medicines with ease.</p>
      </div>
      <div class="feature-box">
        <h3>Diagnostic Tests</h3>
        <p>Manage diagnostic test records and fees seamlessly.</p>
      </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
      <h2>How It Works</h2>
      <div class="steps">
        <div class="step">
          <div class="step-number">1</div>
          <h3>Register & Login</h3>
          <p>Create your account and securely login to access the dashboard.</p>
        </div>
        <div class="step">
          <div class="step-number">2</div>
          <h3>Manage Healthcare</h3>
          <p>Schedule appointments, update patient info, manage medicines and tests.</p>
        </div>
        <div class="step">
          <div class="step-number">3</div>
          <h3>Analyze & Report</h3>
          <p>Generate reports for medicines, diagnostics, and patient visits.</p>
        </div>
      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose">
      <h2>Why Choose PSTU Healthcare?</h2>
      <div class="benefits">
        <div class="benefit">
          <h3>Easy to Use</h3>
          <p>Intuitive interface that healthcare providers can use without training.</p>
        </div>
        <div class="benefit">
          <h3>Secure & Reliable</h3>
          <p>Data protection with secure login and encrypted records.</p>
        </div>
        <div class="benefit">
          <h3>Comprehensive Management</h3>
          <p>All-in-one platform to handle appointments, medicines, and diagnostics.</p>
        </div>
        <div class="benefit">
          <h3>24/7 Support</h3>
          <p>Reliable technical support to keep your healthcare system running smoothly.</p>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
      <h2>Frequently Asked Questions</h2>

      <details>
        <summary>Is this system suitable for small clinics?</summary>
        <p>Yes, PSTU Healthcare Management is scalable for clinics and hospitals of any size.</p>
      </details>

      <details>
        <summary>How do I reset my password?</summary>
        <p>You can reset your password by clicking on the "Forgot Password" link on the login page.</p>
      </details>

      <details>
        <summary>Can I generate monthly medicine usage reports?</summary>
        <p>Yes, the system provides detailed monthly reports for medicine inventory and usage.</p>
      </details>

      <details>
        <summary>Is patient data stored securely?</summary>
        <p>Absolutely. We use encryption and secure authentication to protect all patient information.</p>
      </details>
    </section>

    <!-- Call to Action Section -->
    <section style="text-align: center; margin-bottom: 60px;">
      <a href="register.php" class="btn-primary">Join PSTU Healthcare Today</a>
    </section>
    <!-- Chatbot Button -->
    <div id="chatbot-btn" onclick="toggleChatbot()">Chat with us</div>

    <!-- Chatbot Window -->
    <div id="chatbot-window">
      <div id="chatbot-header">PSTU Health Assistant</div>
      <div id="chatbot-messages"></div>
      <input type="text" id="chatbot-input" placeholder="Type your question..." onkeypress="handleKey(event)">
    </div>

    <style>
      #chatbot-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #0f9d58;
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        cursor: pointer;
        z-index: 1000;
      }

      #chatbot-window {
        display: none;
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 300px;
        height: 400px;
        background: white;
        border: 1px solid #ccc;
        border-radius: 10px;
        overflow: hidden;
        z-index: 1000;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
      }

      #chatbot-header {
        background: #0f9d58;
        color: white;
        padding: 10px;
        font-weight: bold;
      }

      #chatbot-messages {
        height: 310px;
        padding: 10px;
        overflow-y: scroll;
        font-size: 14px;
      }

      #chatbot-input {
        width: 100%;
        padding: 10px;
        border: none;
        border-top: 1px solid #ddd;
      }
    </style>

    <script>
      function toggleChatbot() {
        var bot = document.getElementById('chatbot-window');
        bot.style.display = bot.style.display === 'block' ? 'none' : 'block';
      }

      function handleKey(e) {
        if (e.key === 'Enter') {
          const input = document.getElementById('chatbot-input');
          const msg = input.value;
          if (msg.trim() === '') return;
          document.getElementById('chatbot-messages').innerHTML += "<div><b>You:</b> " + msg + "</div>";
          input.value = '';
          getBotResponse(msg);
        }
      }

      function getBotResponse(msg) {
        let response = "Sorry, I didn't understand that.";
        const text = msg.toLowerCase();

        if (text.includes("doctor")) {
          response = "You can view available doctors on the 'Doctor List' page.";
        } else if (text.includes("appointment")) {
          response = "To book an appointment, go to the 'Appointment' page and select a time slot.";
        } else if (text.includes("medicine")) {
          response = "Medicine availability is shown on the 'Medicine Management' page.";
        } else if (text.includes("contact")) {
          response = "You can contact us via the 'Contact Us' page.";
        } else if (text.includes("lab test")) {
          response = "You can view lab tests on the 'Test Reports' page.";
        } else if (text.includes("report")) {
          response = "Reports are available under your patient profile in 'View Reports'.";
        } else if (text.includes("login")) {
          response = "Please click the 'Login' button on the top right to access your account.";
        } else if (text.includes("signup") || text.includes("register")) {
          response = "Click on 'Register' to create a new patient account.";
        } else if (text.includes("dashboard")) {
          response = "You can access the dashboard after logging in.";
        } else if (text.includes("admin")) {
          response = "Admins can log in using the Admin Login panel.";
        } else if (text.includes("patient")) {
          response = "Patient information is available in the 'Manage Patients' section.";
        } else if (text.includes("prescription")) {
          response = "Doctors can create and view prescriptions in the 'Prescription' section.";
        } else if (text.includes("history")) {
          response = "Patient history is shown in the profile page under 'Medical History'.";
        } else if (text.includes("emergency")) {
          response = "For emergencies, visit the hospital directly or call the emergency contact.";
        } else if (text.includes("services")) {
          response = "Our services include OPD, lab tests, consultations, and more.";
        } else if (text.includes("lab")) {
          response = "Lab details are under the 'Lab Services' section.";
        } else if (text.includes("logout")) {
          response = "Click 'Logout' at the top right corner to end your session.";
        } else if (text.includes("availability")) {
          response = "Doctor and medicine availability is updated in real-time.";
        } else if (text.includes("slot")) {
          response = "Each doctor has defined slots per day. Check the appointment page.";
        } else if (text.includes("forgot password")) {
          response = "Use the 'Forgot Password' link on the login page to reset it.";
        } else if (text.includes("reset password")) {
          response = "Go to your profile > Change Password.";
        } else if (text.includes("working hour")) {
          response = "Our hospital operates from 8 AM to 8 PM daily.";
        } else if (text.includes("location") || text.includes("map")) {
          response = "Our location is shown on the 'Contact Us' page with Google Maps.";
        } else if (text.includes("fees")) {
          response = "Test and consultation fees are listed on the 'Fees' section.";
        } else if (text.includes("payment")) {
          response = "We accept payment via cash or mobile banking at the reception.";
        } else if (text.includes("blood")) {
          response = "Blood group details are stored in the patient profile.";
        } else if (text.includes("age")) {
          response = "You must be 18+ to register without a guardian.";
        } else if (text.includes("gender")) {
          response = "We collect gender information to tailor healthcare.";
        } else if (text.includes("covid")) {
          response = "COVID-19 services are available under the 'Health Alerts' section.";
        } else if (text.includes("vaccination")) {
          response = "Vaccination records are stored in the patient's profile.";
        } else if (text.includes("insurance")) {
          response = "Currently, we do not support health insurance integration.";
        } else if (text.includes("discharge")) {
          response = "Discharge summaries are generated by the hospital admin.";
        } else if (text.includes("upload")) {
          response = "Doctors and lab staff can upload documents from their dashboard.";
        } else if (text.includes("download")) {
          response = "You can download prescriptions and reports as PDFs.";
        } else if (text.includes("profile")) {
          response = "You can update your profile from the 'My Profile' page.";
        } else if (text.includes("notification")) {
          response = "Notifications appear in your dashboard when logged in.";
        } else if (text.includes("staff")) {
          response = "Staff records are maintained by the admin.";
        } else if (text.includes("room")) {
          response = "Room availability is updated in the admin dashboard.";
        } else if (text.includes("bed")) {
          response = "Bed allotment is done by the admission office.";
        } else if (text.includes("ambulance")) {
          response = "You can request ambulance support via emergency services.";
        } else if (text.includes("help")) {
          response = "You can always ask me or visit the Help Center.";
        } else if (text.includes("ai")) {
          response = "Yes, I am an AI assistant built to support your hospital queries.";
        } else if (text.includes("language")) {
          response = "Currently, we support both Bengali and English.";
        } else if (text.includes("feedback")) {
          response = "Please leave your feedback in the 'Feedback' section.";
        } else if (text.includes("rating")) {
          response = "Patients can rate services after their appointment.";
        } else if (text.includes("holiday")) {
          response = "The hospital remains open even on weekends. Limited staff on public holidays.";
        } else if (text.includes("mobile app")) {
          response = "A mobile app version is under development.";
        } else if (text.includes("chatbot")) {
          response = "I'm your friendly AI chatbot assistant!";
        } else if (text.includes("user guide")) {
          response = "You can download the user manual from the Help section.";
        } else if (text.includes("database")) {
          response = "Database management is handled by the IT department.";
        } else if (text.includes("backup")) {
          response = "The system performs automatic daily backups.";
        } else if (text.includes("data privacy")) {
          response = "All data is stored securely and adheres to privacy policies.";
        } else if (text.includes("policy")) {
          response = "Our policies are listed on the 'Terms & Policies' page.";
        }

        // ... Add 50+ more custom keywords as needed ..
        document.getElementById('chatbot-messages').innerHTML += "<div><b>Bot:</b> " + response + "</div>";
        document.getElementById('chatbot-messages').scrollTop = document.getElementById('chatbot-messages').scrollHeight;
      }

      function getSmartBotReply(msg) {
        const text = msg.toLowerCase().trim();
        let response = "Sorry, I didn't understand that.";

        // Navigation responses
        if (text.includes("doctor")) {
          response = "You can view available doctors on the 'Doctor List' page.";
        } else if (text.includes("appointment") || text.includes("book")) {
          response = "To book an appointment, go to the 'Appointment' page and select a time slot.";
        } else if (text.includes("medicine")) {
          response = "Medicine availability is shown on the 'Medicine Management' page.";
        } else if (text.includes("prescription")) {
          response = "Doctors can create and view prescriptions in the 'Prescription' section.";
        } else if (text.includes("patient")) {
          response = "Patient information is available in the 'Manage Patients' section.";
        } else if (text.includes("contact")) {
          response = "You can contact us via the 'Contact Us' page.";
        } else if (text.includes("lab") || text.includes("test")) {
          response = "Lab tests and reports can be accessed in the 'Test Reports' section.";
        } else if (text.includes("login") || text.includes("sign in")) {
          response = "Click on the 'Login' button to access your account.";
        } else if (text.includes("register") || text.includes("resister") || text.includes("signup")) {
          response = "Click on the 'Register' link to create a new account.";
        } else if (text.includes("user guide")) {
          response = "You can download the user manual from the Help section.";
        } else if (text.includes("database")) {
          response = "Database management is handled by the IT department.";
        } else if (text.includes("backup")) {
          response = "The system performs automatic daily backups.";
        } else if (text.includes("data privacy")) {
          response = "All data is stored securely and adheres to privacy policies.";
        } else if (text.includes("policy")) {
          response = "Our policies are listed on the 'Terms & Policies' page.";

          // Disease advice
        } else if (text.includes("fever")) {
          response = `🌡️ For fever:\n• Rest and stay hydrated\n• Take paracetamol if needed\n• Avoid cold drinks\n• Visit doctor if fever >101°F or lasts more than 2 days.`;
        } else if (text.includes("cold") || text.includes("cough")) {
          response = `🤧 For cold & cough:\n• Drink warm fluids (ginger tea, soup)\n• Use steam inhalation\n• Avoid cold weather\n• See doctor if cough lasts >1 week.`;
        } else if (text.includes("headache")) {
          response = `🤕 For headache:\n• Rest in a quiet, dark room\n• Drink water\n• Avoid screens and stress\n• Take mild painkillers if needed.\nConsult a doctor if recurring.`;
        } else if (text.includes("diarrhea")) {
          response = `💧 For diarrhea:\n• Drink plenty of fluids and ORS\n• Avoid spicy/oily food\n• Eat boiled rice, bananas, yogurt\n• Visit doctor if symptoms last >2 days.`;
        } else if (text.includes("vomiting")) {
          response = `🤢 For vomiting:\n• Drink ORS or lemon water\n• Avoid solid food temporarily\n• Rest well\n• Visit hospital if vomiting is frequent or severe.`;
        } else if (text.includes("stomach pain")) {
          response = `⚠️ For stomach pain:\n• Eat light food\n• Avoid spicy/fried meals\n• Take antacid if it's gas-related\n• Visit doctor if sharp pain or continues.`;
        } else if (text.includes("covid") || text.includes("corona")) {
          response = `🦠 For COVID-like symptoms:\n• Isolate yourself\n• Take paracetamol for fever\n• Use oximeter to monitor oxygen\n• Test immediately and seek medical care.`;
        } else if (text.includes("diabetes")) {
          response = `🩸 For diabetes:\n• Avoid sugary/starchy foods\n• Monitor blood sugar regularly\n• Take prescribed insulin or tablets\n• Exercise regularly.`;
        } else if (text.includes("high bp") || text.includes("blood pressure")) {
          response = `💓 For high blood pressure:\n• Reduce salt intake\n• Avoid stress\n• Take BP medication regularly\n• Monitor your pressure daily.`;
        }

        // Display the response
        document.getElementById('chatbot-messages').innerHTML += "<div><b>Bot:</b> " + response.replace(/\n/g, "<br>") + "</div>";
        document.getElementById('chatbot-messages').scrollTop = document.getElementById('chatbot-messages').scrollHeight;
      }
    </script>

  </main>
  <?php include('footer.php'); ?>
</body>

</html>