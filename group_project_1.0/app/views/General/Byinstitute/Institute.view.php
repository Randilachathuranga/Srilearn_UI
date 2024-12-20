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
    <link rel="stylesheet" href="../../../../../group_project_1.0//public//views//General//Byinstitute/insstyle.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="../../../../../group_project_1.0//public//views//General//Byinstitute/ViewInstitute/ViewInstitute.css">
    <link rel="stylesheet" href="../../../../../group_project_1.0//public//views//General//Byinstitute/ApplyInstitute//ApplyInstitute.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">Institute<br>Details</h1>
    <img src="../../../../../group_project_1.0/public/views//General//Byinstitute/institute 1.png" alt="Class Image" class="class-image">
</div>

<div class="search-container">
  <label for="city-dropdown" class="dropdown-label">Search City</label>
  <div class="dropdown-button-wrapper">
    <select id="city-dropdown" class="dropdown" required>
      <option value="" disabled selected hidden>City</option>
      <option value="new-york">New York</option>
      <option value="los-angeles">Los Angeles</option>
      <option value="chicago">Chicago</option>
      <option value="houston">Houston</option>
      <option value="phoenix">Phoenix</option>
    </select>
    <button type="button" class="search-button" onclick="serach()">Search</button>
  </div>
</div>



    <div class="container" id="class-container">
        <!-- Cards will be appended here -->
    </div>


    <!-- Popup form for institute details details -->
    <div id="popupForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">
      <div class="teacher-details">
        <img src="../../../../../group_project_1.0/public/views/General/Byinstitute/Institute_images/2.jpg" alt="Teacher Image" id="teacher-image" class="teacher-image">
    
        <!-- New fields for institute details -->
        <p><strong>Institute Name:</strong> <span id="institute-name"></span></p>
        <p><strong>Location:</strong> <span id="institute-location"></span></p>
        <p><strong>Subject Streams:</strong> <span id="subject-streams"></span></p>
        <p><strong>Institute Phone Number:</strong> <span id="institute-phone"></span></p>
        <p><strong>Institute Email:</strong> <span id="institute-email"></span></p>
        <p><strong>District:</strong> <span id="institute-district"></span></p>
        
        <!-- Additional details about the class -->
        <p><strong>Class Description:</strong> <span id="class-description"></span></p>
        <p><strong>Ratings:</strong> <span id="class-ratings"></span></p>
      </div>
    </form>
    <button type="button" class="close-button" onclick="closePopup()"></button>
  </div>
</div>


<!-- popun apply institute -->
<div id="popupApply" class="popup-form" style="display: none;">
    <div class="form-container">
        <h2>Teaching Position Application</h2>

        <!-- Row 1: First Name and Last Name -->
        <div class="form-row">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>
        </div>

        <!-- Row 2: Email and Subject -->
        <div class="form-row">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
            </div>
        </div>

        <!-- Row 3: Address and Phone -->
        <div class="form-row">
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
        </div>

        <!-- Row 4: Qualifications -->
        <div class="form-group">
            <label for="qualifications">Qualifications</label>
            <textarea id="qualifications" name="qualifications" rows="4" required></textarea>
        </div>

        <!-- Submit and Close Buttons -->
        <button onclick="submitApply()" class="submit-button">Submit</button>
        <button onclick="closeApply()" class="close-button"></button>
    </div>
</div>



    <script src="../../../../../group_project_1.0//public//views//General//Byinstitute/insscript.js"></script> <!-- Link your JavaScript file -->
    <script src="../../../../../group_project_1.0//public//views//General//Byinstitute/ViewInstitute/ViewInstitute.js"></script>
    <script src="../../../../../group_project_1.0//public//views//General//Byinstitute/ApplyInstitute/ApplyInstitute.js"></script>
</body>
</html>

<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
        ?>