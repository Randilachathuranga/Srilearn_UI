<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="../../../group_project_1.0/app/views/UserNav.css">
</head>
<body>
<div class="navbar">
    <img src="../../../group_project_1.0/app/views/logo.png" alt="Logo" class="logo">
    <div class="nav-links">
        <a href="#">Home</a>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" onclick="toggleDropdown()">Search Hub</a>
            <div class="dropdown-content" id="dropdown-menu">
                <a href="#">By Teachers</a>
                <a href="#">By Institutes</a>
                <a href="#">Classes</a>
            </div>
        </div>
        <a href="#">Advertisements</a>
        <a href="#">Blogs</a>
        <a href="#">Contact Us</a>
    </div>
    <div class="profile-buttons">
        <a href="#" class="Profile" onclick="toggleProfile()"><img src="../../../group_project_1.0/app/views/icon/user.png"></a>
    </div>
    <div class="menu-icon" onclick="toggleMenu()"><img src="../../../group_project_1.0/app/views/icon/user.png"></div> 
    <div class="notification-icon" onclick="handleann()"><img src="../../../group_project_1.0/app/views/notification.png"></div> 
    
</div>

<!-- profile bar -->
<div class="profile-overlay" id="profileOverlay">
    <div class="arrow-key">
    <button class="close-btn" onclick="toggleProfile()">←</button>
    </div>
    <div class="profile-links">
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/user.png">View profile</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/school.png">My Classes</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/school.png">My Institutes</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/ads.png">My Advertisements</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/blogs.png">My Blogs</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/subscription.png">Subscriptions</a>
        <a href="http://localhost/group_project_1.0/public/Announcement/viewann"><img src="../../../group_project_1.0/app/views/notification.png">Announcemnets</a>

    </div>
    <div class="auth-buttons">
        <a href="#" onclick="Logout()"><img src="../../../group_project_1.0/app/views/icon/logout.png">Log out</a>
    </div>
</div>

<div class="profile-background" id="profileBackground" onclick="toggleProfile()"></div>


<!-- Right-side Sidebar Overlay -->
<div class="nav-overlay" id="navOverlay">
    <div class="arrow-key">
    <button class="close-btn" onclick="toggleMenu()">←</button>
    </div>
    <div class="nav-links">
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/Home.png">Home</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/teacher.png">By Teacher</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/school.png">By Institute</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/school.png">classes</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/ads.png">Advertisements</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/blogs.png">Blogs</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/contact-mail.png">Contact Us</a>
        <br><br><br>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/user.png">View profile</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/school.png">My Classes</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/school.png">My Institutes</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/ads.png">My Advertisements</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/blogs.png">My Blogs</a>
        <a href="#"><img src="../../../group_project_1.0/app/views/icon/subscription.png">Subscriptions</a>

    </div>
    <div class="auth-buttons">
        <a href="#" onclick="Logout()"><img src="../../../group_project_1.0/app/views/icon/logout.png">Log out</a>
    </div>
</div>

<div class="nav-background" id="navBackground" onclick="toggleMenu()"></div>


<script src="../../../group_project_1.0/app/views/UserNav.js"></script>
</body>
</html>
