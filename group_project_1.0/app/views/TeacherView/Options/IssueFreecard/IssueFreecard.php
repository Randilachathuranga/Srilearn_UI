<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Issue Free Cards</title>
  <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/TeacherView/Options/IssueFreecard/styles.css">
</head>
<body>
  <div class="container">
    <h1>Issue Free Cards</h1>

    <!-- Filter Section -->
    <div class="filter-section">
      <div>
        <label for="classScheduleFilter">Filter by Class Schedule:</label>
        <select id="classScheduleFilter">
          <!-- Options populated dynamically -->
        </select>
      </div>
      <div>
        <label for="studentIdFilter">Filter by Student ID:</label>
        <select id="studentIdFilter" disabled>
          <!-- Options populated dynamically -->
        </select>
      </div>
    </div>

    <!-- Issue Free Card Button -->
    <div class="button-container">
      <button id="issueCardBtn" disabled>Issue Free Card</button>
    </div>

    <!-- Issued Cards Section -->
    <div class="issued-cards">
      <h2>Issued Free Cards</h2>
      <table>
        <thead>
          <tr>
            <th>Card ID</th>
            <th>Schedule ID</th>
            <th>Student ID</th>
            <th>Issued Date</th>
          </tr>
        </thead>
        <tbody id="issuedCardsTable">
          <!-- Issued cards will appear here -->
        </tbody>
      </table>
    </div>
  </div>

  <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/IssueFreecard/script.js"></script>
</body>
</html>
