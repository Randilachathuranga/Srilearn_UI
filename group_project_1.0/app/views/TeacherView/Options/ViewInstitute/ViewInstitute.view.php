<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Institute Class Info</title>
  <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/TeacherView/Options/ViewInstitute/ViewInstitute.css">
</head>
<body>

  <?php include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php" ?>

  <div class="container">
    <h2>Institute Class Details</h2>
    <div id="classInfo" class="info"></div>
    <div id="error" class="error"></div>

    <div class="button-container" style="display: none; justify-content: center; margin-top: 20px;">
  <button onclick="requestPayroll()" class="payroll-button">Request Payroll</button>
</div>

  </div>


  <div id="payrollPopup" class="popup-overlay">
  <div class="popup-form">
    <h3>Request Payroll</h3>
    <form id="payrollForm">
      <input type="hidden" id="Institute_ID" name="Institute_ID">
      <input type="hidden" id="N_id" name="N_id">
      <input type="hidden" id="InstClass_id" name="InstClass_id">

      <div class="form-group">
        <label for="current_date">Current Date:</label>
        <input type="text" id="current_date" name="current_date" readonly>
      </div>

      <div class="form-group">
        <label for="bankdetails">Bank Details:</label>
        <input type="text" id="bankdetails" name="bankdetails" required>
      </div>

      <div class="popup-buttons">
        <button type="submit">Submit</button>
        <button type="button" onclick="closePopup()">Cancel</button>
      </div>
    </form>
  </div>
</div>


  <?php include "C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php" ?>

  <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/ViewInstitute/ViewInstitute.js"></script>
</body>
</html>
