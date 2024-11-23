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

<!-- Background Overlay for Sidebar -->
<!-- Right-side Sidebar Overlay -->
<div class="nav-overlay" id="navOverlay">
    <div class="arrow-key">
    <button class="close-btn" onclick="toggleMenu()">←</button>
    </div>
    <div class="nav-links">
        <a href="#"><img src="./icon/Home.png">Home</a>
        <a href="#"><img src="./icon/teacher.png">By Teacher</a>
        <a href="#"><img src="./icon/school.png">By Institute</a>
        <a href="#"><img src="./icon/ads.png">Advertisements</a>
        <a href="#"><img src="./icon/blogs.png">Blogs</a>
        <a href="#"><img src="./icon/contact-mail.png">Contact Us</a>
    </div>
    <br>
    <div class="auth-buttons">
        <a href="#" class="signup-btn"  onclick="singup()"><img src="./icon/singup.png">Sign Up</a>
        <a href="#" class="login-btn" onclick="Login()"><img src="./icon/enter.png">Login</a>
    </div>
</div>

<div class="nav-background" id="navBackground" onclick="toggleMenu()"></div>


<script src="./NavBar.js"></script>
</body>
</html>
