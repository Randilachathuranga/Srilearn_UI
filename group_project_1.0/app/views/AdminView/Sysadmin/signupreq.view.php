<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Signup Requests</title>
  <style>
    :root {
      --primary: #1e40af;
      --primary-light: #3b82f6;
      --primary-hover: #1e3a8a;
    }

    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #e2ece5;
      margin: 0;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start; /* Changed from center to flex-start */
      padding-top: 2rem; /* Added padding-top instead of full centering */
    }

    .container {
      width: 95%;
      max-width: 1400px;
      margin: 0 auto; /* Changed from 2rem auto to 0 auto */
      background-color: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: var(--primary);
      font-size: 2rem;
      margin-bottom: 2rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
    }

    th, td {
      border: 1px solid #e2e8f0;
      padding: 12px 16px;
      text-align: left;
    }

    th {
      background-color: var(--primary);
      color: white;
      font-weight: 600;
    }

    tr:nth-child(even) {
      background-color: #f8fafc;
    }

    .approve-btn {
      background-color: var(--primary);
      color: white;
      border: none;
      padding: 8px 16px;
      cursor: pointer;
      border-radius: 6px;
      transition: background-color 0.2s;
    }

    .reject-btn {
      background-color: #dc2626;
      color: white;
      border: none;
      padding: 8px 16px;
      cursor: pointer;
      border-radius: 6px;
      transition: background-color 0.2s;
    }

    .approve-btn:hover {
      background-color: var(--primary-hover);
    }

    .reject-btn:hover {
      background-color: #b91c1c;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Signup Requests</h1>
    <table id="signupreqTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>URL</th>
          <th>Approve</th>
          <th>Reject</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data will be injected here -->
      </tbody>
    </table>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      fetch("http://localhost/group_project_1.0/public/Sysadmin/signupreq")
        .then((response) => response.json())
        .then((data) => {
          const tableBody = document.querySelector("#signupreqTable tbody");
          data.forEach((item) => {
            console.log(item); // Log each item to the console for debugging
            const row = document.createElement("tr");
            row.innerHTML = `
              <td>${item.req_id}</td>
              <td>${item.F_name} ${item.L_name}</td>
              <td>${item.Email}</td>
              <td>${item.Phone_number}</td>
              <td>${item.URL}</td>
              <td><button class="approve-btn" onclick="handleApprove(${item.req_id})">Approve</button></td>
              <td><button class="reject-btn" onclick="handleReject(${item.req_id})">Reject</button></td>
            `;
            tableBody.appendChild(row);
          });
        })
        .catch((error) => console.error("Error fetching data:", error));
    });

    function handleApprove(id) {
      fetch(`http://localhost/group_project_1.0/public/Sysadmin/approvessu/${id}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          alert(data.message);
          location.reload(); // Reload the page to see updated data
        })
        .catch((error) => console.error("Error approving request:", error));
      // You can send a fetch POST request here to handle approval
    }

    function handleReject(id) {
        fetch(`http://localhost/group_project_1.0/public/Sysadmin/rejectssu/${id}`, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          alert(data.message);
          location.reload(); // Reload the page to see updated data
        })
        .catch((error) => console.error("Error approving request:", error));
    }
  </script>
</body>
</html>
