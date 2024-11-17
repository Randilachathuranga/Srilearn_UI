<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisement</title>
    <link rel="stylesheet" href="./addvertistment.css">
    <link rel="stylesheet" href="./CreateBlogs/CreateBlogs.css">

</head>
<body>
<div class="header-container">
    <h1 class="header-title">Advertisement</h1>
    <img src="./blogs1.png" alt="Class Image" class="class-image">
</div>

    <button class="create-blog-button" onclick="createAdd()">Create a Add</button>
    <button class="create-blog-button" onclick="">Add for your class</button>
    <!-- <button class="refresh-button">Refresh</button> -->

<div class="container" id="class-container">
    <!-- Blog cards will be appended here by JavaScript -->
</div>

<!-- Popup Form for Creating a Blog -->
<div id="popupForm" class="popup-form" style="display: none;">
    <div class="form-container">
        <h2>Create a Add</h2>
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required>
        
        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>
        
        <button onclick="submitBlog()" class="submit-button">Submit</button>
        <button onclick="closePopup()" class="close-button">Close</button>
    </div>
</div>


<script src="./Blogscript.js"></script>
<script src="./CreateAdd/CreateAdd.js"></script>
</body>
</html>
