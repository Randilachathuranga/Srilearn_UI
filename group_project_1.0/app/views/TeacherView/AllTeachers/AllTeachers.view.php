<?php
    // Corrected the condition to check for 'sysadmin' role
    
    if($_SESSION['User_id']=='Guest'){
        require 'C:xampp/htdocs/group_project_1.0/app/views/NavBar/Guest_NavBar/NavBar.view.php';

    }
    elseif (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'C:xampp/htdocs/group_project_1.0/app/views/NavBar/User_NavBar/UserNavBar.view.php';
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Cards</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/TeacherView/AllTeachers/ViewTeacher/ViewTeacher.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/TeacherView/AllTeachers/AllteachStyles.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">Teachers<br>Details</h1>
    <img src="../../../../../group_project_1.0/public/views/TeacherView/AllTeachers/Teacher 1.png" alt="Class Image" class="class-image">
</div>

<div class="search-container">
  <label for="city-dropdown" class="dropdown-label">Subject Stream</label>
  <div class="dropdown-button-wrapper">
    <select id="city-dropdown" class="dropdown" required>
      <option value="" disabled selected hidden>Subject</option>
      <option value="new-york">English</option>
      <option value="los-angeles">Science</option>
      <option value="chicago">Maths</option>
      <option value="houston">History</option>
      <option value="phoenix">Chemestry</option>
      <option value="chicago">Physics</option>
      <option value="houston">It</option>
      <option value="phoenix">Sinhala</option>
    </select>
    <button type="button" class="search-button" onclick="search()">Search</button>
  </div>
</div>


<div id="popupForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">
      <div class="teacher-details">
        <img src="../../../../../group_project_1.0/public/views/TeacherView/AllTeachers/Teacher 1.png" alt="Teacher Image" id="teacher-image" class="teacher-image">
        <p><strong>Name:</strong> <span id="teacher-name"></span></p>
        <p><strong>Subject:</strong> <span id="teacher-subject"></span></p>
        <p><strong>Phone number:</strong> <span id="teacher-phone"></span></p>
        <p><strong>Email:</strong> <span id="teacher-email"></span></p>
        <p><strong>Institute:</strong> <span id="teacher-institute"></span></p>
        <p><strong>Address:</strong> <span id="teacher-address"></span></p>

        <p></p><strong>Qualifications:</strong> <span id="teacher-qualifications"></span></p>
        
      </div>
    </form>
    <button type="button" class="close-button" onclick="closePopup()"></button>
  </div>
  
</div>




    <div class="container" id="class-container">
        <!-- Cards will be appended here -->
    </div>
    <script src="../../../../../group_project_1.0/public/views/TeacherView/AllTeachers/Allteachcript.js"></script> <!-- Link your JavaScript file -->
    <!-- ../../../../../group_project_1.0/app/views/TeacherView/AllTeachers/Allteachcript.js -->
    <script src="../../../../../group_project_1.0/public/views/TeacherView/AllTeachers/ViewTeacher//ViewTeachers.js"></script>
</body>
</html>
<?php
 include "C:xampp/htdocs/group_project_1.0/app/views/Footer/Footer.php"
 ?>