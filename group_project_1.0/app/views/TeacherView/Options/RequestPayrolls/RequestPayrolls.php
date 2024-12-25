<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request Payroll</title>
  <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/TeacherView/Options/RequestPayrolls/styles.css">
</head>
<body>
  <div class="container">
    <h1>Request Payroll</h1>

    <!-- Payroll Request Form -->
    <div class="form-section">
      <form id="payrollForm">
        <div class="form-group">
          <label for="teacherName">Teacher Name:</label>
          <input type="text" id="teacherName" placeholder="Enter your name" required>
        </div>

        <div class="form-group">
          <label for="classSchedule">Class Schedule:</label>
          <select id="classSchedule" required>
            <option value="">Select Schedule</option>
            <option value="101">Schedule ID: 101 - 2024-11-25</option>
            <option value="102">Schedule ID: 102 - 2024-11-26</option>
            <option value="103">Schedule ID: 103 - 2024-11-27</option>
          </select>
        </div>

        <div class="form-group">
          <label for="month">Payroll Month:</label>
          <select id="month" required>
            <option value="">Select Month</option>
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option>
            <option value="April">April</option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">August</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
          </select>
        </div>

        <div class="form-group">
          <label for="amount">Requested Amount:</label>
          <input type="number" id="amount" placeholder="Enter amount" required>
        </div>

        <div class="form-buttons">
          <button type="submit" id="requestPayrollBtn">Request Payroll</button>
        </div>
      </form>
    </div>

    <!-- Submitted Payroll Requests -->
    <div class="submitted-requests">
      <h2>Submitted Payroll Requests</h2>
      <table>
        <thead>
          <tr>
            <th>Request ID</th>
            <th>Teacher Name</th>
            <th>Schedule ID</th>
            <th>Month</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody id="requestsTable">
          <!-- Requests will be dynamically populated here -->
        </tbody>
      </table>
    </div>
  </div>

  <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/RequestPayrolls/script.js"></script>
</body>
</html>
