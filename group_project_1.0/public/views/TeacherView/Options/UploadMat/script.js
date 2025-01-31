// Constants and utility functions
const API_BASE_URL = "http://localhost/group_project_1.0/public/Learning_mat";
const classId = sessionStorage.getItem("class_id");

// Templates
const topicTemplate = document.getElementById("topic-template");
const materialTemplate = document.getElementById("material-template");

// Form handling functions
function showUploadForm() {
  document.getElementById("uploadForm").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}

function hideUploadForm() {
  document.getElementById("uploadForm").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function showUpdateForm(material) {
  const updateForm = document.getElementById("updateForm");
  document.getElementById("overlay").style.display = "block";
  updateForm.style.display = "block";

  // Populate form with existing data
  document.getElementById("update_mat_id").value = material.Mat_id;
  document.getElementById("update_topic").value = material.topic;
  document.getElementById("update_sub_topic").value = material.sub_topic;
  document.getElementById("update_Description").value = material.Description;
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
    const response = await fetch(`${API_BASE_URL}/viewMat/${classId}`);
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

async function deleteMat(matId) {
  try {
    const response = await fetch(`${API_BASE_URL}/deleteMat/${matId}`, {
      method: "DELETE",
    });
    const data = await response.json();

    if (data.message) {
      alert(data.message);
      window.location.href = API_BASE_URL;
    } else {
      throw new Error(data.error || "Unexpected response from server");
    }
  } catch (error) {
    console.error("Error while deleting material:", error);
    alert("An error occurred while deleting the material. Please try again.");
  }
}

// UI rendering functions
function renderMaterialItem(material) {
  const materialNode = materialTemplate.content.cloneNode(true);
  
  // Corrected role retrieval
  const Role = document.getElementById("user_role").value;

  materialNode.querySelector(".sub-topic").textContent = `Sub-topic: ${material.sub_topic}`;
  materialNode.querySelector(".description").textContent = `Description: ${material.Description}`;
  materialNode.querySelector(".date").textContent = `Date: ${material.Date}`;

  const downloadLink = materialNode.querySelector(".download-link");
  downloadLink.href = material.Url;
  downloadLink.textContent = "Download PDF";

  if (Role === "teacher") {
    const deleteBtn = materialNode.querySelector(".delete-btn");
    deleteBtn.onclick = () => deleteMat(material.Mat_id);

    const updateBtn = materialNode.querySelector(".update-btn");
    updateBtn.onclick = () => showUpdateForm(material);
  }

  return materialNode;
}

function renderTopicSection(topic, materials) {
  const topicNode = topicTemplate.content.cloneNode(true);

  topicNode.querySelector(".topic-title").textContent = topic;
  const materialsContainer = topicNode.querySelector(".materials-container");

  materials.forEach((material) => {
    materialsContainer.appendChild(renderMaterialItem(material));
  });

  return topicNode;
}

async function renderMaterialsList() {
  const container = document.getElementById("materialsList");
  container.innerHTML = ""; // Clear previous content

  const materials = await fetchMaterials();

  if (materials.length === 0) {
    container.innerHTML = "<p>No materials found for this class.</p>";
    return;
  }

  // Group materials by topic
  const groupedMaterials = materials.reduce((acc, material) => {
    (acc[material.topic] = acc[material.topic] || []).push(material);
    return acc;
  }, {});

  // Render each topic section
  Object.entries(groupedMaterials).forEach(([topic, materials]) => {
    container.appendChild(renderTopicSection(topic, materials));
  });
}

// Form submission handling
document.addEventListener("DOMContentLoaded", () => {
  renderMaterialsList();

  // Upload form handling
  const uploadForm = document.getElementById("uploadForm");
  if (uploadForm) {
    uploadForm.addEventListener("submit", async (event) => {
      event.preventDefault();
      const formData = new FormData(uploadForm);

      try {
        const response = await fetch(
          `${API_BASE_URL}/insertLearningMat/${classId}`,
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
          window.location.href = API_BASE_URL;
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
        const response = await fetch(`${API_BASE_URL}/updateMat/${matId}`, {
          method: "POST",
          body: formData,
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        if (result.message) {
          alert(result.message);
          hideUpdateForm();
          window.location.href = API_BASE_URL;
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
