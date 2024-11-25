<!DOCTYPE html>
<html>
<head>
    <title>Announcement Form</title>
</head>
<body>
<?php
$today = date("Y-m-d"); 
?>
<div class='header'><h1>Announcement Form</h1></div>
<div class='container'>
    <form action='#' method="POST">
    <?php if(!empty($errors)):?>
                <div>
            <?= implode("<br>",$errors)?>
            </div>
            <?php endif;?>  
        <div class="form-group">
        <label for="announcement-date">Announcement Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $today; ?>" readonly>
        </div>
        <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" placeholder="title" required>
        </div>
        <div class="form-group">
        <label for="announcement">Post Announcement:</label>
        <textarea id="announcement" name="announcement" rows="10" cols="50" placeholder="Write your announcement here..." required></textarea>
        </div>
        <div class="form-group"> 
        <button type="submit">Post</button>
        </div>
    </form>
</div>
</body>

</html>
