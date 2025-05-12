function closeedit() {
  document.getElementById("popupEditForm").style.display = "none";
}

async function Updateclass(event, Class_id) {
  event.preventDefault();

  const form = event.target;
  const formData = new FormData(form);

  const grade = parseInt(formData.get("classGrade"), 10);
  const maxStd = parseInt(formData.get("classMax_std"), 10);
  const fee = parseFloat(formData.get("classfee"));

  let isValid = true;

  if (isNaN(grade) || grade < 1 || grade > 13) {
    alert("Grade must be a number between 1 and 13.");
    isValid = false;
  }

  if (isNaN(maxStd) || maxStd <= 0) {
    alert("Max students must be a positive number.");
    isValid = false;
  }

  if (isNaN(fee) || fee < 0) {
    alert("Fee cannot be a negative value.");
    isValid = false;
  }

  if (!isValid) {
    return;
  }

  const table1 = {
    Subject: formData.get("classSubject"),
    Grade: grade,
    fee: fee,
    Max_std: maxStd,
    Date: formData.get("Date_"),
    Time: formData.get("Time_"),
  };

  const table2 = {
    Location: formData.get("classLocation"),
    Start_date: formData.get("classStart_date"),
    End_date: formData.get("classEnd_date"),
    Hall_number: formData.get("Hall_number"),
  };

  const data = { table1, table2 };
  console.log("ClassData being sent:", data);
  console.log("Class ID:", Class_id);

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

    const result = JSON.parse(rawResponses[0]);
    if (result.status === "success") {
      alert("Updated successfully!");
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

function deleteclass(Class_id) {
  if (window.confirm("Are you sure you want to delete this Class?")) {
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
