<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Announcement</title>
    <link rel="stylesheet" href="/group_project_1.0/public/views/AdminView/Announcements/anupdate.css"> <!-- Link to the CSS file -->
</head>
<body>
    <?php
    $today = date("Y-m-d"); 
    ?>
    
    <div class="form-container">
        <h1 class="form-title">Update the Announcement</h1>

        <form method="POST" action="#" class="announcement-form">
            <div class="form-group">
                <label for="announcement-date" class="form-label">Announcement Date:</label>
                <input type="date" id="announcement-date" name="date" value="<?php echo $today; ?>" readonly class="form-input">
            </div>

            <div class="form-group">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" required class="form-input">
            </div>

            <div class="form-group">
                <label for="announcement" class="form-label">Post Announcement:</label>
                <textarea id="announcement" name="announcement" rows="10" placeholder="Write your announcement here..." required class="form-input"></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit" class="form-button">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
