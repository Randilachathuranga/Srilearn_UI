<?php 
 include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php"

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

    <!-- Script Section -->
    <script>
        // Fetch all classes initially and render them
        document.addEventListener('DOMContentLoaded', fetchAllClasses);

        // Add event listeners to dropdowns
        document.getElementById("subject").addEventListener("change", fetchFilteredClasses);
        document.getElementById("grade").addEventListener("change", fetchFilteredClasses);

        // Fetch all classes and render
        function fetchAllClasses() {
            fetch('http://localhost/group_project_1.0/public/Student/allclasses')
                .then(response => response.ok ? response.json() : Promise.reject('Failed to load'))
                .then(data => renderClasses(data || [])) // Ensure data is an array
                .catch(error => console.error('Error fetching all classes:', error));
        }

        // Fetch filtered classes based on dropdown selections
        function fetchFilteredClasses() {
            const subject = document.getElementById("subject").value;
            const grade = document.getElementById("grade").value;

            const url = `http://localhost/group_project_1.0/public/Student/viewClasses/${subject}/${grade}`;
            fetch(url)
                .then(response => response.ok ? response.json() : Promise.reject('Failed to load'))
                .then(data => renderClasses(data || [])) // Ensure data is an array
                .catch(error => console.error('Error fetching filtered classes:', error));
        }

        // Render classes dynamically
        function renderClasses(classes) {
            const container = document.getElementById('classes-container');
            container.innerHTML = ""; // Clear existing content

            // Handle empty or null data
            if (!classes || classes.length === 0) {
                container.innerHTML = "<p>No classes available for the selected filters.</p>";
                return;
            }

            // Render each class record
            classes.forEach(record => {
                const rec = document.createElement('div');
                rec.className = 'record';
                rec.innerHTML = `
                    <h2>Subject: ${record.Subject}</h2>
                    <h3>Grade: ${record.Grade}</h3>
                    <p>Type: ${record.Type}</p>
                    <h5>Fee: ${record.fee}</h5>
                    
                    <?php if(($_SESSION['Role']=='student')) echo '<button onclick="handleEnrollment(${record.Class_id})">Join Class</button>';?>
                `;
                container.appendChild(rec);
            });
        }

        function handleEnrollment(classId) {
            fetch(`http://localhost/group_project_1.0/public/Enrollment/post/${classId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    alert(data.error); // Show error message
                } else if (data.message) {
                    alert(data.message); // Show success message
                }
                // Optionally reload classes
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