

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../group_project_1.0/app/views/sysadmin.css">
</head>
<body>
    
    <header>
        <button id="menu-button" class="menu-button" onclick="toggleMenu()">☰</button>
        <h1>Admin Dashboard</h1>
    </header>

    <nav id="side-menu" class="side-menu">
        <button class="close-menu" onclick="toggleMenu()">×</button>
        <button onclick="postAnnouncement()">Post Announcements</button>
        <button onclick="viewAnnouncements()">View Announcements</button>
        <button onclick="viewBlogs()">View Blogs</button>
        <button onclick="viewAds()">View Advertisements</button>
        <button onclick="logout()">Logout</button>
    </nav>

    <div class="main-content">
        <nav class="top-buttons">
            <button onclick="handleStudents()">Students</button>
            <button onclick="handleTeachers()">Teachers</button>
            <button onclick="handleInstitutes()">Institutes</button>
        </nav>

        <div id="graph-container" class="graph-container">
            <canvas id="statsChart"></canvas>
        </div>

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

        function toggleMenu() {
            const sideMenu = document.getElementById('side-menu');
            sideMenu.classList.toggle('visible');
        }

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
                })
                .catch(error => console.error('Error fetching counts:', error));
        }

        function drawGraph() {
            // Clear the canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Set canvas size
            canvas.width = canvas.parentElement.offsetWidth;
            canvas.height = 400;

            const data = [counts.students, counts.teachers, counts.institutes];
            const labels = ['Students', 'Teachers', 'Institutes'];
            const colors = ['#1a73e8', '#4285f4', '#0f9d58'];
            
            const maxValue = Math.max(...data);
            const padding = 60;
            const barWidth = (canvas.width - 2 * padding) / data.length - 20;
            
            // Draw Y-axis
            ctx.beginPath();
            ctx.moveTo(padding, padding);
            ctx.lineTo(padding, canvas.height - padding);
            ctx.stroke();

            // Draw X-axis
            ctx.beginPath();
            ctx.moveTo(padding, canvas.height - padding);
            ctx.lineTo(canvas.width - padding, canvas.height - padding);
            ctx.stroke();

            // Draw bars and labels
            data.forEach((value, index) => {
                const x = padding + index * (barWidth + 20) + 10;
                const barHeight = ((canvas.height - 2 * padding) * value) / maxValue;
                const y = canvas.height - padding - barHeight;

                // Draw bar
                ctx.fillStyle = colors[index];
                ctx.fillRect(x, y, barWidth, barHeight);

                // Draw value on top of bar
                ctx.fillStyle = '#000';
                ctx.textAlign = 'center';
                ctx.fillText(value, x + barWidth/2, y - 5);

                // Draw label below bar
                ctx.fillText(labels[index], x + barWidth/2, canvas.height - padding + 20);
            });

            // Draw Y-axis labels
            const steps = 5;
            for(let i = 0; i <= steps; i++) {
                const value = Math.round((maxValue * i) / steps);
                const y = canvas.height - padding - ((canvas.height - 2 * padding) * i) / steps;
                ctx.fillText(value, padding - 20, y);
            }
        }

        function hideAllTables() {
            document.querySelectorAll('.data-table').forEach(table => table.style.display = 'none');
        }

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
                                <button onclick="handleDelete(${record.User_id}, '${tableId}')">Delete</button>
                                <button onclick="goToUpdateForm(${record.User_id})">Update</button>
                            </td>`;
                        tbody.appendChild(row);
                    });
                    document.getElementById(tableId).style.display = 'table';
                })
                .catch(error => console.error(`Error fetching ${tableId} data:`, error));
        }

        function handleStudents() {
            fetchData('sysadmin/studentapi', 'student-table');
        }

        function handleTeachers() {
            fetchData('sysadmin/teacherapi', 'teacher-table');
        }

        function handleInstitutes() {
            fetchData('sysadmin/instituteapi', 'institute-table');
        }
        function handleDelete(userId, tableId) {
    // Confirm deletion to prevent accidental actions
    

    // Call the delete API
    fetch(`sysadmin/deleteapi/${userId}`, { 
        method: 'POST', // Ensure the method matches your API's expectation
        headers: { 'Content-Type': 'application/json' } 
    })
        .then(response => {
            if (!response.ok) throw new Error('Failed to delete');
            return response.json();
        })
        .then(result => {
            // Check API response status
            if (result.status === 'success') {
                alert(result.message);
                // Refresh counts and reload the appropriate table
                getcount();
                if (tableId === 'student-table') handleStudents();
                else if (tableId === 'teacher-table') handleTeachers();
                else if (tableId === 'institute-table') handleInstitutes();
            } else {
                alert(`Error: ${result.message}`);
            }
        })
        .catch(error => console.error('Error deleting record:', error));
}



        function goToUpdateForm(userId) {
            window.location.href = `Sysadmin/update/${userId}`;
        }

        function postAnnouncement() {
            window.location.href = 'Announcement/index';
        }

        function viewAnnouncements() {
            window.location.href = 'Announcement/viewann';
        }

        function viewAds() {
            window.location.href = 'Advertisements';
        }

        function viewBlogs() {
            window.location.href = 'Blog';
        }

        function logout() {
            window.location.href = 'Signout';
        }

        // Initialize the page
        getcount();
        // Load student table initially
        handleStudents();

        // Redraw graph on window resize
        window.addEventListener('resize', drawGraph);
    </script>
</body>
</html>