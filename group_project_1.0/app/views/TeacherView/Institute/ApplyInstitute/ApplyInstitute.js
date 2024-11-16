
// Close the popup form
function closeApply() {
    document.getElementById("popupApply").style.display = "none";
}

// Submit the blog and redirect to the main blog page
function submitApply() {
    const firstName = document.getElementById("firstName").value;
    const lastName = document.getElementById("lastName").value;
    const email = document.getElementById("email").value;
    const subject = document.getElementById("subject").value;
    const phone = document.getElementById("phone").value;
    const address = document.getElementById("address").value;
    const qualifications = document.getElementById("qualifications").value;

    // Check if all fields are filled
    if (firstName && lastName && email && subject && phone && address && qualifications) {
        // Prepare the data to be sent
        const applicationData = {
            firstName: firstName,
            lastName: lastName,
            email: email,
            subject: subject,
            phone: phone,
            address: address,
            qualifications: qualifications
        };

        // Use fetch to send the data to the server
        fetch('path/to/your/api/submitApplication', { // Replace with your actual API endpoint
            method: 'POST', // HTTP method
            headers: {
                'Content-Type': 'application/json' // Tell the server you're sending JSON data
            },
            body: JSON.stringify(applicationData) // Convert the JavaScript object into a JSON string
        })
        .then(response => response.json()) // Parse the JSON response from the server
        .then(data => {
            console.log('Application submitted successfully:', data);

            // Redirect or close the form after submission
            alert("Application submitted successfully!");
            closeApply(); // Close the popup
        })
        .catch(error => {
            console.error('Error submitting application:', error);
            alert("There was an error submitting your application. Please try again.");
        });
    } else {
        alert("Please fill out all fields.");
    }
}
