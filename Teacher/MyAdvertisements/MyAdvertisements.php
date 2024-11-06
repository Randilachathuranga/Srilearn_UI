<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blogs</title>
    <link rel="stylesheet" href="./Adsstyles.css">
    <link rel="stylesheet" href="./CreateAds/CreateAds.css">
    <link rel="stylesheet" href="./EditAds/EditAds.css">
</head>
<body>
<div class="header-container">
    <h1 class="header-title">My<br>Advertisements</h1>
    <img src="./add.png" alt="Class Image" class="class-image">
</div>

    <button class="create-blog-button" onclick="createAdds()">Create a Advertisement</button>
    <!-- <button class="refresh-button">Refresh</button> -->

<div class="container" id="class-container">
    <!-- Blog cards will be appended here by JavaScript -->
</div>

<!-- Popup Form for Creating a Blog -->
<div id="popupForm" class="popup-form" style="display: none;">
    <div class="form-container">
        <h2>Create a Advertisement</h2>
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required>
        
        <label for="image" class="custom-file-upload">Choose Image</label>
        <input type="file" id="image" name="image" required>

        <br><br>
        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>
        
        <button onclick="submitAds()" class="submit-button">Submit</button>
        <button onclick="closePopup()" class="close-button">Close</button>
    </div>
</div>

<!-- Popup Form for Editing a Blog -->
<div id="popupEditForm" class="popup-form" style="display: none;">
  <div class="form-container">
    <form id="blogForm">
      <label for="title">Title</label>
      <input type="text" id="title" name="title" >
      
      <label for="image" class="custom-file-upload">Choose Image</label>
        <input type="file" id="image" name="image" required>

        <br><br>
      <label for="description">Description</label>
      <textarea id="description" name="description" ></textarea>

      <button type="button" class="submit-button" onclick="UpdateAdds()">Update</button>
      <button type="button" class="delete-button" onclick="deleteAdds()">Delete</button>
      <button class="close-button" onclick="closeeditPopup()">Close</button>

    </form>
  </div>
</div>

<script src="./Adsscripts.js"></script>
<script src="./CreateAds/CreateAds.js"></script>
<script src="./EditAds/EditAds.js"></script>
</body>
</html>
