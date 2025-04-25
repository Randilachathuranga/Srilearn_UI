document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("all_jobrolls");

  console.log(Inst_id);
  fetch(
    `http://localhost/group_project_1.0/public/Jobrollcontroller/viewallsubjects/${Inst_id}`
  )
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      if (!data || data.length === 0) {
        container.innerHTML = "<p>No jobrolls found.</p>";
        return;
      }

      data.forEach((jobroll) => {
        const row = document.createElement("div");
        row.classList.add("jobroll-row", jobroll.Status); // Add status as a class (e.g., Active / Inactive)
        row.innerHTML = `  
              <div class="jobroll-subject"><strong>Subject:</strong> ${jobroll.Subject}</div>
              <div class="jobroll-date"><strong>Application Date:</strong> ${jobroll.application_date}</div>
              <div class="jobroll-status"><strong>Status:</strong> ${jobroll.Status}</div>
              <div class="jobroll-discription"><strong>Description:</strong> ${jobroll.description}</div>
              <div class="jobroll-actions">
                  <button class="view-applications-btn" onclick="viewApplications(${Inst_id},'${jobroll.Subject}')">View Applications</button>
                  <button class="delete-jobroll-btn" onclick="deleteJobroll(${jobroll.Jr_id})">Delete Jobroll</button>
                  <button class="change-state-btn" onclick="changeState(${jobroll.Jr_id})">Change State</button>
              </div>
            `;

        container.appendChild(row);
      });
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
      container.innerHTML = "<p>No jobroll found</p>";
    });
});

function changeState(jobrollId) {
  if (confirm("Are you sure you want to Change this jobroll state?")) {
    fetch(
      `http://localhost/group_project_1.0/public/Jobrollcontroller/Active_inactive/${jobrollId}`
    )
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          alert("Jobroll state changed successfully.");
          location.reload(); // Reload the page to see the changes
        } else {
          alert("Failed to change jobroll state.");
        }
      });
  }
  window.location.href =
    "http://localhost/group_project_1.0/public/Jobrollcontroller";
}

function deleteJobroll(jobrollId) {
  if (confirm("Are you sure you want to delete this jobroll?")) {
    fetch(
      `http://localhost/group_project_1.0/public/Jobrollcontroller/deleteJobroll/${jobrollId}`,
      {
        method: "DELETE",
      }
    )
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          location.reload(); // Refresh to show updated list
        } else if (data.error) {
          alert("Delete failed: " + data.error);
        } else {
          alert("Unexpected response.");
        }
      })
      .catch((error) => {
        console.error("Error deleting jobroll:", error);
        alert("Error deleting jobroll.");
      });
  }
}

function viewApplications(instId, subject) {
  console.log(subject);
  const container = document.getElementById("applications");
  container.innerHTML = "Loading...";

  fetch(
    `http://localhost/group_project_1.0/public/Jobrollcontroller/viewapplications/${instId}/${subject}`
  )
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      container.innerHTML = ""; // Clear existing content

      if (!data || data.length === 0) {
        container.innerHTML = "<p>No applications found.</p>";
      } else {
        data.forEach((app) => {
          const div = document.createElement("div");
          let statusHtml = "";

          // Determine the status and actions
          if (app.stateis === 0) {
            statusHtml = `
              <button onclick="acceptApplication(${app.ID},${app.Teacher_id})">Accept</button>
              <button onclick="rejectApplication(${app.ID})">Reject</button>
            `;
          } else if (app.stateis === 1) {
            statusHtml = `
              Accepted 
            `;
          } else if (app.stateis === 2) {
            statusHtml = `
              Rejected 
              <button onclick="acceptApplication(${app.ID},${app.Teacher_id})">Accept</button>
            `;
          } else {
            statusHtml = "Unknown";
          }

          // Populate the application details
          div.innerHTML = `
            <p><strong>Applicant Name:</strong> ${app.Full_name || "N/A"}</p>
            <p><strong>Applied Date:</strong> ${app.Date || "N/A"}</p>
            <p><strong>Email:</strong> ${app.Email || "N/A"}</p>
            <p><strong>Mobile:</strong> ${app.Phone_number || "N/A"}</p>
            <p><strong>Qualifications:</strong> ${
              app.Qualifications || "N/A"
            }</p>
            <p><strong>Status:</strong> ${statusHtml}</p>
            <hr/>
          `;
          container.appendChild(div);
        });
      }

      document.getElementById("applicationPopup").style.display = "block";
    })
    .catch((error) => {
      console.error("Error loading applications:", error);
      container.innerHTML = "<p>Error loading applications.</p>";
      alert("No applications found");
    });
}
function closePopup() {
  document.getElementById("applicationPopup").style.display = "none";
}

function rejectApplication(id) {
  if (confirm("Are you sure you want to reject this application?")) {
    fetch(
      `http://localhost/group_project_1.0/public/Jobrollcontroller/rejectteachers/${id}`,
      {
        method: "PUT",
      }
    )
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        window.location.reload();
        return response.json();
      })
      .catch((error) => {
        console.error("Error rejecting application:", error);
        alert("An error occurred while rejecting the application.");
      });
  }
}

function openAddJobrollPopup() {
  document.getElementById("addJobrollPopup").style.display = "block";
}

function closeAddJobrollPopup() {
  document.getElementById("addJobrollPopup").style.display = "none";
}

document
  .getElementById("addJobrollForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    const title = document.getElementById("jobrollTitle").value;
    const description = document.getElementById("jobrollDescription").value;
    const date = document.getElementById("Current_date").value;

    $data = {
      Subject: title,
      application_date: date,
      description: description,
    };

    console.log("dad", $data);
    fetch(
      `http://localhost/group_project_1.0/public/Jobrollcontroller/createjobroll/${Inst_id}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify($data),
      }
    )
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Jobroll added successfully!");
          window.location.href =
            "http://localhost/group_project_1.0/public/Jobrollcontroller";
        } else {
          alert("Failed to add jobroll.");
          window.reload();
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        window.location.href =
          "http://localhost/group_project_1.0/public/Jobrollcontroller";
      });
  });

function acceptApplication(id, Teacher_id) {
  if (confirm("Are you sure you want to accept this application?")) {

    fetch(`http://localhost/group_project_1.0/public/Normalteacher_Controller/isalreadyin/${Teacher_id}/${Inst_id}`)
      .then((response) => response.json())
      .then((data) => {
        if (data && data.length > 0) {
          alert("This teacher is already joined for this institute");
          window.location.href =
          "http://localhost/group_project_1.0/public/Jobrollcontroller";
        } else {
          fetch(
            `http://localhost/group_project_1.0/public/Jobrollcontroller/reqruitteachers/${id}/${Teacher_id}/${Inst_id}`,
            {
              method: "PUT",
            }
          )
            .then((response) => {
              if (!response.ok) throw new Error("Network response was not ok");
              window.location.reload();
              return response.json();
            })
            .catch((error) => {
              console.error("Error accepting application:", error);
              alert("An error occurred while accepting the application.");
            });
        }
      })
      .catch((error) => {
        console.error("Error fetching institute data:", error);
        alert("An error occurred while fetching institute data.");
      });
  }
}
