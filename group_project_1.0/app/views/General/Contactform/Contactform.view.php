<?php
    // Corrected the condition to check for 'sysadmin' role
    
    if($_SESSION['User_id']=='Guest'){
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/Guest_NavBar/NavBar.view.php';

    }
    elseif (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php';
    }

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Form</title>
  <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Contactform//contact.css">
</head>
<body>

  <div class="contact-wrapper">
  <div class="form-section">
    <h2>Get in touch with us</h2>
    <div class="user-info">
      <img src="../../../../../group_project_1.0/public//views/General/Contactform/contactform 1.png" alt="Profile Image" class="avatar">
      <p>Hi, I'm Amanda. Need help? Use the form below or email me at <a href="mailto:hello@california_golfclub.org">hello@california_golfclub.org</a>.</p>
    </div>
    
    <form id="contactForm">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" placeholder="Name" required>
      
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Email" required>
      
      <label for="message">Message</label>
      <textarea id="message" name="message" placeholder="Message" required></textarea>
      
      <button type="submit">Submit</button>
    </form>
  </div>
  
  <div class="image-section">
    <img src="../../../../../group_project_1.0/public//views/General/Contactform/contactform 1.png" alt="Contact Illustration">
  </div>
</div>


  <script src="../../../../../group_project_1.0/public//views/General/Contactform/Contact.js"></script>

</body>
</html>

<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
        ?>

