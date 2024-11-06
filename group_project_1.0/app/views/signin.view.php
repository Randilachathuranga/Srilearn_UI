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
            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?= implode("<br>", $errors) ?>
                </div>
            <?php endif; ?>     

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="name" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Sign In</button>
            </div>
        </form>
    </div>
</body>
</html>
