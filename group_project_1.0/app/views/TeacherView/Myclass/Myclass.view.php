<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Class</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/app/views/TeacherView/Myclass/Mystyle.css"> <!-- Link your CSS file -->
    <link rel="stylesheet" href="../../../../../group_project_1.0/app/views/TeacherView/Myclass/Scheduleclass/Scheduleclass.css">
    <link rel="stylesheet" href="../../../../../group_project_1.0/app/views/TeacherView/Myclass/EditShedule/EditShedules.css">
    <link rel="stylesheet" href="../../../../../group_project_1.0/app/views/TeacherView/Myclass/More_details/Moredetailss.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">My Class <br>Details</h1>
    <img src="../../../../../group_project_1.0/app/views/TeacherView/Myclass/class1.png" alt="Class Image" class="class-image">
</div>

<div class="filterhead">
<form id="filter" class="filter">
    <div class="form-group">
        <label for="filter-type">Filter by Type</label>
        <select id="filter-type" name="filter-type" class="form-select" required>
            <option value="All">All</option>
            <option value="Individual">Individual</option>
            <option value="Institute">Institute</option>
        </select>
    </div>

</form>
<button id="create-class-btn" class="create-blog-button" onclick="ScheduleClass()">Create a class</button>

</div>


<!-- my class details will be displayed -->
    <div class="container" id="class-container">
    </div>

<!-- Popup Form for Creating a Schedule -->
<div id="popupForm" class="popup-form" style="display: none;">
    <div class="form-container">
        <h2>Create a classs</h2>
        <form id="editScheduleForm">
        <label for="Subject">Subject</label>
<select id="Subject" name="Subject" required>
    <option value="" disabled selected>Select a subject</option>
    <option value=" Mathematics"> Mathematics</option>
    <option value="Science">Science</option>
    <option value="History">History</option>
    <option value="English">English</option>
    <option value="Physics">Physics</option>
    <!-- Add more options as needed -->
</select>
            <div class="create-row">
                <div>
                    <label for="Fee">Fee</label>
                    <input type="number" id="Fee" name="Fee" required>
                </div>
                <div>
                    <label for="Location">Address</label>
                    <input type="text" id="Location" name="Location" required>
                </div>
            </div>
            <div class="create-row">
                <div>
                    <label for="Grade">Grade</label>
                    <input type="number" id="Grade" name="Grade" required>
                </div>
                <div>
                    <label for="Max_std">Max Students</label>
                    <input type="number" id="Max_std" name="Max_std" required />
                </div>
            </div>
            <div class="create-row">
                <div>
                    <label for="Start_date">Start Date</label>
                    <input type="date" id="Start_date" name="Start_date" required>
                </div>
                <div>
                    <label for="End_date">End date</label>
                    <input type="date" id="End_date" name="End_date" required>
                </div>
            </div>
            <div class="create-row">
                <div>
                    <label for="Institute_name">Institute</label>
                    <select id="Institute_name" name="Institute_name" required>
                        <option value="" disabled selected>Select Institute</option>
                        <option value="None">None</option>
                        <option value="Institute1">Institute1</option>
                        <option value="Institute2">Institute2</option>
                    </select>
                </div>
                <div>
                    <label for="Type">Type</label>
                    <select id="Type" name="Type" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="Individual">Individual</option>
                        <option value="Institute">Institute</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="submit-button">Submit</button>
            <button type="button" onclick="closePopup()" class="close-button">Close</button>
        </form>
    </div>
</div>


<!-- Popup Form for Editing a class -->
<div id="popupEditForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="editScheduleForm" onsubmit="Updateschedule(event, currentClassId)">
    
    <label for="classSubject">Subject</label>
<select id="classSubject" name="classSubject" required>
    <option value="" disabled selected>Select a subject</option>
    <option value="Mathematics">Mathematics</option>
    <option value="Science">Science</option>
    <option value="History">History</option>
    <option value="English">English</option>
    <option value="Geography">Geography</option>
</select>

    
    <label for="classGrade">Grade</label>
      <input type="number" id="classGrade" name="classGrade" required />
      <div class="fm-row ">
        <div>
          <label for="classfee">Fee</label>
          <input type="number" id="classfee" name="classfee" required />
        </div>
        <div>
          <label for="classMax_std">Max Students</label>
          <input type="number" id="classMax_std" name="classMax_std" required />
        </div>
      </div>
      <div class="time-row">
        <div>
          <label for="classStart_date">Start date</label>
          <input type="date" id="classStart_date" name="classStart_date" required />
        </div>
        <div>
          <label for="classEnd_date">End date</label>
          <input type="date" id="classEnd_date" name="classEnd_date" required />
        </div>
      </div>
      <label for="classLocation">Address</label>
      <input type="text" id="classLocation" name="classLocation" required />
      <button type="submit" class="submit-button">Update</button>
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
            <p><strong>Address:</strong> <span id="locat"></span></p>
            <p><strong>Grade:</strong> Grade <span id="moreGrade"></span></p>
            <p><strong>Fee:</strong> <span id="classFee"></span></p>
            <p><strong>Max-Student:</strong> <span id="maxstu"></span></p>
            <p><strong>date:</strong> <span id="classdate"></span></p>
            </div>
            <div class="button-container">
                <button onclick="view()" class="buttons">Upload Learning materials</button>
                <button onclick="view()" class="buttons">Upload Assignments marks</button>
                <button onclick="view()" class="buttons">View Institute</button>
                <button onclick="view()" class="buttons">View Class schedule</button>
                <button onclick="view()" class="buttons">Issue free cards</button>
                <button onclick="view()" class="buttons">Request payrolls</button>
                <button onclick="view()" class="buttons">Create schedule</button>

            </div>
    </div>
</div>



    <script src="../../../../../group_project_1.0/app/views/TeacherView/Myclass/My_script.js"></script> <!-- Link your JavaScript file -->
    <script src="../../../../../group_project_1.0/app/views/TeacherView/Myclass/EditShedule/UDS.js"></script>
</body>
</html>
