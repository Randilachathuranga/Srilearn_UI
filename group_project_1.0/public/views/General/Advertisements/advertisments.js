// Fetch advertisements from the server dynamically when the page loads
window.onload = function() {
    fetchAds();
};

// Function to fetch ads from the backend using AJAX
function fetchAds() {
    fetch('http://localhost/group_project_1.0/public/Advertisements/viewadd')  // Adjust the path to your controller's viewadd method
        .then(response => response.json())
        .then(data => {
            displayAds(data);
        })
        .catch(error => console.error('Error fetching ads:', error));
}

// Function to display ads in the container
function displayAds(ads) {
    const adContainer = document.getElementById('adContainer');
    adContainer.innerHTML = ''; // Clear the container before adding new ads

    if (ads.message) {
        adContainer.innerHTML = `<p>${ads.message}</p>`;
        return;
    }

    // Loop through the ads and create HTML elements
    ads.forEach(ad => {
        const adElement = document.createElement('div');
        adElement.classList.add('card', ad.Iseducation ? 'education' : 'non-education');
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

// Function to filter advertisements based on type and subject
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

    // Loop through the ads and apply filters
    ads.forEach(ad => {
        const isEducation = ad.classList.contains('education');
        const adSubject = ad.getAttribute('data-subject');

        let typeMatch = adType === 'all' || (adType === 'education' && isEducation) || (adType === 'non-education' && !isEducation);
        let subjectMatch = adType !== 'education' || subject === 'all' || adSubject === subject;

        ad.style.display = typeMatch && subjectMatch ? 'block' : 'none';
    });
}

// Redirect the user to the form for creating a new advertisement
function handleclick(){
    window.location.href = 'advertisements/form';  // Adjust the path as necessary
}
