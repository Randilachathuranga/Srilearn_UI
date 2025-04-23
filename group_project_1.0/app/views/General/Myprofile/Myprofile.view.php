<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Myprofile/Myprofile.css">
    <link rel="stylesheet" href="./../../../../../group_project_1.0/public/views/General/Popup.css">

</head>
<body>
<?php 
 include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php";
?>

<div class="container">
    <h1>User Profile</h1>

    <!-- Card Layout with Profile Image and Data -->
    <div class="card-container">
        <!-- Left Side - Profile Image -->
        <div class="card-image">
            <img id="userImage" src="" alt="User Image">
            <form id="imageForm" enctype="multipart/form-data">
                <input type="hidden" id="userId" value="<?php echo $_SESSION['User_id']; ?>">
                <label for="image">Upload Image</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </form>
        </div>
        
        <!-- Right Side - User Data -->
        <div class="card-data">
            <!-- Profile Form -->
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
                    <!-- <div class="input-wrapper">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="Email" disabled>
                    </div> -->
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
                        <!-- District Options -->
                        <?php
                        $districts = ["Ampara", "Anuradhapura", "Badulla", "Batticaloa", "Colombo", "Galle", "Gampaha", "Hambantota", "Jaffna", "Kalutara", "Kandy", "Kegalle", "Kilinochchi", "Kurunegala", "Mannar", "Matale", "Matara", "Monaragala", "Mullaitivu", "Nuwara Eliya", "Polonnaruwa", "Puttalam", "Ratnapura", "Trincomalee", "Vavuniya"];
                        foreach ($districts as $district) {
                            echo "<option value='$district'>$district</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="form-buttons">
                    <button type="button" id="editButton">Edit</button>
                    <button type="submit" id="updateButton" disabled>Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="popup-overlay hidden" id="popupOverlay"></div>
<div class="popup hidden" id="popupBox">
    <p class="popup-message" id="popupMessage"></p>
    <div class="popup-buttons">
        <button class="ok-btn" id="popupOkBtn">OK</button>
        <button class="cancel-btn" id="popup_CancelBtn" onclick="Popupclose()">Cancel</button>
    </div>
</div>

<script>
    const userId = <?php echo json_encode($_SESSION['User_id']); ?>;
    const data = {};

    // Fetch user profile data
    document.addEventListener('DOMContentLoaded', () => {
        fetch(`http://localhost/group_project_1.0/public/Profile/myapi/${userId}`)
            .then(response => response.json())
            .then(records => {
                records.forEach(record => {
                    Object.keys(record).forEach(key => {
                        data[key] = record[key];
                    });
                });
                // Populate form with data
                document.getElementById('first_name').value = data.F_name || '';
                document.getElementById('last_name').value = data.L_name || '';
                // document.getElementById('email').value = data.Email || '';
                document.getElementById('phone_number').value = data.Phone_number || '';
                document.getElementById('address').value = data.Address || '';
                document.getElementById('district').value = data.District || '';
            })
            .catch(error => console.error('Error fetching profile data:', error));
    });

    // Enable editing
    document.getElementById('editButton').addEventListener('click', () => {
        const fields = document.querySelectorAll('#profileForm input, #profileForm select');
        fields.forEach(field => field.disabled = false);
        document.getElementById('updateButton').disabled = false;
    });

    // Fetch and display user image
    document.addEventListener('DOMContentLoaded', () => {
        fetch(`http://localhost/group_project_1.0/public//Profile/view_image/${userId}`)
            .then(response => response.json())
            .then(result => {
                if (result.length > 0 && result[0].Src) {
                    console.log(result);
                    document.getElementById('userImage').src = result[0].Src;
                } else {
                    document.getElementById('userImage').src = '../../../../../group_project_1.0/public/views/General/Myprofile/user.jpg';
                }
            })
            .catch(() => {
                document.getElementById('userImage').src = '../../../../../group_project_1.0/public/views/General/Myprofile/user.jpg';
            });
    });

    // Handle image upload
    // Automatically handle image upload on file selection
    document.getElementById('image').addEventListener('change', async (event) => {
        const fileInput = event.target;
        if (fileInput.files.length === 0) return;

        const formData = new FormData();
        formData.append('image', fileInput.files[0]);

        try {
            const response = await fetch(`http://localhost/group_project_1.0/public/Profile/upload_image/${userId}`, {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();
            if (result.success && result.newSrc) {
                document.getElementById('userImage').src = result.newSrc;
                showPopup('Image uploaded successfully!', true);
            } else {
                showPopup('Image upload failed.', true);
            }
        } catch (error) {
            console.error('Image upload error:', error);
            showPopup('An error occurred. Please try again.', false);
        }
    });
</script>
<script src="./../../../../../group_project_1.0/public/views/General/Popup.js"></script>

</body>
</html>

<?php
require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
?>