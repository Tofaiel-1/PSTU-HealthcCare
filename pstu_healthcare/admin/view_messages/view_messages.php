<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header("Location: ../../login/login.php");
  exit();
}
require_once '../../db_config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Messages - Admin Dashboard</title>
  <link rel="stylesheet" href="./style.css" />
  <link rel="stylesheet" href="../admin_navbar/style.css" />
  <link rel="stylesheet" href="/style.css" />
  <style>
    /* Modal backdrop */
    .modal {
      display: none;
      position: fixed;
      z-index: 1050;
      left: 0;
      top: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.45);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      transition: opacity 0.3s ease;
      overflow-y: auto;
      padding: 60px 20px;
      box-sizing: border-box;
    }

    /* Modal content container */
    .modal-content {
      position: relative;
      background-color: #fff;
      max-width: 600px;
      margin: 0 auto;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      padding: 30px 40px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
      animation: slideDown 0.35s ease forwards;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Close button */
    .close-btn {
      position: absolute;
      top: 18px;
      right: 20px;
      font-size: 28px;
      font-weight: 700;
      color: #888;
      border: none;
      background: transparent;
      cursor: pointer;
      transition: color 0.25s ease;
      line-height: 1;
    }

    .close-btn:hover {
      color: #444;
    }

    /* Modal heading */
    #modalSubject {
      font-size: 26px;
      font-weight: 700;
      margin: 0 0 15px 0;
      color: #2c3e50;
      letter-spacing: 0.03em;
    }

    /* Modal message */
    #modalMessage {
      font-size: 16px;
      line-height: 1.6;
      white-space: pre-wrap;
      color: #555;
      border-top: 1px solid #eee;
      padding-top: 15px;
      max-height: 320px;
      overflow-y: auto;
      user-select: text;
    }

    /* Scrollbar for message */
    #modalMessage::-webkit-scrollbar {
      width: 7px;
    }

    #modalMessage::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 5px;
    }

    #modalMessage::-webkit-scrollbar-thumb {
      background: #bbb;
      border-radius: 5px;
    }

    #modalMessage::-webkit-scrollbar-thumb:hover {
      background: #999;
    }

    /* View More button style */
    .view-more-btn {
      background-color: #3498db;
      color: #fff;
      border: none;
      padding: 7px 15px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(52, 152, 219, 0.4);
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .view-more-btn:hover {
      background-color: #2980b9;
      box-shadow: 0 4px 12px rgba(41, 128, 185, 0.6);
    }
  </style>
</head>

<body>
  <?php include('../admin_navbar/admin_sidebar.php'); ?>

  <main class="main-content">
    <h1>Contact Messages</h1>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Sender</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Date</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
          while ($row = $result->fetch_assoc()):
          ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars(strlen($row['subject']) > 20 ? substr($row['subject'], 0, 20) . '...' : $row['subject']) ?></td>
              <td><?= $row['created_at'] ?></td>
              <td>
                <button class="view-more-btn"
                  data-subject="<?= htmlspecialchars($row['subject'], ENT_QUOTES) ?>"
                  data-message="<?= htmlspecialchars($row['message'], ENT_QUOTES) ?>">
                  View More
                </button>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div id="messageModal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="modalSubject" aria-modal="true">
      <div class="modal-content">
        <button class="close-btn" aria-label="Close modal">&times;</button>
        <h2 id="modalSubject"></h2>
        <p id="modalMessage"></p>
      </div>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const modal = document.getElementById('messageModal');
      const modalSubject = document.getElementById('modalSubject');
      const modalMessage = document.getElementById('modalMessage');
      const closeBtn = modal.querySelector('.close-btn');
      const viewMoreButtons = document.querySelectorAll('.view-more-btn');

      // Open modal and populate content
      viewMoreButtons.forEach(btn => {
        btn.addEventListener('click', () => {
          modalSubject.textContent = btn.getAttribute('data-subject');
          modalMessage.textContent = btn.getAttribute('data-message');
          modal.style.display = 'block';
          modal.setAttribute('aria-hidden', 'false');
          // Optional: trap focus inside modal here for accessibility
        });
      });

      // Close modal when clicking the close button
      closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
      });

      // Close modal when clicking outside modal content
      window.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.style.display = 'none';
          modal.setAttribute('aria-hidden', 'true');
        }
      });

      // Optional: Close modal on ESC key press
      window.addEventListener('keydown', (e) => {
        if (e.key === "Escape" && modal.style.display === 'block') {
          modal.style.display = 'none';
          modal.setAttribute('aria-hidden', 'true');
        }
      });
    });
  </script>
</body>

</html>