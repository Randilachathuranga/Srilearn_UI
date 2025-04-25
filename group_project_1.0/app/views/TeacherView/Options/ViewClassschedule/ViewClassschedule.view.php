<?php 
  include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Class Schedule</title>
  <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/TeacherView/Options/ViewClassschedule/styles.css">
  <style>
    .announcement-container {
      margin: 20px;
      text-align: center;
    }

    .announcement-btn {
      margin: 10px;
      padding: 10px 20px;
      background-color: #2874A6;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }

    .announcement-btn:hover {
      background-color: #1A5276;
    }

    .popup {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      z-index: 999;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .popup-content {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      width: 400px;
      max-width: 90%;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      position: relative;
    }

    .popup-content textarea {
      width: 100%;
      height: 80px;
      margin-bottom: 10px;
      padding: 10px;
      font-size: 14px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .popup-content button {
      margin-right: 10px;
      padding: 8px 16px;
      background-color: #2874A6;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 6px;
    }

    .popup-content button:hover {
      background-color: #1A5276;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Class Schedule</h1>
    
    <?php 
      if ($_SESSION['Role'] == 'teacher') { 
        echo '<button class="create-schedule" onclick="openForm()">Create Schedule</button>';
      }
    ?>
    <table>
      <thead>
        <tr>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Date</th>
          <?php 
            if ($_SESSION['Role'] == 'teacher') { 
              echo '<th>Actions</th>';
            }
          ?>
        </tr>
      </thead>
      <tbody id="scheduleTable">
        <!-- Rows will be dynamically added -->
      </tbody>
    </table>
  </div>

  <div class="announcement-container">
    <?php 
      if ($_SESSION['Role'] == 'teacher') { 
        echo '<button class="announcement-btn" onclick="openCreateAnnouncement()">Create Announcement</button>';
      }
    ?>
    <button class="announcement-btn" onclick="openViewAnnouncement()">View Announcements</button>
  </div>

  <!-- Schedule Form Popup -->
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

  <!-- Create Announcement Popup -->
  <div id="createAnnouncementPopup" class="popup" style="display: none;">
    <div class="popup-content">
      <h2>Create Announcement</h2>
      <form id="announcementForm">
        <label for="announcementDesc">Description:</label>
        <textarea id="announcementDesc" name="description" required></textarea>

        <p id="announcementDate"></p>

        <button type="submit">Submit</button>
        <button type="button" onclick="closeCreateAnnouncement()">Close</button>
      </form>
    </div>
  </div>

  <!-- View Announcements Popup -->
  <div id="viewAnnouncementPopup" class="popup" style="display: none;">
    <div class="popup-content">
      <h2>Announcements</h2>
      <div id="announcementList">
        <!-- Placeholder for announcement content -->
      </div>
      <button type="button" onclick="closeViewAnnouncement()">Close</button>
    </div>
  </div>
    
 

  <script>
    const userRole = `<?php echo $_SESSION['Role']; ?>`;
    console.log(userRole);

    document.getElementById('announcementForm')?.addEventListener('submit', function(e) {
      e.preventDefault();
      const description = document.getElementById('announcementDesc').value.trim();
      
      if (description) {
        const now = new Date();
        const recordData = {
          classid: classId,
          date: now.toISOString().split('T')[0],
          time: now.toTimeString().split(' ')[0],
          description: description
        };
        console.log("Record Data:", recordData);

        fetch('http://localhost/group_project_1.0/public/ClassShcedules/post', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(recordData)
        })
        .then(response => {
          if (!response.ok) throw new Error('Failed to send message');
          return response.json();
        })
        .then(data => {
          console.log(data);
          closeCreateAnnouncement(); // close form after successful submission
         // openViewAnnouncement();    // show announcements
        })
        .catch(error => {
          console.error('Error sending message:', error);
          closeCreateAnnouncement();
        });
      }
    });

    function openForm() {
      document.getElementById('scheduleFormPopup').style.display = 'flex';
    }

    function closeForm() {
      document.getElementById('scheduleFormPopup').style.display = 'none';
    }

    function openCreateAnnouncement() {
      const now = new Date();
      document.getElementById('announcementDate').innerText = "Date: " + now.toLocaleDateString();
      document.getElementById('createAnnouncementPopup').style.display = 'flex';
      console.log("Opening Create Announcement Form");
    }

    function closeCreateAnnouncement() {
      document.getElementById('createAnnouncementPopup').style.display = 'none';
      console.log("Closing Create Announcement Form");
    }

    
      function openViewAnnouncement() {
  const announcementList = document.getElementById('announcementList');
  announcementList.innerHTML = '<p>Loading...</p>';

  fetch(`http://localhost/group_project_1.0/public/ClassShcedules/viewclsann/${classId}`)
    .then(response => response.json())
    .then(data => {
      announcementList.innerHTML = ''; // Clear previous content
      data.forEach(schedule => {
        const announcementDiv = document.createElement('div');
        announcementDiv.innerHTML = `
          <p><strong>Date:</strong> ${schedule.date}</p>
          <p><strong>Time:</strong> ${schedule.time}</p>
          <p><strong>Announcement:</strong> ${schedule.description}</p>
          <hr>
        `;
        announcementList.appendChild(announcementDiv);
      });

      // Show the popup only after loading
      document.getElementById('viewAnnouncementPopup').style.display = 'flex';
      console.log("Opening View Announcements");
    })
    .catch(error => {
      console.error('Error fetching announcements:', error);
      announcementList.innerHTML = '<p>Error loading announcements.</p>';
    });
}

    

    function closeViewAnnouncement() {
      document.getElementById('viewAnnouncementPopup').style.display = 'none';
      console.log("Closing View Announcements");
    }
  </script>
  <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/ViewClassschedule/script.js"></script>
</body>
</html>

<?php
  include "C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php";
?>
