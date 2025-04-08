// Redirect to 'adform' when the button is clicked
function handleclick() {
    window.location.href = 'advertisements/form';  // This should route to the correct form view
}

// Function to fetch ads dynamically and display them
function fetchAds() {
    fetch('http://localhost/group_project_1.0/public/Advertisements/viewadd')  // URL for fetching ads
        .then(response => response.json())
        .then(data => displayAds(data))
        .catch(error => console.error('Error fetching ads:', error));
}

// Function to display ads
function displayAds(ads) {
    const adContainer = document.getElementById('adContainer');
    adContainer.innerHTML = ''; // Clear any existing ads

    if (ads.message) {
        adContainer.innerHTML = `<p>${ads.message}</p>`;
        return;
    }

    ads.forEach(ad => {
        const adElement = document.createElement('div');
        adElement.classList.add('ad-card', ad.Iseducation ? 'education' : 'non-education');
        adElement.setAttribute('data-subject', ad.Subject);

        adElement.innerHTML = `
            <img src="../../../../../group_project_1.0/public/views/General/Advertisements/advertisement.jpg" alt="${ad.Title}">
            <h2>${ad.Title}</h2>
            <p>${ad.Content}</p>
            <small>Posted on: ${ad.Post_date}</small>
        `;

        adContainer.appendChild(adElement);
    });
}

// Function to filter ads based on type and subject
function filterAds() {
    const adType = document.getElementById('adType').value;
    const subject = document.getElementById('subject').value;
    const ads = document.querySelectorAll('.ad-card');

    // Show/hide subject filter based on adType
    const subjectDropdown = document.getElementById('subject');
    const subjectLabel = document.getElementById('subjectLabel');
    if (adType === 'education') {
        subjectDropdown.style.display = 'inline-block';
        subjectLabel.style.display = 'inline-block';
    } else {
        subjectDropdown.style.display = 'none';
        subjectLabel.style.display = 'none';
    }

    // Apply filters to each ad
    ads.forEach(ad => {
        const isEducation = ad.classList.contains('education');
        const adSubject = ad.getAttribute('data-subject');

        let typeMatch = adType === 'all' || (adType === 'education' && isEducation) || (adType === 'non-education' && !isEducation);
        let subjectMatch = adType !== 'education' || subject === 'all' || adSubject === subject;

        ad.style.display = typeMatch && subjectMatch ? 'block' : 'none';
    });
}

// Fetch ads when the page loads
window.onload = function() {
    fetchAds();
};
