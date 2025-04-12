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

<div class="form-container hidden" display=none>
    <h1 class="title">Submit Advertisement</h1>
    <form id="adForm" class="ad-form" method="POST" action="submit_advertisement.php"> <!-- Set the form method to POST -->
        <div class="form-group">
            <label for="title">Advertisement Title</label>
            <input type="text" id="title" name="Title" required placeholder="Enter advertisement title">
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="Content" required placeholder="Enter advertisement content"></textarea>
        </div>

        <div class="form-group">
            <label for="post_date">Post Date</label>
            <input type="date" id="post_date" name="Post_date" required>
        </div>

        <div class="form-group">
            <label>Advertisement Type</label>
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" id="educational" name="ad_type" value="educational" required>
                    <label for="educational">Educational</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="non_educational" name="ad_type" value="non_educational">
                    <label for="non_educational">Non-Educational</label>
                </div>
            </div>
        </div>

        <div class="form-group" id="subjectGroup" style="display: none;">
            <label for="subject">Subject</label>
            <select id="subject" name="subject">
                <option value="">Select a subject</option>
                <option value="mathematics">Mathematics</option>
                <option value="science">Science</option>
                <option value="literature">Literature</option>
                <option value="history">History</option>
                <option value="computer_science">Computer Science</option>
                <option value="languages">Languages</option>
                <option value="arts">Arts</option>
                <option value="other">Other</option>
            </select>
        </div>

        <button type="submit" class="submit-btn">Submit Advertisement</button>
    </form>
</div>


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
    fetch('http://localhost/group_project_1.0/public/Advertisements/viewall') // Adjust this URL to match your routing structure
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
                    <p>${record.Title}</p>
                    <h5>${record.Content}</h5>
                    <button onclick="handleDelete(${record.Ad_id})">Delete</button>
                   
                `;
                container.appendChild(rec); // Append each announcement to the container
            });
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
});
window.addEventListener('DOMContentLoaded', initAdsPage);

async function handleDelete(id) {
    try {
        alert("are you sure ?")
        const response = await fetch(`http://localhost/group_project_1.0/public/Advertisements/deleteapi/${id}`, {
            method: 'DELETE'
        });

        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }

        const data = await response.json();
        console.log("Delete successful:", data);
        // Optionally update UI or notify user here
        window.location.href = 'http://localhost/group_project_1.0/public/Advertisements'; // change URL as needed

    } catch (error) {
        console.error("Error deleting item:", error);
        // You can also show a message to the user here
    }
}


function handleClick() {
    // Redirect to ad creation page
    alert("hi");
}
</script>
</body>
</html>

<?php
// Include footer if user is not sysadmin
if (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
    require 'C:/xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
}
?>
