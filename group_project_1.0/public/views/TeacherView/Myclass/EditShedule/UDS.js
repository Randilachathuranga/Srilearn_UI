// Close the edit schedule form
function closeedit() {
  document.getElementById("popupEditForm").style.display = "none";
}

// Function to update the Class
async function Updateclass(event, Class_id) {
  event.preventDefault();

  const form = event.target;
  const formData = new FormData(form);

  // Prepare data
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

  // Optional: validate date range
  if (
    table2.Start_date &&
    table2.End_date &&
    table2.Start_date >= table2.End_date
  ) {
    alert("Start date should be earlier than the end date.");
    return;
  }

  try {
    const endpoints = [
      `http://localhost/group_project_1.0/public/Ind_Myclass/UpdateclassApi/${Class_id}`,
    ];

    const updateRequests = endpoints.map((url) =>
      fetch(url, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
    );

    const responses = await Promise.all(updateRequests);
    const rawResponses = await Promise.all(responses.map((res) => res.text()));
    console.log("Raw API Responses:", rawResponses);

    const success = responses.every((res) => res.ok);

    if (!success) {
      throw new Error("One or more update requests failed.");
    }

    const result = JSON.parse(rawResponses[0]); // Assume similar response structure
    if (result.status === "success") {
      alert("Schedule updated successfully!");
    } else {
      alert(`Update failed: ${result.message}`);
    }

    window.location.href =
      "http://localhost/group_project_1.0/public/Ind_Myclass";
  } catch (error) {
    console.error("Error during update:", error);
    alert("An error occurred while updating. Please try again later.");
  }
}

// Function to delete a Class
function deleteclass(Class_id) {
  if (window.confirm("Are you sure you want to delete this schedule?")) {
    fetch(`Ind_Myclass/DeleteclassApi/${Class_id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
      })
      .then((text) => {
        console.log("Server response:", text);
        try {
          const data = JSON.parse(text);
          console.log("Schedule deleted successfully:", data);
          window.location.href =
            "http://localhost/group_project_1.0/public/Ind_Myclass";
        } catch (e) {
          console.error("Error parsing JSON, redirecting anyway:", e);
          window.location.href =
            "http://localhost/group_project_1.0/public/Ind_Myclass";
        }
      })
      .catch((error) => {
        console.error("Error deleting schedule:", error);
      });
  } else {
    console.log("Schedule deletion canceled.");
  }
}
