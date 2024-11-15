<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Cards</title>
    <link rel="stylesheet" href="./Mystyles.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="./Scheduleclass/Scheduleclasses.css">
    <link rel="stylesheet" href="./EditShedule/EditShedule.css">
    <link rel="stylesheet" href="./More_details/More_details.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">My Class <br>Details</h1>
    <img src="./class1.png" alt="Class Image" class="class-image">
</div>

<button class="create-blog-button" onclick="ScheduleClass()">Create class schedule</button>
<!-- <button class="refresh-button">Refresh</button> -->

    <div class="container" id="class-container">
        <!-- Cards will be appended here -->
    </div>

    <!-- Popup Form for Creating a Blog -->
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
                <label for="Start-time">Start Time</label>
                <input type="time" id="Start-time" name="Start-time" required>
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

<!-- Popup Form for Editing a Blog -->
<div id="popupEditForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">        
        <label for="Subject">Subject</label>
        <input type="text" id="Subject" name="Subject" required>

        <label for="Grade">Grade</label>
        <input type="text" id="Grade" name="Grade" required>

        <label for="Fee">Fee</label>
        <input type="text" id="Fee" name="Fee" required>

        <!-- Single row for Start and End Time -->
        <div class="time-row">
            <div>
                <label for="Start-time">Start Time</label>
                <input type="time" id="Start-time" name="Start-time" required>
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

    <button type="button" class="submit-button" onclick="Updateschedule()">Update</button>
      <button type="button" class="delete-button" onclick="deleteschedule()">Delete</button>
      <button class="close-button" onclick="closeedit()">Close</button>

    </form>
  </div>
</div>


<!-- Modal for showing class details -->
<div class="modal-background" id="modalBackground">
    <div class="modal-content">
        <span class="close_button" onclick="closeModal()">×</span>
        <img id="classImage" src="" alt="Class Image" width="100" />
        <h2 id="classTitle">Class Title</h2>
        <p><strong>Subject:</strong> <span id="classSubject"></span></p>
        <p><strong>Institute:</strong> <span id="classInstitute"></span></p>
        <p><strong>Grade:</strong> <span id="classGrade"></span></p>
        <p><strong>Fee:</strong> <span id="classFee"></span></p>
        <p><strong>Time:</strong> <span id="classTime"></span></p>
        <button class="button">Upload Learning materials</button>
        <button class="button">Upload Assignments marks</button>
        <button class="button">View Institute</button>
        <button class="button">View Class schedule</button>
        <button class="button">Issue free cards</button>
        <button class="button">Request payrolls</button>
    </div>
</div>




    <script src="scripts.js"></script> <!-- Link your JavaScript file -->
    <script src="Scheduleclass/Scheduleclass.js"></script>
    <script src="EditShedule/EditShedules.js"></script>
</body>
</html>
