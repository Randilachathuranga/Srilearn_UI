<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php';

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Jobrolls</title>
  <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/InstituteView/Jobroll/Jobroll.css">
</head>
<body>

  <div class="header">
    <h1>Jobrolls</h1>
    <button id="addJobrollBtn" class="add-jobroll-btn" onclick="openAddJobrollPopup()">Add Jobroll</button>
  </div>

  <div id="addJobrollPopup" class="popup">
    <div class="popup-content">
      <span class="close-btn" onclick="closeAddJobrollPopup()">&times;</span>
      <h2>Add Jobroll</h2>
      <form id="addJobrollForm">
        <label for="jobrollTitle">Subject:</label>
        <input type="text" id="jobrollTitle" name="jobrollTitle" required>
        <br>
        <label for="jobrollDescription">Description:</label>
        <textarea id="jobrollDescription" name="jobrollDescription" required></textarea>
  <br>
        <label for="Current_date">Date:</label>
        <input type="date" id="Current_date" name="Current_date" value="<?php echo date('Y-m-d'); ?>" readonly>
        
        <button type="submit" class="submit-btn">Add</button>
      </form>
    </div>
  </div>

  <div id="all_jobrolls" class="jobroll-container"></div>

   <!-- Popup Modal -->
   <div id="applicationPopup" class="popup">
    <div class="popup-content">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <h2>Applications</h2>
      <div id="applications"></div>
    </div>
  </div>


  <script>
    const Inst_id = "<?php echo $_SESSION['User_id']; ?>";
  </script>
  <script src="../../../../../group_project_1.0/public/views/InstituteView/Jobroll/Jobroll.js"></script>

</body>
</html>

<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
        ?>
