  // Close the edit schedule form
  function closeedit() {
    document.getElementById("popupEditForm").style.display = "none";
  }
  
  // Function to update the Class
  async function Updateschedule(event, Class_id) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const table1 = {
        Subject: formData.get("classSubject"),
        Grade: formData.get("classGrade"),
        fee: parseInt(formData.get("classfee"), 10),
        Max_std: parseInt(formData.get("classMax_std"), 10),
    };
    const table2 = {
        Location: formData.get("classLocation"),
        Start_date: formData.get("classStart_date"),
        End_date: formData.get("classEnd_date"),
    };
    const data = { table1, table2 };
    console.log("ClassData being sent:", data);
    console.log("Class ID:", Class_id);
    try {
        const response = await fetch(`http://localhost/group_project_1.0/public/Ind_Myclass/UpdateclassApi/${Class_id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        });
        const textResponse = await response.text();  // Try reading as text first to debug
    console.log("Raw API Response:", textResponse);
    
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const result = JSON.parse(textResponse);  // Manually parse it if needed
        console.log("API Response:", result);
        if (result.status === "success") {
            alert("Schedule updated successfully!");
            window.location.href = 'http://localhost/group_project_1.0/public/Ind_Myclass';
        } else {
            alert(`Failed to update schedule: ${result.message}`);
            window.location.href = 'http://localhost/group_project_1.0/public/Ind_Myclass';
        }
    } catch (error) {
        console.error("Error updating schedule:", error);
        alert("An error occurred while updating the schedule. Please try again later.");
    } 
}


// Function to delete a Class
function deleteschedule(Class_id) {
    if (window.confirm('Are you sure you want to delete this schedule?')) {
        fetch(`Ind_Myclass/DeleteclassApi/${Class_id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text(); 
        })
        .then(text => {
            console.log('Server response:', text);
            try {
                const data = JSON.parse(text);
                console.log('Schedule deleted successfully:', data);
                window.location.href = 'http://localhost/group_project_1.0/public/Ind_Myclass';
            } catch (e) {
                console.error('Error parsing JSON, redirecting anyway:', e);
                window.location.href = 'http://localhost/group_project_1.0/public/Ind_Myclass';
            }
        })
        .catch(error => {
            console.error('Error deleting schedule:', error);
        });
    } else {
        console.log('Schedule deletion canceled.');
    }
}



