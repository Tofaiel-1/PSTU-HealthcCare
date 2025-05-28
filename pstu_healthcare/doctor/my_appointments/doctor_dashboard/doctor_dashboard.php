<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Doctor Dashboard</title>
  <link rel="stylesheet" href="../sidebar/style.css">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background: #f4f6f8;
    }

    main.content {
      margin-left: 220px;
      padding: 30px;
      flex-grow: 1;
    }

    main.content h1 {
      margin-bottom: 20px;
      color: #333;
      font-size: 28px;
    }

    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      color: #444;
      font-weight: 600;
    }

    .card h3 {
      margin-bottom: 15px;
      font-size: 18px;
      color: #0073e6;
    }

    .card p {
      font-size: 26px;
      font-weight: 700;
    }
  </style>
</head>

<body>

  <?php include '../sidebar/sidebar.php'; ?>

  <main class="content">
    <h1>Welcome, Doctor!</h1>
    <div class="dashboard-cards">
      <div class="card">
        <h3>Today's Appointments</h3>
        <p>8</p>
      </div>
      <div class="card">
        <h3>Pending Patients</h3>
        <p>4</p>
      </div>
      <div class="card">
        <h3>Messages</h3>
        <p>2</p>
      </div>
      <div class="card">
        <h3>Notifications</h3>
        <p>3</p>
      </div>
    </div>
  </main>

</body>

</html>