<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Announcements</title>
    <link rel="stylesheet" href="../../../group_project_1.0/app/views/Announcement.css"> <!-- Link to the CSS file -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Header Section -->
    <header class="header">
        <h1>System Announcements</h1>
    </header>

    <!-- Container for Announcements -->
    <div id="container" class="container"></div>

    <!-- JavaScript to Handle Fetching and Displaying Announcements -->
    <script>
        const userRole = "<?php echo $_SESSION['Role'] ?? ''; ?>"; // Set the role from PHP

        document.addEventListener('DOMContentLoaded', () => {
            fetch('http://localhost/group_project_1.0/public/Announcement/api') // Adjust this URL to match your routing structure
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const container = document.getElementById('container');
                    data.forEach(record => {
                        const rec = document.createElement('div');
                        rec.className = 'record';
                        rec.innerHTML = `
                            <h3>${record.title}</h3>
                            <p>${record.announcement}</p>
                            <h5>${record.date}</h5>
                            ${userRole === 'Sysadmin' ? `<button onclick="handleDelete(${record.annid})">Delete</button>` : ''}
                            ${userRole === 'Sysadmin' ? `<button onclick="gotoupdateform(${record.annid})">Update</button>` : ''}
                        `;
                        container.appendChild(rec); // Append each announcement to the container
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        });

        function handleDelete(id) {
            fetch(`http://localhost/group_project_1.0/public/Announcement/deleteapi/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(() => window.location.href = `viewann`) // Redirect after deletion
            .catch(error => {
                console.error('Error deleting record:', error);
            });
        }

        function gotoupdateform(id) {
            window.location.href = `updateapi/${id}`;
        }
    </script>

</body>
</html>
