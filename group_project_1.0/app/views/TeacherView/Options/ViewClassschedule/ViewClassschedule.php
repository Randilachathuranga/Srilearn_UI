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
    <button class="create-schedule" id="createScheduleBtn">Create Schedule</button>
    <table>
      <thead>
        <tr>
          <th>Schedule ID</th>
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

  <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/ViewClassschedule/script.js"></script>
</body>
</html>
