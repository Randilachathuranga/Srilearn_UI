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
                <option value="District1">District1</option>
                <option value="District2">District2</option>
                <option value="District3">District3</option>
                <option value="District4">District4</option>
                <option value="District5">District5</option>
                <option value="District6">District6</option>
                <option value="District7">District7</option>
                <option value="District8">District8</option>
                <option value="District9">District9</option>
                <option value="District10">District10</option>
                <option value="District11">District11</option>
                <option value="District12">District12</option>
                <option value="District13">District13</option>
                <option value="District14">District14</option>
                <option value="District15">District15</option>
                <option value="District16">District16</option>
                <option value="District17">District17</option>
                <option value="District18">District18</option>
                <option value="District19">District19</option>
                <option value="District20">District20</option>
                <option value="District21">District21</option>
                <option value="District22">District22</option>
                <option value="District23">District23</option>
                <option value="District24">District24</option>
                <option value="District25">District25</option>
            </select>
        </div>

        <div class="form-group">
            <label for="role" class="form-label">Role:</label>
            <select id="role" name="Role" placeholder =<?php echo $user->Role?>class="form-select" required>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                <option value="institute">Institute</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="submit-btn">Update</button>
        </div>
    </form>
</div>

</body>
</html>
