<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/General/NavBar/Guest_NavBar/NavBar.css">
</head>
<body>
<div class="navbar">
    <img src="../../../../../../group_project_1.0/public/views/General/NavBar/Guest_NavBar/logo.png" alt="Logo" class="logo">
    <div class="nav-links">
    <a href="http://localhost/group_project_1.0/public/<?php echo htmlspecialchars($_SESSION['Role']); ?>">Home</a>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" onclick="toggleDropdown()">Search Hub</a>
            <div class="dropdown-content" id="dropdown-menu">
                <a href="http://localhost/group_project_1.0/public/By_teacher">By Teachers</a>
                <a href="http://localhost/group_project_1.0/public/By_institute">By Institutes</a>
            </div>
        </div>
        <a href="Advertisements">Advertisements</a>
        <a href="Blog">Blogs</a>
        <a href="http://localhost/group_project_1.0/public/ContactUS">Contact Us</a>
    </div>
    <div class="auth-buttons">
        <a href="http://localhost/group_project_1.0/public/Signup" class="signup-btn" onclick="singup()">Sign Up</a>
        <a href="http://localhost/group_project_1.0/public/Signin" class="login-btn" onclick="Login()">Login</a>
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
        <a href="http://localhost/group_project_1.0/public/<?php echo htmlspecialchars($_SESSION['Role']); ?>"><img src="../../../../../../group_project_1.0/public/views/General/NavBar/User_NavBar/icon/Home.png">Home</a>
        <a href="http://localhost/group_project_1.0/public/By_teacher"><img src="../../../../../../group_project_1.0/public/views/General/NavBar/User_NavBar/icon/teacher.png">By Teacher</a>
        <a href="http://localhost/group_project_1.0/public/By_institute"><img src="../../../../../../group_project_1.0/public/views/General/NavBar/User_NavBar/icon/school.png">By Institute</a>
        <a href="Advertisements"><img src="../../../../../../group_project_1.0/public/views/General/NavBar/User_NavBar/icon/ads.png">Advertisements</a>
        <a href="Blog"><img src="../../../../../../group_project_1.0/public/views/General/NavBar/User_NavBar/icon/blogs.png">Blogs</a>
        <a href="http://localhost/group_project_1.0/public/ContactUS"><img src="../../../../../../group_project_1.0/public/views/General/NavBar/User_NavBar/icon/contact-mail.png">Contact Us</a>
    </div>
    <br>
    <div class="auth-buttons">
        <a href="http://localhost/group_project_1.0/public/Signup" class="signup-btn"  ><img src="../../../../../../group_project_1.0/public/views/General/NavBar/User_NavBar/icon/singup.png">Sign Up</a>
        <a href="http://localhost/group_project_1.0/public/Signin" class="login-btn" ><img src="../../../../../../group_project_1.0/public/views/General/NavBar/User_NavBar/icon/singup.png">Login</a>
    </div>
</div>

<div class="nav-background" id="navBackground" onclick="toggleMenu()"></div>


<script src=".../../../../../../group_project_1.0/public/views/General/NavBar/Guest_NavBar/NavBar.js"></script>
</body>
</html>
