document.addEventListener("DOMContentLoaded", () => {
  const classId = sessionStorage.getItem("class_id");
  console.log("Retrieved Class ID from sessionStorage:", classId);

  function loadAssignments() {
    fetch(
      "http://localhost/group_project_1.0/public/AssignmentController/AllAssingments"
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            response.status === 404
              ? "No assignments found"
              : "An unexpected error occurred"
          );
        }
        return response.json();
      })
      .then((assignments) => {
        const assignmentsContainer = document.getElementById(
          "assignmentsContainer"
        );
        assignmentsContainer.innerHTML = "";

        // Modify the card creation in loadAssignments function
        assignments.forEach((assignment) => {
          const card = document.createElement("div");
          card.classList.add("assignment-card");

          card.innerHTML = `
      <div class="assignment-number">Assignment #${assignment.Ass_id}</div>
      <div class="card-buttons">
          <button class="view-btn" onclick="viewAssignment(${assignment.Ass_id})">View Assingment</button>
          <button class="delete-btn" onclick="deleteAssignment(${assignment.Ass_id})">Delete Assingment</button>
          <div class="search-section">
              <input type="number" class="STU_id" id="STU_id_${assignment.Ass_id}" 
                  placeholder="Enter Student ID" />
              <button class="search-btn" onclick="My_Marks(${assignment.Ass_id})">Search</button>
          </div>
          <div id="result_${assignment.Ass_id}" class="result-container"></div>
      </div>
  `;

          assignmentsContainer.appendChild(card);
        });
      })
      .catch((error) => {
        console.error("Error loading assignments:", error);
        showAlert(error.message, "error");
      });
  }

  //
  window.viewAssignment = function (Ass_id) {
    fetch(
      `http://localhost/group_project_1.0/public/AssignmentController/ViewAllStudentsMarks/${Ass_id}`
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            response.status === 404
              ? "No student marks found"
              : "An unexpected error occurred"
          );
        }
        return response.json();
      })
      .then((students) => {
        const modalContent = document.getElementById("modalContent");
        modalContent.innerHTML = `
              <h2>Assignment #${Ass_id} - Student Marks</h2>
              <table>
                <tr>
                  <th>Student ID</th>
                  <th>Name</th>
                  <th>Marks</th>
                  <th>Update Marks</th>
                </tr>
                ${students
                  .map(
                    (stu) => `
                  <tr>
                    <td>${stu.Stu_id}</td>
                    <td>${stu.Name}</td>
                    <td id="marks_${stu.Stu_id}">${stu.Marks}</td>
                    <td>
                      <button id="updateBtn_${stu.Stu_id}" onclick="enableEdit(${stu.Stu_id}, ${Ass_id})">
                        Update Marks
                      </button>
                    </td>
                  </tr>`
                  )
                  .join("")}
              </table>
            `;

        document.getElementById("modal").style.display = "block";
      })
      .catch((error) => {
        console.error("Error loading student marks:", error);
        showAlert(error.message, "error");
      });
  };

  // Function to enable editing
  window.enableEdit = function (Stu_id, Ass_id) {
    const marksCell = document.getElementById(`marks_${Stu_id}`);
    const currentMarks = marksCell.innerText;

    // Replace marks text with an input field
    marksCell.innerHTML = `<input type="number" id="marksInput_${Stu_id}" value="${currentMarks}" style="width: 60px;">`;

    // Change button to "OK"
    const updateBtn = document.getElementById(`updateBtn_${Stu_id}`);
    updateBtn.innerText = "OK";
    updateBtn.onclick = function () {
      saveUpdatedMarks(Stu_id, Ass_id);
    };
  };

  // Function to save updated marks
  window.saveUpdatedMarks = function (Stu_id, Ass_id) {
    const inputField = document.getElementById(`marksInput_${Stu_id}`);
    const newMarks = inputField.value;

    fetch(
      `http://localhost/group_project_1.0/public/AssignmentController/UpdateSTDmarks/${Stu_id}`,
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ Ass_id: Ass_id, Marks: newMarks }),
      }
    )
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          // Update the table cell with the new marks
          document.getElementById(`marks_${Stu_id}`).innerText = newMarks;

          // Change button back to "Update Marks"
          const updateBtn = document.getElementById(`updateBtn_${Stu_id}`);
          updateBtn.innerText = "Update Marks";
          updateBtn.onclick = function () {
            enableEdit(Stu_id, Ass_id);
          };

          showAlert("Marks updated successfully", "success");
        } else {
          showAlert("Failed to update marks", "error");
        }
      })
      .catch((error) => {
        console.error("Error updating marks:", error);
        showAlert("An error occurred while updating marks", "error");
      });
  };

  //

  window.deleteAssignment = function (Ass_id) {
    if (confirm("Are you sure you want to delete this assignment?")) {
      fetch(
        `http://localhost/group_project_1.0/public/AssignmentController/DeleteAssingment/${Ass_id}`,
        {
          method: "DELETE",
        }
      )
        .then((response) => response.json())
        .then((result) => {
          if (result.status === "success") {
            showAlert("Assignment deleted successfully", "success");
            loadAssignments();
          } else {
            showAlert("Failed to delete assignment", "error");
          }
        })
        .catch((error) => {
          console.error("Error deleting assignment:", error);
          showAlert("Failed to delete assignment", "error");
        });
    }
  };

  document.getElementById("modalClose").addEventListener("click", () => {
    document.getElementById("modal").style.display = "none";
  });

  loadAssignments();
});

// Correct the fetch function and the body of the request
function My_Marks(assId) {
  const studentId = document.getElementById(`STU_id_${assId}`).value;
  const result = document.getElementById(`result_${assId}`); // Add this line
  if (!studentId) {
    showAlert("Please enter a valid Student ID", "error");
    return;
  }
  fetch(
    `http://localhost/group_project_1.0/public/AssignmentController/MyMarks/${studentId}`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ assId: assId }),
    }
  )
    .then((response) => {
      if (!response.ok) {
        throw new Error(
          response.status === 404
            ? "No marks found for this student"
            : "An unexpected error occurred"
        );
      }
      return response.json();
    })
    .then((data) => {
      if (Array.isArray(data) && data.length > 0) {
        const student = data[0];
        // Update the result div with the marks
        result.innerHTML = `
              <div class="result-card">
                  <h3>Student Details</h3>
                  <p>Student ID: ${student.Stu_id}</p>
                  <p>Name: ${student.Name}</p>
                  <p>Marks: ${student.Marks}</p>
              </div>
          `;
        result.style.display = "block";
      } else {
        throw new Error("No marks found for this student");
      }
    })
    .catch((error) => {
      showAlert(error.message, "error");
      result.innerHTML = `<div class="error-message">${error.message}</div>`;
      result.style.display = "block";
    });
}

function closePopup() {
  window.location.href =
    "http://localhost/group_project_1.0/public/AssignmentController";
}

function showAlert(message, type) {
  const alertContainer = document.getElementById("alertContainer");
  alertContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
  setTimeout(() => {
    alertContainer.innerHTML = "";
  }, 3000);
}
