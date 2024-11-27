<?php 
 include "C:xampp/htdocs/group_project_1.0/app/views/NavBar/User_NavBar/UserNavBar.view.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../../../group_project_1.0/app/views/MyTeachers.view.css">
  <title>My Teachers </title>
</head>
<body>

<div id="user-data" data-user-id="<?php echo htmlspecialchars($_SESSION['User_id']); ?>"></div>


  <!-- Container for displaying teacher classes -->
  <div id="class-container"></div>

  <script src="../../../../../group_project_1.0/app/views/MyTeachers.view.js"></script>
</body>
</html>
