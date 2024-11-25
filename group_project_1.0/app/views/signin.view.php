<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="../../../group_project_1.0/app/views/signin.css"> <!-- Link to the CSS file -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h1>SIGN IN</h1>
            <form action="#" method="POST">
                <?php if (!empty($data['errors'])): ?>
                    <div class="error-messages">
                        <?php 
                            foreach ($data['errors'] as $error) {
                                echo "<p>$error</p>";
                            }
                        ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="User_id">Email:</label>
                    <input type="text" id="Email" name="Email" placeholder="Enter your Email" required>
                </div>
                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="password" id="Password" name="Password" placeholder="Enter your Password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Sign In</button>
                    <p>Don't have an account? <a href="signup">Sign Up</a></p>
                 </div>
                </div>
            </form>
        </div>
    </div>
<script>
    window.onunload = function () {
    if (performance.navigation.type === 2) {
        window.location.href = '/Signin'; // Redirect to prevent back action
    }
};
</script>

   
</body>
</html>

