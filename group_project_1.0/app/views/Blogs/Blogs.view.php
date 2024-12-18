
<?php
    // Corrected the condition to check for 'sysadmin' role
    
    if($_SESSION['User_id']=='Guest'){
        require 'C:xampp/htdocs/group_project_1.0/app/views/NavBar/Guest_NavBar/NavBar.view.php';

    }
    elseif (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'C:xampp/htdocs/group_project_1.0/app/views/NavBar/User_NavBar/UserNavBar.view.php';
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blogs</title>
    <link rel="stylesheet" href="../../../../group_project_1.0/public/views/Blogs/Blogstyles.css">
    <link rel="stylesheet" href="../../../../group_project_1.0/public/views/Blogs/CreateBlogs/CreateBlogs.css">

</head>
<body>
<?php $today = date("Y-m-d"); ?>
<div class="header-container">
    <h1 class="header-title">Blogs</h1>
    
    <img src="../../../../group_project_1.0/public/views/blogs/blogs1.png" alt="Class Image" class="class-image">
</div>

    <!-- Button Container -->
<div class="button-container">
    <?php if((isset($_SESSION['User_id']) && !($_SESSION['Role']=='sysadmin')) && !($_SESSION['User_id']=='Guest')) echo '<button class="create-blog-button" onclick="createBlog(event)">Create a Blog</button>';?>
    <?php if((isset($_SESSION['User_id']) && !($_SESSION['Role']=='sysadmin')) && !($_SESSION['User_id']=='Guest')) echo '<button class="my-blogs-button" onclick="gotomyBlog()">My Blogs</button>';?>
</div>


<div class="container" id="class-container">
    <!-- Blog cards will be appended here by JavaScript -->
</div>

<!-- Popup Form for Creating a Blog -->
<div id="popupForm" class="popup-form" style="display: none;">
    <div class="form-container">
        <h2>Create a Blog</h2>
        <form action="#" method="POST" onsubmit="submitBlog(event)">
        <label for="Title">Title</label>
        <input type="text" id="Title" name="Title" required>
        
        <label for="Content">Description</label>
        <textarea id="Content" name="Content" required></textarea>
        
        <label for="Post-date">Post Date:</label>
        <input type="date" id="Post_date" name="Post_date" value="<?php echo $today; ?>" readonly>
        
        <button  class="submit-button">Submit</button>
        </form>
        <button onclick="closePopup()" class="close-button">Close</button>
    </div>
</div>
<script>
    // Pass session data to JavaScript
    const sessionData = <?php echo json_encode([
        'User_id' => $_SESSION['User_id'] ?? null,
        'Role' => $_SESSION['Role'] ?? null
    ]); ?>;
</script>


<script src="../../../../group_project_1.0/public/views/Blogs/Blogscript.js"></script>
<script src="../../../../group_project_1.0/public/views/Blogs/CreateBlogs/CreateBlogs.js"></script>
</body>
</html>

<?php
 
 if (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'C:xampp/htdocs/group_project_1.0/app/views/Footer/Footer.php';
    }
    ?>