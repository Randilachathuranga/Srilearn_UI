<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Class Cards</title>
    <link rel="stylesheet" href="./Classstyles.css"> <!-- Link your CSS file -->
</head>
<body>
<div class="header-container">
    <h1 class="header-title">Our Class <br>Details</h1>
    <img src="./class1.png" alt="Class Image" class="class-image">
</div>

<div class="search-container">
  <label for="city-dropdown" class="dropdown-label">Search City</label>
  <div class="dropdown-button-wrapper">
    <select id="city-dropdown" class="dropdown" required>
      <option value="" disabled selected hidden>City</option>
      <option value="new-york">New York</option>
      <option value="los-angeles">Los Angeles</option>
      <option value="chicago">Chicago</option>
      <option value="houston">Houston</option>
      <option value="phoenix">Phoenix</option>
    </select>
    <button type="button" class="search-button" onclick="serach()">Search</button>
  </div>
</div>

    <div class="container" id="class-container">
        <!-- Cards will be appended here -->
    </div>
    <script src="./Classscript.js"></script> <!-- Link your JavaScript file -->
</body>
</html>
