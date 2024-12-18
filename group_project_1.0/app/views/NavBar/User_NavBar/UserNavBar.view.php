<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/UserNav.css">
</head>
<body>

    
<div class="navbar">
    <img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/logo.png" alt="Logo" class="logo">
    <div class="nav-links">
    <a href="http://localhost/group_project_1.0/public/<?php echo htmlspecialchars($_SESSION['Role']); ?>">Home</a>

        <div class="dropdown">
            <a href="#" class="dropdown-toggle" onclick="toggleDropdown()">Search Hub</a>
            <div class="dropdown-content" id="dropdown-menu">
                <a href="http://localhost/group_project_1.0/public/GeneralController/loadteacher">By Teachers</a>
                <a href="http://localhost/group_project_1.0/public/GeneralController/loadinstitute">By Institutes</a>
                <a href="http://localhost/group_project_1.0/public/Student/classes">Classes</a>
            </div>
        </div>
        <a href="http://localhost/group_project_1.0/public/Advertisements">Advertisements</a>
        <a href="http://localhost/group_project_1.0/public/Blog">Blogs</a>
        <a href="http://localhost/group_project_1.0/public/ContactUS">Contact Us</a>
    </div>
    

    <div class="profile-buttons">
    <!-- Bell Icon with Notification Badge -->
    <a href="http://localhost/group_project_1.0/public/Announcement/viewann" class="notification-bell">
        <img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/bell.png" alt="Bell Icon">
        <span class="notification-badge" id="notificationBadge"></span>
    </a>
    &nbsp;&nbsp;&nbsp;
    <!-- Profile Icon -->
    <a href="#" class="Profile" onclick="toggleProfile()">
        <img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/user.png" alt="User Profile">
    </a>
</div>

    <div class="menu-icon" onclick="toggleMenu()">&#9776;</div> 
    
</div>

<!-- profile bar -->
<div class="profile-overlay" id="profileOverlay">
    <div class="arrow-key">
    <button class="close-btn" onclick="toggleProfile()">←</button>
    </div>
    <div class="profile-links">
        <a href="http://localhost/group_project_1.0/public/Profile"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/user.png">View profile</a>
        <?php if ($_SESSION['Role'] == "teacher") { ?>
            <a href="http://localhost/group_project_1.0/public/Ind_Myclass"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/school.png">My Classes</a>
        <?php }
        elseif($_SESSION['Role']=='student'){?>
            <a href="http://localhost/group_project_1.0/public/Enrollment"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/school.png">My Classes</a>
        <?php
            
        } ?> 
        
        <a href="http://localhost/group_project_1.0/public/My_Institute"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/school.png">My Institutes</a>
        <a href="http://localhost/group_project_1.0/public/Advertisements"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/ads.png">My Advertisements</a>
        <a href="http://localhost/group_project_1.0/public/Blog/myblogs"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/blogs.png">My Blogs</a>

        <?php if ($_SESSION['Role'] == "institute") { ?>
            <a href="http://localhost/group_project_1.0/public/Institute_teacher"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/subscription.png">My Teachers</a>
        <?php } ?>   
        <a href="http://localhost/group_project_1.0/public/Subscriptions/Subscriptions"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/subscription.png">Subscriptions</a>

    </div>
    <br>    <br>    <br><br>
        <br><br>
    <div class="auth-buttons">
        <a href="http://localhost/group_project_1.0/public/Signout" ><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/logout.png">Log out</a>
    </div>
</div>

<div class="profile-background" id="profileBackground" onclick="toggleProfile()"></div>


<!-- Right-side Sidebar Overlay -->
<div class="nav-overlay" id="navOverlay">
    <div class="arrow-key">
    <button class="close-btn" onclick="toggleMenu()">←</button>
    </div>
    <div class="nav-links">
        <a href="http://localhost/group_project_1.0/public/<?php echo htmlspecialchars($_SESSION['Role']); ?>"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/Home.png">Home</a>
        <a href="http://localhost/group_project_1.0/public/GeneralController/loadteacher"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/teacher.png">By Teacher</a>
        <a href="http://localhost/group_project_1.0/public/GeneralController/loadinstitute"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/school.png">By Institute</a>
        <a href="http://localhost/group_project_1.0/public/Student/classes"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/school.png">classes</a>
        <a href="http://localhost/group_project_1.0/public/Advertisements"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar /icon/ads.png">Advertisements</a>
        <a href="http://localhost/group_project_1.0/public/Blog"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/blogs.png">Blogs</a>
        <a href="http://localhost/group_project_1.0/public/ContactUS"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/contact-mail.png">Contact Us</a>
        <br><br><br>
        <a href="http://localhost/group_project_1.0/public/Profile"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/user.png">View profile</a>
        <a href="http://localhost/group_project_1.0/public/My_Institute"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/school.png">My Institutes</a>
        <a href="http://localhost/group_project_1.0/public/Advertisements"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/ads.png">My Advertisements</a>
        <a href="http://localhost/group_project_1.0/public/Blog/myblogs"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/blogs.png">My Blogs</a>
        <a href="http://localhost/group_project_1.0/public/Institute_teacher"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/subscription.png">My Teachers</a>
        <a href="http://localhost/group_project_1.0/public/Subscriptions/Subscriptions"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/subscription.png">Subscriptions</a>
    </div>
    <div class="auth-buttons">
        <a href="http://localhost/group_project_1.0/public/Signout" onclick="Logout()"><img src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/icon/logout.png">Log out</a>
    </div>
</div>

<div class="nav-background" id="navBackground" onclick="toggleMenu()"></div>


<script src="../../../../../group_project_1.0/public/views/NavBar/User_NavBar/UserNav.js"></script>
</body>
</html>

