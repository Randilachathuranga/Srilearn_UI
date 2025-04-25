<?php 
 include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Filter</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Byclasses/class.css">
</head>
<body>

<!-- Page Content Container -->
<div class="container">
    <!-- Title Section -->
    <div class="header-container">
        <h1 class="header-title">Classes</h1>
    </div>

    <!-- Banner Image -->
    <div class="banner-container">
        <img src="../../../../../group_project_1.0/public/views/General/Byclasses/teacher.jpg" alt="Teacher Image">
    </div>

    <!-- Filter Section -->
    <div class="filter-container">
        <h2>Filter Classes</h2>
        <div class="dropdown-container">
            <label for="subject">Select Subject:</label>
            <select id="subject">
                <option value="">--Select Subject--</option>
                <option value="Buddhism">Buddhism</option>
                <option value="Civics">Civics</option>
                <option value="Commerce">Commerce</option>
                <option value="Dance">Dance</option>
                <option value="Drama">Drama</option>
                <option value="Eastern Music">Eastern Music</option>
                <option value="English">English</option>
                <option value="Geography">Geography</option>
                <option value="Health">Health</option>
                <option value="History">History</option>
                <option value="ICT">ICT</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Pali">Pali</option>
                <option value="Physical Education">Physical Education</option>
                <option value="Physics">Physics</option>
                <option value="Political Science">Political Science</option>
                <option value="Religion">Religion</option>
                <option value="Science">Science</option>
                <option value="Sinhala">Sinhala</option>
                <option value="Tamil">Tamil</option>
                <option value="Technology">Technology</option>
                <option value="Western Music">Western Music</option>
            </select>

            <label for="grade">Select Grade:</label>
            <select id="grade">
                <option value="">--Select Grade--</option>
                <option value="1">Grade 1</option>
                <option value="2">Grade 2</option>
                <option value="3">Grade 3</option>
                <option value="4">Grade 4</option>
                <option value="5">Grade 5</option>
                <option value="6">Grade 6</option>
                <option value="7">Grade 7</option>
                <option value="8">Grade 8</option>
                <option value="9">Grade 9</option>
                <option value="10">Grade 10</option>
                <option value="11">Grade 11</option>
                <option value="12">Grade 12</option>
                <option value="13">Grade 13</option>
            </select>
        </div>
    </div>

    <!-- Classes Display Section -->
    <div class="classes-container" id="classes-container">
        <!-- Classes will be dynamically rendered here -->
    </div>
</div>

<!-- Insert user role from PHP into JavaScript -->
<script>
    const userRole = "<?php echo $_SESSION['Role'] ?? ''; ?>";
</script>

<script>
    document.addEventListener('DOMContentLoaded', fetchAllClasses);
    document.getElementById("subject").addEventListener("change", fetchFilteredClasses);
    document.getElementById("grade").addEventListener("change", fetchFilteredClasses);

    function fetchAllClasses() {
        const individualURL = 'http://localhost/group_project_1.0/public/Student/allindividual';
        const instituteURL = 'http://localhost/group_project_1.0/public/Student/allinstitute';

        Promise.all([
            fetch(individualURL).then(res => res.ok ? res.json() : []),
            fetch(instituteURL).then(res => res.ok ? res.json() : [])
        ])
        .then(([individualData, instituteData]) => {
            const allClasses = [...individualData, ...instituteData];
            renderClasses(allClasses);
        })
        .catch(error => console.error('Error fetching class data:', error));
    }

    function fetchFilteredClasses() {
        const subject = document.getElementById("subject").value;
        const grade = document.getElementById("grade").value;
        let combinedResults = [];

        const fetchUrl1 = fetch(`http://localhost/group_project_1.0/public/Student/viewindividual/${subject}/${grade}`)
            .then(response => response.ok ? response.json() : []);

        const fetchUrl2 = fetch(`http://localhost/group_project_1.0/public/Student/viewinstitute/${subject}/${grade}`)
            .then(response => response.ok ? response.json() : []);

        Promise.all([fetchUrl1, fetchUrl2])
            .then(([data1, data2]) => {
                if (Array.isArray(data1)) combinedResults = combinedResults.concat(data1);
                if (Array.isArray(data2)) combinedResults = combinedResults.concat(data2);
                renderClasses(combinedResults);
            })
            .catch(error => {
                console.error('Error fetching filtered classes:', error);
                renderClasses([]);
            });
    }

    function renderClasses(classes) {
        const container = document.getElementById('classes-container');
        container.innerHTML = "";

        if (!classes || classes.length === 0) {
            container.innerHTML = "<p>No classes available for the selected filters.</p>";
            return;
        }

        classes.forEach(record => {
            const rec = document.createElement('div');
            rec.className = 'record';

            rec.innerHTML = `
                <h2>Subject: ${record.Subject}</h2>
                <h5>Teacher : ${record.F_name || "N/A"} ${record.L_name || ""}</h5>
                <h3>Grade: ${record.Grade}</h3>
                <p>Type: ${record.Type}</p>
                <p>Address: ${record.Location}</p>
                <p>Subject: ${record.Subject}</p>
                <h5>Fee: ${record.fee}</h5>
                <p>Date: ${record.Def_Date}</p>
                <p>Time: ${record.Def_Time}</p>
            `;

            if (userRole === 'student') {
                const btn = document.createElement('button');
                btn.textContent = 'Join Class';
                btn.onclick = () => proceedtopayment(
                    record.Class_id,
                    record.Subject,
                    `${record.F_name} ${record.L_name}`,
                    record.fee
                );
                rec.appendChild(btn);
            }

            container.appendChild(rec);
        });
    }

    function proceedtopayment(classID, subject, teacher, fee) {
        const url = new URL('http://localhost/group_project_1.0/public/Payment/enrollpayment');
        url.searchParams.set('classID', classID);
        url.searchParams.set('subject', subject);
        url.searchParams.set('teacher', teacher);
        url.searchParams.set('fee', fee);
        window.location.href = url.toString();
    }

    function handleEnrollment(classId) {
        fetch(`http://localhost/group_project_1.0/public/Enrollment/post/${classId}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
        })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            alert(data.error || data.message || 'Enrollment status unknown.');
            window.location.href = 'http://localhost/group_project_1.0/public/Enrollment';
        })
        .catch(error => {
            console.error('Error during enrollment:', error);
            alert('Could not complete enrollment. You are already enrolled to this class.');
        });
    }
</script>

</body>
</html>

<?php
require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
?>