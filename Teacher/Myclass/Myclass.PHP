<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Cards</title>
    <link rel="stylesheet" href="./Mystyles.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="./Scheduleclass/Scheduleclasses.css">
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


    <script src="script.js"></script> <!-- Link your JavaScript file -->
    <script src="Scheduleclass/Scheduleclass.js"></script>
</body>
</html>
