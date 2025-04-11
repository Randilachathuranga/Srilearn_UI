<?php
    // Corrected the condition to check for 'sysadmin' role
    
    if($_SESSION['User_id']=='Guest'){
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/Guest_NavBar/NavBar.view.php';

    }
    elseif (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php';
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Cards</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Byteacher/ViewTeacher/ViewTeacher.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Byteacher/AllteachStyles.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">Teachers<br>Details</h1>
    <img src="../../../../../group_project_1.0/public/views/General/Byteacher/Teacher 1.png" alt="Class Image" class="class-image">
</div>

<div class="search-container">
  <label for="city-dropdown" class="dropdown-label">Subject Stream</label>
  <div class="dropdown-button-wrapper">
    <select id="city-dropdown" class="dropdown" required>
      <option value="Subject" disabled selected hidden>Subject</option>
      <option value="All">All Subjects</option>
      <option value="Accounting">Accounting</option>
<option value="Agriculture">Agriculture</option>
<option value="Art">Art</option>
<option value="BioSystemsTechnology">Bio Systems Technology</option>
<option value="Biology">Biology</option>
<option value="Buddhism">Buddhism</option>
<option value="BusinessStudies">Business Studies</option>
<option value="Catholicism">Catholicism</option>
<option value="CivicEducation">Civic Education</option>
<option value="Commerce">Commerce</option>
<option value="Drama">Drama and Theatre</option>
<option value="English">English</option>
<option value="Engineering">Engineering Technology</option>
<option value="Geography">Geography</option>
<option value="Health">Health & Physical Education</option>
<option value="History">History</option>
<option value="ICT">ICT</option>
<option value="Mathematics">Mathematics</option>
<option value="Physics">Physics</option>
<option value="Science">Science</option>
<option value="Sinhala">Sinhala</option>
<option value="Tamil">Tamil</option>
    </select>
    <button type="button" class="search-button" onclick="search()">Search</button>
  </div>
</div>


<div id="popupForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">
      <div class="teacher-details">
        <!-- Profile image -->
        <img 
          src="" 
          alt="Teacher Image" 
          id="teacher-image" 
          class="teacher-image"
        >

        <!-- Teacher info fields -->
        <p><strong>Name:</strong> <span id="teacher-name"></span></p>
        <p><strong>Subject:</strong> <span id="teacher-subject"></span></p>
        <p><strong>Phone number:</strong> <span id="teacher-phone"></span></p>
        <p><strong>Email:</strong> <span id="teacher-email"></span></p>
        <p><strong>My Institutes:</strong> <span id="teacher-institute"></span></p>
        <p><strong>My Address:</strong> <span id="teacher-address"></span></p>
        <p><strong>District:</strong> <span id="teacher-district"></span></p>
      </div>
    </form>

    <!-- Close button -->
    <button type="button" class="close-button" onclick="closePopup()"></button>
  </div>
</div>





    <div class="container" id="class-container">
        <!-- Cards will be appended here -->
    </div>
    <script src="../../../../../group_project_1.0/public/views/General/Byteacher/Allteachcript.js"></script> <!-- Link your JavaScript file -->
    <!-- ../../../../../group_project_1.0/app/views/General/Byteacher/Allteachcript.js -->
    <script src="../../../../../group_project_1.0/public/views/General/Byteacher/ViewTeacher//ViewTeachers.js"></script>
</body>
</html>
<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
        ?>