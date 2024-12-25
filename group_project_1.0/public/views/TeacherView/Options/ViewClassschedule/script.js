// Retrieve class ID from sessionStorage
const classId = sessionStorage.getItem("class_id");
console.log("Retrieved Class ID from sessionStorage:", classId);

document.addEventListener("DOMContentLoaded", () => {
  fetch(`http://localhost/group_project_1.0/public/ClassShcedules/AllclassShcedule/${classId}`)
    .then((response) => {
      if (!response.ok) {
        if (response.status === 404) {
          console.error("No schedules found for this class.");
          return [];
        }
        throw new Error("An unexpected error occurred.");
      }
      return response.json();
    })
    .then((data) => {
      const container = document.getElementById("scheduleTable");
      if (!container) {
        console.error("Container element with ID 'scheduleTable' not found.");
        return;
      }
      container.innerHTML = ""; // Clear previous rows

      if (!data || data.length === 0) {
        container.innerHTML = "<p>No classes found for this teacher.</p>";
        return;
      }

   


      data.forEach((schedule) => {
        const row = document.createElement("tr");
        // Create cells with input fields
        const startTimeCell = createInputCell("time", schedule.Start_time);
        const endTimeCell = createInputCell("time", schedule.End_time);
        const dateCell = createDropdownCell(schedule.Date);
     
        // Actions cell
        const actionsCell = document.createElement("td");
        const updateBtn = document.createElement("button");
        const okBtn = document.createElement("button");
        const deleteBtn = document.createElement("button");
     
        // Only show the Update and Delete buttons if the user is a teacher
        if (userRole === 'teacher') {
            // Setup "Update" button 
            updateBtn.textContent = "Update";
            updateBtn.className = "update";
            updateBtn.onclick = () => {
              [startTimeCell, endTimeCell, dateCell].forEach((cell) => {
                const input = cell.querySelector("input, select");
                if (input) input.disabled = false;
              });
              updateBtn.style.display = "none";
              okBtn.style.display = "inline-block";
            };
     
            // Setup "OK" button
            okBtn.textContent = "OK";
            okBtn.className = "update";
            okBtn.style.display = "none";
            okBtn.onclick = () => {
              const updatedData = {
                Sch_id: schedule.Sch_id,
                Start_time: startTimeCell.querySelector("input").value,
                End_time: endTimeCell.querySelector("input").value,
                Date: dateCell.querySelector("select").value,
              };
     
              console.log(updatedData);
     
              fetch(`http://localhost/group_project_1.0/public/ClassShcedules/UpdateApi/${schedule.Sch_id}`, {
                method: "PUT",
                headers: {
                  "Content-Type": "application/json",
                },
                body: JSON.stringify(updatedData),
              })
                .then((response) => {
                  if (!response.ok) {
                    throw new Error(`Failed to update schedule: ${response.status}`);
                  }
                  return response.json();
                })
                .then((data) => {
                  console.log("Schedule updated successfully:", data);
                  [startTimeCell, endTimeCell, dateCell].forEach((cell) => {
                    const input = cell.querySelector("input, select");
                    if (input) input.disabled = true;
                  });
                  okBtn.style.display = "none";
                  updateBtn.style.display = "inline-block";
                })
                .catch((error) => {
                  console.error("Error updating schedule:", error);
                });
            };
     
            // Setup "Delete" button
            deleteBtn.textContent = "Delete";
            deleteBtn.className = "delete";
            deleteBtn.onclick = () => {
              if (confirm(`Are you sure you want to delete this schedule?`)) {
                fetch(`http://localhost/group_project_1.0/public/ClassShcedules/deleteSchedule/${schedule.Sch_id}`, {
                  method: "DELETE",
                  headers: {
                    "Content-Type": "application/json",
                  },
                })
                  .then((response) => {
                    if (!response.ok) {
                      throw new Error(`Failed to delete schedule: ${response.status}`);
                    }
                    console.log(`Schedule with ID ${schedule.Sch_id} deleted.`);
                    row.remove(); // Remove the row from the table
                  })
                  .catch((error) => {
                    console.error("Error deleting schedule:", error);
                  });
              }
            };
     
            // Append buttons to actions cell
            actionsCell.appendChild(updateBtn);
            actionsCell.appendChild(okBtn);
            actionsCell.appendChild(deleteBtn);
        }
     
        // Append all cells to the row
        row.appendChild(startTimeCell);
        row.appendChild(endTimeCell);
        row.appendChild(dateCell);
        row.appendChild(actionsCell);
     
        // Append row to the table
        container.appendChild(row);
     });
    })
    .catch((error) => {
      console.error("Error fetching schedules:", error);
    });
});

// Utility function to create input cells
function createInputCell(type, value) {
  const cell = document.createElement("td");
  const input = document.createElement("input");
  input.type = type;
  input.value = value;
  input.disabled = true;
  cell.appendChild(input);
  return cell;
}

// Utility function to create dropdown cells
function createDropdownCell(selectedValue) {
  const cell = document.createElement("td");
  const select = document.createElement("select");

  const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
  days.forEach((day) => {
    const option = document.createElement("option");
    option.value = day;
    option.textContent = day;
    if (day === selectedValue) option.selected = true;
    select.appendChild(option);
  });

  select.disabled = true;
  cell.appendChild(select);
  return cell;
}


// Utility function to create editable cells
function createEditableCell(content) {
  const cell = document.createElement("td");
  cell.textContent = content;
  cell.contentEditable = "false"; // Disable editing by default
  return cell;
}

//create shcedule
document.getElementById("scheduleForm").addEventListener("submit", function (event) {
  event.preventDefault();
  createSchedule(event, classId);
});

// Function to show the form popup
function openForm() {
  document.getElementById("scheduleFormPopup").style.display = "block";
}

// Function to hide the form popup
function closeForm() {
  document.getElementById("scheduleFormPopup").style.display = "none";
}

async function createSchedule(event, classId) {
  console.log("createSchedule called with class id:", classId);
  
  // Access form data
  const form = event.target;
  const formData = new FormData(form);

  // Prepare data object for submission
  const data = {
    Start_time: formData.get("start_time"),
    End_time: formData.get("end_time"),
    Date: formData.get("day_of_week"),
  };

  console.log("Sending data:", data); // Check the data before sending

  // Sending the data via fetch to the API
  try {
    const response = await fetch(
      `http://localhost/group_project_1.0/public/ClassShcedules/createScheduleAPI/${classId}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      }
    );

    const contentType = response.headers.get("content-type");

    if (!response.ok) {
      const errorText = await response.text();
      console.error("Server response:", errorText);
      throw new Error(`HTTP error! Status: ${response.status}, Body: ${errorText}`);
    }

    if (contentType && contentType.includes("application/json")) {
      const data = await response.json();
      console.log("Schedule submitted successfully:", data);
      alert("Schedule created successfully!");
      window.location.href = "http://localhost/group_project_1.0/public/ClassShcedules";
    } else {
      const text = await response.text();
      console.warn("Unexpected response format:", text);
      alert("Unexpected response format received.");
    }
  } catch (error) {
    console.error("Error submitting schedule:", error);
    alert("There was an error submitting the schedule. Please try again.");
  }
}
