
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
    const fetchUrls = [
      fetch(`Ind_Myclass/MyclassApi/${P_id}`),
      fetch(`Ind_Myclass/MyinstituteClass/${P_id}`)
    ];
  
    Promise.allSettled(fetchUrls)
      .then(results => {
        const jsonPromises = results.map(result => {
          if (result.status === "fulfilled" && result.value.ok) {
            return result.value.json();
          }
          return Promise.resolve([]); // Treat rejected or non-ok fetches as empty data
        });
  
        return Promise.all(jsonPromises);
      })
      .then(dataArrays => {
        const combinedData = [...dataArrays[0], ...dataArrays[1]];
  
        const container = document.getElementById("class-container");
        if (!container) {
          console.error("Container element with ID 'class-container' not found.");
          return;
        }
  
        container.innerHTML = ""; // Clear previous results
  
        if (combinedData.length === 0) {
          container.innerHTML = "<p>No classes found for this teacher.</p>";
          return;
        }
  
        // Filter data by class type if needed
        const filteredData =
          filterType === "All"
            ? combinedData
            : combinedData.filter(classItem => classItem.Type === filterType);
  
        if (filteredData.length === 0) {
          container.innerHTML = `<p>No ${filterType.toLowerCase()} classes found.</p>`;
          return;
        }
  
        // Subject images map
        const subjectImages = {
          Physics: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
          Mathematics: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Maths.png",
          English: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/English.png",
          Chemistry: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
          History: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/History.png",
          IT: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/It.png",
          Biology: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Bio.png",
        };
  
        // Render each class card
        filteredData.forEach(classItem => {
          const card = document.createElement("div");
          card.className = "card";
  
          const imageUrl =
            subjectImages[classItem.Subject] ||
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/defult.jpg";
  
          card.innerHTML = `
            <div class="card-content">
              <img src="${imageUrl}" alt="${classItem.Subject}">
              <h3>${classItem.Subject} - Grade ${classItem.Grade}</h3>
              <br>
              <p><h3>Address:</h3> ${classItem.Location }</p>
              <br>
              <p>Start date: ${classItem.Start_date || "N/A"}</p>
              <p>End date: ${classItem.End_date || "N/A"}</p>
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
      .catch(error => {
        const container = document.getElementById("class-container");
        if (container) {
          container.innerHTML = `<p class="error">Failed to load classes: ${error.message}</p>`;
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
  const individualUrl = `Ind_Myclass/MoredetailsApi/${Class_id}`;
  const instituteUrl = `Ind_Myclass/Moredetailsinstitute/${Class_id}`;

  Promise.allSettled([
    fetch(individualUrl),
    fetch(instituteUrl)
  ])
    .then(results => {
      const successful = results.filter(r => r.status === 'fulfilled' && r.value.ok);
      if (successful.length === 0) {
        throw new Error("No valid response from any API.");
      }

      return Promise.all(successful.map(r => r.value.json()));
    })
    .then(dataArrays => {
      const [individualClassData = [], instituteClassData = []] = dataArrays;

      const classDetail = 
        (individualClassData.length > 0 && individualClassData[0]) || 
        (instituteClassData.length > 0 && instituteClassData[0]);

      if (!classDetail) {
        console.error("No class details found.");
        alert("Class details not available.");
        return;
      }

      const subjectImages = {
        Physics: "Class_images/science.png",
        Mathematics: "Class_images/Maths.png",
        English: "Class_images/English.png",
        Chemistry: "Class_images/science.png",
        History: "Class_images/History.png",
        IT: "Class_images/It.png",
        Biology: "Class_images/Bio.png",
        CS: "Class_images/It.png"
      };

      const imageBasePath = "../../../../../group_project_1.0/public/views/TeacherView/Myclass/";
      const imageUrl = classDetail.image || 
        imageBasePath + (subjectImages[classDetail.Subject] || "Class_images/defult.jpg");

      document.getElementById("classImage").src = imageUrl;
      document.getElementById("moreSubject").textContent = classDetail.Subject || "N/A";
      document.getElementById("classType").textContent = classDetail.Type || "N/A";
      document.getElementById("locat").textContent = classDetail.Location || classDetail.Hall_number || "N/A";
      // document.getElementById("classInstitute").textContent = classDetail.Type === "Individual" ? "None" : (classDetail.Type || "N/A");
      document.getElementById("moreGrade").textContent = classDetail.Grade || "N/A";
      document.getElementById("classid").textContent = classDetail.Class_id || "N/A";
      document.getElementById("classFee").textContent = classDetail.fee || "N/A";
      document.getElementById("maxstu").textContent = classDetail.Max_std || "N/A";
      document.getElementById("classdate").textContent = 
        `${classDetail.Start_date || "N/A"} - ${classDetail.End_date || "N/A"}`;

      document.getElementById("modalBackground").style.display = "block";

      console.log("Class Details:", classDetail);
    })
    .catch(error => {
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

  const allfetch = [
    fetch(`Ind_Myclass/MoredetailsApi/${class_id}`),
    fetch(`Ind_Myclass/Moredetailsinstitute/${class_id}`)
  ];

  Promise.all(allfetch)
    .then((responses) => {
      // Check for response status
      for (const response of responses) {
        if (!response.ok) {
          console.warn("Some data might be missing. Status:", response.status);
        }
      }

      // Convert all responses to JSON
      return Promise.all(
        responses.map((response) => {
          // If not OK, return empty array to avoid breaking the chain
          return response.ok ? response.json() : [];
        })
      );
    })
    .then((dataArrays) => {
      const individualClassData = dataArrays[0];
      const instituteClassData = dataArrays[1];

      // Prefer individual data, fallback to institute
      let classDetail = null;
      if (individualClassData && individualClassData.length > 0) {
        classDetail = individualClassData[0];
      } else if (instituteClassData && instituteClassData.length > 0) {
        classDetail = instituteClassData[0];
      }

      if (!classDetail) {
        console.error("No class details found.");
        alert("No class details found for the selected ID.");
        return;
      }

      console.log("Class Detail Object:", classDetail);

      // Fill form fields
      document.getElementById("classSubject").value = classDetail.Subject || "";
      document.getElementById("classGrade").value = classDetail.Grade || "";
      document.getElementById("classfee").value = classDetail.fee || "";
      document.getElementById("classMax_std").value = classDetail.Max_std || "";
      document.getElementById("classStart_date").value = classDetail.Start_date || "";
      document.getElementById("classEnd_date").value = classDetail.End_date || "";
      document.getElementById("classLocation").value = classDetail.Location || classDetail.Hall_number || "";

      // Show the popup form
      document.getElementById("popupEditForm").style.display = "flex";
    })
    .catch((error) => {
      console.error("Error fetching class details:", error);
      alert("Failed to load class details. Please try again.");
    });
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

function UploadASS(Class_id) {
  sessionStorage.setItem("class_id", Class_id);
  window.location.href = "http://localhost/group_project_1.0/public/AssignmentController";
  console.log("Class ID stored in sessionStorage:", Class_id);  
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

function viewStudents(Class_id) {
  sessionStorage.setItem("class_id", Class_id);
  window.location.href = "http://localhost/group_project_1.0/public/ClassStudents";
  console.log("Class ID stored in sessionStorage:", Class_id);
}
