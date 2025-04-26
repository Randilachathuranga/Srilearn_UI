<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Form</title>
    <link rel="stylesheet" href="../../../../group_project_1.0/public/views/AdminView/Sysadmin/userupdate.css"> <!-- Link to your CSS file -->
</head>
<body>
<div class="container">
    <h1 class="form-title">Update Info</h1>

    <form action="#" method="POST" class="update-form">

        <div class="form-group">
            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" id="first_name" name="F_name" placeholder =<?php echo $user->F_name?> class="form-input" required>
        </div>

        <div class="form-group">
            <label for="last_name" class="form-label">Last Name:</label>
            <input type="text" id="last_name" name="L_name" placeholder =<?php echo $user->L_name?> class="form-input" required>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="Email" placeholder =<?php echo $user->Email?> class="form-input" required>
        </div>

        <div class="form-group">
            <label for="phone_number" class="form-label">Phone Number:</label>
            <input type="tel" id="phone_number" name="Phone_number" placeholder =<?php echo $user->Phone_number?> class="form-input" required>
        </div>

        <div class="form-group">
            <label for="address" class="form-label">Address:</label>
            <input type="text" id="address" name="Address"placeholder =<?php echo $user->Address?> class="form-input" required>
        </div>

        <div class="form-group">
            <label for="district" class="form-label">District:</label>
            <select id="district" name="District" class="form-select" placeholder =<?php echo $user->District ?>required>
            <option value="Colombo">Colombo</option>
<option value="Gampaha">Gampaha</option>
<option value="Kalutara">Kalutara</option>
<option value="Kandy">Kandy</option>
<option value="Matale">Matale</option>
<option value="Nuwara Eliya">Nuwara Eliya</option>
<option value="Galle">Galle</option>
<option value="Hambantota">Hambantota</option>
<option value="Matara">Matara</option>
<option value="Jaffna">Jaffna</option>
<option value="Kilinochchi">Kilinochchi</option>
<option value="Mannar">Mannar</option>
<option value="Vavuniya">Vavuniya</option>
<option value="Mullaitivu">Mullaitivu</option>
<option value="Batticaloa">Batticaloa</option>
<option value="Ampara">Ampara</option>
<option value="Trincomalee">Trincomalee</option>
<option value="Anuradhapura">Anuradhapura</option>
<option value="Polonnaruwa">Polonnaruwa</option>
<option value="Kurunegala">Kurunegala</option>
<option value="Puttalam">Puttalam</option>
<option value="Rathnapura">Rathnapura</option>
<option value="Kegalle">Kegalle</option>
<option value="Badulla">Badulla</option>
<option value="Moneragala">Moneragala</option>
<option value="Mullaitivu">Mullaitivu</option>

            </select>
        </div>

        <div class="form-group">
    <label for="role" class="form-label">Role:</label>
    <select id="role" name="Role" class="form-select" disabled>
        <option value="student" <?php echo ($user->Role == 'student') ? 'selected' : ''; ?>>Student</option>
        <option value="teacher" <?php echo ($user->Role == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
        <option value="institute" <?php echo ($user->Role == 'institute') ? 'selected' : ''; ?>>Institute</option>
    </select>
</div>


        <div class="form-group">
            <button type="submit" class="submit-btn">Update</button>
        </div>
    </form>
</div>

</body>
</html>