<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="./NavBar.css">
</head>
<body>
<div class="navbar">
    <img src="logo.png" alt="Logo" class="logo">
    <div class="nav-links">
        <a href="#">Home</a>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" onclick="toggleDropdown()">Search Hub</a>
            <div class="dropdown-content" id="dropdown-menu">
                <a href="search_teachers.php">By Teachers</a>
                <a href="search_institutes.php">By Institutes</a>
            </div>
        </div>
        <a href="#">Advertisements</a>
        <a href="#">Blogs</a>
        <a href="#">Contact Us</a>
    </div>
    <div class="auth-buttons">
        <a href="#" class="signup-btn" onclick="singup()">Sign Up</a>
        <a href="#" class="login-btn" onclick="Login()">Login</a>
    </div>
    <div class="menu-icon" onclick="toggleMenu()">&#9776;</div> <!-- Hamburger icon -->
</div>

<!-- Menu Icon -->

<!-- Right-side Sidebar Overlay -->
<div class="nav-overlay" id="navOverlay">
    <!-- Close Button -->

    <div class="arrow-key">
    <button class="close-btn" onclick="toggleMenu()">←</button>
    </div>
    <!-- Nav Links and Auth Buttons -->
    <div class="nav-links">
        <a href="#">Home</a>
        <a href="#">By Teacher</a>
        <a href="#">By Institute</a>
        <a href="#">Advertisements</a>
        <a href="#">Blogs</a>
        <a href="#">Contact Us</a>
    </div>
    <div class="auth-buttons">
        <a href="#" class="signup-btn"  onclick="singup()">Sign Up</a>
        <a href="#" class="login-btn" onclick="Login()">Login</a>
    </div>
</div>



<script src="./NavBar.js"></script>
</body>
</html>
