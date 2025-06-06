<?php 
 include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php"

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Class</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/TeacherView/Myclass/Mystyle.css"> 
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/TeacherView/Myclass/Scheduleclass/Scheduleclass.css">
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/TeacherView/Myclass/EditShedule/EditShedules.css">
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/TeacherView/Myclass/More_details/Moredetailss.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">My Class <br>Details</h1>
    <img src="../../../../../group_project_1.0/public/views/TeacherView/Myclass/class1.png" alt="Class Image" class="class-image">
</div>

<div id="user-data" data-user-id="<?php echo htmlspecialchars(string: $_SESSION['User_id']); ?>"></div>

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
<?php if ((isset($_SESSION['hasinst']) && $_SESSION['hasinst'] == 1) || (isset($_SESSION['Subtype']))): ?>
    <button id="create-class-btn" class="create-blog-button" onclick="createclass()">Create a class</button>
<?php endif; ?>

<?php if (!empty($_SESSION['Ispayavail']) && $_SESSION['Ispayavail'] != 0): ?>
    <button class="create-blog-button" onclick="reqpaymentind()">Request Payment</button>
<?php endif; ?>


</div>


    <div class="container" id="class-container">
    </div>

<div id="popupForm" class="popup-form" style="display: none;">
    <div class="form-container">
        <h2>Create a classs</h2>
        <form id="editScheduleForm">
        <label for="Subject">Subject</label>
<select id="Subject" name="Subject" required>
    <option value="" disabled selected>Select a subject</option>
    <option value="Accounting">Accounting</option>
<option value="Agriculture">Agriculture</option>
<option value="Art">Art</option>
<option value="BioSystemsTechnology">Bio Systems Technology</option>
<option value="Biology">Biology</option>
<option value="Buddhism">Buddhism</option>
<option value="BusinessStudies">Business Studies</option>
<option value="Catholicism">Catholicism</option>
<option value="CivicEducation">Civic Education</option>
<option value="Commerce">Commerce</option>
<option value="Drama">Drama and Theatre</option>
<option value="English">English</option>
<option value="Engineering">Engineering Technology</option>
<option value="Geography">Geography</option>
<option value="Health">Health & Physical Education</option>
<option value="History">History</option>
<option value="ICT">ICT</option>
<option value="Mathematics">Mathematics</option>
<option value="Physics">Physics</option>
<option value="Science">Science</option>
<option value="Sinhala">Sinhala</option>
<option value="Tamil">Tamil</option>

</select>
<div class="create-row">
            <div>
                 <label for="Institute_name">Institute</label>
                     <select id="Institute_name" name="Institute_name" required>
                    <option value="" disabled selected>Select Institute</option>
                    <option value="None">None</option>
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

            <div class="create-row">
            <div>
                    <label for="Hallnumber">Hall number</label>
                    <input type="text" id="Hallnumber" name="Hallnumber" required>
                </div>
                    <input type="hidden" id="inst_id" name="inst_id" required>
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
                    <label for="Start_date">Start Date</label>
                    <input type="date" id="Start_date" name="Start_date" required>
                </div>
                <div>
                    <label for="End_date">End date</label>
                    <input type="date" id="End_date" name="End_date" required>
                </div>
            </div>

            <label for="Stream">Stream</label>
                    <select id="Stream" name="Stream" required>
                        <option value="" disabled selected>Select Stream</option>
                        <option value="Maths">Maths</option>
                        <option value="Science">Science</option>
                    </select>


            <div class="create-row">
                <div>
                    <label for="Date">Class Date</label>
                    <input type="text" id="Date" name="Date" placeholder="Monday" required>
                </div>
                <div>
                    <label for="Time">Class Time</label>
                    <input type="time" id="Time" name="Time" required>
                </div>
            </div>
            
            <button type="submit" class="submit-button">Submit</button>
            <button type="button" onclick="closePopup()" class="close-button">Close</button>
        </form>
    </div>
</div>

<div id="popupEditForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="editScheduleForm" onsubmit="Updateclass(event, currentClassId)">
    
    <label for="classSubject">Subject</label>
<select id="classSubject" name="classSubject" required>
    <option value="" disabled selected>Select a subject</option>
    <option value="Accounting">Accounting</option>
<option value="Agriculture">Agriculture</option>
<option value="Art">Art</option>
<option value="BioSystemsTechnology">Bio Systems Technology</option>
<option value="Biology">Biology</option>
<option value="Buddhism">Buddhism</option>
<option value="BusinessStudies">Business Studies</option>
<option value="Catholicism">Catholicism</option>
<option value="CivicEducation">Civic Education</option>
<option value="Commerce">Commerce</option>
<option value="Drama">Drama and Theatre</option>
<option value="English">English</option>
<option value="Engineering">Engineering Technology</option>
<option value="Geography">Geography</option>
<option value="Health">Health & Physical Education</option>
<option value="History">History</option>
<option value="ICT">ICT</option>
<option value="Mathematics">Mathematics</option>
<option value="Physics">Physics</option>
<option value="Science">Science</option>
<option value="Sinhala">Sinhala</option>
<option value="Tamil">Tamil</option>


</select>

<div class="fm-row ">
   <div>
   <label for="classGrade">Grade</label>
   <input type="number" id="classGrade" name="classGrade" required />
   </div>
      <div>
          <label for="Hall_number">Hall number</label>
          <input type="text" id="Hall_number" name="Hall_number" disabled />
        </div>

        </div>
        
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

      <div class="create-row">
                <div>
                    <label for="Date_">Class Date</label>
                    <input type="text" id="Date_" name="Date_" placeholder="Monday" required>
                </div>
                <div>
                    <label for="Time_">Class Time</label>
                    <input type="time" id="Time_" name="Time_" required>
                </div>
            </div>

      
     
      <label for="classLocation">Address</label>
      <input type="text" id="classLocation" name="classLocation" required />
      <button type="submit" class="submit-button">Update</button>
      <button type="button" class="delete-button" onclick="deleteclass(currentClassId)">Delete</button>
      <button type="button" class="close-button" onclick="closeedit()">Close</button>
    </form>
  </div>
</div>



<div class="modal-background" id="modalBackground" style="display: none;">
    <div class="modal-content">
        <span class="closebutton" onclick="closeModal()">×</span>
        <h1>
            <span id="moreSubject"></span><strong></strong> : Grade <span id="moreGrade"></span>
        </h1>
        
        <img id="classImage" src="" alt="Class Image" />
        <div class="class-details">
            <p><strong>Type:</strong> <span id="classType"></span></p>
            <p><strong>Fee:</strong> <span id="classFee"></span></p>
            <p><strong>Max-Student:</strong> <span id="maxstu"></span></p>
            <p><strong>Hall no:</strong> <span id="Hall_no"></span></p>
            <p><strong>Address:</strong> <span id="locat"></span></p>
            <p><span id="classid" style="display: none;"></span></p>
        </div>
        <div class="button-container">
            <button onclick="UploadMat(getClassId())" class="buttons">Upload Learning materials</button>
            <button onclick="UploadASS(getClassId())" class="buttons">Upload Assignments marks</button>
            <button onclick="viewinst(getClassId())" class="buttons">View Institute</button>
            <button onclick="viewschedule(getClassId())" class="buttons">View Class schedule</button>
            <button onclick="freeCard(getClassId())" class="buttons">Issue free cards</button>
            <button onclick="viewStudents(getClassId())" class="buttons">View all students</button>
        </div>
    </div>
</div>

<script>
     var userID = "<?php echo $_SESSION['User_id'] ?? ''; ?>";
     function reqpaymentind() {
    fetch(`http://localhost/group_project_1.0/public/Payment/checkinstpayreq`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
        } else {

            createPaymentRequest();
        }
    })
    .catch(error => {
        console.error('There was an error checking payment request status!', error);
    });
}

function createPaymentRequest() {
    fetch(`http://localhost/group_project_1.0/public/Payment/reqpaymentind`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ userID })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Monthly payment request sent successfully!');
            location.reload();
        } else {
            alert('Failed to send monthly payment request.');
        }
    })
    .catch(error => {
        console.error('There was an error creating payment request!', error);
    });
}
</script>


    <script src="../../../../../group_project_1.0/public/views/TeacherView/Myclass/My_script.js"></script> 
    <script src="../../../../../group_project_1.0/public/views/TeacherView/Myclass/EditShedule/UDS.js"></script>
</body>
</html>


<?php
 include "C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php"
 ?>
