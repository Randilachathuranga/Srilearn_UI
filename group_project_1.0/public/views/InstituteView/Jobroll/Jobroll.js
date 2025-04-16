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
              <button class="change-state-btn" onclick="createJobroll(${jobroll.Jr_id})">Create jobroll</button>
  
              <div class="jobroll-subject"><strong>Subject:</strong> ${jobroll.Subject}</div>
              <div class="jobroll-date"><strong>Application Date:</strong> ${jobroll.application_date}</div>
              <div class="jobroll-status"><strong>Status:</strong> ${jobroll.Status}</div>
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
        container.innerHTML = "<p>Error loading jobrolls.</p>";
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
            alert("Jobroll deleted successfully.");
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
          container.innerHTML = ""; // Clear existing
          
          if (!data || data.length === 0) {
            container.innerHTML = "<p>No applications found.</p>";
          } else {
            data.forEach((app) => {
              const div = document.createElement("div");
              div.innerHTML = `
                  <p><strong>Applicant Name:</strong> ${app.Full_name || "N/A"}</p>
                  <p><strong>Applied Date:</strong> ${app.Date || "N/A"}</p>
                  <p><strong>Email:</strong> ${app.Email || "N/A"}</p>
                  <p><strong>Mobile:</strong> ${app.Phone_number || "N/A"}</p>
                  <p><strong>Qualifications:</strong> ${app.Qualifications || "N/A"}</p>
                  <p><strong>Status:</strong> ${
                    app.stateis === 0
                      ? `<button onclick="acceptApplication(${app.Application_id})">Accept</button>
                         <button onclick="rejectApplication(${app.Application_id})">Reject</button>`
                      : app.stateis === 1
                      ? "Accepted"
                      : "Rejected"
                  }</p>
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
  