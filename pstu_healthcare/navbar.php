<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PSTU HealthCare</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    header {
      background-color: #2e8b57;
      color: white;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    header h1 {
      margin: 0;
      font-size: 1.5rem;
    }

    nav {
      display: flex;
      gap: 15px;
      align-items: center;
    }

    nav a {
      color: white;
      text-decoration: none;
      padding: 8px 12px;
      border-radius: 4px;
    }

    nav a.active {
      background-color: #1e5f3e;
    }

    .menu-toggle {
      display: none;
      flex-direction: column;
      cursor: pointer;
    }

    .bar {
      width: 25px;
      height: 3px;
      background-color: white;
      margin: 4px 0;
    }

    @media (max-width: 768px) {
      nav {
        flex-direction: column;
        width: 100%;
        display: none;
      }

      nav.show {
        display: flex;
      }

      .menu-toggle {
        display: flex;
      }
    }
  </style>
</head>

<body>

  <header>
    <a href="http://localhost/pstu_healthcare/index.php" style="text-decoration: none; color: white;">
      <h1>PSTU HealthCare</h1>
    </a>

    <div class="menu-toggle" onclick="toggleMenu()">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>

    <nav id="nav-menu">
      <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Home</a>
      <a href="medicine-management.php" class="<?= basename($_SERVER['PHP_SELF']) == 'medicine-management.php' ? 'active' : '' ?>">Medicine</a>
      <a href="test-fee.php" class="<?= basename($_SERVER['PHP_SELF']) == 'test-fee.php' ? 'active' : '' ?>">Test Fee</a>
      <a href="facility.php" class="<?= basename($_SERVER['PHP_SELF']) == 'facility.php' ? 'active' : '' ?>">Faci</a>


      <a href="./appoint/appointment.php" class="<?= basename($_SERVER['PHP_SELF']) == 'appointment.php' ? 'active' : '' ?>">Appointment</a>
      <a href="contact.php" class="<?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : '' ?>">Contact</a>

      <?php if (isset($_SESSION['user_id'])): ?>
        <?php
        $dashboardLink = '#';
        $dashboardText = 'Dashboard';

        if (isset($_SESSION['user_role'])) {
          switch ($_SESSION['user_role']) {
            case 'admin':
              $dashboardLink = 'admin/admin_dashboard/admin_dashboard.php';
              break;
            case 'doctor':
              $dashboardLink = 'doctor/doctor_dashboard/doctor_dashboard.php';
              break;
            case 'patient':
              $dashboardLink = 'patient/patient_dashboard/patient_dashboard.php';
              break;
          }
        }
        ?>
        <a href="<?= $dashboardLink ?>" class="<?= basename($_SERVER['PHP_SELF']) == basename($dashboardLink) ? 'active' : '' ?>">
          <?= $dashboardText ?>
        </a>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php" class="<?= basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : '' ?>">Login</a>
      <a href="register.php" class="<?= basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : '' ?>">Register</a>
      <?php endif; ?>
    </nav>
  </header>

  <script>
    function toggleMenu() {
      const nav = document.getElementB'nav-menu');
      nav.classList.toggle('show');
    }
  </script>

</body>

</html>