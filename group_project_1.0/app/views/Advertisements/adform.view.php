<?php
    // Corrected the condition to check for 'sysadmin' role
    if (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'C:xampp/htdocs/group_project_1.0/app/views/NavBar/User_NavBar/UserNavBar.view.php';
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../../group_project_1.0/public/views/General/Advertisements/adform.css"> <!-- Link to the CSS file -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="form-container">
    <h1 class="title">Submit Advertisement</h1>
    <form id="adForm" class="ad-form">
        <div class="form-group">
            <label for="title">Advertisement Title</label>
            <input type="text" id="title" name="Title" required 
                   placeholder="Enter advertisement title">
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="Content" required 
                      placeholder="Enter advertisement content"></textarea>
        </div>

        <div class="form-group">
            <label for="post_date">Post Date</label>
            <input type="date" id="post_date" name="Post_date" required>
        </div>

        <div class="form-group">
            <label>Advertisement Type</label>
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" id="educational" name="ad_type" value="educational" required>
                    <label for="educational">Educational</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="non_educational" name="ad_type" value="non_educational">
                    <label for="non_educational">Non-Educational</label>
                </div>
            </div>
        </div>

        <div class="form-group" id="subjectGroup" style="display: none;">
            <label for="subject">Subject</label>
            <select id="subject" name="subject">
                <option value="">Select a subject</option>
                <option value="mathematics">Mathematics</option>
                <option value="science">Science</option>
                <option value="literature">Literature</option>
                <option value="history">History</option>
                <option value="computer_science">Computer Science</option>
                <option value="languages">Languages</option>
                <option value="arts">Arts</option>
                <option value="other">Other</option>
            </select>
        </div>

        <button type="submit" class="submit-btn">Submit Advertisement</button>
    </form>
</div>

<script>
document.getElementById('educational').addEventListener('change', function() {
    document.getElementById('subjectGroup').style.display = this.checked ? 'block' : 'none';
    document.getElementById('subject').required = this.checked;
});

document.getElementById('non_educational').addEventListener('change', function() {
    document.getElementById('subjectGroup').style.display = 'none';
    document.getElementById('subject').required = false;
});
</script>
    
</body>
</html>
<?php
 
 if (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'C:xampp/htdocs/group_project_1.0/app/views/Footer/Footer.php';
    }
    ?>