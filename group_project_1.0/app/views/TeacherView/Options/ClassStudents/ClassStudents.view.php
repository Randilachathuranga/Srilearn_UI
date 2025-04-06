<?php   
include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php"  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Details</title>
    <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/TeacherView/Options/ClassStudents/Styles.css">
</head>
<body>
    <div class="container">
        <h1>Students Details</h1>
        
        <div class="search-container">
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Search students by name..." 
                class="search-input"
            >
            <button id="searchButton" class="search-button">Search</button>
        </div>

        <table class="students-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>District</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="studentsTableBody">
                <!-- Students will be dynamically added here -->
            </tbody>
        </table>
    </div>
    <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/ClassStudents/Script.js"></script>
</body>
</html>

<?php
 include "C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php"
 ?>