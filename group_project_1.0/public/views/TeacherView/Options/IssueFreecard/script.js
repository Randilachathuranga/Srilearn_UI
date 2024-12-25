const classId = sessionStorage.getItem("class_id");
console.log("Retrieved Class ID from sessionStorage:", classId);

// Fetch students for the class to populate the filter dropdown
fetch(`http://localhost/group_project_1.0/public/FreeCard/viewAPI/${classId}`)
  .then((response) => response.json())
  .then((data) => {
    const studentIdFilter = document.getElementById("studentIdFilter");

    // Assuming 'data' contains an array of students for the specific class
    data.forEach(student => {
      // Only add students where Isdiscountavail == 0
      if (student.Isdiscountavail === 0) {
        const option = document.createElement("option");
        option.value = student.Stu_id;
        option.textContent = student.Stu_id;  // Or any other information you'd like to show (e.g., name)
        studentIdFilter.appendChild(option);
      }
    });

    // Enable the filter and button after fetching
    studentIdFilter.disabled = false;
    document.getElementById("issueCardBtn").disabled = false;
  })
  .catch((error) => {
    console.error("Error fetching students for the class:", error);
  });




  // Handle button click for issuing a free card
  function handleIssueCard() {
    const studentIdFilter = document.getElementById("studentIdFilter");
    const selectedStudentId = studentIdFilter.value;
  
    if (selectedStudentId) {
      if (confirm("Are you sure you want to add this student to the free card list?")) {
        fetch(`http://localhost/group_project_1.0/public/FreeCard/Createfreecard/${selectedStudentId}`, {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ classId }),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Failed to issue free card.");
            }
            console.log(`Free card issued for Student ID ${selectedStudentId}.`);
            window.location.href = "http://localhost/group_project_1.0/public/FreeCard";
          })
          .catch((error) => {
            alert("Error issuing free card: " + error.message);
          });
      }
    } else {
      alert("Please select a student ID.");
    }
  }

  // Handle delete function
  function handleDeleteCard(StudentId) {
    if (StudentId) {
        fetch(`http://localhost/group_project_1.0/public/FreeCard/Deletefreecard/${StudentId}`, {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ classId }),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Failed to issue free card.");
            }
            console.log(`Free card issued for Student ID ${StudentId}.`);
            window.location.href = "http://localhost/group_project_1.0/public/FreeCard";
          })
          .catch((error) => {
            alert("Error issuing free card: " + error.message);
          });
    } else {
      alert("Please select a student ID.");
    }
  }





// Fetch issued free cards for the class
document.addEventListener("DOMContentLoaded", () => {
  fetch(`http://localhost/group_project_1.0/public/FreeCard/viewAPI/${classId}`)
    .then((response) => {
      if (!response.ok) {
        if (response.status === 404) {
          console.error("No free cards found for this class.");
          return [];
        }
        throw new Error("An unexpected error occurred.");
      }
      return response.json();
    })
    .then((data) => {
      const issuedCardsTable = document.getElementById("issuedCardsTable");
      if (!issuedCardsTable) {
        console.error("Table body element with ID 'issuedCardsTable' not found.");
        return;
      }

      // Clear previous rows
      issuedCardsTable.innerHTML = "";

      if (!data || data.length === 0) {
        issuedCardsTable.innerHTML = "<p>No free cards found for this class.</p>";
        return;
      }

      data.forEach((freecard_list) => {
        if (freecard_list.Isdiscountavail == 1) {
          const row = document.createElement("tr");

          // Create table cells for Class ID, Student ID, and Issued Date
          const Stu_id = createInputCell("text", freecard_list.Stu_id);
          const Class_id = createInputCell("text", freecard_list.F_name + " " +freecard_list.L_name);
          const Issue_date = createInputCell("text", freecard_list.Date);

          // Append cells to row
          row.appendChild(Stu_id);
          row.appendChild(Class_id);
          row.appendChild(Issue_date);

          // If the user is a teacher, show a delete button
          if (userRole === 'teacher') {
            const deleteBtn = document.createElement("button");
            deleteBtn.textContent = "Delete";
            deleteBtn.className = "delete";
            deleteBtn.onclick = () => {
              if (confirm("Are you sure you want to delete this free card?")) {
                handleDeleteCard(freecard_list.Stu_id);
              }
            };
            row.appendChild(deleteBtn);
          }

          // Append row to the table
          issuedCardsTable.appendChild(row);
        }
      });
    })
    .catch((error) => {
      console.error("Error fetching free cards:", error);
    });
});

// Helper function to create input cells
function createInputCell(type, value) {
  const cell = document.createElement("td");
  const input = document.createElement("input");
  input.type = type;
  input.value = value;
  input.disabled = true;
  cell.appendChild(input);
  return cell;
}
