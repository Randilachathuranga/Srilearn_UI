<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../../../../group_project_1.0/public/views/General/Signin_Signup/signup.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>SIGN UP</h1>
        <br>
        <form action="#" method="POST"> <!-- Action should point to your server-side script -->

            <!-- Display error messages -->
            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?= implode("<br>", $errors) ?>
                </div>
            <?php endif; ?>  

            <!-- Form Fields -->
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
                <label for="password">Re-Type Password:</label>
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
                <div class="input-wrapper">
                    <label for="role">Role:</label>
                    <select id="role" name="Role" required>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="institute">Institute</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <button type="submit">Sign Up</button>
                <p>Already have an account? <a href="signin">Sign In</a></p>
            </div>
        </form>
    </div>
</body>
</html>
