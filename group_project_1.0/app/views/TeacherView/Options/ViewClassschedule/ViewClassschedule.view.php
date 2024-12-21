<?php 
 include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php"

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Class Schedule</title>
  <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/TeacherView/Options/ViewClassschedule/styles.css">
</head>
<body>
  <div class="container">
    <h1>Class Schedule</h1>
    <button class="create-schedule" onclick="openForm()">Create Schedule</button>
    <table>
      <thead>
        <tr>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="scheduleTable">
        <!-- Rows will be dynamically added -->
      </tbody>
    </table>
  </div>

  <!-- Hidden form (Popup) -->
  <div id="scheduleFormPopup" style="display: none;">
    <div class="modal-content">
  <h2>Create Schedule</h2>
  <form id="scheduleForm">
    <label for="startTime">Start Time:</label>
    <input type="time" id="startTime" name="start_time" required />

    <label for="endTime">End Time:</label>
    <input type="time" id="endTime" name="end_time" required />

    <label for="dayOfWeek">Day of the Week:</label>
    <select id="dayOfWeek" name="day_of_week" required>
      <option value="Monday">Monday</option>
      <option value="Tuesday">Tuesday</option>
      <option value="Wednesday">Wednesday</option>
      <option value="Thursday">Thursday</option>
      <option value="Friday">Friday</option>
      <option value="Saturday">Saturday</option>
      <option value="Sunday">Sunday</option>
    </select>

    <button type="submit">Submit</button>
    <button type="button" onclick="closeForm()">Cancel</button>
  </form>
    </div>
</div>


<Script>
     const userRole = `<?php echo $_SESSION['Role']; ?>`;  // Make sure this is properly set in the PHP view
     console.log(userRole);
</Script>
  <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/ViewClassschedule/script.js"></script>
</body>
</html>



<?php
 include "C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php"
 ?>