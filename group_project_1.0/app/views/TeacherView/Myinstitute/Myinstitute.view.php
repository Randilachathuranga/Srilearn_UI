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
    <link rel="stylesheet" href="../../../../../group_project_1.0//public//views/TeacherView/Myinstitute/Myinstitute.css"> <!-- Link your CSS file -->
</head>
<body>
<div class="header-container">
    <h1 class="header-title">My Institute<br>Details</h1>
    <img src="../../../../../group_project_1.0/public/views//General//Byinstitute/institute 1.png" alt="Class Image" class="class-image">
</div>



<div class="container" id="class-container">
    <!-- Static card -->
  </div>



    <!-- Popup form for institute details details -->
    <div id="popupForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">
      <div class="teacher-details">
        <img src="../../../../../group_project_1.0/public/views/General/Myprofile/user.jpg" alt="Teacher Image" id="institute-image" class="teacher-image">
    
        <!-- New fields for institute details -->
        <p><strong>Institute Name:</strong> <span id="institute-name"></span></p>
        <p><strong>Location:</strong> <span id="institute-location"></span></p>
        <p><strong>Institute Phone Number:</strong> <span id="institute-phone"></span></p>
        <p><strong>Institute Email:</strong> <span id="institute-email"></span></p>
        <p><strong>District:</strong> <span id="institute-district"></span></p>
      </div>
    </form>
    <button type="button" class="close-button" onclick="closePopup()"></button>
  </div>
</div>



<script>
  const Userid = "<?php echo $_SESSION['User_id']; ?>";
</script>

    <script src="../../../../../group_project_1.0//public//views/TeacherView/Myinstitute/Myinstitute.js"></script> <!-- Link your JavaScript file -->
</body>
</html>

<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
        ?>