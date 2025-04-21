<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Signup Requests</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f7f7f7;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #007BFF;
      color: white;
    }

    .approve-btn {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 6px 12px;
      cursor: pointer;
      border-radius: 5px;
    }

    .reject-btn {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 6px 12px;
      cursor: pointer;
      border-radius: 5px;
    }

    .approve-btn:hover, .reject-btn:hover {
      opacity: 0.9;
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
