<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Cards</title>
    <link rel="stylesheet" href="./AllteachStyles.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="./ViewTeacher//ViewTeacher.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">Teachers<br>Details</h1>
    <img src="./Teacher 1.png" alt="Class Image" class="class-image">
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


<!-- Popup Form for Editing a Blog -->
<div id="popupForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">
      <div class="teacher-details">
        <img src="./teachers_images//3.jpg" alt="Teacher Image" id="teacher-image" class="teacher-image">
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
    <script src="./Allteachcript.js"></script> <!-- Link your JavaScript file -->
    <script src="./ViewTeacher/ViewTeachers.js"></script>
</body>
</html>
