// Show the popup form
function createBlog() {
    document.getElementById("popupForm").style.display = "flex";
}

// Close the popup form
function closePopup() {
    document.getElementById("popupForm").style.display = "none";
}

// Submit the blog and redirect to the main blog page


    
function submitBlog(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    // Get form data from the event target
    const form = event.target;
    const formData = new FormData(form);

    // Convert form data to JSON
    const data = {
        Title: formData.get('Title'),
        Content: formData.get('Content'), // Current date
        Post_date: formData.get('Post_date'),
        Likes: 0,

    };
    console.log(data); // Check the data in the console to ensure it's correct
    setTimeout(() => {
        console.clear(); // Clears the console
    }, 4000);
    // Use fetch to send the data to the server
    fetch('http://localhost/group_project_1.0/public/Blog/post', {
        method: 'POST', // HTTP method
        headers: {
            'Content-Type': 'application/json' // Tell the server you're sending JSON data
        },
        body: JSON.stringify(data) // Use 'data' here, not 'blogData'
    })
    .then(response => response.json()) // Parse the JSON response from the server
    .then(data => {
        console.log('Blog submitted successfully:', data);

        // Redirect after submission (simulate form submission)
        window.location.href = "Blog";
    })
    .catch(error => {
        console.error('Error submitting blog:', error);
        alert("There was an error submitting your blog. Please try again.");
    });
}

