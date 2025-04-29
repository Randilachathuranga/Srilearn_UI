const classId = sessionStorage.getItem("class_id");
const Rolee = sessionStorage.getItem("Rolee");
console.log("Retrieved Class ID from sessionStorage:", classId);
console.log("Retrieved Class ID from sessionStorage:", Rolee);


let allStudentsData = []; // Store all students data globally
async function hasteachsubbed(classId) {
  return fetch(
    `http://localhost/group_project_1.0/public/Subscriptions/hassubbedteachpayment/${classId}`,
    {
      method: "POST",
      headers: { "Content-Type": "application/json" },
    }
  )
    .then((response) => {
      if (!response.ok) throw new Error("Failed to send message");
      return response.json();
    })
    .then((data) => data)
    .catch((error) => {
      console.error("Error sending message:", error);
    });
}

async function hasinstsubbedc(classId) {
  return fetch(
    `http://localhost/group_project_1.0/public/Subscriptions/hassubbedinst/${classId}`,
    {
      method: "POST",
      headers: { "Content-Type": "application/json" },
    }
  )
    .then((response) => {
      if (!response.ok) throw new Error("Failed to send message");
      return response.json();
    })
    .then((data) => data)
    .catch((error) => {
      console.error("Error sending message:", error);
    });
}

document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("searchInput");
  const searchButton = document.getElementById("searchButton");

  fetch(
    `http://localhost/group_project_1.0/public/ClassStudents/viewstudents/${classId}`
  )
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
    .then(async (data) => {
      allStudentsData = data; // Store all data
      if ((data[0].Type === "Individual")&& (Rolee=='teacher')) {
        if (await hasteachsubbed(classId)) {
          document.getElementById("chatHeader").style.display = "table-cell";
        }
      } else if ((data[0].Type === "Institute")&&(Rolee=='teacher')) {
        if (await hasinstsubbedc(classId)) {
          document.getElementById("chatHeader").style.display = "table-cell";
        }
      }
      renderStudentsTable(data);
    })
    .catch((error) => {
      console.error("Error fetching students:", error);
      updateTableMessage("No students found for this class.");
    });

  // Live search functionality
  searchInput.addEventListener("input", () => {
    const searchTerm = searchInput.value.toLowerCase().trim();
    filterStudents(searchTerm);
  });
});

async function renderStudentsTable(students) {
  const studentsTableBody = document.getElementById("studentsTableBody");

  if (!studentsTableBody) {
    console.error("Table body element not found.");
    return;
  }

  // Clear previous rows
  studentsTableBody.innerHTML = "";

  if (!students || students.length === 0) {
    updateTableMessage("No students found for this class.");
    return;
  }

  for (const student of students) {
    const row = document.createElement("tr");

    // Create cells for each student detail
    const cellData = [
      student.Stu_id,
      `${student.F_name} ${student.L_name}`,
      student.Email,
      student.District,
      student.Phone_number,
      student.Address,
    ];

    cellData.forEach((data) => {
      const cell = document.createElement("td");
      cell.textContent = data;
      row.appendChild(cell);
    });

    // Create "Remove" button cell
    const removeCell = document.createElement("td");
    const removeButton = document.createElement("button");
    removeButton.textContent = "Remove";
    removeButton.className = "btn-danger";
    removeButton.addEventListener("click", function () {
      showReasonPopup(student.Enrollment_id);
    });
    removeCell.appendChild(removeButton);
    row.appendChild(removeCell);

    // Check subscription status
    let substatus = false;
    if (student.Type === "Individual") {
      substatus = await hasteachsubbed(classId);
    } else {
      substatus = await hasinstsubbedc(classId);
    }

    // Conditionally add chat button if subbed
    if (substatus && (Rolee=='teacher')) {
      const chatCell = document.createElement("td");
      const chatButton = document.createElement("button");
      chatButton.textContent = "Send Message";
      chatButton.className = "btn-chat";
      chatButton.addEventListener("click", function () {
        chatredirect(student.Stu_id);
      });
      chatCell.appendChild(chatButton);
      row.appendChild(chatCell);
    }

    studentsTableBody.appendChild(row);
  }
}

function chatredirect(reciever_id) {
  window.location.href = `Chat/mychat/${reciever_id}`;
}

function filterStudents(searchTerm) {
  const filteredStudents = allStudentsData.filter((student) =>
    `${student.F_name} ${student.L_name}`.toLowerCase().includes(searchTerm)
  );

  renderStudentsTable(filteredStudents);
}

function updateTableMessage(message) {
  const studentsTableBody = document.getElementById("studentsTableBody");
  if (studentsTableBody) {
    studentsTableBody.innerHTML = `
            <tr>
                <td colspan="6" class="no-data">${message}</td>
            </tr>
        `;
  }
}

let studentToRemoveId = null;

function showReasonPopup(studentId) {
  studentToRemoveId = studentId;
  document.getElementById("removalReason").value = "";
  document.getElementById("reasonPopup").style.display = "flex";
}

function closePopup() {
  studentToRemoveId = null;
  document.getElementById("reasonPopup").style.display = "none";
}

function submitRemoval() {
  const Reason = document.getElementById("removalReason").value.trim();
  if (!Reason) {
    alert("Please provide a reason for removal.");
    return;
  }

  console.log(`Reason for removal of ID ${studentToRemoveId}:`, Reason);
  removeStudent(studentToRemoveId, Reason);
  closePopup();
}

function showdeletedstd() {
  window.location.href = `http://localhost/group_project_1.0/public/Enrollment/deletedstudents/${classId}`;
}

function removeStudent(id, Reason) {
  if (!confirm("Are you sure you want to remove this studnet?")) return;

  console.log("Removing student with ID:", id, Reason);
  const date = new Date()

  fetch(
    `http://localhost/group_project_1.0/public/Enrollment/mydeleteapi/${id}`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ Reason, Rem_Date: date }),
    }
  )
    .then(() => {
      location.reload();
    })
    .catch((error) => {
      console.error("Error deleting record:", error);
    });
}
