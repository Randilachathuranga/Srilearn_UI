<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Cards</title>
    <link rel="stylesheet" href="./insstyle.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="./ViewInstitute/ViewInstitute.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">Institute<br>Details</h1>
    <img src="./institute 1.png" alt="Class Image" class="class-image">
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


    <div id="popupForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">
      <div class="teacher-details">
        <img src="./Institute_images/2.jpg" alt="Teacher Image" id="teacher-image" class="teacher-image">
    
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


    <script src="./insscript.js"></script> <!-- Link your JavaScript file -->
    <script src="./ViewInstitute/ViewInstitute.js"></script>
</body>
</html>
