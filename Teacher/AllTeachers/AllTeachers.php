<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Cards</title>
    <link rel="stylesheet" href="./AllteachStyles.css"> <!-- Link your CSS file -->
</head>
<body>
<div class="header-container">
    <h1 class="header-title">Teachers<br>Details</h1>
    <img src="./Teacher 1.png" alt="Class Image" class="class-image">
</div>

<div class="search-container">
  <label for="city-dropdown" class="dropdown-label">Subject Stream</label>
  <div class="dropdown-button-wrapper">
    <select id="city-dropdown" class="dropdown" required>
      <option value="" disabled selected hidden>Subject</option>
      <option value="new-york">English</option>
      <option value="los-angeles">Science</option>
      <option value="chicago">Maths</option>
      <option value="houston">History</option>
      <option value="phoenix">Chemestry</option>
      <option value="chicago">Physics</option>
      <option value="houston">It</option>
      <option value="phoenix">Sinhala</option>
    </select>
    <button type="button" class="search-button" onclick="search()">Search</button>
  </div>
</div>



    <div class="container" id="class-container">
        <!-- Cards will be appended here -->
    </div>
    <script src="./Allteachcript.js"></script> <!-- Link your JavaScript file -->
</body>
</html>
