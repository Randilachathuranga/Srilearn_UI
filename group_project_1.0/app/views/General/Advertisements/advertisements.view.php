<?php
// Load appropriate NavBar
if ($_SESSION['User_id'] === 'Guest') {
    require 'C:/xampp/htdocs/group_project_1.0/app/views/General/NavBar/Guest_NavBar/NavBar.view.php';
} elseif (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
    require 'C:/xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisements</title>
    
    <!-- CSS Styles -->
    <link rel="stylesheet" href="/group_project_1.0/public/views/General/Advertisements/advertisement.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="title">Advertisements</h1>

        <!-- Banner Section -->
        <div class="banner">
            <img src="/group_project_1.0/public/views/General/Advertisements/advertisement.jpg" alt="Banner Image">
        </div>

        <!-- Filters Section -->
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
            if (isset($_SESSION['Role']) && ($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute')) {
                echo '<div class="create-button"><button onclick="handleClick()">Create Your Own Advertisement</button></div>';
            }
            ?>
        </div>

        <!-- Advertisement Cards Container -->
        <!-- Advertisement Cards Container -->
        <div id="adContainer" class="ad-container"></div>
        <!-- Ads will be inserted dynamically by JavaScript -->

    </div>

    <!-- JavaScript -->
    
    <script>document.addEventListener('DOMContentLoaded', () => {
    fetch('http://localhost/group_project_1.0/public/Advertisements/viewadd') // Adjust this URL to match your routing structure
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
            
        })
        .then(data => {
            console.log(data)
            const container = document.getElementById('adContainer');
            data.forEach(record => {
                const rec = document.createElement('div');
                rec.className = 'record';
                rec.innerHTML = `
                    <h3>${record.Ad_id}</h3>
                    <p>${record.Title}</p>
                    <h5>${record.Content}</h5>
                   
                `;
                container.appendChild(rec); // Append each announcement to the container
            });
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
});
window.addEventListener('DOMContentLoaded', initAdsPage);
</script>
</body>
</html>

<?php
// Include footer if user is not sysadmin
if (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
    require 'C:/xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
}
?>
