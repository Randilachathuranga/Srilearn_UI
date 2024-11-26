<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/SriLearn_UI/group_project_1.0/app/views/UserView/UserUpdate.css">
</head>
<body>
    <h1>Edit Profile</h1>

    <!-- Error and Success Messages -->
    <div id="errorBox" style="display: none; color: red;"></div>
    <div id="successBox" style="display: none; color: green;"></div>

    <!-- Form for Editing Profile -->
    <form id="editProfileForm" method="POST" action="/SriLearn_UI/group_project_1.0/User/updateprofile">
        <label>First Name:</label>
        <input type="text" name="F_name" value="<?= htmlspecialchars($userData['F_name'] ?? '') ?>" required><br>

        <label>Last Name:</label>
        <input type="text" name="L_name" value="<?= htmlspecialchars($userData['L_name'] ?? '') ?>"><br>

        <label>Email:</label>
        <input type="email" name="Email" value="<?= htmlspecialchars($userData['Email'] ?? '') ?>" required><br>

        <label>District:</label>
        <input type="text" name="District" value="<?= htmlspecialchars($userData['District'] ?? '') ?>" required><br>

        <label>Phone Number:</label>
        <input type="text" name="Phone_number" value="<?= htmlspecialchars($userData['Phone_number'] ?? '') ?>" required><br>

        <label>Address:</label>
        <input type="text" name="Address" value="<?= htmlspecialchars($userData['Address'] ?? '') ?>" required><br>

        <label>Password:</label>
        <input type="password" name="Password" placeholder="Enter new password (optional)"><br>

        <button type="submit">Update Profile</button>
    </form>

    <!-- Link to JavaScript File -->
    <script src="/SriLearn_UI/group_project_1.0/app/views/UserView/EditProfile.js"></script>
</body>
</html>
