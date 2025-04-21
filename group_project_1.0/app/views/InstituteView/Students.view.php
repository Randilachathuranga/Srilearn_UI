<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
</head>
<body>
    <div id="container"></div>

    <script>
        // Retrieve class_id from sessionStorage
        const classId = sessionStorage.getItem("class_id");
        console.log('Class ID from session storage:', classId); // Log the class ID for debugging

        // PHP session variables for user ID and role
        var userID = "<?php echo $_SESSION['User_id'] ?? ''; ?>"; // User ID from PHP session
        var userRole = "<?php echo $_SESSION['role'] ?? ''; ?>"; // User role from PHP session

        document.addEventListener('DOMContentLoaded', () => {
            // Check if classId exists in sessionStorage
            if (!classId) {
                console.error('No class ID found in session storage');
                return; // Stop execution if no class ID is found
            }

            // Fetch student data using the classId
            fetch(`http://localhost/group_project_1.0/public/Institute/studentapi/${classId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data || data.length === 0) {
                        console.log('No students found for this class');
                        return;
                    }

                    // Append student records to the container
                    const container = document.getElementById('container');
                    data.forEach(record => {
                        const rec = document.createElement('div');
                        rec.className = 'record';
                        rec.innerHTML = `
                            <h3>Student ID: ${record.Stu_id}</h3>
                            <p>Enrollment Date: ${record.Date}</p>
                            
                            <!-- Conditionally show the delete button based on userRole -->
                           <button onclick="handleDelete(${record.Enrollment_id})">Delete</button>
                        `;
                        container.appendChild(rec); // Append each student record to the container
                    });
                })
                .catch(error => {
                    console.error('There was an error fetching student data:', error);
                });
        });

        // Define the handleDelete function
        function handleDelete(enrollId) {
            console.log('Deleting student with ID:', enrollId); // Log the enrollment ID for debugging
            alert("Are you sure you want to remove this class?");
            fetch(`http://localhost/group_project_1.0/public/Institute/removestudent/${enrollId}`, {
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
