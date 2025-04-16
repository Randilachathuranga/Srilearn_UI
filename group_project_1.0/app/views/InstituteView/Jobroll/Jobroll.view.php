

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Jobrolls</title>
  <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/InstituteView/Jobroll/Jobroll.css">
</head>
<body>

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
