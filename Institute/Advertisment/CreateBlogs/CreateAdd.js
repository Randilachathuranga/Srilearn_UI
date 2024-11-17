// Show the popup form
function createAdd() {
    document.getElementById("popupForm").style.display = "flex";
}

// Close the popup form
function closePopup() {
    document.getElementById("popupForm").style.display = "none";
}

// Submit the blog and redirect to the main blog page
function submitAdd() {
    const title = document.getElementById("title").value;
    const description = document.getElementById("description").value;
    
    if (title && description) {
        // Prepare the data to be sent
        const blogData = {
            title: title,
            description: description
        };

        // Use fetch to send the data to the server
        fetch('path/to/your/api/submitBlog', {
            method: 'POST', // HTTP method
            headers: {
                'Content-Type': 'application/json' // Tell the server you're sending JSON data
            },
            body: JSON.stringify(blogData) // Convert the JavaScript object into a JSON string
        })
        .then(response => response.json()) // Parse the JSON response from the server
        .then(data => {
            console.log('Blog submitted successfully:', data);

            // Redirect after submission (simulate form submission)
            window.location.href = "../../../../Srilearn_UI/Institute/Advertisment/Addvertistment.php";
        })
        .catch(error => {
            console.error('Error submitting blog:', error);
            alert("There was an error submitting your blog. Please try again.");
        });

    } else {
        alert("Please fill out all fields.");
    }
}
