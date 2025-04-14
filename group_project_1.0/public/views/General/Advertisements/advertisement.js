// Select elements
const adContainer = document.getElementById('adContainer');
const createAdBtn = document.getElementById('createAdBtn');
const adFormContainer = document.getElementById('adFormContainer');
const adForm = document.getElementById('adForm');

// Show the form when "Create Advertisement" is clicked
createAdBtn.addEventListener('click', () => {
    adFormContainer.style.display = 'block'; // Show the form
});

// Handle form submission (POST request)
adForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(adForm);
    const formObject = Object.fromEntries(formData.entries());
    const response = await fetch('http://localhost/group_project_1.0/public/Advertisements/post', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formObject),
    });

    const result = await response.json();

    if (result.message === 'Advertisement created successfully') {
        alert('Advertisement created successfully');
        loadAds();  // Reload the ads after a successful post
        adFormContainer.style.display = 'none';  // Hide the form
    } else {
        alert(result.message || 'Something went wrong!');
    }
});

// Function to load all advertisements (GET request)
async function loadAds() {
    try {
        const response = await fetch('http://localhost/group_project_1.0/public/Advertisements/viewall');
        const ads = await response.json();

        adContainer.innerHTML = '';  // Clear current content

        ads.forEach(ad => {
            const adDiv = document.createElement('div');
            adDiv.className = 'ad-item';
            adDiv.innerHTML = `
                <h3>${ad.Title}</h3>
                <p>${ad.Content}</p>
                <p><strong>Subject:</strong> ${ad.Subject}</p>
                <p><strong>Posted on:</strong> ${ad.Post_date}</p>
                <button onclick="deleteAd(${ad.Ad_id})">Delete</button>
            `;
            adContainer.appendChild(adDiv);
        });
    } catch (error) {
        console.error('Error fetching advertisements:', error);
    }
}

// Function to delete an advertisement (DELETE request)
async function deleteAd(adId) {
    if (!confirm('Are you sure you want to delete this advertisement?')) return;

    try {
        const response = await fetch(`http://localhost/group_project_1.0/public/Advertisements/deleteapi/${adId}`, {
            method: 'DELETE',
        });

        const result = await response.json();

        if (result.message === 'Advertisement deleted successfully') {
            alert('Advertisement deleted');
            loadAds();  // Reload the ads after successful deletion
        } else {
            alert(result.error || 'Something went wrong!');
        }
    } catch (error) {
        console.error('Error deleting advertisement:', error);
    }
}

// Load all advertisements on page load
document.addEventListener('DOMContentLoaded', loadAds);
