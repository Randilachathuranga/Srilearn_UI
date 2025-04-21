<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Classes</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
    }

    .top-bar {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 20px;
    }

    .top-bar button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
    }

    #container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .record {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      width: 300px;
    }

    .record h3 {
      margin-top: 0;
    }

    .record button {
      margin-top: 10px;
      margin-right: 10px;
      padding: 8px 12px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .record button:last-child {
      background-color: #f44336;
    }
  </style>
</head>
<body>

  <div class="top-bar">
    <button onclick="requestMonthlyPayment()">Request Monthly Payment</button>
  </div>

  <div id="container"></div>

  <script>
    var userID = "<?php echo $_SESSION['User_id'] ?? ''; ?>";
    var userRole = "<?php echo $_SESSION['role'] ?? ''; ?>";

    document.addEventListener('DOMContentLoaded', () => {
      fetch(`http://localhost/group_project_1.0/public/Institute/classapi/${userID}`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          const container = document.getElementById('container');
          data.forEach(record => {

           
            const rec = document.createElement('div');
            rec.className = 'record';
            rec.innerHTML = `
              <h3>Class ID: ${record.InstClass_id}</h3>
              <p>Teacher ID: ${record.N_id}</p>
              <h5>Location: ${record.Location}</h5>
              <h5>Hall: ${record.Hall_number}</h5>
              <button onclick="viewstudents(${record.InstClass_id})">View Students</button>
              <button onclick="payteacher(${record.InstClass_id})">Pay Teacher</button>
              <button onclick="handleDelete(${record.InstClass_id})">Delete</button>
            `;
            container.appendChild(rec);
          });
        })
        .catch(error => console.error('There was an error!', error));
    });

    function payteacher(id) {
  fetch(`http://localhost/group_project_1.0/public/Institute/payfee/${id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ id }) // Though not used in backend, it's safe to keep
  })
    .then(async (response) => {
      const data = await response.json();

      if (!response.ok) {
        // Handle various errors based on the backend response
        if (data.message.includes('No pending request')) {
          alert('This month’s payment request was already sent or no pending request exists.');
        } else {
          alert(`Error: ${data.message}`);
        }
        throw new Error(data.message || 'Unknown error');
      }

      // If success
      if (data.status === 'success') {
        alert('✅ Monthly payment request sent successfully!');
        location.reload(); // Refresh to reflect changes
      } else {
        alert(`❌ Failed: ${data.message}`);
      }
    })
    .catch((error) => {
      console.error('Request error:', error);
      alert('⚠️ Something went wrong while processing the request. Please try again later.');
    });
}


    

    function handleDelete(classId) {
      console.log('Deleting class with ID:', classId);
    }

    function viewstudents(classId) {
      sessionStorage.setItem("class_id", classId);
      window.location.href = "http://localhost/group_project_1.0/public/Institute/viewstudents";
    }

    function requestMonthlyPayment() {
      fetch(`http://localhost/group_project_1.0/public/Payment/requestMonthlyPayment`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ userID })
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
        .then(data => {
            if (data.success) {
            alert('Monthly payment request sent successfully!');
            location.reload(); // Reload the page to see updated data
          
       } else {
            alert('Failed to send monthly payment request.');
            }
        })  
        .catch(error => {
          console.error('There was an error!', error);
    });
    }
  </script>
</body>
</html>
