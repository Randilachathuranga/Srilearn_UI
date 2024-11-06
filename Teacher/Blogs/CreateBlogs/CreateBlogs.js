// Show the popup form
function createBlog() {
    document.getElementById("popupForm").style.display = "flex";
}

// Close the popup form
function closePopup() {
    document.getElementById("popupForm").style.display = "none";
}

// Submit the blog and redirect to the main blog page
function submitBlog() {
    const title = document.getElementById("title").value;
    const description = document.getElementById("description").value;
    
    if (title && description) {
        // Here, you would usually send the data to the server via fetch or AJAX
        // For demonstration, we'll just log it and redirect

        console.log("Blog Title:", title);
        console.log("Blog Description:", description);

        // Redirect after submission (simulate form submission)
        window.location.href = "../../../../Srilearn_UI/Teacher/Myblogs/Myblogs.php"
    } else {
        alert("Please fill out all fields.");
    }
}
