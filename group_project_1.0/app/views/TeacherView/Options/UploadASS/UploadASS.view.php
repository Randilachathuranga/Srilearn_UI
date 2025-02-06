<?php   
include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php"  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Management</title>
    <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/TeacherView/Options/UploadASS/Styles.css">
</head>
<body>
    <div class="container">
        <div class="assignments-header">
            <h2>All Assignments</h2>
            <button class="create-assignment-btn">
                <span class="plus-icon">+</span>
                Create
            </button>
        </div>
        
        <div id="alertContainer"></div>
        
        <div class="assignments-grid" id="assignmentsContainer"></div>
    </div>

    <!-- Modal Popup for Student Marks -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span id="modalClose" class="close">&times;</span>
            <div id="modalContent"></div>
        </div>
    </div>

    <!-- popup -->
    <div id="popupContainer" class="popup">
  <div class="popup-content">
    <h3 id="popupTitle"></h3>
    <p id="popupMessage"></p>
    <button onclick="closePopup()">OK</button>
  </div>
</div>


    <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/UploadASS/script.js"></script>
</body>
</html>

<?php
 include "C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php"
 ?>