<?php 
 include "C:xampp/htdocs/group_project_1.0/app/views/NavBar/User_NavBar/UserNavBar.view.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Filter</title>
    <link rel="stylesheet" href="../../../group_project_1.0/app/views/class.css">
</head>
<body>
    <div class="filter-container">
        <h1>Class Filter</h1>
        <div class="dropdown-container">
            <label for="subject">Select Subject:</label>
            <select id="subject">
                <option value="Mathematics">Mathematics</option>
                <option value="Biology">Science</option>
                <option value="History">History</option>
                <option value="English">English</option>
                <option value="Physics">Physics</option>
            </select>

            <label for="grade">Select Grade:</label>
            <select id="grade">
                <option value=6>Grade 6</option>
                <option value=7>Grade 7</option>
                <option value=11>Grade 11</option>
                <option value=12>Grade 12</option>
            </select>
        </div>
    </div>

    <div class="classes-container" id="classes-container">
        <!-- Classes will be dynamically rendered here -->
    </div>

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
                    <button onclick="handleEnrollment(${record.Class_id})">Enroll</button>
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
            alert('Could not complete enrollment. Please try again later.');
        });
}

    </script>
</body>
</html>


<?php
 include "C:xampp/htdocs/group_project_1.0/app/views/Footer/Footer.php"
 ?>