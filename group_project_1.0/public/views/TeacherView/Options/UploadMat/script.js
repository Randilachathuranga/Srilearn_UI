const classId = sessionStorage.getItem("class_id");

// Form handling functions
function showUploadForm() {
  document.getElementById("uploadForm").style.display = "block";
  document.getElementById("overlay").style.display = "block"; //background blur
}

function hideUploadForm() {
  document.getElementById("uploadForm").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

// Modified this function to accept individual properties rather than a complete object
function showUpdateForm(matId, topic, subTopic, description) {
  const updateForm = document.getElementById("updateForm");
  document.getElementById("overlay").style.display = "block"; //background blur
  updateForm.style.display = "block";

  // Populate form with existing data
  document.getElementById("update_mat_id").value = matId;
  document.getElementById("update_topic").value = topic;
  document.getElementById("update_sub_topic").value = subTopic;
  document.getElementById("update_Description").value = description;
}

function hideUpdateForm() {
  document.getElementById("updateForm").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function hideOverlay() {
  document.getElementById("overlay").style.display = "none";
  hideUploadForm();
  hideUpdateForm();
}

// API functions
async function fetchMaterials() {
  try {
    const response = await fetch(
      `http://localhost/group_project_1.0/public/Learning_mat/viewMat/${classId}`
    );
    if (!response.ok) {
      if (response.status === 404) {
        console.error("No materials found for this class.");
        return [];
      }
      throw new Error("An unexpected error occurred.");
    }
    const data = await response.json();
    return Array.isArray(data) ? data : [];
  } catch (error) {
    console.error("Error while fetching materials:", error);
    return [];
  }
}

async function deleteMaterial(matId) {
  try {
    const response = await fetch(
      `http://localhost/group_project_1.0/public/Learning_mat/deleteMat/${matId}`,
      {
        method: "DELETE",
      }
    );
    const data = await response.json();

    if (data.message) {
      alert(data.message);
      window.location.href =
        "http://localhost/group_project_1.0/public/Learning_mat";
    } else {
      throw new Error(data.error || "Unexpected response from server");
    }
  } catch (error) {
    console.error("Error while deleting material:", error);
    alert("An error occurred while deleting the material. Please try again.");
  }
}



// Direct DOM manipulation functions without templates
function displayMaterials() {
  if (Role == 'teacher') {
    const container = document.getElementById("materialsList");
    container.innerHTML = ""; // Clear previous content

    fetchMaterials().then((materials) => {
      if (materials.length === 0) {
        container.innerHTML = "<p>No materials found for this class.</p>";
        return;
      }

      const groupedMaterials = materials.reduce((acc, material) => {
        acc[material.topic] = acc[material.topic] || [];
        acc[material.topic].push(material);
        return acc;
      }, {});

      container.innerHTML = Object.entries(groupedMaterials)
        .map(
          ([topic, materials]) => `
            <div class="topic-section">
              <h2>${topic}</h2>
              <div class="materials-container">
                ${materials
                  .map(
                    (material) => `
                      <div class="material-item">
                        <p>Sub-topic: ${material.sub_topic}</p>
                        <p>Description: ${material.Description}</p>
                        <p>Date: ${material.Date}</p>
                        <a href="${material.Url}" target="_blank">Download PDF</a>
                        ${
                          document.getElementById("user_role").value === "teacher"
                            ? `
                              <button class="delete-btn" onclick="deleteMaterial(${
                                material.Mat_id
                              })">Delete</button>
                              <button class="update-btn" onclick="showUpdateForm(${
                                material.Mat_id
                              }, '${material.topic}', '${
                                material.sub_topic
                              }', '${material.Description.replace(
                                /'/g,
                                "\\'"
                              )}')">Update</button>
                            `
                            : ""
                        }
                      </div>
                    `
                  )
                  .join("")}
              </div>
            </div>
          `
        )
        .join("");
    });
  } else if (Role == 'student') {
    // First, check enrollment date
    fetch(`http://localhost/group_project_1.0/public/Learning_mat/checkenrolldate/${User_id}/${classId}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((enrollmentData) => {
        console.log("Enrollment data:", enrollmentData);
        
        // Then, check request status
        return fetch(`http://localhost/group_project_1.0/public/Learning_mat/viewrequest/${User_id}/${classId}`)
          .then((response) => {
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
          })
          .then((requestData) => {
            console.log("Request data:", requestData);
            
            return fetchMaterials().then((materials) => {
              const filteredMaterials = materials.filter((material) => {
                return (enrollmentData.length > 0 && new Date(enrollmentData[0].Date) < new Date(material.Date)) || 
                       (requestData && requestData.length > 0 && requestData[0].Status === 1);
              });

              const container = document.getElementById("materialsList");
              container.innerHTML = ""; // Clear previous content

              if (filteredMaterials.length === 0) {
                container.innerHTML = "<p>No materials available for you.</p>";
                return;
              }

              const groupedMaterials = filteredMaterials.reduce((acc, material) => {
                acc[material.topic] = acc[material.topic] || [];
                acc[material.topic].push(material);
                return acc;
              }, {});

              container.innerHTML = Object.entries(groupedMaterials)
                .map(
                  ([topic, materials]) => `
                    <div class="topic-section">
                      <h2>${topic}</h2>
                      <div class="materials-container">
                        ${materials
                          .map(
                            (material) => `
                              <div class="material-item">
                                <p>Sub-topic: ${material.sub_topic}</p>
                                <p>Description: ${material.Description}</p>
                                <p>Date: ${material.Date}</p>
                                <a href="${material.Url}" target="_blank">Download PDF</a>
                              </div>
                            `
                          )
                          .join("")}
                      </div>
                    </div>
                  `
                )
                .join("");
            });
          });
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred: " + error.message);
      });
  }
}



// Form submission handling
document.addEventListener("DOMContentLoaded", () => {
  displayMaterials();

  // Upload form handling
  const uploadForm = document.getElementById("uploadForm");
  if (uploadForm) {
    uploadForm.addEventListener("submit", async (event) => {
      event.preventDefault();
      const formData = new FormData(uploadForm);

      try {
        const response = await fetch(
          `http://localhost/group_project_1.0/public/Learning_mat/insertLearningMat/${classId}`,
          {
            method: "POST",
            body: formData,
          }
        );

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        if (result.message) {
          alert(result.message);
          hideUploadForm();
          window.location.href =
            "http://localhost/group_project_1.0/public/Learning_mat";
        } else {
          throw new Error(result.error || "Unexpected response from server");
        }
      } catch (error) {
        console.error("Error during form submission:", error);
        alert(
          "An error occurred while uploading the material. Please try again."
        );
      }
    });
  }

  // Update form handling
  const updateForm = document.getElementById("updateForm");
  if (updateForm) {
    updateForm.addEventListener("submit", async (event) => {
      event.preventDefault();
      const formData = new FormData(updateForm);
      const matId = document.getElementById("update_mat_id").value;

      try {
        const response = await fetch(
          `http://localhost/group_project_1.0/public/Learning_mat/updateMat/${matId}`,
          {
            method: "POST",
            body: formData,
          }
        );

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        if (result.message) {
          alert(result.message);
          hideUpdateForm();
          window.location.href =
            "http://localhost/group_project_1.0/public/Learning_mat";
        } else {
          throw new Error(result.error || "Unexpected response from server");
        }
      } catch (error) {
        console.error("Error during update:", error);
        alert(
          "An error occurred while updating the material. Please try again."
        );
      }
    });
  }
});


//request old materials
function request() {
  fetch(`http://localhost/group_project_1.0/public/Learning_mat/viewrequest/${User_id}/${classId}`)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      console.log("Request data:", data);
      
      // Check if data exists and has elements
      if ((data && data.length > 0 && data[0].Status === 0) || (data && data.length > 0 && data[0].Status === 1)) {
        alert("You have already requested old materials.");
      } else {
        return fetch(`http://localhost/group_project_1.0/public/Learning_mat/requestOldMat/${User_id}/${classId}`)
          .then((response) => {
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
          })
          .then((requestData) => {
            alert("Request for old materials was successful!");
            console.log("Response data:", requestData);
          });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An error occurred: " + error.message);
    });
}


function showRequests() {
  document.getElementById("overlay").style.display = "block";
  const popup = document.getElementById('requestPopup');
  const tableBody = document.getElementById('requestsTableBody');
  const noRequestsMessage = document.getElementById('noRequestsMessage');
  const errorMessage = document.getElementById('errorMessage');
  const requestsTable = document.getElementById('requestsTable');
  tableBody.innerHTML = '';
  noRequestsMessage.style.display = 'none';
  errorMessage.style.display = 'none';
  requestsTable.style.display = 'none';
  tableBody.innerHTML = `
    <tr><td colspan="3" style="text-align:center;">Loading...</td></tr>
  `;
  fetch(`http://localhost/group_project_1.0/public/Learning_mat/allrequests/${classId}`)
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then(requests => {
      console.log("Fetched Requests:", requests);
      tableBody.innerHTML = ''; // Clear loading message

      if (!Array.isArray(requests) || requests.length === 0) {
        noRequestsMessage.style.display = 'block';
      } else {
        requestsTable.style.display = 'table';

        requests.forEach(request => {
          const row = document.createElement('tr');

          const id = request.Stu_id;
          const Name = request.F_name + " " + request.L_name || 'Unknown';
          const status = request.Status === 0 ? 'Pending' : 'Approved';
          const request_id = request.ID;

          row.innerHTML = `
            <td>${id}</td>
            <td>${Name}</td>
            <td>
              <span class="status-badge status-${status.toLowerCase()}">${status}</span>
            </td>
            <td>
              ${status === 'Pending' ? `
                <button class="action-button approve-button" onclick="updateRequestStatus(${request_id})">Approve</button>
              ` : ''}
            </td>
          `;

          tableBody.appendChild(row);
        });
      }

      popup.style.display = "block";
    })
    .catch(error => {
      console.error("Error fetching requests:", error.message);
      console.log("Requested URL:", fetchURL);
      errorMessage.style.display = 'block';
      popup.style.display = "block";
    });
}



function closeRequestPopup() {
  document.getElementById('requestPopup').style.display = 'none';
  document.getElementById('overlay').style.display = 'none';
}



function updateRequestStatus(requestId) {
 if(confirm("Are you sure you want to approve this request?")) {
  fetch(`http://localhost/group_project_1.0/public/Learning_mat/acceptrequest/${requestId}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ status: status })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showRequests();
    } else {
      alert('Failed to update status: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred while updating the status');
  });
 }
}
