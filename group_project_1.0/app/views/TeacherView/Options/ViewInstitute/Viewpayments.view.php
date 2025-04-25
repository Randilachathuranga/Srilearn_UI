<?php $classid = $id; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All Payments</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f7fa;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    .record {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      margin: 20px auto;
      padding: 20px;
      max-width: 600px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td, th {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }

    th {
      text-align: left;
      background-color: #f0f0f0;
    }

    .status.pending {
      color: orange;
      font-weight: bold;
    }

    .status.rejected {
      color: red;
      font-weight: bold;
    }

    .status.approved {
      color: green;
      font-weight: bold;
    }

    .actions button {
      margin-right: 10px;
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .approve-btn {
      background-color: #4CAF50;
      color: white;
    }

    .reject-btn {
      background-color: #e74c3c;
      color: white;
    }
  </style>
</head>
<body>
  <h1>All Payment Requests</h1>
  <div id="container"></div>

  <script>
    const classid = <?= json_encode($classid) ?>;

    document.addEventListener('DOMContentLoaded', () => {
      const container = document.getElementById('container');
      const url = `http://localhost/group_project_1.0/public/Requestpayroll_forteacher/payments/${classid}`;

      fetch(url)
        .then(response => {
          if (!response.ok) throw new Error('Network response was not ok');
          return response.json();
        })
        .then(data => {
          if (!Array.isArray(data) || data.length === 0) {
            container.innerHTML = '<p>No payment requests found.</p>';
            return;
          }

          data.forEach(record => {
            const rec = document.createElement('div');
            rec.className = 'record';

            const stateText = record.stateis === 1 ? 'Approved' : (record.stateis === -1 ? 'Rejected' : 'Pending');
            const statusClass = record.stateis === 1 ? 'approved' : (record.stateis === -1 ? 'rejected' : 'pending');

            const actionsHtml = record.stateis === 0 ? `
              <button class="approve-btn" onclick="handleApproval(${record.Id})">Approve</button>
              <button class="reject-btn" onclick="handleRejection(${record.Id})">Reject</button>
            ` : '';

            rec.innerHTML = `
              <table>
                <tr><th>Class ID</th><td>${record.InstClass_id}</td></tr>
                <tr><th>Teacher ID</th><td>${record.N_id}</td></tr>
                <tr><th>Request Date</th><td>${record.currentdate}</td></tr>
                <tr><th>Amount</th><td>${record.Amount}</td></tr>
                <tr><th>Status</th><td class="status ${statusClass}">${stateText}</td></tr>
                <tr><th>Actions</th><td class="actions">${actionsHtml}</td></tr>
              </table>
            `;

            container.appendChild(rec);
          });
        })
        .catch(error => {
          console.error('Error fetching data:', error);
          container.innerHTML = `<p style="color:red;">Error fetching payment requests.</p>`;
        });
    });

    function handleApproval(id) {
      fetch(`http://localhost/group_project_1.0/public/Institute/payfee/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
      })
      .then(async (response) => {
        const data = await response.json();
        if (!response.ok) {
          alert(data.message || 'Unknown error');
          throw new Error(data.message || 'Unknown error');
        }
        if (data.status === 'success') {
          alert('✅ Monthly payment request sent successfully!');
          location.reload();
        } else {
          alert(`❌ Failed: ${data.message}`);
        }
      })
      .catch(error => {
        console.error('Request error:', error);
        alert('⚠️ Something went wrong. Try again later.');
      });
    }

    function handleRejection(id) {
      fetch(`http://localhost/group_project_1.0/public/Institute/rejectfee/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
      })
      .then(async (response) => {
        const data = await response.json();
        if (!response.ok) {
          alert(data.message || 'Unknown error');
          throw new Error(data.message || 'Unknown error');
        }
        if (data.status === 'success') {
          alert('❌ Monthly payment request rejected');
          location.reload();
        } else {
          alert(`❌ Failed: ${data.message}`);
        }
      })
      .catch(error => {
        console.error('Request error:', error);
        alert('⚠️ Something went wrong. Try again later.');
      });
    }
  </script>
</body>
</html>
