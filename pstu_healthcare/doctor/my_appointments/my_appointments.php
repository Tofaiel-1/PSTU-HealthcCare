<?php
session_start();

require_once '../../db_config.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'doctor') {
  header("Location: ../../login.php");
  exit();
}

$doctor_id = $_SESSION['user_id'];

$sql = "SELECT a.*, u.full_name AS patient_name 
        FROM appointments a
        JOIN users u ON a.patient_id = u.id
        WHERE a.doctor_id = ?
        ORDER BY a.appointment_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

$appointments = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Appointments</title>
  <link rel="stylesheet" href="../sidebar/style.css" />
  <style>
    main.content {
      margin-left: 220px;
      padding: 30px;
      flex-grow: 1;
      background: #f4f6f8;
      min-height: 100vh;
    }

    h1 {
      color: #333;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      border-radius: 6px;
      overflow: hidden;
    }

    th,
    td {
      padding: 14px 20px;
      text-align: left;
      border-bottom: 1px solid #ddd;
      vertical-align: middle;
    }

    th {
      background: #0073e6;
      color: white;
    }

    tr:hover {
      background: #e6f2ff;
    }

    .status-dropdown {
      padding: 6px 12px;
      border-radius: 12px;
      border: 1px solid #ccc;
      font-weight: 600;
      cursor: pointer;
      min-width: 120px;
      transition: background-color 0.3s ease;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 12px;
      color: white;
      background-color: #f0ad4e;
      background-image: url('data:image/svg+xml;utf8,<svg fill="white" height="12" viewBox="0 0 24 24" width="12" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
    }

    /* Prescription button style */
    .prescription-btn {
      background-color: #17a2b8;
      color: white;
      border: none;
      padding: 8px 14px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      
    }

    .prescription-btn:hover {
      background-color: #138496;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 20px 30px;
      border-radius: 10px;
      max-width: 500px;
      width: 90%;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
      position: relative;
    }

    .modal-content h2 {
      margin-top: 0;
    }

    .modal-content textarea {
      width: 100%;
      height: 150px;
      padding: 10px;
      font-size: 16px;
      margin-bottom: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
      resize: vertical;
    }

    .modal-content button {
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      margin-right: 10px;
    }

    .modal-submit-btn {
      background-color: #28a745;
      color: white;
    }

    .modal-cancel-btn {
      background-color: #dc3545;
      color: white;
    }

    /* Responsive */
    @media (max-width: 600px) {
      main.content {
        padding: 15px;
      }

      table,
      thead,
      tbody,
      th,
      td,
      tr {
        display: block;
      }

      th {
        display: none;
      }

      tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
      }

      td {
        padding: 10px 5px;
        text-align: right;
        position: relative;
      }

      td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        width: 50%;
        padding-left: 10px;
        font-weight: 600;
        text-align: left;
      }

      .status-dropdown,
      .prescription-btn {
        min-width: 100%;
        margin-top: 10px;
      }
    }
  </style>
</head>

<body>
  <?php include '../sidebar/sidebar.php'; ?>

  <main class="content">
    <h1>My Appointments</h1>
    <?php if (empty($appointments)): ?>
      <p>No appointments found.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Patient Name</th>
            <th>Appointment Date & Time</th>
            <th>Status</th>
            <th>Prescription</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($appointments as $appt): ?>
            <tr>
              <td data-label="Patient Name"><?php echo htmlspecialchars($appt['patient_name']); ?></td>
              <td data-label="Appointment Date & Time">
                <?php echo date("d M Y, h:i A", strtotime($appt['appointment_date'])); ?>
              </td>
              <td data-label="Status">
                <select class="status-dropdown" data-appointment-id="<?php echo $appt['id']; ?>">
                  <?php
                  $statuses = ['Pending', 'Completed', 'Cancelled'];
                  foreach ($statuses as $status) {
                    $selected = ($appt['status'] === $status) ? 'selected' : '';
                    echo "<option value=\"$status\" $selected>$status</option>";
                  }
                  ?>
                </select>
              </td>
              <td data-label="Prescription">
                <button class="prescription-btn"
                  data-appointment-id="<?php echo $appt['id']; ?>"
                  data-patient-id="<?php echo $appt['patient_id']; ?>"
                  data-patient-name="<?php echo htmlspecialchars($appt['patient_name']); ?>">
                  Issue Prescription
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </main>

  <!-- Prescription Modal -->
  <div class="modal" id="prescriptionModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-content">
      <h2 id="modalTitle">Issue Prescription for <span id="modalPatientName"></span></h2>
      <textarea id="prescriptionText" placeholder="Write prescription here..." aria-label="Prescription text"></textarea>
      <div>
        <button class="modal-submit-btn" id="modalSaveBtn">Save</button>
        <button class="modal-cancel-btn" id="modalCancelBtn">Cancel</button>
      </div>
    </div>
  </div>

  <script>
    // Status dropdown color update
    function updateDropdownColors() {
      document.querySelectorAll('.status-dropdown').forEach(dropdown => {
        const val = dropdown.value;
        switch (val) {
          case 'Pending':
            dropdown.style.backgroundColor = '#f0ad4e';
            dropdown.style.color = 'white';
            break;
          case 'Completed':
            dropdown.style.backgroundColor = '#5cb85c';
            dropdown.style.color = 'white';
            break;
          case 'Cancelled':
            dropdown.style.backgroundColor = '#d9534f';
            dropdown.style.color = 'white';
            break;
          default:
            dropdown.style.backgroundColor = 'white';
            dropdown.style.color = 'black';
            break;
        }
      });
    }

    updateDropdownColors();

    document.querySelectorAll('.status-dropdown').forEach(dropdown => {
      dropdown.addEventListener('change', function() {
        updateDropdownColors();

        const appointmentId = this.getAttribute('data-appointment-id');
        const newStatus = this.value;

        fetch('update_status.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              id: appointmentId,
              status: newStatus
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Status updated successfully!');
            } else {
              alert('Failed to update status: ' + data.message);
            }
          })
          .catch(error => {
            alert('Error updating status: ' + error);
          });
      });
    });

    // Prescription modal logic
    const modal = document.getElementById('prescriptionModal');
    const modalPatientName = document.getElementById('modalPatientName');
    const prescriptionText = document.getElementById('prescriptionText');
    const modalSaveBtn = document.getElementById('modalSaveBtn');
    const modalCancelBtn = document.getElementById('modalCancelBtn');

    let currentAppointmentId = null;
    let currentPatientId = null;

    // Open modal when clicking prescription button
    document.querySelectorAll('.prescription-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        currentAppointmentId = btn.getAttribute('data-appointment-id');
        currentPatientId = btn.getAttribute('data-patient-id');
        const patientName = btn.getAttribute('data-patient-name');

        modalPatientName.textContent = patientName;
        prescriptionText.value = '';
        modal.style.display = 'flex';
        prescriptionText.focus();
      });
    });

    // Save button event handler
    modalSaveBtn.addEventListener('click', () => {
      const prescription = prescriptionText.value.trim();
      if (!prescription) {
        alert('Please write a prescription before saving.');
        prescriptionText.focus();
        return;
      }

      fetch('save_prescription.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            appointment_id: currentAppointmentId,
            patient_id: currentPatientId,
            prescription: prescription
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Prescription saved successfully!');
            modal.style.display = 'none';
          } else {
            alert('Failed to save prescription: ' + data.message);
          }
        })
        .catch(error => {
          alert('Error saving prescription: ' + error);
        });
    });

    // Cancel button event handler
    modalCancelBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    // Close modal on clicking outside modal-content
    window.addEventListener('click', e => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });

    // Close modal on Escape key
    window.addEventListener('keydown', e => {
      if (e.key === 'Escape' && modal.style.display === 'flex') {
        modal.style.display = 'none';
      }
    });
  </script>
</body>

</html>