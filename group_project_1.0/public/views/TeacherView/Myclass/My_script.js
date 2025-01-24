
document.addEventListener("DOMContentLoaded", () => {
  const userDataElement = document.getElementById("user-data");
  if (!userDataElement) {
    console.error("User data element not found.");
    return;
  }

  // Get the user ID from the data attribute
  const P_id = userDataElement.dataset.userId;
  const formElement = document.getElementById("filter");
  const selectElement = formElement.querySelector("#filter-type");

  if (!formElement || !selectElement) {
    console.error("Required DOM elements not found.");
    return;
  }

  const fetchAndRenderClasses = (filterType) => {
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
        return response.json();
      })
      .then((data) => {
        const container = document.getElementById("class-container");
        if (!container) {
          console.error(
            "Container element with ID 'class-container' not found."
          );
          return;
        }
        container.innerHTML = ""; // Clear previous cards

        if (!data || data.length === 0) {
          container.innerHTML = "<p>No classes found for this teacher.</p>";
          return;
        }

        // Filter data based on the selected filter type
        const filteredData =
          filterType === "All"
            ? data // Show all classes if "All" is selected
            : data.filter((classItem) => classItem.Type === filterType);

        if (filteredData.length === 0) {
          container.innerHTML = `<p>No ${filterType.toLowerCase()} classes found.</p>`;
          return;
        }

        // Render filtered cards
        filteredData.forEach((classItem) => {
          const card = document.createElement("div");
          card.className = "card";

          const subjectImages = {
            Physics:
              "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
            Mathematics:
              "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Maths.png",
            English:
              "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/English.png",
            Chemistry:
              "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
            History:
              "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/History.png",
            IT: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/It.png",
            Biology:
              "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Bio.png",
          };

          const imageUrl =
            subjectImages[classItem.Subject] ||
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/defult.jpg";

          card.innerHTML = `
            <div class="card-content">
              <img src="${imageUrl}" alt="${classItem.title}">
              <h3>${classItem.Subject} - Grade ${classItem.Grade}</h3>
              <br>
              <p><h3>Address:</h3> ${classItem.Location}</p>
              <br>
              <p>Start date: ${classItem.Start_date}</p>
              <p>End date: ${classItem.End_date}</p>
                            <br>

              <button class="card-button" onclick="showDetails(${classItem.Class_id})">More Details</button>
              <button class="button" onclick="editclass(${classItem.Class_id})">
                <img src="../../../../../group_project_1.0/public/views/TeacherView/Myclass/icon/pencil.png" alt="Edit" class="icon"> Edit
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
  };

  // Fetch and render classes on dropdown selection change
  selectElement.addEventListener("change", () => {
    const selectedType = selectElement.value;
    console.log("Selected item: ", selectedType); // Log selected value
    fetchAndRenderClasses(selectedType);
  });

  // Initial fetch with default dropdown value
  fetchAndRenderClasses(selectElement.value);

  // Show the popup form
  document
    .getElementById("editScheduleForm")
    .addEventListener("submit", (event) => createSchedule(event, P_id));

  async function createSchedule(event, P_id) {
    console.log("createSchedule called with P_id:", P_id);
    event.preventDefault(); // Prevent form submission and page reload

    const form = event.target;
    const formData = new FormData(form);

    const table1 = {
      Type: formData.get("Type"),
      Subject: formData.get("Subject"),
      Grade: formData.get("Grade"),
      Max_std: parseInt(formData.get("Max_std"), 10),
      fee: parseFloat(formData.get("Fee")),
    };
    const table2 = {
      P_id: P_id,
      Location: formData.get("Location"),
      Start_date: formData.get("Start_date"),
      End_date: formData.get("End_date"),
    };

    const institute = formData.get("Institute_name");

    if (
      institute == "None" &&
      table1.Type == "Individual" &&
      table2.Start_date < table2.End_date
    ) {
      const data = { table1, table2 };
      console.log("ClassData being sent:", data);

      fetch(
        `http://localhost/group_project_1.0/public/Ind_Myclass/CreateclassApi/${P_id}`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        }
      )
        .then(async (response) => {
          const contentType = response.headers.get("content-type");
          if (!response.ok) {
            const errorText = await response.text();
            console.error("Server response:", errorText);
            throw new Error(
              `HTTP error! Status: ${response.status}, Body: ${errorText}`
            );
          }
          if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.warn("Unexpected response format:", text);
            return { message: text }; // Return text for unexpected formats
          }
          return response.json();
        })
        .then((data) => {
          console.log("Schedule submitted successfully:", data);
          alert("Schedule created successfully!");
          window.location.href =
            "http://localhost/group_project_1.0/public/Ind_Myclass";
        })
        .catch((error) => {
          console.error("Error submitting schedule:", error);
          alert(
            "There was an error submitting the schedule. Please try again."
          );
        });
    } else {
      alert(
        "Institute name should be 'None' for individual classes, or the start date should be earlier than the end date."
      );
    }
  }
});

//More Details
function showDetails(Class_id) {
  fetch(`Ind_Myclass/MoredetailsApi/${Class_id}`)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Failed to fetch class details");
      }
      return response.json();
    })
    .then((details) => {
      if (details && details.length > 0) {
        const classDetail = details[0]; // Assuming a single class detail is returned
        const subjectImages = {
          Physics:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
          Mathematics:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Maths.png",
          English:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/English.png",
          Chemistry:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
          History:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/History.png",
          IT: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/It.png",
          Biology:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Bio.png",
        };
        const imageUrl =
          subjectImages[classDetail.Subject] ||
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/defult.jpg";
        document.getElementById("classImage").src = imageUrl; // Corrected to set the src of the image element
        document.getElementById("moreSubject").textContent =
          classDetail.Subject;
        document.getElementById("classType").textContent = classDetail.Type;
        document.getElementById("locat").textContent = classDetail.Location;
        if (classDetail.Type == "Individual") {
          document.getElementById("classInstitute").textContent = "None";
        }
        document.getElementById("moreGrade").textContent = classDetail.Grade;
        document.getElementById("classid").textContent = classDetail.Class_id;
        document.getElementById("classFee").textContent = classDetail.fee;
        document.getElementById("maxstu").textContent = classDetail.Max_std;
        document.getElementById(
          "classdate"
        ).textContent = `${classDetail.Start_date} - ${classDetail.End_date}`;
        console.log("Class Details:", classDetail);
        if (classDetail.image) {
          document.getElementById("classImage").src = classDetail.image;
        }
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

// Function to show the edit Class popup form
function editclass(class_id) {
  currentClassId = class_id;
  console.log(`Editing schedule for Class ID: ${class_id}`);
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
        document.getElementById("classSubject").value = classDetail.Subject;
        document.getElementById("classGrade").value = classDetail.Grade;
        document.getElementById("classfee").value = classDetail.fee;
        document.getElementById("classMax_std").value = classDetail.Max_std;
        document.getElementById("classStart_date").value =
          classDetail.Start_date;
        document.getElementById("classEnd_date").value = classDetail.End_date;
        document.getElementById("classLocation").value = classDetail.Location;
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

function createclass() {
  document.getElementById("popupForm").style.display = "flex";
  console.log("p_ID ", P_id);
}

function closePopup() {
  document.getElementById("popupForm").style.display = "none";
}

function view() {
  alert("Not implemented");
}

function UploadMat(Class_id) {
  sessionStorage.setItem("class_id", Class_id);
  window.location.href = "http://localhost/group_project_1.0/public/Learning_mat";
  console.log("Class ID stored in sessionStorage:", Class_id);
}

function UploadASS() {
  window.location.href =
    "../../../../../group_project_1.0/app/views/TeacherView/Options/UploadASS/UploadASS.php";
}

function viewschedule(Class_id) {
  sessionStorage.setItem("class_id", Class_id);
  window.location.href = "http://localhost/group_project_1.0/public/ClassShcedules";
  console.log("Class ID stored in sessionStorage:", Class_id);
}

function getClassId() {
  return document.getElementById('classid').textContent.trim();
}

function freeCard(Class_id) {
    sessionStorage.setItem("class_id", Class_id);
    window.location.href = "http://localhost/group_project_1.0/public/FreeCard";
    console.log("Class ID stored in sessionStorage:", Class_id);
  }

function reqPay() {
  window.location.href =
    "../../../../../group_project_1.0/app/views/TeacherView/Options/RequestPayrolls/RequestPayrolls.php";
}
