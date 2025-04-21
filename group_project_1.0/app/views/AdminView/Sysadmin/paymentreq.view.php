<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Requests</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      margin: 0;
      padding: 20px;
    }

    h2 {
      margin-top: 40px;
      color: #333;
      border-left: 6px solid #007bff;
      padding-left: 10px;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: flex-start;
    }

    .section {
      margin-bottom: 40px;
    }

    .record {
      background-color: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      width: 300px;
      transition: transform 0.2s;
    }

    .record:hover {
      transform: translateY(-5px);
    }

    .record h3 {
      color: #333;
      margin-top: 0;
    }

    .record p, .record h5 {
      margin: 5px 0;
    }

    .record button {
      margin-top: 10px;
      margin-right: 10px;
      padding: 6px 12px;
      border: none;
      background-color: #007bff;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    .record button:hover {
      background-color: #0056b3;
    }

    .empty-message {
      font-style: italic;
      color: #888;
    }
  </style>
</head>
<body>

  <div class="section" id="institute-section">
    <h2>Institute Payment Requests</h2>
    <div class="container" id="institute-container"></div>
  </div>

  <div class="section" id="teacher-section">
    <h2>Teacher Payment Requests</h2>
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
              <button onclick="handleApprove(${record.req_id})">Approve</button>
              <button onclick="handleReject(${record.req_id})">Reject</button>
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
          document.getElementById('institute-container').innerHTML = `<p style="color:red;">Failed to load institute requests.</p>`;
          document.getElementById('teacher-container').innerHTML = `<p style="color:red;">Failed to load teacher requests.</p>`;
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
          location.reload(); // Reload the page to see updated requests
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
          location.reload(); // Reload the page to see updated requests
        } else {
          alert('Failed to reject payment request.');
        }
      })
      .catch(error => console.error('Error:', error));
    }
  </script>
</body>
</html>
