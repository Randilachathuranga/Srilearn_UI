

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../../../group_project_1.0/app/views/Myprofile.css">
</head>
<body>
<?php 
 include "C:xampp/htdocs/group_project_1.0/app/views/NavBar/User_NavBar/UserNavBar.view.php"

?>

    <div class="container">
        <h1>User Profile</h1>

        <!-- Profile Image -->
        <div class="profile-image">
            <img id="userImage" src="/group_project_1.0/app/views/user.jpg" alt="User Image">
        </div>

        <!-- Form -->
        <form id="profileForm" action="#" method="POST">
            <div class="form-group double-field">
                <div class="input-wrapper">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="F_name" disabled>
                </div>
                <div class="input-wrapper">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="L_name" disabled>
                </div>
            </div>

            <div class="form-group double-field">
                <div class="input-wrapper">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="Email" disabled>
                </div>
                <div class="input-wrapper">
                    <label for="phone_number">Phone Number:</label>
                    <input type="tel" id="phone_number" name="Phone_number" disabled>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="Address" disabled>
            </div>

            <div class="form-group">
                <label for="district">District:</label>
                <select id="district" name="District" disabled>
                <option value="Ampara">Ampara</option>
                <option value="Anuradhapura">Anuradhapura</option>
                <option value="Badulla">Badulla</option>
                <option value="Batticaloa">Batticaloa</option>
                <option value="Colombo">Colombo</option>
                <option value="Galle">Galle</option>
                <option value="Gampaha">Gampaha</option>
                <option value="Hambantota">Hambantota</option>
                <option value="Jaffna">Jaffna</option>
                <option value="Kalutara">Kalutara</option>
                <option value="Kandy">Kandy</option>
                <option value="Kegalle">Kegalle</option>
                <option value="Kilinochchi">Kilinochchi</option>
                <option value="Kurunegala">Kurunegala</option>
                <option value="Mannar">Mannar</option>
                <option value="Matale">Matale</option>
                <option value="Matara">Matara</option>
                <option value="Monaragala">Monaragala</option>
                <option value="Mullaitivu">Mullaitivu</option>
                <option value="Nuwara Eliya">Nuwara Eliya</option>
                <option value="Polonnaruwa">Polonnaruwa</option>
                <option value="Puttalam">Puttalam</option>
                <option value="Ratnapura">Ratnapura</option>
                <option value="Trincomalee">Trincomalee</option>
                <option value="Vavuniya">Vavuniya</option>
            </select>
            </div>

            <!-- Buttons -->
            <div class="form-buttons">
                <button type="button" id="editButton">Edit</button>
                <button type="submit" id="updateButton" disabled>Update</button>
            </div>
        </form>
    </div>

    <script>
   
    const userId = <?php echo json_encode($_SESSION['User_id']); ?>;
    const data = {};

    document.addEventListener('DOMContentLoaded', () => {
        // Fetch data from the API
        fetch(`http://localhost/group_project_1.0/public/Profile/myapi/${userId}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json(); // Parse the JSON response
            })
            .then(records => {
                // Populate the `data` object with the API response
                records.forEach(record => {
                    Object.keys(record).forEach(key => {
                        data[key] = record[key];
                    });
                });

                // Populate form with data after the `data` object is updated
                document.getElementById('first_name').value = data.F_name || '';
                document.getElementById('last_name').value = data.L_name || '';
                document.getElementById('email').value = data.Email || '';
                document.getElementById('phone_number').value = data.Phone_number || '';
                document.getElementById('address').value = data.Address || '';
                document.getElementById('district').value = data.District || '';

                console.log(data); // Verify the data object
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });



        // Enable editing
        document.getElementById('editButton').addEventListener('click', () => {
            const fields = document.querySelectorAll('#profileForm input, #profileForm select');
            fields.forEach(field => field.disabled = false);
            document.getElementById('updateButton').disabled = false;
        });
    </script>
</body>
</html>