<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
  <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Signin_Signup/signup.css">
</head>
<body>

<?php
// PHP arrays for districts and subjects
$districts = [
  "Ampara", "Anuradhapura", "Badulla", "Batticaloa", "Colombo",
  "Galle", "Gampaha", "Hambantota", "Jaffna", "Kalutara",
  "Kandy", "Kegalle", "Kilinochchi", "Kurunegala", "Mannar",
  "Matale", "Matara", "Monaragala", "Mullaitivu", "Nuwara Eliya",
  "Polonnaruwa", "Puttalam", "Ratnapura", "Trincomalee", "Vavuniya"
];

$subjects = [
  "Accounting", "Agriculture", "Art", "Bio Systems Technology", "Biology",
  "Buddhism", "Business Studies", "Catholicism", "Civic Education", "Commerce",
  "Drama and Theatre", "English", "Engineering Technology", "Geography", "Health & Physical Education",
  "History", "ICT", "Mathematics", "Physics", "Science",
  "Sinhala", "Tamil"
];
?>

<div class="container">
  <h1>SIGN UP</h1>
  <br>
  <form action="#" method="POST">

    <?php if (!empty($errors)): ?>
      <div class="error-messages">
        <?= implode("<br>", $errors) ?>
      </div>
    <?php endif; ?>  

    <!-- Personal Info -->
    <div class="form-group double-field">
      <div class="input-wrapper">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="F_name" required>
      </div>
      <div class="input-wrapper">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="L_name" required>
      </div>
    </div>

    <div class="form-group double-field">
      <div class="input-wrapper">
        <label for="email">Email:</label>
        <input type="email" id="email" name="Email" required>
      </div>
      <div class="input-wrapper">
        <label for="phone_number">Phone Number:</label>
        <input type="tel" id="phone_number" name="Phone_number" required>
      </div>
    </div>

    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="Password" required>
    </div>

    <div class="form-group">
      <label for="Re-password">Re-Type Password:</label>
      <input type="password" id="Re-password" name="Re-password" required>
    </div>

    <div class="form-group">
      <label for="address">Address:</label>
      <input type="text" id="address" name="Address" required>
    </div>

    <div class="form-group double-field">
      <div class="input-wrapper">
        <label for="district">District:</label>
        <select id="district" name="District" required>
          <?php foreach ($districts as $district): ?>
            <option value="<?= htmlspecialchars($district) ?>"><?= htmlspecialchars($district) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="input-wrapper">
        <label for="role">Role:</label>
        <select id="role" name="Role" required>
          <option value="student">Student</option>
          <option value="teacher">Teacher</option>
          <option value="institute">Institute</option>
        </select>
      </div>
    </div>

    <!-- Link input (only for teacher) -->
    <div class="form-group" id="link-group" style="display: none;">
      <label for="link">Provide a Valid Link with Required Documents:</label>
      <input type="text" id="link" name="Link">
    </div>

    <!-- Subjects (only for teacher) -->
    <div class="form-group" id="subject-group" style="display: none;">
      <label>Select Subject(s):</label>
      <div>
        <?php foreach ($subjects as $subject): ?>
          <label>
            <input type="checkbox" name="Subject[]" value="<?= htmlspecialchars($subject) ?>"> <?= htmlspecialchars($subject) ?>
          </label><br>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Submit -->
    <div class="form-group">
      <button type="submit" id="btn-sb">Sign Up</button>
      <p>Already have an account? <a href="signin">Sign In</a></p>
    </div>
  </form>
</div>

<script>
  const roleSelect = document.getElementById('role');
  const linkGroup = document.getElementById('link-group');
  const subjectGroup = document.getElementById('subject-group');
  const submitButton = document.getElementById('btn-sb');

  function toggleTeacherFields() {
    const role = roleSelect.value;
    const isTeacher = role === 'teacher';
    
    linkGroup.style.display = isTeacher ? 'block' : 'none';
    subjectGroup.style.display = isTeacher ? 'block' : 'none';
    submitButton.textContent = isTeacher ? 'Request Signup' : 'Sign Up';
  }

  roleSelect.addEventListener('change', toggleTeacherFields);
  window.addEventListener('load', toggleTeacherFields);
</script>

</body>
</html>
