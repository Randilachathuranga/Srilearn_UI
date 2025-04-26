const classId = sessionStorage.getItem("class_id");
console.log("Retrieved Class ID from sessionStorage:", classId);
const role = document.getElementById("user_role").value;
console.log("Role:", role);

document.addEventListener("DOMContentLoaded", () => {
  function loadAssignments() {
    fetch(
      `http://localhost/group_project_1.0/public/AssignmentController/AllAssignments/${classId}`
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
        if (!assignmentsContainer) {
          console.error("assignmentsContainer element not found in DOM");
          return;
        }

        assignmentsContainer.innerHTML = "";

        // Group assignments by Ass_id
        const uniqueAssignments = Array.from(
          new Map(assignments.map((item) => [item.Ass_id, item])).values()
        );

        uniqueAssignments.sort((a, b) => a.Ass_id - b.Ass_id);

        uniqueAssignments.forEach((assignment) => {
          const card = document.createElement("div");
          card.classList.add("assignment-card");

          const submissions = assignments.filter(
            (a) => a.Ass_id === assignment.Ass_id
          );
          const submissionCount = submissions.length;

            card.innerHTML = `
            <div class="assignment-number">${assignment.Ass_name}</div>
            <div class="card-buttons">
              ${role === "teacher" ? `
              <button class="view-btn" data-assignment-id="${assignment.Ass_id}">View</button>
              <button class="delete-btn" data-assignment-id="${assignment.Ass_id}">Delete</button>
              <div class="search-section">
                <input type="number" class="STU_id" id="STU_id_${assignment.Ass_id}" placeholder="Student ID" />
                <button class="search-btn" data-assignment-id="${assignment.Ass_id}">Search</button>
              </div>
              ` : role === "student" ? `
              <div class="search-section">
                <button class="search-btn" data-assignment-id="${assignment.Ass_id}">View Marks</button>
              </div>
              ` : ""}
              <div id="result_${assignment.Ass_id}" class="result-container"></div>
            </div>`;

          assignmentsContainer.appendChild(card);
        });

        // Add event listeners
        document.querySelectorAll(".view-btn").forEach((btn) => {
          btn.addEventListener("click", (event) => {
            const assignmentId =
              event.target.getAttribute("data-assignment-id");
            viewAssignment(assignmentId);
          });
        });

        document.querySelectorAll(".delete-btn").forEach((btn) => {
          btn.addEventListener("click", (event) => {
            const assignmentId =
              event.target.getAttribute("data-assignment-id");
            deleteAssignment(assignmentId);
          });
        });

        document.querySelectorAll(".search-btn").forEach((btn) => {
          btn.addEventListener("click", (event) => {
            const assignmentId =
              event.target.getAttribute("data-assignment-id");
            My_Marks(assignmentId);
          });
        });
      })
      .catch((error) => {
        console.error("Error loading assignments:", error);
        showAlert(error.message, "error");
      });
  }

  // View Assignment Function
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
          <h2>Student Marks</h2>
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

  // Enable Edit Function
  window.enableEdit = function (Stu_id, Ass_id) {
    const marksCell = document.getElementById(`marks_${Stu_id}`);
    const currentMarks = marksCell.innerText;

    marksCell.innerHTML = `<input type="number" id="marksInput_${Stu_id}" value="${currentMarks}" style="width: 60px;">`;

    const updateBtn = document.getElementById(`updateBtn_${Stu_id}`);
    updateBtn.innerText = "OK";
    updateBtn.onclick = function () {
      saveUpdatedMarks(Stu_id, Ass_id);
    };
  };

  // Save Updated Marks Function
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
          document.getElementById(`marks_${Stu_id}`).innerText = newMarks;

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

  // Delete Assignment Function
  window.deleteAssignment = function (Ass_id) {
    if (confirm("Are you sure you want to delete this assignment?")) {
      fetch(
        `http://localhost/group_project_1.0/public/AssignmentController/DeleteAssignment/${Ass_id}`,
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

  // Search Marks Function
  window.My_Marks = function (assId) {

    const result = document.getElementById(`result_${assId}`);

    let studentId;
    if (role === 'teacher') {
      studentId = document.getElementById(`STU_id_${assId}`).value;
    } else if (role === 'student') {
      studentId = user_id;
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
  };

  // Alert Function
  window.showAlert = function (message, type) {
    const alertContainer = document.getElementById("alertContainer");
    alertContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
    setTimeout(() => {
      alertContainer.innerHTML = "";
    }, 3000);
  };

  // Modal Close Event
  document.getElementById("modalClose").addEventListener("click", () => {
    document.getElementById("modal").style.display = "none";
  });

  // Initial load
  loadAssignments();
});

//create Ass

// JavaScript for creating the form
function Createform() {
  let allStudentsData = [];
  let assignment_name = "";

  // Create a table header
  const tableHeader = document.getElementById("tableHeader");
  if (tableHeader) {
    const headerRow = document.createElement("tr");
    const headers = ["Student ID", "Name", "Marks"];

    headers.forEach((headerText) => {
      const th = document.createElement("th");
      th.textContent = headerText;
      headerRow.appendChild(th);
    });

    tableHeader.appendChild(headerRow);
  }

  // Show modal function
  function showModal() {
    const modal = document.getElementById('assignmentModal');
    modal.style.display = 'block';
    // Center the modal when shown
    const modalContent = document.querySelector('.modal-content');
    modalContent.style.transform = 'translate(-50%, -50%)';
  }

  // Close modal function
  function closeModal() {
    const modal = document.getElementById('assignmentModal');
    modal.style.display = 'none';
  }

  // Add close modal event listener
  window.onclick = function(event) {
    const modal = document.getElementById('assignmentModal');
    if (event.target === modal) {
      closeModal();
    }
  }

  // Fetch the list of students for the class
  fetch(`http://localhost/group_project_1.0/public/ClassStudents/viewstudents/${classId}`)
    .then((response) => {
      if (!response.ok) {
        if (response.status === 404) {
          console.error("No students found for this class.");
          updateTableMessage("No students found for this class.");
          return [];
        }
        throw new Error("An unexpected error occurred.");
      }
      return response.json();
    })
    .then((data) => {
      allStudentsData = data;
      renderStudentsTable(data);
      showModal(); // Show modal after table is rendered
    })
    .catch((error) => {
      console.error("Error fetching students:", error);
    });

  // Render the students table with marks input
  function renderStudentsTable(students) {
    const studentsTableBody = document.getElementById("studentsTableBody");
    studentsTableBody.innerHTML = "";

    // Input for Assignment Name
    const assignmentNameRow = document.createElement("tr");
    const assignmentNameCell = document.createElement("td");
    assignmentNameCell.colSpan = 3;
    const assignmentNameInput = document.createElement("input");
    assignmentNameInput.type = "text";
    assignmentNameInput.className = "form-control mb-3";
    assignmentNameInput.id = "assignment_name";
    assignmentNameInput.placeholder = "Enter Assignment Name";
    assignmentNameCell.appendChild(assignmentNameInput);
    assignmentNameRow.appendChild(assignmentNameCell);
    studentsTableBody.appendChild(assignmentNameRow);

    // Create rows for students and their marks input
    students.forEach((student) => {
      const row = document.createElement("tr");

      const cellData = [student.Stu_id, `${student.F_name} ${student.L_name}`];
      cellData.forEach((data) => {
        const cell = document.createElement("td");
        cell.textContent = data;
        row.appendChild(cell);
      });

      const marksCell = document.createElement("td");
      const marksInput = document.createElement("input");
      marksInput.type = "number";
      marksInput.className = "form-control";
      marksInput.id = `marks_${student.Stu_id}`;
      marksInput.placeholder = "Enter Marks";
      marksCell.appendChild(marksInput);
      row.appendChild(marksCell);

      studentsTableBody.appendChild(row);
    });

    // Add the "Add Assignment" button
    const buttonRow = document.createElement("tr");
    const buttonCell = document.createElement("td");
    buttonCell.colSpan = 3;
    buttonCell.className = "text-center";

    const okButton = document.createElement("button");
    okButton.textContent = "Add Assignment";
    okButton.className = "btn btn-success mt-3";
    okButton.onclick = addAssignment;

    buttonCell.appendChild(okButton);
    buttonRow.appendChild(buttonCell);
    studentsTableBody.appendChild(buttonRow);
  }

  // Add the assignment with marks data
  async function addAssignment() {
    try {
      assignment_name = document.getElementById("assignment_name").value;

      if (!assignment_name) {
        alert("Please enter the assignment name.");
        return;
      }

      let marksData = [];

      allStudentsData.forEach((student) => {
        const marksInput = document.getElementById(`marks_${student.Stu_id}`);
        if (marksInput) {
          marksData.push({
            Stu_id: student.Stu_id,
            Name: `${student.F_name} ${student.L_name}`,
            Marks: marksInput.value || 0,
          });
        }
      });

      const response = await fetch(
        `http://localhost/group_project_1.0/public/AssignmentController/createASS/${classId}`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({ Marks: marksData, Ass_name: assignment_name }),
        }
      );

      const responseData = await response.json();

      if (!responseData.success) {
        throw new Error(responseData.error || "Failed to add assignment");
      }

      alert("Assignment created successfully!");
      closeModal();
      window.location.href = "http://localhost/group_project_1.0/public/AssignmentController";
    } catch (error) {
      console.error("Error adding assignment:", error);
      alert(error.message || "Failed to add assignment. Please try again.");
    }
  }



  function updateTableMessage(message) {
    const studentsTableBody = document.getElementById("studentsTableBody");
    if (studentsTableBody) {
      studentsTableBody.innerHTML = `
              <tr>
                  <td colspan="3" class="no-data">${message}</td>
              </tr>
          `;
    }
  }
}


function back(){
  document.getElementById('assignmentModal').style.display = "none";
}

