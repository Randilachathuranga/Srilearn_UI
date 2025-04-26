<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../../group_project_1.0/public/views/AdminView/Sysadmin/sysadmin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Header with Menu Button -->
    <header>
        <button id="menu-button" class="menu-button" onclick="toggleMenu()">☰</button>
        <h1>Admin Dashboard</h1>
        <div class="header-notifications">
            <div class="notification-badge pending-payments">
                <i class="fas fa-money-bill-wave"></i>
                <span id="pending-payment-count">0</span>
            </div>
            <div class="notification-badge pending-signups">
                <i class="fas fa-user-plus"></i>
                <span id="pending-signup-count">0</span>
            </div>
        </div>
    </header>

    <!-- Sidebar Menu -->
    <nav id="side-menu" class="side-menu">
        <button class="close-menu" onclick="toggleMenu()"><i class="fas fa-times"></i></button>
        <button onclick="postAnnouncement()"><i class="fas fa-bullhorn"></i> Post Announcements</button>
        <button onclick="viewAnnouncements()"><i class="fas fa-list"></i> View Announcements</button>
        <button onclick="viewBlogs()"><i class="fas fa-blog"></i> View Blogs</button>
        <button onclick="viewAds()"><i class="fas fa-ad"></i> View Advertisements</button>
        <button onclick="viewpayreq()"><i class="fas fa-money-check-alt"></i> Payment Requests</button>
        <button onclick="viewsignupreq()"><i class="fas fa-user-clock"></i> SignUp Requests</button>
        <button onclick="Analyze()"><i class="fas fa-chart-line"></i> Payment Analytics</button>
        <button onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Stats Overview Cards -->
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-icon students">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-info">
                    <h3>Students</h3>
                    <span id="students-count">0</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon teachers">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-info">
                    <h3>Teachers</h3>
                    <span id="teachers-count">0</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon institutes">
                    <i class="fas fa-school"></i>
                </div>
                <div class="stat-info">
                    <h3>Institutes</h3>
                    <span id="institutes-count">0</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>Pending Actions</h3>
                    <span id="pending-actions-count">0</span>
                </div>
            </div>
        </div>

        <!-- Stats Container for Charts -->
        <div id="stats-container" class="stats-container">
            <div class="stats-content">
                <div class="analytics-content">
                    <div class="stats-chart">
                        <canvas id="statsChart"></canvas>
                    </div>
                    <div class="analytics-chart">
                        <canvas id="paymentAnalyticsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons for Tables -->
    <nav class="top-buttons">
        <button onclick="handleStudents()"><i class="fas fa-user-graduate"></i> Students</button>
        <button onclick="handleTeachers()"><i class="fas fa-chalkboard-teacher"></i> Teachers</button>
        <button onclick="handleInstitutes()"><i class="fas fa-school"></i> Institutes</button>
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

    <script>
    let counts = { 
        students: 0, 
        teachers: 0, 
        institutes: 0,
        pendingPayments: 0,
        pendingSignups: 0
    };
    
    const canvas = document.getElementById('statsChart');
    const ctx = canvas.getContext('2d');
    let statsChartInstance;
    let analyticsChartInstance;

    // Fetch pending counts
    function fetchPendingCounts() {
        // Fetch pending payments
        fetch('sysadmin/pendingpayment')
            .then(response => response.json())
            .then(data => {
                counts.pendingPayments = data.count || 0;
                document.getElementById('pending-payment-count').textContent = counts.pendingPayments;
                updatePendingActions();
            })
            .catch(error => console.error('Error fetching pending payments:', error));

        // Fetch pending signups
        fetch('sysadmin/pendingsignuppayment')
            .then(response => response.json())
            .then(data => {
                counts.pendingSignups = data.count || 0;
                document.getElementById('pending-signup-count').textContent = counts.pendingSignups;
                updatePendingActions();
            })
            .catch(error => console.error('Error fetching pending signups:', error));
    }

    function updatePendingActions() {
        const totalPending = counts.pendingPayments + counts.pendingSignups;
        document.getElementById('pending-actions-count').textContent = totalPending;
    }

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
                counts.students = data[0]?.stdcount || 0;
                counts.teachers = data[0]?.tchcount || 0;
                counts.institutes = data[0]?.instcount || 0;
                drawGraph();
                displayStats();
            })
            .catch(error => console.error('Error fetching counts:', error));
    }

    function displayStats() {
        document.getElementById('students-count').textContent = counts.students;
        document.getElementById('teachers-count').textContent = counts.teachers;
        document.getElementById('institutes-count').textContent = counts.institutes;
    }

    function drawGraph() {
        if (statsChartInstance) {
            statsChartInstance.destroy();
        }

        const data = [counts.students, counts.teachers, counts.institutes];
        const labels = ['Students', 'Teachers', 'Institutes'];
        const total = data.reduce((acc, count) => acc + count, 0);
        const percentages = data.map(count => (total ? (count / total) * 100 : 0));

        statsChartInstance = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: percentages,
                    backgroundColor: ['#4361ee', '#3a0ca3', '#4895ef'],
                    hoverBackgroundColor: ['#3a56e8', '#2e0a8c', '#3b82f6'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw.toFixed(2)}% (${data[context.dataIndex]})`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
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
                            <button class="delete-btn" onclick="handleDelete(${record.User_id}, '${tableId}')"><i class="fas fa-trash-alt"></i> Delete</button>
                            <button class="update-btn" onclick="goToUpdateForm(${record.User_id})"><i class="fas fa-edit"></i> Update</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
                document.getElementById(tableId).style.display = 'table';
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function handleStudents() { fetchData('sysadmin/studentapi', 'student-table'); }
    function handleTeachers() { fetchData('sysadmin/teacherapi', 'teacher-table'); }
    function handleInstitutes() { fetchData('sysadmin/instituteapi', 'institute-table'); }

    function handleDelete(userId, tableId) {
        if(confirm('Are you sure you want to delete this user?')) {
            fetch(`http://localhost/group_project_1.0/public/sysadmin/deleteapi/${userId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Failed to delete');
                    return response.json();
                })
                .then(() => {
                    getcount();
                    if (tableId === 'student-table') handleStudents();
                    else if (tableId === 'teacher-table') handleTeachers();
                    else if (tableId === 'institute-table') handleInstitutes();
                    window.location.reload(); // Reload the page to reflect changes
                })
                .catch(error => console.error('Error deleting record:', error));
        }
    }

    function goToUpdateForm(userId) {
        window.location.href = `Sysadmin/update/${userId}`;
    }

    function postAnnouncement() { window.location.href = 'Announcement/index'; }
    function viewpayreq() { window.location.href = 'Sysadmin/paymentreq'; }
    function viewsignupreq() { window.location.href = 'Sysadmin/signupre'; }
    function viewAnnouncements() { window.location.href = 'Announcement/viewann'; }
    function viewAds() { window.location.href = 'Advertisements'; }
    function viewBlogs() { window.location.href = 'Blog'; }
    function logout() { window.location.href = 'Signout'; }
    function Analyze() { window.location.href = 'Sysadmin/paymentreview'; }

    function fetchAndDrawAnalytics() {
        fetch('sysadmin/analaticsfordb')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.status !== 'success') {
                    console.error('Error fetching analytics:', data.message);
                    return;
                }

                const labels = Object.keys(data.data);
                const amounts = Object.values(data.data);

                if (analyticsChartInstance) {
                    analyticsChartInstance.destroy();
                }

                const ctxAnalytics = document.getElementById('paymentAnalyticsChart').getContext('2d');
                analyticsChartInstance = new Chart(ctxAnalytics, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Monthly Payments',
                            data: amounts,
                            fill: true,
                            borderColor: '#7209b7',
                            backgroundColor: 'rgba(114, 9, 183, 0.1)',
                            tension: 0.4,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#7209b7',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Monthly Payment Analytics',
                                font: {
                                    size: 16
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `Amount: ${context.raw} LKR`;
                                    }
                                }
                            },
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                title: { 
                                    display: true, 
                                    text: 'Month',
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    display: false
                                },
                                ticks: { 
                                    autoSkip: false, 
                                    maxRotation: 90, 
                                    minRotation: 45 
                                }
                            },
                            y: {
                                title: { 
                                    display: true, 
                                    text: 'Amount (LKR)',
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching analytics:', error));
    }

    // Initialize everything
    document.addEventListener('DOMContentLoaded', function() {
        getcount();
        fetchPendingCounts();
        handleStudents();
        fetchAndDrawAnalytics();
    });

    window.addEventListener('resize', function() {
        if (statsChartInstance) statsChartInstance.resize();
        if (analyticsChartInstance) analyticsChartInstance.resize();
    });
    </script>
</body>
</html>