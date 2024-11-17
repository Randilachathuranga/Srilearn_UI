<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Class</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/app/views/TeacherView/Myclass/Mystyle.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="../../../../../group_project_1.0/app/views/TeacherView/Myclass/Scheduleclass/Scheduleclasses.css">
    <link rel="stylesheet" href="../../../../../group_project_1.0/app/views/TeacherView/Myclass/EditShedule/EditShedules.css">
    <link rel="stylesheet" href="../../../../../group_project_1.0/app/views/TeacherView/Myclass/More_details/Moredetailss.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">My Class <br>Details</h1>
    <img src="../../../../../group_project_1.0/app/views/TeacherView/Myclass/class1.png" alt="Class Image" class="class-image">
</div>

<button class="create-blog-button" onclick="ScheduleClass()">Create class schedule</button>
<!-- <button class="refresh-button">Refresh</button> -->

    <div class="container" id="class-container">
        <!-- Cards will be appended here -->
    </div>

    <!-- Popup Form for Creating a Schedule -->
    <div id="popupForm" class="popup-form" style="display: none;">
    <div class="form-container">
        <h2>Create Schedule</h2>
        
        <label for="Subject">Subject</label>
        <input type="text" id="Subject" name="Subject" required>

        <label for="Grade">Grade</label>
        <input type="text" id="Grade" name="Grade" required>

        <label for="Fee">Fee</label>
        <input type="text" id="Fee" name="Fee" required>

        <!-- Single row for Start and End Time -->
        <div class="time-row">
            <div>
                <label for="Start_Time">Start Time</label>
                <input type="time" id="Start_Time" name="Start_Time" required>
            </div>
            <div>
                <label for="End-time">End Time</label>
                <input type="time" id="End-time" name="End-time" required>
            </div>
        </div>

        <!-- Dropdown for Institute -->
        <label for="Institute-name">Institute Name</label>
        <select id="Institute-name" name="Institute-name" required>
            <option value="" disabled selected>Select Institute</option>
            <option value="Institute1">None</option>
            <option value="Institute1">Institute 1</option>
            <option value="Institute2">Institute 2</option>
            <!-- Add more options as needed -->
        </select>

        <button onclick="submit()" class="submit-button">Submit</button>
        <button onclick="closePopup()" class="close-button">Close</button>
    </div>
</div>

<!-- Popup Form for Editing a Schedule -->
<div id="popupEditForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">
      <label for="classSubject">Subject</label>
      <input type="text" id="classSubject" name="classSubject" required />

      <label for="classGrade">Grade</label>
      <input type="text" id="classGrade" name="classGrade" required />

      <div class="time-row">
        <div>
          <label for="classfee">Fee</label>
          <input type="text" id="classfee" name="classfee" required />
        </div>
        <div>
          <label for="classMax_std">Max Students</label>
          <input type="text" id="classMax_std" name="classMax_std" required />
        </div>
      </div>

      <div class="time-row">
        <div>
          <label for="classStart_Time">Start Time</label>
          <input type="time" id="classStart_Time" name="classStart_Time" required />
        </div>
        <div>
          <label for="classEnd_time">End Time</label>
          <input type="time" id="classEnd_time" name="classEnd_time" required />
        </div>
      </div>

      <label for="classLocation">Location</label>
      <input type="text" id="classLocation" name="classLocation" required />

      <button type="button" class="submit-button" onclick="Updateschedule()">Update</button>
      <button type="button" class="delete-button" onclick="deleteschedule(currentClassId)">Delete</button>
      <button type="button" class="close-button" onclick="closeedit()">Close</button>
    </form>
  </div>
</div>



<!-- Modal for showing class details -->
<div class="modal-background" id="modalBackground" style="display: none;">
    <div class="modal-content">
        <span class="closebutton" onclick="closeModal()">×</span>
        <h1> <span id="moreSubject">  </span><strong> Class</strong></h1>
        <img id="classImage" src="" alt="Class Image" />
            <div class="class-details">
            <p><strong>Institute:</strong> <span id="classInstitute"></span></p>
            <p><strong>Type:</strong> <span id="classType"></span></p>
            <p><strong>Location:</strong> <span id="locat"></span></p>
            <p><strong>Grade:</strong> <span id="moreGrade"></span></p>
            <p><strong>Fee:</strong> <span id="classFee"></span></p>
            <p><strong>Max-Student:</strong> <span id="maxstu"></span></p>
            <p><strong>Time:</strong> <span id="classTime"></span></p>
            </div>
            <div class="button-container">
                <button onclick="view()" class="buttons">Upload Learning materials</button>
                <button onclick="view()" class="buttons">Upload Assignments marks</button>
                <button onclick="view()" class="buttons">View Institute</button>
                <button onclick="view()" class="buttons">View Class schedule</button>
                <button onclick="view()" class="buttons">Issue free cards</button>
                <button onclick="view()" class="buttons">Request payrolls</button>
            </div>
    </div>
</div>



    <script src="../../../../../group_project_1.0/app/views/TeacherView/Myclass/My_script.js"></script> <!-- Link your JavaScript file -->
    <script src="../../../../../group_project_1.0/app/views/TeacherView/Myclass/Scheduleclass/Scheduleclass.js"></script>
    <script src="../../../../../group_project_1.0/app/views/TeacherView/Myclass/EditShedule/Editshedule.js"></script>
</body>
</html>


<?php
require_once __DIR__ . '/../../../../../group_project_1.0/app/views/Footer/footer.php';
?>