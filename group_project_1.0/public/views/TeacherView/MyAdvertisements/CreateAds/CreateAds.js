// Show the popup form
function createAdds() {
    document.getElementById("popupForm").style.display = "flex";
}

// Close the popup form
function closePopup() {
    document.getElementById("popupForm").style.display = "none";
}

// Submit the blog and redirect to the main blog page
function submitAds() {
    const title = document.getElementById("title").value;
    const description = document.getElementById("description").value;
    const image = document.getElementById("image").value;
    
    if (title && description && image) {
        // Prepare the data to be sent
        const Adsdata = {
            title: title,
            description: description,
            image: image
        };

        // Use fetch to send the data to the server
        fetch('path/to/your/api/submitBlog', {
            method: 'POST', // HTTP method
            headers: {
                'Content-Type': 'application/json' // Tell the server you're sending JSON data
            },
            body: JSON.stringify(Adsdata) // Convert the JavaScript object into a JSON string
        })
        .then(response => response.json()) // Parse the JSON response from the server
        .then(data => {
            console.log('Blog submitted successfully:', data);

            // Redirect after submission (simulate form submission)
            window.location.href = "../../../../../../group_project_1.0/app/views/TeacherView/MyAdvertisements/MyAdvertisements.php";
            // ../../../Teacher/MyAdvertisements/MyAdvertisements.php
        })
        .catch(error => {
            console.error('Error submitting blog:', error);
            alert("There was an error submitting your blog. Please try again.");
        });

    } else {
        alert("Please fill out all fields.");
    }
}
