// Show the popup form
function ScheduleClass() {
    document.getElementById("popupForm").style.display = "flex";
}

// Close the popup form
function closePopup() {
    document.getElementById("popupForm").style.display = "none";
}

// Submit the blog and redirect to the main blog page
function submit() {
    const subject = document.getElementById("Subject").value;
    const grade = document.getElementById("Grade").value;
    const fee = document.getElementById("Fee").value;
    const startTime = document.getElementById("Start-time").value;
    const endTime = document.getElementById("End-time").value;
    const instituteName = document.getElementById("Institute-name").value;

    // Check if all required fields are filled out
    if (subject && grade && fee && startTime && endTime && instituteName) {
        // Prepare the data to be sent
        const scheduleData = {
            subject: subject,
            grade: grade,
            fee: fee,
            start_time: startTime,
            end_time: endTime,
            institute_name: instituteName
        };

        // Use fetch to send the data to the server
        fetch('path/to/your/api/submitSchedule', {
            method: 'POST', // HTTP method
            headers: {
                'Content-Type': 'application/json' // Tell the server you're sending JSON data
            },
            body: JSON.stringify(scheduleData) // Convert the JavaScript object into a JSON string
        })
        .then(response => response.json()) // Parse the JSON response from the server
        .then(data => {
            console.log('Schedule submitted successfully:', data);

            // Optionally, redirect after submission
            window.location.href = "../../../../Srilearn_UI/Teacher/Myblogs/Myblogs.php";
        })
        .catch(error => {
            console.error('Error submitting schedule:', error);
            alert("There was an error submitting the schedule. Please try again.");
        });
    } else {
        alert("Please fill out all fields.");
    }
}

