<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Materials</title>
    <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/TeacherView/Options/UploadMat/Styles.css">
</head>
<body>
    <?php include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php" ?>
    
    <h1>Class Materials</h1>
    
    <?php if ($_SESSION['Role'] == 'teacher') { ?>
        <div id="uploadMat" onclick="showUploadForm()">Upload Material</div>
    <?php } ?>

    <?php if ($_SESSION['Role'] == 'student') { ?>
        <div id="request" onclick="request()">Request Old Material</div>
    <?php } ?>
    
    <div id="overlay" onclick="hideOverlay()"></div>
    <input type="hidden" id="user_role" value="<?php echo $_SESSION['Role']; ?>">
    
    <!-- Upload Form -->
    <form id="uploadForm" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="Class_id" value="123">
        <label for="topic">Topic:</label>
        <input type="text" id="topic" name="topic" required>
        
        <label for="sub_topic">Sub-topic:</label>
        <input type="text" id="sub_topic" name="sub_topic" required>
        
        <label for="Description">Description:</label>
        <textarea id="Description" name="Description" required></textarea>
        
        <label for="pdf">Upload PDF:</label>
        <input type="file" id="pdf" name="pdf" accept=".pdf" required>
        
        <button type="submit">Upload</button>
        <button type="button" onclick="hideUploadForm()">Cancel</button>
    </form>
    
    <!-- Update Form -->
    <form id="updateForm" enctype="multipart/form-data" method="POST">
        <input type="hidden" id="update_mat_id" name="Mat_id">
        <label for="update_topic">Topic:</label>
        <input type="text" id="update_topic" name="topic" required>
        
        <label for="update_sub_topic">Sub-topic:</label>
        <input type="text" id="update_sub_topic" name="sub_topic" required>
        
        <label for="update_Description">Description:</label>
        <textarea id="update_Description" name="Description" required></textarea>
        
        <label for="update_pdf">Upload New PDF (optional):</label>
        <input type="file" id="update_pdf" name="pdf" accept=".pdf">
        
        <button type="submit">Update</button>
        <button type="button" onclick="hideUpdateForm()">Cancel</button>
    </form>
    
    <div id="materialsList">
        <!-- Materials will be loaded here -->
    </div>
    
    <?php include "C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php" ?>
    <script>
    const Role = "<?php echo $_SESSION['Role']; ?>";
    const User_id = "<?php echo $_SESSION['User_id']; ?>";
  </script>

     <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/UploadMat/script.js"></script>
</body>
</html>