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
    <title>My Advertisements</title>
    <link rel="stylesheet" href="/group_project_1.0/public/views/General/Advertisements/advertisement.css">
    <link rel="stylesheet" href="./../../../../../group_project_1.0/public/views/General/Popup.css">
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
        
        .ad-image img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }
        
        .record {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .ad-content h3 {
            margin-top: 0;
            color: #333;
        }
        
        .ad-details {
            margin-bottom: 15px;
        }
        
        .ad-text {
            margin-bottom: 10px;
        }
        
        .ad-date, .ad-subject, .ad-type {
            font-size: 0.9em;
            color: #666;
            margin: 5px 0;
        }
        
        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .button-container button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .delete {
            background-color: #ff4d4d;
            color: white;
        }
        
        .update {
            background-color: #4d94ff;
            color: white;
        }
        
        /* Loading indicator styles */
        .loading {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #666;
        }
        
        .loading:after {
            content: '';
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 2px solid #666;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
            margin-left: 10px;
            vertical-align: middle;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .hidden { display: none; }

        .form-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            max-width: 90%;
            max-height: 90%;
            overflow-y: auto;
            z-index: 1001;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            padding: 20px;
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
    <form id="adForm" class="ad-form" method="POST" enctype="multipart/form-data">
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
            
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" name="image" id="image" accept="image/*">
                <div class="preview">
                    <img id="imagePreview" src="" alt="Image Preview" style="max-width: 200px; display: none;">
                </div>
            </div>

            <button type="submit" class="submit-btn">Submit Advertisement</button>
            <button class="submit-btn" type="button" onclick="Cancelform()">Cancel</button>

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
        <?php 
        if (isset($_SESSION['Role']) && ($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute')) {
            echo '
            <div class="create-button">
                <button onclick="handleClick()">Create Your Own Advertisement</button>
                <button onclick="window.location.href=\'http://localhost/group_project_1.0/public/Advertisements\'">View All Advertisements</button>
            </div>';
        }
        ?>
    </div>

    <div id="adContainer" class="ad-container"></div>
</div>

<div class="popup-overlay hidden" id="popupOverlay"></div>
<div class="popup hidden" id="popupBox">
    <p class="popup-message" id="popupMessage"></p>
    <div class="popup-buttons">
        <button class="ok-btn" id="popupOkBtn">OK</button>
        <button class="cancel-btn" id="popupCancelBtn" onclick="closePopup()">Cancel</button>
    </div>
</div>

<script>
    const User_id = "<?php echo $_SESSION['User_id']; ?>";
    const container = document.getElementById('adContainer');
    
    // Function to show loading indicator
    function showLoading() {
        container.innerHTML = '<div class="loading">Loading your advertisements...</div>';
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Set default date value to today for the post date input
        const today = new Date();
        const formattedDate = today.toISOString().substr(0, 10);
        const postDateInput = document.getElementById('post_date');
        if (postDateInput) {
            postDateInput.value = formattedDate;
        }
        
        // Initialize image preview functionality
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.addEventListener('change', function(event) {
                const preview = document.getElementById('imagePreview');
                const file = event.target.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.style.display = 'none';
                }
            });
        }
        
        // Load user's advertisements
        fetchMyAds();
    });
    
    function fetchMyAds() {
        showLoading();
        fetch('http://localhost/group_project_1.0/public/Advertisements/myads')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                container.innerHTML = '';
                
                if (data.length === 0) {
                    container.innerHTML = '<p>You have no advertisements yet.</p>';
                    return;
                }
                
                const promises = data.map(record => {
                    return new Promise((resolve) => {
                        // Create record element
                        const rec = document.createElement('div');
                        rec.className = 'record';
                        
                        // Fetch image for this ad
                        fetch(`http://localhost/group_project_1.0/public/Advertisements/view_image/${record.Ad_id}`)
                            .then(imgResponse => imgResponse.json())
                            .then(imgData => {
                                // Handle the image path correctly
                                let imgSrc;
                                if (imgData && imgData.length > 0 && imgData[0].Src) {
                                    // Use the full path from the root
                                    imgSrc = 'http://localhost' + imgData[0].Src;
                                } else {
                                    imgSrc = '../../../../../group_project_1.0/app/views/General/Advertisements/ad.png';
                                }
                                
                                rec.innerHTML = `
                                    <div class="ad-content">
                                        <h3>${record.Title}</h3>
                                        <div class="ad-details">
                                            <p class="ad-text">${record.Content}</p>
                                            <p class="ad-date">Posted on: ${record.Post_date}</p>
                                            <p class="ad-subject">Subject: ${record.Subject}</p>
                                            <p class="ad-type">Type: ${record.Iseducation === '1' ? 'Educational' : 'Non-Educational'}</p>
                                        </div>
                                        <div class="ad-image">
                                            <img src="${imgSrc}" alt="${record.Title}">
                                        </div>
                                        <div class="button-container">
                                            <button class="update" onclick='handleUpdate(${JSON.stringify(record)}, "${imgSrc}")'>Update</button>
                                            <button class="delete" onclick="handleDelete(${record.Ad_id})">Delete</button>
                                        </div>
                                    </div>
                                `;
                                container.appendChild(rec);
                                resolve();
                            })
                    });
                });
                
                // Wait for all ads to be processed
                Promise.all(promises).then(() => {
                    // All ads have been loaded
                    if (container.children.length === 0) {
                        container.innerHTML = '<p>You have no advertisements yet.</p>';
                    }
                });
            })
            .catch(error => {
                console.error('Fetch error:', error);
                container.innerHTML = '<p>Error loading your advertisements. Please try again later.</p>';
            });
    }

    async function handleDelete(id) {
        showPopup("Are you sure you want to delete this advertisement?", null, async () => {
            try {
                const response = await fetch(`http://localhost/group_project_1.0/public/Advertisements/deleteapi/${id}`, {
                    method: 'DELETE'
                });

                const result = await response.json();

                if (response.ok) {
                    showPopup("Advertisement deleted successfully!", true);
                    setTimeout(() => {
                        fetchMyAds(); // Refresh the ads list
                    }, 1500);
                } else {
                    showPopup(result.error || "Deletion failed.", false);
                }
            } catch (error) {
                console.error("Delete error:", error);
                showPopup("Something went wrong while deleting.", false);
            }
        });
    }

    function handleUpdate(ad, imgSrc) {
        const form = document.getElementById('adFormContainer');
        const titleInput = document.getElementById('title');
        const contentInput = document.getElementById('content');
        const postDateInput = document.getElementById('post_date');
        const subjectInput = document.getElementById('Subject');
        const moreFields = document.getElementById('moreFields');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

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

        // Set the image preview
        if (imgSrc && imgSrc !== '../../../../../group_project_1.0/app/views/General/Advertisements/ad.png') {
            imagePreview.src = imgSrc;
            imagePreview.style.display = 'block';
        } else {
            imagePreview.style.display = 'none';
        }

        const adForm = document.getElementById('adForm');
        adForm.onsubmit = async function (e) {
            e.preventDefault();

            const formData = new FormData(adForm);
            const imageFile = formData.get('image');

            const formObject = {
                Title: formData.get('Title'),
                Content: formData.get('Content'),
                Post_date: formData.get('Post_date'),
                Subject: formData.get('Subject'),
                Iseducation: document.getElementById('educational').checked ? "1" : "0"
            };

            try {
                // Update advertisement data (excluding image)
                const response = await fetch(`http://localhost/group_project_1.0/public/Advertisements/myupdateapi/${ad.Ad_id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formObject)
                });

                const result = await response.json();

                if (!response.ok) {
                    showPopup(result.error || 'Update failed.', false);
                    return;
                }

                // If image selected, upload it separately
                if (imageFile && imageFile.size > 0) {
                    const imageData = new FormData();
                    imageData.append('image', imageFile);

                    const imageResponse = await fetch(`http://localhost/group_project_1.0/public/Advertisements/update_image/${ad.Ad_id}`, {
                        method: 'POST',
                        body: imageData
                    });

                    const imageResult = await imageResponse.json();

                    if (!imageResponse.ok) {
                        showPopup(imageResult.error || 'Image update failed.', false);
                        return;
                    }
                }

                showPopup('Advertisement updated successfully!', true);
                fetchMyAds(); // Refresh the ad list
                setTimeout(() => {
                    window.location.href = 'http://localhost/group_project_1.0/public/Advertisements/viewmyads';
                }, 2000);

            } catch (error) {
                console.error('Update error:', error);
                showPopup('Something went wrong while updating.', false);
            }
        };
    }

    async function handleInsert(event) {
        event.preventDefault();

        const form = document.getElementById('adForm');
        const formData = new FormData(form);
        
        // Add additional data
        formData.append('User_id', User_id);
        formData.append('Iseducation', document.getElementById('educational').checked ? "1" : "0");
        
        try {
            // Show loading state
            document.querySelector('.submit-btn').disabled = true;
            document.querySelector('.submit-btn').textContent = 'Submitting...';
            
            const response = await fetch('http://localhost/group_project_1.0/public/Advertisements/post', {
                method: 'POST',
                body: formData
            });
            
            // Reset button state
            document.querySelector('.submit-btn').disabled = false;
            document.querySelector('.submit-btn').textContent = 'Submit Advertisement';
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            
            if (result.success) {
                showPopup('Advertisement created successfully!', true);
                setTimeout(() => {
                    fetchMyAds(); // Refresh the ads list
                    // Reset form
                    form.reset();
                    document.getElementById('imagePreview').style.display = 'none';
                    document.getElementById('moreFields').classList.add('hidden');
                }, 1500);
            } else {
                showPopup(result.message || 'Failed to create advertisement', false);
            }
        } catch (error) {
            console.error('Error inserting advertisement:', error);
            document.querySelector('.submit-btn').disabled = false;
            document.querySelector('.submit-btn').textContent = 'Submit Advertisement';
            showPopup('An error occurred. Please try again.', false);
        }
    }

    function handleClick() {
        const formContainer = document.getElementById('adFormContainer');
        formContainer.classList.remove('hidden');
        formContainer.scrollIntoView({ behavior: 'smooth' });

        // Reset form
        const adForm = document.getElementById('adForm');
        adForm.reset();
        document.getElementById('imagePreview').style.display = 'none';
        
        const adTypeRadios = document.querySelectorAll('input[name="ad_type"]');
        adTypeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                document.getElementById('moreFields').classList.remove('hidden');
            });
        });

        adForm.removeEventListener('submit', handleInsert);
        adForm.addEventListener('submit', handleInsert);
    }

    function Popupclose() {
        document.getElementById('popupBox').classList.add('hidden');
        document.getElementById('popupOverlay').classList.add('hidden');
    }

    function Cancelform() {
        const formContainer = document.getElementById('adFormContainer');
        formContainer.classList.add('hidden');
        document.getElementById('adForm').reset();
        document.getElementById('moreFields').classList.add('hidden');
    }
    
</script>
<script src="./../../../../../group_project_1.0/public/views/General/Popup.js"></script>

</body>
</html>