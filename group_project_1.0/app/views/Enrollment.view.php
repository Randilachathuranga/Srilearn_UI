<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>My Classes</h1>
    <div class="classes-container" id="classes-container">
        <!-- Classes will be dynamically rendered here -->
    </div>

    <script>
        // Fetch all classes initially and render them
        document.addEventListener('DOMContentLoaded', fetchAllClasses);
        // Fetch all classes and render
        function fetchAllClasses() {
            fetch('http://localhost/group_project_1.0/public/Enrollment/api/')
                .then(response => response.ok ? response.json() : Promise.reject('Failed to load'))
                .then(data => renderClasses(data || [])) // Ensure data is an array
                .catch(error => console.error('Error fetching all classes:', error));
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
                    <button onclick="deleteEnrollment(${record.Enrollment_id})">Leave</button>
                `;
                container.appendChild(rec);
            });
        }

         function deleteEnrollment(id){
            fetch(`http://localhost/group_project_1.0/public/Enrollment/mydeleteapi/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(() => {
                location.reload(); // Reload the page to reflect deletion
            })
            .catch(error => {
                console.error('Error deleting record:', error);
            });
         }
    </script>
</body>
</html>