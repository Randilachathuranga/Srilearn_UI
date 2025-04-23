<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../../group_project_1.0/public/views/AdminView/Sysadmin/sysadmin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
</head>
<body>
    <!-- Header with Menu Button -->
    <header>
        <button id="menu-button" class="menu-button" onclick="toggleMenu()">☰</button>
        <h1>Admin Dashboard</h1>
    </header>

    <!-- Sidebar Menu -->
    <nav id="side-menu" class="side-menu">
        <button class="close-menu" onclick="toggleMenu()">×</button>
        <button onclick="postAnnouncement()">Post Announcements</button>
        <button onclick="viewAnnouncements()">View Announcements</button>
        <button onclick="viewBlogs()">View Blogs</button>
        <button onclick="viewAds()">View Advertisements</button>
        <button onclick="logout()">Logout</button>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Stats Container for Pie Chart and Counts -->
        <div id="stats-container" class="stats-container">
            <div class="stats-chart">
                <canvas id="statsChart"></canvas>
            </div>
            <div class="stats-info">
                <h3>User Count</h3>
                <div class="stat-item">Students: <span id="students-count">0</span></div>
                <div class="stat-item">Teachers: <span id="teachers-count">0</span></div>
                <div class="stat-item">Institutes: <span id="institutes-count">0</span></div>
            </div>
        </div>

        <!-- Navigation Buttons for Tables -->
        <nav class="top-buttons">
            <button onclick="handleStudents()">Students</button>
            <button onclick="handleTeachers()">Teachers</button>
            <button onclick="handleInstitutes()">Institutes</button>
        </nav> 

        <!-- Tables Section -->
        <div id="card-container">
            <table id="student-table" class="data-table">
                <caption>Students</caption>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>District</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <table id="teacher-table" class="data-table" style="display:none;">
                <caption>Teachers</caption>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>District</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <table id="institute-table" class="data-table" style="display:none;">
                <caption>Institutes</caption>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>District</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script>
        let counts = { students: 0, teachers: 0, institutes: 0 };
        const canvas = document.getElementById('statsChart');
        const ctx = canvas.getContext('2d');

        // Toggle the side menu visibility
        function toggleMenu() {
            const sideMenu = document.getElementById('side-menu');
            sideMenu.classList.toggle('visible');
        }

        // Fetch the counts of students, teachers, and institutes from the API
        function getcount() {
            fetch('sysadmin/count')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    counts.students = data[0].stdcount || 0;
                    counts.teachers = data[0].tchcount || 0;
                    counts.institutes = data[0].instcount || 0;
                    drawGraph();
                    displayStats();
                })
                .catch(error => console.error('Error fetching counts:', error));
        }

        // Display the stats in the right panel
        function displayStats() {
            document.getElementById('students-count').textContent = counts.students;
            document.getElementById('teachers-count').textContent = counts.teachers;
            document.getElementById('institutes-count').textContent = counts.institutes;
        }

        // Draw the graph (Pie chart) with the percentage data
        function drawGraph() {
            const data = [counts.students, counts.teachers, counts.institutes];
            const labels = ['Students', 'Teachers', 'Institutes'];
            const total = data.reduce((acc, count) => acc + count, 0);

            // Calculate the percentage for each category
            const percentages = data.map(count => (count / total) * 100);

            canvas.width = 200; // Make the chart smaller
            canvas.height = 200; // Make the chart smaller

            // Create the pie chart
            const chart = new Chart(ctx, {
                type: 'pie',  // Pie chart
                data: {
                    labels: labels,
                    datasets: [{
                        data: percentages,
                        backgroundColor: ['#ff5733', '#4285f4', '#0f9d58'],  // Color for each section
                        hoverBackgroundColor: ['#ff2a00', '#3b82f6', '#0f7d4e'],  // Hover color
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw;
                                    let percentage = value.toFixed(2) + '%';
                                    return label + ': ' + percentage;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Hide all tables
        function hideAllTables() {
            document.querySelectorAll('.data-table').forEach(table => table.style.display = 'none');
        }

        // Fetch and display data for a specific table
        function fetchData(api, tableId) {
            hideAllTables();
            fetch(api)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const tbody = document.querySelector(`#${tableId} tbody`);
                    tbody.innerHTML = '';
                    data.forEach(record => {
                        const row = document.createElement('tr');
                        row.innerHTML = ` 
                            <td>${record.User_id}</td>
                            <td>${record.F_name}</td>
                            <td>${record.L_name}</td>
                            <td>${record.Email}</td>
                            <td>${record.District}</td>
                            <td>${record.Phone_number}</td>
                            <td>${record.Address}</td>
                            <td>
                                <button class="delete-btn" onclick="handleDelete(${record.User_id}, '${tableId}')">Delete</button>
                                <button class="update-btn" onclick="goToUpdateForm(${record.User_id})">Update</button>
                            </td>`;
                        tbody.appendChild(row);
                    });
                    document.getElementById(tableId).style.display = 'table';
                })
                .catch(error => console.error(`Error fetching ${tableId} data:`, error));
        }

        // Handle button clicks for displaying data
        function handleStudents() {
            fetchData('sysadmin/studentapi', 'student-table');
        }

        function handleTeachers() {
            fetchData('sysadmin/teacherapi', 'teacher-table');
        }

        function handleInstitutes() {
            fetchData('sysadmin/instituteapi', 'institute-table');
        }

        // Handle delete of a record
        function handleDelete(userId, tableId) {
            fetch(`sysadmin/deleteapi/${userId}`, { method: 'DELETE' })
                .then(response => {
                    if (!response.ok) throw new Error('Failed to delete');
                    return response.json();
                })
                .then(() => {
                    getcount();
                    if (tableId === 'student-table') handleStudents();
                    else if (tableId === 'teacher-table') handleTeachers();
                    else if (tableId === 'institute-table') handleInstitutes();
                })
                .catch(error => console.error('Error deleting record:', error));
        }

        // Redirect to the update form
        function goToUpdateForm(userId) {
            window.location.href = `Sysadmin/update/${userId}`;
        }

        // Initialize the page
        getcount();
        handleStudents();  // Load student table initially

        // Redraw graph on window resize
        window.addEventListener('resize', drawGraph);
    </script>
</body>
</html>
