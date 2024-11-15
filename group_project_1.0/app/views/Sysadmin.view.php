<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Button controls -->
    <div>
        <button onClick="handleStudents()">Students</button>
        <button onClick="handleTeachers()">Teachers</button>
        <button onClick="handleInstitutes()">Institutes</button>
        <button onClick="postAnnouncement()">Post Announcements</button>
        <button onClick="viewAnnouncements()">View Announcements</button>
        <button onClick="logout()">logout</button>
    </div>

    <!-- Containers for tables -->
    <div id="card-container" class="card-container">
        <!-- Students Table -->
        <table id="student-table" border="1" style="display:none;">
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
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <!-- Teachers Table -->
        <table id="teacher-table" border="1" style="display:none;">
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
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <!-- Institutes Table -->
        <table id="institute-table" border="1" style="display:none;">
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
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script>
        // Hide all tables initially
        function hideAllTables() {
            document.getElementById("student-table").style.display = "none";
            document.getElementById("teacher-table").style.display = "none";
            document.getElementById("institute-table").style.display = "none";
        }

        // Fetch and display student data
        function handleStudents() {
            hideAllTables();
            fetch('sysadmin/studentapi')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const tbody = document.querySelector("#student-table tbody");
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
                            <td><button onClick="handleDelete(${record.User_id}, 'Student')">Delete</button></td>
                            <td><button onClick="goToUpdateForm(${record.User_id})">Update</button></td>
                        `;
                        tbody.appendChild(row);
                    });
                    document.getElementById("student-table").style.display = "table";
                })
                .catch(error => {
                    console.error('Error fetching student data:', error);
                });
        }

        // Fetch and display teacher data
        function handleTeachers() {
            hideAllTables();
            fetch('sysadmin/teacherapi')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const tbody = document.querySelector("#teacher-table tbody");
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
                            <td><button onClick="handleDelete(${record.User_id}, 'Teacher')">Delete</button></td>
                            <td><button onClick="goToUpdateForm(${record.User_id})">Update</button></td>
                        `;
                        tbody.appendChild(row);
                    });
                    document.getElementById("teacher-table").style.display = "table";
                })
                .catch(error => {
                    console.error('Error fetching teacher data:', error);
                });
        }

        // Fetch and display institute data
        function handleInstitutes() {
            hideAllTables();
            fetch('sysadmin/instituteapi')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const tbody = document.querySelector("#institute-table tbody");
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
                            <td><button onClick="handleDelete(${record.User_id}, 'Institute')">Delete</button></td>
                            <td><button onClick="goToUpdateForm(${record.User_id})">Update</button></td>
                        `;
                        tbody.appendChild(row);
                    });
                    document.getElementById("institute-table").style.display = "table";
                })
                .catch(error => {
                    console.error('Error fetching institute data:', error);
                });
        }

        // Delete user based on type
        function handleDelete(userId, type) {
            fetch(`sysadmin/deleteapi/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Delete successful:', data);
                if (type === 'Student') {
                    handleStudents();
                } else if (type === 'Teacher') {
                    handleTeachers();
                } else if (type === 'Institute') {
                    handleInstitutes();
                }
            })
            .catch(error => {
                console.error('Error deleting record:', error);
            });
        }

        function goToUpdateForm(userId) {
            window.location.href = `Sysadmin/update/${userId}`;
        }

        // Post announcement function
        function postAnnouncement() {
          window.location.href=`Announcement/index`;
        }

        // View announcements function
        function viewAnnouncements() {
            window.location.href=`Announcement/viewann`;
        }   

        function logout(){
            window.location.href=`Signout`;
        }
    </script>

</body>
</html>
