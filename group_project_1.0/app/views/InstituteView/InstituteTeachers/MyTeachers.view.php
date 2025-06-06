
<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php';
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/InstituteView/InstituteTeachers/MyTeachers.view.css">
  <title>My Teachers</title>
</head>
<body>
  <div class="container">
    <!-- Header -->
    <div class="header-container">
      <h1 class="header-title">Our Teachers</h1>
    </div>

    <!-- Banner -->
    <div class="banner-container">
      <img src="../../../../../group_project_1.0/public/views/InstituteView/InstituteTeachers/img.jpg" alt="Teachers Banner">
    </div>

    <!-- Teachers List -->
    <div id="user-data" data-user-id="<?php echo htmlspecialchars($_SESSION['User_id']); ?>"></div>
    <div id="class-container" class="teachers-container"></div>
  </div>

  <script src="../../../../../group_project_1.0/public/views/InstituteView/InstituteTeachers/MyTeachers.view.js"></script>
</body>
</html>


<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
        ?>