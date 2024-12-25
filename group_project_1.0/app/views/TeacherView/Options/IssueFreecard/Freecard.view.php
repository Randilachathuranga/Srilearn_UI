<?php 
 include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php"

?>

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
   <!-- Filter Section -->
<div class="filter-section">
  <div>
    <label for="studentIdFilter">Filter by Student ID:</label>
    <select id="studentIdFilter" disabled>
      <!-- Options populated dynamically -->
      <option value="">None</option>

    </select>
  </div>
</div>
    <div class="button-container">
      <button id="issueCardBtn" disabled onclick="handleIssueCard()">Issue Free Card</button>
    </div>

    <!-- Issued Cards Section -->
    <div class="issued-cards">
      <table>
        <thead>
          <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Issued Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <br>
        <tbody id="issuedCardsTable">
          <!-- Issued cards will appear here -->
        </tbody>
      </table>
    </div>
  </div>

  <Script>
     const userRole = `<?php echo $_SESSION['Role']; ?>`;  // Make sure this is properly set in the PHP view
     console.log(userRole);
</Script>

  <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/IssueFreecard/script.js"></script>
</body>
</html>


<?php
 include "C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php"
 ?>