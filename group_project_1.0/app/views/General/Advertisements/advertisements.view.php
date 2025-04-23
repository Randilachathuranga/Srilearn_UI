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
    <link rel="stylesheet" href="/group_project_1.0/public/views/General/Popup.css">

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
            backdrop-filter: blur(5px);
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
    <h1 class="title">Advertisements</h1>

    <div class="banner">
        <img src="/group_project_1.0/public/views/General/Advertisements/advertisement.jpg" alt="Banner Image">
    </div>

    <div class="filters">
        <label for="adType">Filter by Type:</label>
        <select id="adType">
            <option value="all">All</option>
            <option value="education">Educational</option>
            <option value="non-education">Non-Educational</option>
        </select>

        <?php 
        if (isset($_SESSION['Role']) && ($_SESSION['Role'] === 'teacher' || $_SESSION['Role'] === 'institute')) {
            echo '
            <div class="create-button">
                <button onclick="handleClick()">Create Your Own Advertisement</button>
                <button onclick="handleMyAds()">My Advertisements</button>
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
        <button class="cancel-btn" id="popup_CancelBtn" onclick="Popupclose()">Cancel</button>
    </div>
</div> 

<script src="/group_project_1.0/public/views/General/Popup.js"></script> 

<script>
    const User_id = "<?php echo $_SESSION['User_id']; ?>";
    const container = document.getElementById('adContainer');

    document.addEventListener('DOMContentLoaded', () => {
        const adTypeSelect = document.getElementById('adType');
        
        // Set default date value to today for the post date input
        const today = new Date();
        const formattedDate = today.toISOString().substr(0, 10);
        const postDateInput = document.getElementById('post_date');
        if (postDateInput) {
            postDateInput.value = formattedDate;
        }

        // Initial fetch - all ads
        fetchAds('all');

        // Listen to filter changes
        adTypeSelect.addEventListener('change', () => {
            const selectedType = adTypeSelect.value;
            fetchAds(selectedType);
        });

        // Function to fetch advertisements
        function fetchAds(type) {
            fetch(`${window.location.origin}/group_project_1.0/public/Advertisements/viewall`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    container.innerHTML = '';
                    
                    // Filter based on selected type
                    const filtered = data.filter(record => {
                        if (type === 'education') return record.Iseducation === '1';
                        if (type === 'non-education') return record.Iseducation === '0';
                        return true; // 'all'
                    });
                    
                    if (filtered.length === 0) {
                        container.innerHTML = '<p>No advertisements found.</p>';
                        return;
                    }
                    
                    const promises = filtered.map(record => {
                        return new Promise((resolve) => {
                            // Create record element
                            const rec = document.createElement('div');
                            rec.className = 'record';
                            
                            // Fetch image for this ad
                            fetch(`${window.location.origin}/group_project_1.0/public/Advertisements/view_image/${record.Ad_id}`)
                                .then(imgResponse => imgResponse.json())
                                .then(imgData => {
                                    // Fix: Handle the image path correctly
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
                            container.innerHTML = '<p>No advertisements found.</p>';
                        }
                    });
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    container.innerHTML = '<p>Error loading advertisements. Please try again later.</p>';
                });
        }
    });

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
                    window.location.href = 'http://localhost/group_project_1.0/public/Advertisements';
                }, 2000);
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
        window.location.href = `http://localhost/group_project_1.0/public/Advertisements/viewmyads`;
    }

    // Image preview functionality
    document.addEventListener('DOMContentLoaded', function() {
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
    });

    // Function to cancel the form
    function Cancelform() {
        const formContainer = document.getElementById('adFormContainer');
        formContainer.classList.add('hidden');
        document.getElementById('adForm').reset();
        document.getElementById('moreFields').classList.add('hidden');
    }

    // Initialize popup
    document.addEventListener('DOMContentLoaded', function() {
        const popupOkBtn = document.getElementById('popupOkBtn');
        if (popupOkBtn) {
            popupOkBtn.addEventListener('click', function() {
                document.getElementById('popupBox').classList.add('hidden');
                document.getElementById('popupOverlay').classList.add('hidden');
            });
        }
    });

</script>
<script src="./../../../../../group_project_1.0/public/views/General/Popup.js"></script>
</body>
</html>