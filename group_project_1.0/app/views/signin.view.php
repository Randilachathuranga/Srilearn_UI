<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="signin.css"> <!-- Link to your CSS file if needed -->
</head>
<body>
    <div class="container">
        <h1>Sign In</h1>
        
        <form action="#" method="POST"> <!-- Action should point to your server-side script -->
            <?php if (!empty($data['errors'])): ?>
                <div class="error-messages">
                    <?php 
                        // Display each error from the array
                        foreach ($data['errors'] as $error) {
                            echo "<p>$error</p>";
                        }
                    ?>
                </div>
            <?php endif; ?>     

            <div class="form-group">
                <label for="User_id">User-ID:</label>
                <input type="text" id="User_id" name="User_id" required>
            </div>
            <div class="form-group">
                <label for="Password">Password:</label>
                <input type="password" id="Password" name="Password" required>
            </div>
            <div class="form-group">
                <button type="submit">Sign In</button>
            </div>
        </form>
    </div>
</body>
</html>
