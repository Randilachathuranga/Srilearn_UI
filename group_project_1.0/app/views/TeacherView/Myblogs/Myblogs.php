<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blogs</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="./CreateBlogs/CreateBlogs.css">
    <link rel="stylesheet" href="./EditBlogs/EditBlogs.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">My<br>Blogs</h1>
    <img src="./blogs1.png" alt="Class Image" class="class-image">
</div>

    <button class="create-blog-button" onclick="createBlog()">Create a Blog</button>
    <!-- <button class="refresh-button">Refresh</button> -->

    <div class="container" id="class-container">
    <!-- Blog cards will be appended here by JavaScript -->
    </div>

<!-- Popup Form for Creating a Blog -->
<div id="popupForm" class="popup-form" style="display: none;">
    <div class="form-container">
        <h2>Create a Blog</h2>
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required>
        
        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>
        
        <button onclick="submitBlog()" class="submit-button">Submit</button>
        <button onclick="closePopup()" class="close-button">Close</button>
    </div>
</div>

<!-- Popup Form for Editing a Blog -->
<div id="popupEditForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">
      <label for="title">Title</label>
      <input type="text" id="title" name="title" >
      
      <label for="description">Description</label>
      <textarea id="description" name="description" ></textarea>

      <button type="button" class="submit-button" onclick="UpdateBlogs()">Update</button>
      <button type="button" class="delete-button" onclick="deleteBlogs()">Delete</button>
      <button class="close-button" onclick="closeeditPopup()">Close</button>

    </form>
  </div>
</div>


<script src="script.js"></script>
<script src="./CreateBlogs/CreateBlogs.js"></script>
<script src="./EditBlogs//EditBlogs.js"></script>
</body>
</html>
