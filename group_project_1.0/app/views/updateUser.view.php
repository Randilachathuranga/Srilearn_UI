<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Form</title>
</head>
<body>
<div class="container">
    <h1>Update Info</h1>

    <!-- Debugging line to check if $user data is passed correctly -->
    <pre><?php print_r($user); ?></pre>

    <form action="#" method="POST">


        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="F_name"  required>
        </div>

      

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="L_name"  required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="Email"  required>
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="Phone_number"  required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="Address"  required>
        </div>

       

        <div class="form-group">
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

            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="Role" required>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="institute">Institute</option>
                </select>
            </div>
        <div class="form-group">
            <button type="submit" >Update</button>
        </div>
    </form>
</div>

</body>
</html>
