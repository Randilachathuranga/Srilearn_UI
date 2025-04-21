<?php
session_start();

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
    <link rel="stylesheet" href="/group_project_1.0/public/views/General/Advertisements/advertisement.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        .hidden { display: none; }

        .form-container {
            margin: 30px;
            padding: 20px;
            border: 2px solid #ccc;
            background-color: #f9f9f9;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<!-- Form Container -->
<div class="form-container hidden" id="adFormContainer">
    <h1 class="title">Submit Advertisement</h1>
    <form id="adForm" class="ad-form" method="POST">

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

        <div id="moreFields" class="hidden">
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
                <label for="Subject">Subject</label>
                <input type="text" id="Subject" name="Subject" required>
            </div>

            <button type="submit" class="submit-btn">Submit Advertisement</button>
        </div>
    </form>
</div>

<!-- Main Container -->
<div class="container">
    <h1 class="title">My Advertisements</h1>

    <div class="banner">
        <img src="/group_project_1.0/public/views/General/Advertisements/advertisement.jpg" alt="Banner Image">
    </div>

    <div class="filters">
        <label for="adType">Filter by Type:</label>
        <select id="adType" onchange="filterAds()">
            <option value="all">All</option>
            <option value="education">Educational</option>
            <option value="non-education">Non-Educational</option>
        </select>

        <?php 
    if (isset($_SESSION['Role']) && ($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute')) {
        echo '
        <div class="create-button">
            <button onclick="handleClick()">Create Your Own Advertisement</button>
           
        </div>';
    }
?>

    </div>

    <div id="adContainer" class="ad-container"></div>
</div>

<script>
    const User_id = "<?php echo $_SESSION['User_id']; ?>";

    document.addEventListener('DOMContentLoaded', () => {
        fetch('http://localhost/group_project_1.0/public/Advertisements/myads')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('adContainer');
                container.innerHTML = '';
                data.forEach(record => {
                    const rec = document.createElement('div');
                    rec.className = 'record';
                    rec.innerHTML = `
                        <p>${record.Title}</p>
                        <h5>${record.Content}</h5>
                         <button onclick="handleDelete(${record.Ad_id})">Delete</button>
                        <button onclick='handleUpdate(${JSON.stringify(record)})'>Update</button>
                       
                    `;
                    container.appendChild(rec);
                });
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    });

    async function handleDelete(id) {
        if (!confirm("Are you sure you want to delete this advertisement?")) return;

        try {
            const response = await fetch(`http://localhost/group_project_1.0/public/Advertisements/deleteapi/${id}`, {
                method: 'DELETE'
            });

            const result = await response.json();
            if (response.ok) {
                alert("Advertisement deleted successfully!");
                window.location.href = 'http://localhost/group_project_1.0/public/Advertisements';
            } else {
                alert(result.error || 'Deletion failed.');
            }
        } catch (error) {
            console.error("Delete error:", error);
        }
    }

    function handleUpdate(ad) {
    const form = document.getElementById('adFormContainer');
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const postDateInput = document.getElementById('post_date');
    const subjectInput = document.getElementById('Subject');
    const moreFields = document.getElementById('moreFields');

    form.classList.remove('hidden');
    moreFields.classList.remove('hidden');
    form.scrollIntoView({ behavior: 'smooth' });

    // Pre-fill form fields
    titleInput.value = ad.Title;
    contentInput.value = ad.Content;
    postDateInput.value = ad.Post_date;
    subjectInput.value = ad.Subject;

    if (ad.Iseducation === "1") {
        document.getElementById('educational').checked = true;
    } else {
        document.getElementById('non_educational').checked = true;
    }

    const adForm = document.getElementById('adForm');
    adForm.onsubmit = async function (e) {
        e.preventDefault();

        const formData = new FormData(adForm);
        const formObject = Object.fromEntries(formData.entries());

        // Forcefully set Iseducation based on radio button
        formObject.Iseducation = document.getElementById('educational').checked ? "1" : "0";

        console.log("dddddd", formObject); // Debug log

        try {
            const response = await fetch(`http://localhost/group_project_1.0/public/Advertisements/myupdateapi/${ad.Ad_id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formObject)
            });

            const result = await response.json();

            if (response.ok) {
                alert('Advertisement updated successfully!');
                window.location.href = 'http://localhost/group_project_1.0/public/Advertisements';
            } else {
                alert(result.error || 'Update failed.');
            }
        } catch (error) {
            console.error('Update error:', error);
            alert('Something went wrong while updating.');
        }
    };
}


async function handleInsert(event) {
    event.preventDefault();

    const form = document.getElementById('adForm');
    const formData = new FormData(form);
    const formObject = Object.fromEntries(formData.entries());
    formObject.Iseducation = document.getElementById('educational').checked ? "1" : "0";
    formObject.User_id = User_id;
    console.log("ssss", formObject);

    const pass_data = {
        'User_id': formObject.User_id,
        'Title': formObject.Title,
        'Content': formObject.Content,
        'Post_date': formObject.Post_date,
        'Iseducation': formObject.Iseducation,
        'Subject': formObject.Subject
    };

    try {
        const response = await fetch('http://localhost/group_project_1.0/public/Advertisements/post', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(pass_data)
        });

        const result = await response.json();

        
        if (response.ok) {
            alert('Advertisement created successfully!');
            window.location.href = 'http://localhost/group_project_1.0/public/Advertisements';
        } else {
            alert(result.error || result.message || 'Failed to create advertisement.');
        }
    } catch (error) {
        console.error('Error inserting advertisement:', error);
    }
}

    function handleClick() {
        const formContainer = document.getElementById('adFormContainer');
        formContainer.classList.remove('hidden');
        formContainer.scrollIntoView({ behavior: 'smooth' });

        const adTypeRadios = document.querySelectorAll('input[name="ad_type"]');
        adTypeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                document.getElementById('moreFields').classList.remove('hidden');
            });
        });

        const adForm = document.getElementById('adForm');
        adForm.removeEventListener('submit', handleInsert);
        adForm.addEventListener('submit', handleInsert);
    }

     function handleMyAds() {
         window.location.href = `http://localhost/group_project_1.0/public/Advertisements/myads/`;
     }

    function filterAds() {
        // Optional: implement ad filtering logic here if needed
    }
</script>


</body>
</html>
