<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Requests</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #e3f2fd;
      margin: 0;
      padding: 20px;
    }

    h2 {
      margin-top: 40px;
      color: #1565c0;
      border-left: 6px solid #1565c0;
      padding-left: 10px;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: flex-start;
      max-width: 1200px;
      margin: 0 auto;
    }

    .section {
      margin-bottom: 40px;
      width: 100%;
    }

    .section-header {
      background-color: #ffffff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(21, 101, 192, 0.1);
      margin-bottom: 20px;
    }

    .record {
      background-color: #bbdefb;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(21, 101, 192, 0.1);
      width: 250px; /* Reduced from 300px */
      transition: transform 0.2s;
      display: flex;
      flex-direction: column;
    }

    .record:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(21, 101, 192, 0.2);
    }

    .record h3 {
      color: #1565c0;
      margin-top: 0;
      margin-bottom: 5px;
      font-size: 1rem; /* Slightly reduced */
    }

    .record p, .record h5 {
      margin: 4px 0;
      color: #1565c0;
      font-size: 0.85rem; /* Slightly reduced */
    }

    .button-container {
      display: flex;
      gap: 8px; /* Reduced from 10px */
      margin-top: 8px; /* Reduced from 10px */
    }

    .record button {
      flex: 1;
      padding: 6px; /* Reduced from 8px */
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.2s;
      font-size: 11px; /* Reduced from 12px */
      text-transform: uppercase;
      color: white;
    }

    .record button.approve {
      background-color: #1565c0;
    }

    .record button.reject {
      background-color: #dc3545;
    }

    .record button.approve:hover {
      background-color: #0d47a1;
    }

    .record button.reject:hover {
      background-color: #c82333;
    }

    .empty-message {
      font-style: italic;
      color: #1565c0;
      text-align: center;
      width: 100%;
    }
  </style>
</head>
<body>

  <div class="section" id="institute-section">
    <div class="section-header">
      <h2>Institute Payment Requests</h2>
    </div>
    <div class="container" id="institute-container"></div>
  </div>

  <div class="section" id="teacher-section">
    <div class="section-header">
      <h2>Teacher Payment Requests</h2>
    </div>
    <div class="container" id="teacher-container"></div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      fetch(`http://localhost/group_project_1.0/public/Sysadmin/payreqapi`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          const instituteContainer = document.getElementById('institute-container');
          const teacherContainer = document.getElementById('teacher-container');

          let hasInstitute = false;
          let hasTeacher = false;

          if (!Array.isArray(data) || data.length === 0) {
            instituteContainer.innerHTML = '<p class="empty-message">No institute payment requests found.</p>';
            teacherContainer.innerHTML = '<p class="empty-message">No teacher payment requests found.</p>';
            return;
          }

          data.forEach(record => {
            const rec = document.createElement('div');
            rec.className = 'record';
            rec.innerHTML = `
              <h3>Payment Request ID: ${record.req_id}</h3>
              <p>Institute ID: ${record.inst_id}</p>
              <h5>Amount: ${record.amount}</h5>
              <h5>Request Date: ${record.date}</h5>
              <h5>Request Time: ${record.time}</h5>
              <h5>Role: ${record.Role}</h5>
              <div class="button-container">
                <button class="approve" onclick="handleApprove(${record.req_id})">Approve</button>
                <button class="reject" onclick="handleReject(${record.req_id})">Reject</button>
              </div>
            `;

            if (record.Role === 'institute') {
              instituteContainer.appendChild(rec);
              hasInstitute = true;
            } else if (record.Role === 'teacher') {
              teacherContainer.appendChild(rec);
              hasTeacher = true;
            }
          });

          if (!hasInstitute) {
            instituteContainer.innerHTML = '<p class="empty-message">No institute payment requests found.</p>';
          }

          if (!hasTeacher) {
            teacherContainer.innerHTML = '<p class="empty-message">No teacher payment requests found.</p>';
          }
        })
        .catch(error => {
          console.error('There was an error!', error);
          document.getElementById('institute-container').innerHTML = `<p style="color:#1565c0;">Failed to load institute requests.</p>`;
          document.getElementById('teacher-container').innerHTML = `<p style="color:#1565c0;">Failed to load teacher requests.</p>`;
        });
    });

    function handleApprove(reqId) {
      fetch(`http://localhost/group_project_1.0/public/Sysadmin/approve/${reqId}`, {
        method: 'POST'
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          alert('Payment request approved successfully!');
          location.reload();
        } else {
          alert('Failed to approve payment request.');
        }
      })
      .catch(error => console.error('Error:', error));
    }

    function handleReject(reqId) {
      fetch(`http://localhost/group_project_1.0/public/Sysadmin/reject/${reqId}`, {
        method: 'POST'
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          alert('Payment request rejected successfully!');
          location.reload();
        } else {
          alert('Failed to reject payment request.');
        }
      })
      .catch(error => console.error('Error:', error));
    }
  </script>
</body>
</html>
