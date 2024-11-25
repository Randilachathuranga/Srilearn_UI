<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Post Your Blog</title>
</head>
<body>
<?php $today = date("Y-m-d"); ?>
    <h1>Post YOur Blogs Here</h1>
    <form action="#" method="POST">
        <div class="form-group">
        <label for="Post-date">Post Date:</label>
        <input type="date" id="Post_date" name="Post_date" value="<?php echo $today; ?>" readonly>
        </div>
        <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="Title" name="Title" placeholder="title" required>
        </div>
        <div class="form-group">
        <label for="announcement">Content:</label>
        <textarea id="Content" name="Content" rows="10" cols="50" placeholder="Write your Content here..." required></textarea>
        </div>
    <button type="submit">LOL</button>
    </form>
</body>
</html>