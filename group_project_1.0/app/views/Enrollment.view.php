<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Enrollments</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/app/views/enrollmentview.css">
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header-container">
            <h1 class="header-title">My Enrollments</h1>
        </div>

        <!-- Banner Section -->
        <div class="banner-container">
            <img src="../../../../../group_project_1.0/app/views/teacherclass.jpg" alt="Teacher Class" class="banner-image">
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
            fetch('http://localhost/group_project_1.0/public/Enrollment/api/')
                .then(response => response.ok ? response.json() : Promise.reject('Failed to load'))
                .then(data => renderClasses(data || [])) // Ensure data is an array
                .catch(error => console.error('Error fetching all classes:', error));
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
                    <h3>Grade: ${record.Grade}</h3>
                    <p>Type: ${record.Type}</p>
                    <h5>Fee: ${record.fee}</h5>
                    <button onclick="deleteEnrollment(${record.Enrollment_id})">Leave</button>
                `;
                container.appendChild(rec);
            });
        }

        function deleteEnrollment(id) {
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
    </script>
</body>
</html>
