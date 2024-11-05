<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Cards</title>
    <link rel="stylesheet" href="./Mystyles.css"> <!-- Link your CSS file -->
</head>
<body>
<div class="header-container">
    <h1 class="header-title">My Class <br>Details</h1>
    <img src="./class1.png" alt="Class Image" class="class-image">
</div>

<button class="create-blog-button" onclick="createClassShcedule()">Create class schedule</button>
<!-- <button class="refresh-button">Refresh</button> -->

    <div class="container" id="class-container">
        <!-- Cards will be appended here -->
    </div>
    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>
