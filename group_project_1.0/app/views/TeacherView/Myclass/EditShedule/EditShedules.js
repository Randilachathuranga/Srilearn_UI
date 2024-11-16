// Show the popup form

  // Close the popup form
  function closeedit() {
    document.getElementById("popupEditForm").style.display = "none";
  }
  
  // Function to update the schedule
function Updateschedule() {
  const scheduleId = window.currentScheduleId;
  const subject = document.getElementById("Subject").value;
  const grade = document.getElementById("Grade").value;
  const fee = document.getElementById("Fee").value;
  const startTime = document.getElementById("Start-time").value;
  const endTime = document.getElementById("End-time").value;
  const instituteName = document.getElementById("Institute-name").value;

  // Ensure all form fields are filled out
  if (subject && grade && fee && startTime && endTime && instituteName) {
      // Prepare the data to send to the server
      const scheduleData = {
          id: scheduleId,
          subject: subject,
          grade: grade,
          fee: fee,
          start_time: startTime,
          end_time: endTime,
          institute_name: instituteName
      };

      // Send the data using fetch
      fetch('./updateSchedule.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify(scheduleData), // Send data as JSON
      })
      .then(response => response.json()) // Parse response as JSON
      .then(data => {
          if (data.success) {
              alert("Schedule updated successfully!");
              closeedit(); // Close the popup after a successful update
          } else {
              alert("Failed to update the schedule.");
          }
      })
      .catch(error => {
          console.error('Error updating schedule:', error);
          alert('An error occurred while updating the schedule.');
      });
  } else {
      alert("Please fill out all fields.");
  }
}

// Function to delete a schedule
function deleteschedule() {
  const scheduleId = window.currentScheduleId;
  const confirmDelete = confirm("Are you sure you want to delete this schedule?");

  if (confirmDelete && scheduleId) {
      // Send the request to delete the schedule
      fetch('./deleteSchedule.php', {
          method: 'DELETE',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify({ id: scheduleId }), // Send the schedule ID in the body as JSON
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              alert("Schedule deleted successfully!");
              closeedit(); // Close the form after deletion
          } else {
              alert("Failed to delete the schedule.");
          }
      })
      .catch(error => {
          console.error('Error deleting schedule:', error);
          alert('An error occurred while deleting the schedule.');
      });
  }
}