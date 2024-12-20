<?php
    // Corrected the condition to check for 'sysadmin' role
    
    if($_SESSION['User_id']=='Guest'){
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/Guest_NavBar/NavBar.view.php';

    }
    elseif (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php';
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Advertisements/advertisement.css"> <!-- Link to the CSS file -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Advertisements</title>
</head>
<body>
    <div class="container">
        <!-- Title -->
        <h1 class="title">Advertisements</h1>

        <!-- Banner Image -->
        <div class="banner">
            <img src="../../../../../group_project_1.0/public/views/General/Advertisements/advertisement.jpg" alt="Banner Image">
        </div>

        <!-- Filters -->
        <div class="filters">
            <label for="adType">Filter by Type:</label>
            <select id="adType" onchange="filterAds()">
                <option value="all">All</option>
                <option value="education">Educational</option>
                <option value="non-education">Non-Educational</option>
            </select>

            <label for="subject" id="subjectLabel" style="display: none;">Filter by Subject:</label>
            <select id="subject" style="display: none;" onchange="filterAds()">
                <option value="all">All</option>
                <option value="scholarship">Scholarship</option>
                <option value="o/l">O/L</option>
                <option value="a/l">A/L</option>
                <option value="grd6-9">Grade 6-9</option>
            </select>
            <?php 
if  ( isset($_SESSION['Role'])&&($_SESSION['Role'] == 'teacher' || $_SESSION['Role'] == 'institute')) {
    echo '<div class="create-button"><button onclick="handleclick()">Create Your Own Advertisement</button></div>';
}
?>

        </div>

        <!-- Advertisement Cards -->
        <div id="adContainer" class="ad-container">
            <?php
            // Advertisement data
            $ads = [
                ["Title" => "Scholarship Program", "Content" => "Apply for scholarships now!", "Post_date" => "2024-11-22", "Iseducation" => true, "Subject" => "scholarship", "Image" => "../../../group_project_1.0/public/views/icon/ad.jpg"],
                ["Title" => "O/L Study Tips", "Content" => "Ace your O/L exams with these tips.", "Post_date" => "2024-11-21", "Iseducation" => true, "Subject" => "o/l", "Image" => "../../../group_project_1.0/public/views/icon/ad.jpg"],
                ["Title" => "Grade 6 Science", "Content" => "Explore engaging science content.", "Post_date" => "2024-11-20", "Iseducation" => true, "Subject" => "grd6-9", "Image" => "../../../group_project_1.0/public/views/icon/ad.jpg"],
                ["Title" => "Furniture Sale", "Content" => "Get the best deals on furniture!", "Post_date" => "2024-11-19", "Iseducation" => false, "Subject" => null, "Image" => "../../../group_project_1.0/public/views/icon/ad.jpg"],
                ["Title" => "A/L Mathematics", "Content" => "Master mathematics for A/L exams.", "Post_date" => "2024-11-18", "Iseducation" => true, "Subject" => "a/l", "Image" => "../../../group_project_1.0/public/views/icon/ad.jpg"],
                ["Title" => "Car Services", "Content" => "Affordable car services now available.", "Post_date" => "2024-11-17", "Iseducation" => false, "Subject" => null, "Image" => "../../../group_project_1.0/public/views/icon/ad.jpg"]
            ];
            ?>

            <!-- Render ads -->
            <?php foreach ($ads as $ad): ?>
                <div class="card <?= $ad['Iseducation'] ? 'education' : 'non-education'; ?>" data-subject="<?= $ad['Subject']; ?>">
                    <img src="<?= $ad['Image']; ?>" alt="<?= $ad['Title']; ?>">
                    <h2><?= $ad['Title']; ?></h2>
                    <p><?= $ad['Content']; ?></p>
                    <small>Posted on: <?= $ad['Post_date']; ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function filterAds() {
            const adType = document.getElementById('adType').value;
            const subject = document.getElementById('subject').value;
            const ads = document.querySelectorAll('.card');

            // Show/hide subject filter dropdown
            const subjectDropdown = document.getElementById('subject');
            const subjectLabel = document.getElementById('subjectLabel');
            if (adType === 'education') {
                subjectDropdown.style.display = 'inline-block';
                subjectLabel.style.display = 'inline-block';
            } else {
                subjectDropdown.style.display = 'none';
                subjectLabel.style.display = 'none';
            }

            ads.forEach(ad => {
                const isEducation = ad.classList.contains('education');
                const adSubject = ad.getAttribute('data-subject');

                let typeMatch = adType === 'all' || (adType === 'education' && isEducation) || (adType === 'non-education' && !isEducation);
                let subjectMatch = adType !== 'education' || subject === 'all' || adSubject === subject;

                ad.style.display = typeMatch && subjectMatch ? 'block' : 'none';
            });
        }

        function handleclick(){
            window.location.href='advertisements/form';
        }
    </script>
</body>
</html>


<?php
 
 if (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
    }
    ?>