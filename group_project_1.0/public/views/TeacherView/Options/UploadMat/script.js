// Retrieve Class ID from sessionStorage
const classId = sessionStorage.getItem("class_id");
console.log("Class ID:", classId);

document.addEventListener("DOMContentLoaded", () => {
  fetch(`http://localhost/group_project_1.0/public/Learning_mat/viewMat/${classId}`)
    .then((response) => {
      if (!response.ok) {
        if (response.status === 404) {
          console.error("No materials found for this class.");
          return [];
        }
        throw new Error("An unexpected error occurred.");
      }
      return response.json();
    })
    .then((data) => {
      console.log("Fetched data:", data); // Add this line
      if (!Array.isArray(data)) {
        throw new Error("Expected an array but got something else.");
      }

      const container = document.getElementById("materialsList");
      container.innerHTML = ""; // Clear previous rows

      if (data.length === 0) {
        container.innerHTML = "<p>No materials found for this class.</p>";
        return;
      }

      // Group materials by topic
      const groupedMaterials = {};
      data.forEach((material) => {
        if (!groupedMaterials[material.topic]) {
          groupedMaterials[material.topic] = [];
        }
        groupedMaterials[material.topic].push(material);
      });

      // Render materials grouped by topic
      for (const [topic, materials] of Object.entries(groupedMaterials)) {
        const topicDiv = document.createElement("div");
        topicDiv.className = "topic-section";

        const topicHeader = document.createElement("h2");
        topicHeader.textContent = topic;
        topicDiv.appendChild(topicHeader);

        materials.forEach((material) => {
          const materialDiv = document.createElement("div");
          materialDiv.className = "material-item";

          const subTopicEl = document.createElement("p");
          subTopicEl.textContent = `Sub-topic: ${material.sub_topic}`;
          materialDiv.appendChild(subTopicEl);

          const descriptionEl = document.createElement("p");
          descriptionEl.textContent = `Description: ${material.Description}`;
          materialDiv.appendChild(descriptionEl);

          const downloadLink = document.createElement("a");
          downloadLink.href = material.Url;
          console.log(material.Url);
          downloadLink.textContent = "Download PDF";
          downloadLink.target = "_blank"; // Open in a new tab if you want
          materialDiv.appendChild(downloadLink);

          const deleteBtn = document.createElement("button");
          deleteBtn.textContent = `Delete`;
          deleteBtn.onclick = function () {
            deleteMat(material.Mat_id);
          };
          materialDiv.appendChild(deleteBtn);

          topicDiv.appendChild(materialDiv);
        });

        container.appendChild(topicDiv);
      }
    })
    .catch((error) => {
      console.error("Error while fetching materials:", error);
    });
});


// upload pdf
const uploadForm = document.getElementById("uploadForm");
if (uploadForm) {
  uploadForm.addEventListener("submit", async function (event) {
    event.preventDefault(); 
    const formData = new FormData(uploadForm);
    try {
      const response = await fetch(`http://localhost/group_project_1.0/public/Learning_mat/insertLearningMat/${classId}`, {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const result = await response.json();
      if (result.message) {
        alert(result.message);
        hideUploadForm(); // Hide the form after successful submission
        window.location.href = "http://localhost/group_project_1.0/public/Learning_mat";
      } else if (result.error) {
        alert(`Error: ${result.error}`);
      } else {
        alert("Unexpected response from the server.");
      }
    } catch (error) {
      console.error("Error during form submission:", error);
      alert("An error occurred while uploading the material. Please try again.");
    }
  });
} else {
  console.error("Upload form element not found.");
}


// Show the upload form
function showUploadForm() {
  document.getElementById("uploadForm").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}

// Hide the upload form
function hideUploadForm() {
  document.getElementById("uploadForm").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}



function deleteMat(Mat_id){
  console.log(Mat_id);
  fetch(`http://localhost/group_project_1.0/public/Learning_mat/deleteMat/${Mat_id}`, {
    method: "DELETE",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("An unexpected error occurred.");
      }
      return response.json();
    })
    .then((data) => {
      console.log("Deleted data:", data);
      if (data.message) {
        alert(data.message);
        window.location.href = "http://localhost/group_project_1.0/public/Learning_mat";
      } else if (data.error) {
        alert(`Error: ${data.error}`);
      } else {
        alert("Unexpected response from the server.");
      }
    })
    .catch((error) => {
      console.error("Error while deleting material:", error);
      alert("An error occurred while deleting the material. Please try again.");
    });
}
