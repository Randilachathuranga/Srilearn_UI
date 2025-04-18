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
