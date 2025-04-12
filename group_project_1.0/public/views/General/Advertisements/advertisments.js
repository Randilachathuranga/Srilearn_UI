document.addEventListener('DOMContentLoaded', () => {
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
                    <h3>${record.title}</h3>
                    <p>${record.announcement}</p>
                    <h5>${record.date}</h5>
                    ${userRole === 'sysadmin' ? `<button onclick="handleDelete(${record.annid})">Delete</button>` : ''}
                    ${userRole === 'sysadmin' ? `<button onclick="gotoupdateform(${record.annid})">Update</button>` : ''}
                `;
                container.appendChild(rec); // Append each announcement to the container
            });
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
});
window.addEventListener('DOMContentLoaded', initAdsPage);


function filterAds() {
    const typeFilter = document.getElementById('adType').value;
    const subjectFilter = document.getElementById('subject').value;

    // Show subject dropdown only if educational
    const subjectDropdown = document.getElementById('subject');
    const subjectLabel = document.getElementById('subjectLabel');
    if (typeFilter === 'education') {
        subjectDropdown.style.display = 'inline-block';
        subjectLabel.style.display = 'inline-block';
    } else {
        subjectDropdown.style.display = 'none';
        subjectLabel.style.display = 'none';
    }

    let filtered = [...adsData];

    if (typeFilter === 'education') {
        filtered = filtered.filter(ad => ad.Iseducation === "1");
    } else if (typeFilter === 'non-education') {
        filtered = filtered.filter(ad => ad.Iseducation === "0");
    }

    // If education is selected, apply subject filter
    if (typeFilter === 'education' && subjectFilter !== 'all') {
        filtered = filtered.filter(ad => ad.Subject.toLowerCase().includes(subjectFilter.toLowerCase()));
    }

    renderAds(filtered);
}

function handleClick() {
    // Redirect to ad creation page
    window.location.href = '/group_project_1.0/app/views/General/Advertisements/create_advertisement.php';
}
