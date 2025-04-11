<?php 
 include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Enrollments</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/StudentView/MyEnrollements/enrollmentview.css">
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header-container">
            <h1 class="header-title">My Enrollments</h1>
        </div>

        <!-- Banner Section -->
        <div class="banner-container">
            <img src="../../../../../group_project_1.0/public/views/StudentView/MyEnrollements/teacherclass.jpg" alt="Teacher Class" class="banner-image">
        </div>

        <!-- Classes Display Section -->
        <div class="classes-container" id="classes-container">
            <!-- Enrolled classes will be dynamically rendered here -->
        </div>
    </div>

    <script>
        // Fetch all enrolled classes initially
        document.addEventListener('DOMContentLoaded', fetchAllClasses);

        function fetchAllClasses() {
    const individualURL = 'http://localhost/group_project_1.0/public/Enrollment/allindividual';
    const instituteURL = 'http://localhost/group_project_1.0/public/Enrollment/allinstitute';

    Promise.all([
        fetch(individualURL).then(res => res.ok ? res.json() : []),
        fetch(instituteURL).then(res => res.ok ? res.json() : [])
    ])
    .then(([individualData, instituteData]) => {
        if (individualData.length > 0 && instituteData.length > 0) {
            // Both have data
            renderClasses([...individualData, ...instituteData]);
        } else if (individualData.length > 0) {
            // Only individual has data
            renderClasses(individualData);
        } else if (instituteData.length > 0) {
            // Only institute has data
            renderClasses(instituteData);
        } else {
            // No data in either
            console.log("No classes found in either category.");
        }
    })
    .catch(error => {
        console.error('Error fetching class data:', error);
    });
}



        function renderClasses(classes) {
            const container = document.getElementById('classes-container');
            container.innerHTML = ""; // Clear existing content

            if (!classes || classes.length === 0) {
                container.innerHTML = "<p>No enrollments found.</p>";
                return;
            }

            classes.forEach(record => {
    const rec = document.createElement('div');
    rec.className = 'record';
    rec.innerHTML = `
        <h2>Subject: ${record.Subject}</h2>
        <h5>Teacher : ${record.F_name || "N/A"} ${record.L_name || " "}</h5>
        <h3>Grade: ${record.Grade}</h3>
        <p>Type: ${record.Type}</p>
        <p>Max Student: ${record.Max_std}</p>
         <p>Address: ${record.Location}</p>
        <h5>Fee: ${record.fee}</h5>
        ${record.Isdiscountavail === 1 ? '<p class="free-card-msg">You have a free card for this class</p>' : ''}
        <button onclick="deleteEnrollment(${record.Enrollment_id})">Leave</button>
        <button onclick="viewShedule(${record.Class_id})">Schedule</button> <br><br>
        <button onclick="viewMat(${record.Class_id})">Learning Materials</button> <br><br>
        <button onclick="viewASS(${record.Class_id})">Assingments</button>

    `;
    container.appendChild(rec);
});

        }

        function deleteEnrollment(id) {
            alert("Are you sure you want to leave this class?");
            fetch(`http://localhost/group_project_1.0/public/Enrollment/mydeleteapi/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(() => {
                location.reload(); // Reload the page to reflect the deletion
            })
            .catch(error => {
                console.error('Error deleting record:', error);
            });
        }

        function viewShedule(Class_id){
            sessionStorage.setItem("class_id", Class_id);
             window.location.href = "http://localhost/group_project_1.0/public/ClassShcedules";
            console.log("Class ID stored in sessionStorage:", Class_id);
        }

        function viewMat(Class_id){
            sessionStorage.setItem("class_id", Class_id);
            window.location.href = "http://localhost/group_project_1.0/public/Learning_mat";
            console.log("Class ID stored in sessionStorage:", Class_id);
        }

        function viewASS(Class_id){
            sessionStorage.setItem("class_id", Class_id);
            window.location.href = "http://localhost/group_project_1.0/public/AssignmentController";
            console.log("Class ID stored in sessionStorage:", Class_id);
        }

    </script>
</body>
</html>

<?php
 include "C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php"
 ?>