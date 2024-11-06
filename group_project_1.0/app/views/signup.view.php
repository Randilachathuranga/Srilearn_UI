<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <form action="#" method="POST">
        <div>
            <?php if(!empty($errors)):?>
                <div>
            <?= implode("<br>",$errors)?>
            </div>
            <?php endif;?>  
        <!-- Action points to your server-side script -->
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required min="1">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Sign Up</button>
                <a href="signin">Sign-in</a>
            </div>
        </form>
    </div>
</body>
</html>
