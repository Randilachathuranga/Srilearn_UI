document.addEventListener("DOMContentLoaded", () => {
  const P_id = 6; /* Your logic to get P_id, e.g., from localStorage or query params */

  fetch(`Ind_Myclass/MyclassApi/${P_id}`)
    .then((response) => {
      if (!response.ok) {
        if (response.status === 403) {
          throw new Error("Access denied. Not a premium teacher.");
        } else if (response.status === 404) {
          throw new Error("No classes found for the given teacher.");
        } else {
          throw new Error("An unexpected error occurred.");
        }
      }
      return response.json(); // Parse the response JSON
    })
    .then((data) => {
      const container = document.getElementById("class-container");
      if (!container) {
        console.error("Container element with ID 'class-container' not found.");
        return;
      }

      container.innerHTML = ""; // Clear any existing content
      if (!data || data.length === 0) {
        container.innerHTML = "<p>No classes found for this teacher.</p>";
        return;
      }
      data.forEach((classItem) => {
        const card = document.createElement("div");
        card.className = "card";

        const subjectImages = {
          Physics:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/science.png",
          Mathematics:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/Maths.png",
          English:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/English.png",
          Chemistry:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/science.png",
          History:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/History.png",
          IT: "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/It.png",
          Biology:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/Bio.png",

          // Add more subjects and their images as needed
        };
        const imageUrl =
          subjectImages[classItem.Subject] ||
          "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/defult.jpg";

        card.innerHTML = `
                    <div class="card-content">
                        <img src="${imageUrl}" alt="${classItem.title}">
                        <h3>${classItem.Subject} - ${classItem.Grade}</h3>
                        <p>Location: ${classItem.Location}</p>
                        <p>Start Time: ${classItem.Start_Time}</p>
                        <p>End Time: ${classItem.End_time}</p>
                        <button class="card-button" onclick="showDetails(${classItem.Class_id})">More Details</button>
                        <button class="button" onclick="editSchedule(${classItem.Class_id})">
                            <img src="../../../../../group_project_1.0/app/views/TeacherView/Myclass/icon/pencil.png" alt="Edit" class="icon"> Edit
                        </button>
                    </div>
                `;
        container.appendChild(card);
      });
    })
    .catch((error) => {
      const container = document.getElementById("class-container");
      if (container) {
        container.innerHTML = `<p class="error">${error.message}</p>`;
      }
      console.error("There was a problem with the fetch operation:", error);
    });
});


//More Details
function showDetails(Class_id) {
  fetch(`Ind_Myclass/MoredetailsApi/${Class_id}`) // Pass the correct Class_id to PHP for fetching details
    .then((response) => {
      if (!response.ok) {
        throw new Error("Failed to fetch class details");
      }
      return response.json();
    })
    .then((details) => {
      // Ensure details contain the data before accessing properties
      if (details && details.length > 0) {
        const classDetail = details[0]; // Assuming a single class detail is returned

        const subjectImages = {
          Physics:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/science.png",
          Mathematics:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/Maths.png",
          English:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/English.png",
          Chemistry:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/science.png",
          History:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/History.png",
          IT: "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/It.png",
          Biology:
            "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/Bio.png",
          // Add more subjects and their images as needed
        };
        const imageUrl =
          subjectImages[classDetail.Subject] ||
          "../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/defult.jpg";

        // Update modal content
        document.getElementById("classImage").src = imageUrl; // Corrected to set the src of the image element
        document.getElementById("moreSubject").textContent =classDetail.Subject;
        document.getElementById("classType").textContent = classDetail.Type;
        document.getElementById("locat").textContent = classDetail.Location;
        if (classDetail.Type == "individual") {
          document.getElementById("classInstitute").textContent = "None";
        }
        document.getElementById("moreGrade").textContent = classDetail.Grade;
        document.getElementById("classFee").textContent = classDetail.fee;
        document.getElementById("maxstu").textContent =
          classDetail.Max_std;
        document.getElementById(
          "classTime"
        ).textContent = `${classDetail.Start_Time} - ${classDetail.End_time}`;

        console.log("Class Details:", classDetail);
        // If there’s an image URL, set it
        if (classDetail.image) {
          document.getElementById("classImage").src = classDetail.image;
        }

        // Show modal
        document.getElementById("modalBackground").style.display = "block";
      } else {
        console.error("No class details available.");
      }
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
      alert("Failed to load class details.");
    });
}

// Function to close the modal
function closeModal() {
  document.getElementById("modalBackground").style.display = "none";
}

// Function to show the edit schedule popup form
function editSchedule(class_id) {
  currentClassId = class_id;
  console.log(`Editing schedule for Class ID: ${class_id}`);

  // Fetch class details
  fetch(`Ind_Myclass/MoredetailsApi/${class_id}`)
      .then((response) => {
          console.log("API Response Status:", response.status); // Log the status
          if (!response.ok) {
              throw new Error("Failed to fetch class details");
          }
          return response.json();
      })
      .then((details) => {
          console.log("Fetched Details:", details); // Log the fetched data

          if (details && details.length > 0) {
              const classDetail = details[0]; // Assume the first object is needed
              console.log("Class Detail Object:", classDetail);

              // Populate all fields (Ensure field names match exactly with the response keys)
              document.getElementById("classSubject").value = classDetail.Subject;
              document.getElementById("classGrade").value = classDetail.Grade;
              document.getElementById("classfee").value = classDetail.fee;
              document.getElementById("classMax_std").value = classDetail.Max_std;
              document.getElementById("classStart_Time").value = classDetail.Start_Time;
              document.getElementById("classEnd_time").value = classDetail.End_time;
              document.getElementById("classLocation").value = classDetail.Location;

              // Log each field to verify the values are being set
              console.log("Subject:", document.getElementById("classSubject").value);
              console.log("Grade:", document.getElementById("classGrade").value);
              console.log("Fee:", document.getElementById("classfee").value);
              console.log("Max_std:", document.getElementById("classMax_std").value);
              console.log("Start-time:", document.getElementById("classStart_Time").value);
              console.log("End-time:", document.getElementById("classEnd_time").value);
              console.log("Location:", document.getElementById("classLocation").value);
          } else {
              console.error("No class details available.");
              alert("No class details found for the selected ID.");
          }
      })
      .catch((error) => {
          console.error("Error fetching class details:", error);
          alert("Failed to load class details. Please try again.");
      });

  // Show the popup form
  document.getElementById("popupEditForm").style.display = "flex";
}



function view(){
    alert("Not implemented")
}