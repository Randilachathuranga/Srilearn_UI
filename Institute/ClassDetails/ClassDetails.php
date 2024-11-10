<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Details</title>
    <link rel="stylesheet" href="./ClassDetails.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="./ViewTeacher/ViewTeacher.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">Class<br>Details</h1>
    <img src="./Class 1.jpg" alt="Class Image" class="class-image">
</div>


<div id="popupForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">
      <div class="teacher-details">
        <img src="./teachers_images//3.jpg" alt="Teacher Image" id="teacher-image" class="teacher-image">
        <p><strong>Name:</strong> <span id="subject-name"></span></p>
        <p><strong>Subject:</strong> <span id="teacher-subject"></span></p>
        <p><strong>Teacher:</strong> <span id="teacher-name"></span></p>

        
      </div>
    </form>
    <button type="button" class="close-button" onclick="closePopup()"></button>
  </div>
  
</div>




    <div class="container" id="class-container">
        <!-- Cards will be appended here -->
    </div>
    <script src="./Class.js"></script> <!-- Link your JavaScript file -->
    <script src="./ViewClass/ViewClass.js"></script>
</body>
</html>
