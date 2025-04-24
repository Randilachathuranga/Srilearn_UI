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
</head>
<body>
<div class="header-container">
    <h1 class="header-title">Institute<br>Details</h1>
    <img src="../../../../../group_project_1.0/public/views//General//Byinstitute/institute 1.png" alt="Class Image" class="class-image">
</div>

<div class="search-container">
  <label for="city-dropdown" class="dropdown-label">Search District</label>
  <div class="dropdown-button-wrapper">
    <select id="city-dropdown" class="dropdown" required>
      <option value="" disabled selected hidden>Select District</option>
      <option value="All">All</option>
      <option value="ampara">Ampara</option>
      <option value="anuradhapura">Anuradhapura</option>
      <option value="badulla">Badulla</option>
      <option value="batticaloa">Batticaloa</option>
      <option value="colombo">Colombo</option>
      <option value="galle">Galle</option>
      <option value="gampaha">Gampaha</option>
      <option value="hambantota">Hambantota</option>
      <option value="jaffna">Jaffna</option>
      <option value="kalutara">Kalutara</option>
      <option value="kandy">Kandy</option>
      <option value="kegalle">Kegalle</option>
      <option value="kilinochchi">Kilinochchi</option>
      <option value="kurunegala">Kurunegala</option>
      <option value="mannar">Mannar</option>
      <option value="matale">Matale</option>
      <option value="matara">Matara</option>
      <option value="monaragala">Monaragala</option>
      <option value="mullaitivu">Mullaitivu</option>
      <option value="nuwara-eliya">Nuwara Eliya</option>
      <option value="polonnaruwa">Polonnaruwa</option>
      <option value="puttalam">Puttalam</option>
      <option value="ratnapura">Ratnapura</option>
      <option value="trincomalee">Trincomalee</option>
      <option value="vavuniya">Vavuniya</option>
    </select>
    <button type="button" class="search-button" onclick="serach()">Search</button>
  </div>
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



<!-- popun apply institute -->
<div id="popupApply" class="popup-form" style="display: none;">
    <div class="form-container">
        <h2 id="all_subjects"></h2>

        <br><br>
        <div class="form-row">
            <div class="form-group">
                <label for="Full_name">Full Name</label>
                <input type="text" id="Full_name" name="Full_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" id="email" name="email" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="subject">Subject</label>
                <select id="subject" name="subject" required>
                    <option value="" disabled selected hidden>Select Subject</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Phone number</label>
                <input type="text" id="phone" name="phone" required>
            </div>
        </div>

        <div class="form-group">
            <label for="qualifications">Qualifications</label>
            <textarea id="qualifications" name="qualifications" rows="4" required placeholder="Enter your qualifications, description, and any relevant links"></textarea>
        </div>

        <p id="inst_id" style="display: none;"></p>

        <button onclick="submitApply()" class="submit-button">Submit</button>
        <button onclick="closeApply()" class="close-button"></button>
    </div>
</div>


<script>
  const userRole = "<?php echo $_SESSION['Role']; ?>";
  const userID = "<?php echo $_SESSION['User_id']; ?>";
</script>


    <script src="../../../../../group_project_1.0//public//views//General//Byinstitute/insscript.js"></script> <!-- Link your JavaScript file -->
</body>
</html>

<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
        ?>