<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Signin_Signup/signin.css"> <!-- Link to the CSS file -->
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
                    <p>Don't have an account? <a href="http://localhost/group_project_1.0/public/Signup">Sign Up</a></p>
                    <div class="guest"><a  href="guest">Log in as a Guest</a></div>
                    <?php 
                if (!empty($data['errors'])) {
                    foreach ($data['errors'] as $error) {
                        if (stripos($error, "Wrong password") !== false) {
                        echo '<div class="f-pword"><a href="http://localhost/group_project_1.0/public/ForgotPassword">Forgot Password?</a></div>';
                        break;
                }
            }
        }
    ?>
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

