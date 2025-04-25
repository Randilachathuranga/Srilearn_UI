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
            <button id="removedstdButton" class="show-removed" onclick="showdeletedstd()">Show removed Students</button>
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
                    <th>Chat</th>
                </tr>
            </thead>
            <tbody id="studentsTableBody">
                <!-- Students will be dynamically added here -->
            </tbody>
        </table>
    </div>
    <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/ClassStudents/Script.js"></script>
    <div id="reasonPopup" style="display: none; position: fixed; top: 0; left: 0; 
  width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); 
  justify-content: center; align-items: center; z-index: 9999;">
  <div style="background-color: white; padding: 20px; border-radius: 10px; max-width: 400px; width: 90%;">
    <h3>Reason for Removal</h3>
    <textarea id="removalReason" rows="4" style="width: 100%;"></textarea>
    <div style="margin-top: 10px; text-align: right;">
      <button onclick="submitRemoval()" style="margin-right: 10px;">Submit</button>
      <button onclick="closePopup()">Cancel</button>
    </div>
  </div>
</div>
</body>
</html>

<?php
 include "C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php"
 ?>