document.addEventListener("DOMContentLoaded", () => {
  fetch(
    `http://localhost/group_project_1.0/public/By_institute/viewallinstitute`
  )
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      const container = document.getElementById("class-container");
      
      data.forEach((institute) => {
        // Create a unique ID for each card and image
        const cardId = `card-${institute.User_id}`;
        const imageId = `institute-image-${institute.User_id}`;
        
        // Initialize applyButton as empty - will be populated after checking user role
        let applyButton = '';
        
        // Create card first with placeholder image
        const card = document.createElement("div");
        card.className = "card";
        card.id = cardId;
        card.innerHTML = `
          <img id="${imageId}" src="../../../../../group_project_1.0/public/views/General/Myprofile/user.jpg" alt="${institute.Name}" class="card-image">
          <div class="card-content">
            <h3>${institute.F_name} ${institute.L_name}</h3>
            <p>Phone: ${institute.Phone_number}</p>
            <p>District: ${institute.District}</p>
            <div class="button-container">
              <button class="card-button" onclick="ViewInstitute('${institute.User_id}')">View</button>
            </div>
          </div>
        `;
        container.appendChild(card);
        
        // Fetch subjects to determine if apply button should be displayed
        fetch(`http://localhost/group_project_1.0/public/Jobrollcontroller/viewallsubjects/${institute.User_id}`)
          .then((response) => {
            if (!response.ok) throw new Error("Network response was not ok");
            return response.json();
          })
          .then((data1) => {
            // Check if we have data and user is a teacher
            if (data1.length > 0 && typeof userRole !== 'undefined' && userRole === "teacher") {
              applyButton = `<button class="card-button" onclick="Applyinstitute('${institute.User_id}')">Apply</button>`;
            } 
            
            // Update the button container with the apply button if needed
            if (applyButton) {
              const buttonContainer = document.querySelector(`#${cardId} .button-container`);
              if (buttonContainer) {
                buttonContainer.innerHTML += applyButton;
              }
            }
          })
          .catch((error) => {
            console.error(`Failed to fetch subjects for institute ${institute.User_id}:`, error);
            // Optional: Add a fallback button or message when subject fetch fails
          });
        
        // Fetch the profile image for this institute
        fetch(
          `http://localhost/group_project_1.0/public/Profile/view_image/${institute.User_id}`
        )
          .then((response) => {
            if (!response.ok) throw new Error("Image fetch failed");
            return response.json();
          })
          .then((result) => {
            if (result.length > 0 && result[0].Src) {
              // Update the image source with the fetched data
              const imgElement = document.getElementById(imageId);
              if (imgElement) {
                imgElement.src = result[0].Src;
              }
            }
          })
          .catch((error) => {
            console.error(
              `Failed to fetch image for institute ${institute.User_id}:`,
              error
            );
            // Keep the default image when fetch fails - no action needed
          });
      });
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
      // Add user-friendly error message to the container
      const container = document.getElementById("class-container");
      if (container) {
        container.innerHTML = `<div class="error-message">Unable to load institutes. Please try again later.</div>`;
      }
    });
});

function ViewInstitute(userId) {
  // Show the popup
  document.getElementById("popupForm").style.display = "flex";

  // Fetch teacher details
  fetch(
    `http://localhost/group_project_1.0/public/By_institute/specificinstitute/${userId}`
  )
    .then((response) => {
      if (!response.ok) throw new Error("Failed to fetch teacher details");
      return response.json();
    })
    .then((data) => {
      const institute = data[0]; // Adjust based on your backend response format
      console.log("Teacher data:", institute);

      // Fill popup with data
      document.getElementById(
        "institute-name"
      ).textContent = `${institute.F_name} ${institute.L_name}`;
      document.getElementById("institute-phone").textContent =
        institute.Phone_number || "N/A";
      document.getElementById("institute-email").textContent =
        institute.Email || "N/A";
      document.getElementById("institute-location").textContent =
        institute.Address || "N/A";
      document.getElementById("institute-district").textContent =
        institute.District || "N/A";
      // Load profile image
      fetch(
        `http://localhost/group_project_1.0/public/Profile/view_image/${institute.User_id}`
      )
        .then((response) => response.json())
        .then((result) => {
          const imageSrc =
            result.length > 0 && result[0].Src
              ? result[0].Src
              : "../../../../../group_project_1.0/public/views/General/Myprofile/user.jpg";

          document.getElementById("institute-image").src = imageSrc;
        })
        .catch(() => {
          document.getElementById("institute-image").src =
            "../../../../../group_project_1.0/public/views/General/Myprofile/user.jpg";
        });
    })
    .catch((error) => {
      console.error("Error loading institute details:", error);
    });
}

document.addEventListener("DOMContentLoaded", () => {
  // Set up the search button click handler
  document.querySelector(".search-button").addEventListener("click", search);
});

function search() {
  const districtSelect = document.getElementById("city-dropdown");
  const district = districtSelect.value;

  if (!district) {
    alert("Please select a district");
    return;
  }

  const container = document.getElementById("class-container");
  // Clear previous results
  container.innerHTML = "";
  let url = ``;
  if (district == "All") {
    url = `http://localhost/group_project_1.0/public/By_institute/viewallinstitute`;
  } else {
    url = `http://localhost/group_project_1.0/public/By_institute/searchbydistrict/${district}`;
  }

  fetch(url)
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      if (data.length === 0) {
        container.innerHTML = "<p>No institutes found in this district</p>";
        return;
      }

      data.forEach((institute) => {
        // Create a unique ID for each image
        const imageId = `institute-image-${institute.User_id}`;

        // Create card first with placeholder image
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
          <img id="${imageId}" src="../../../../../group_project_1.0/public/views/General/Myprofile/user.jpg" alt="${institute.Name}" class="card-image">
          <div class="card-content">
            <h3>${institute.F_name} ${institute.L_name}</h3>
            <p>Phone: ${institute.Phone_number}</p>
            <p>District: ${institute.District}</p>
            <button class="card-button" onclick="ViewInstitute('${institute.User_id}')">View</button>
            <button class="card-button" onclick="Applyinstitute('${institute.User_id}')">Apply</button>
          </div>
        `;
        container.appendChild(card);

        // Now fetch the specific image for this institute's user
        fetch(
          `http://localhost/group_project_1.0/public/Profile/view_image/${institute.User_id}`
        )
          .then((response) => {
            if (!response.ok) throw new Error("Image fetch failed");
            return response.json();
          })
          .then((result) => {
            if (result.length > 0 && result[0].Src) {
              // Update the image source with the fetched data
              const imgElement = document.getElementById(imageId);
              if (imgElement) {
                imgElement.src = result[0].Src;
              }
            }
          })
          .catch((error) => {
            console.error(
              `Failed to fetch image for institute ${institute.User_id}:`,
              error
            );
          });
      });
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
      container.innerHTML = "<p>Error loading data. Please try again.</p>";
    });
}

// Close the popup form
function closeApply() {
  document.getElementById("popupApply").style.display = "none";
}

function Applyinstitute(institute) {
  document.getElementById("popupApply").style.display = "flex";
  document.getElementById("inst_id").textContent = institute;

  fetch(
    `http://localhost/group_project_1.0/public/Jobrollcontroller/viewallsubjects/${institute}`
  )
    .then((response) => {
      if (!response.ok) throw new Error("Failed to fetch subjects");
      return response.json();
    })
    .then((data) => {
      // console.log("Subjects fetched successfully:", data);
      const subjectContainer = document.getElementById("all_subjects");
      subjectContainer.innerHTML = ""; // Clear previous content

      const activeSubjects = data
        .filter((subject) => subject.Status === "Active")
        .map((subject) => subject.Subject);
      const title = document.createElement("h3");
      if (activeSubjects.length === 0) {
        title.textContent = "Teaching Position: No active subjects available.";
      } else if (activeSubjects.length === 1) {
        title.textContent = `Teaching Position: ${activeSubjects[0]}`;
      } else if (activeSubjects.length === 2) {
        title.textContent = `Teaching Position: ${activeSubjects[0]} and ${activeSubjects[1]}`;
      } else {
        title.textContent = `Teaching Position: ${activeSubjects
          .slice(0, -1)
          .join(", ")} and ${activeSubjects[activeSubjects.length - 1]}`;
      }
      subjectContainer.appendChild(title);

      const subjectDropdown = document.getElementById("subject");
      subjectDropdown.innerHTML = "";

      data.forEach((subject) => {
        if (subject.Status === "Active") {
          const option = document.createElement("option");
          option.value = subject.Subject;
          option.textContent = subject.Subject;
          subjectDropdown.appendChild(option);
        }
      });
    })
    .catch((error) => {
      console.error("Error fetching subjects:", error);
    });
}

// Submit the blog and redirect to the main blog page
function submitApply() {
  const Full_name = document.getElementById("Full_name").value;
  const email = document.getElementById("email").value;
  const subject = document.getElementById("subject").value;
  const phone = document.getElementById("phone").value;
  const qualifications = document.getElementById("qualifications").value;
  const Inst_id = document.getElementById("inst_id").textContent;
  // const Jr_id = '1';

  // Check if all fields are filled
  if (Full_name && email && subject && phone && qualifications && Inst_id) {
    // Prepare the data to be sent
    const applicationData = {
      Inst_id: Inst_id,
      Teacher_id: userID,
      Date: new Date().toISOString().split("T")[0],
      Full_name: Full_name,
      Email: email,
      Subject: subject,
      Phone_number: phone,
      Qualifications: qualifications,
    };

    // Check if the user has already submitted an application
    fetch(
      `http://localhost/group_project_1.0/public/Jobrollcontroller/checkapplied/${userID}/${Inst_id}/${subject}`
    )
      .then((response) => response.json())
      .then((data) => {
        if (data.length > 0) {
          // If the application already exists, alert the user
          alert("You have already submitted an application for this subject.");
          window.location.href = `http://localhost/group_project_1.0/public/By_institute`;
        } else {
          // If no application exists, proceed with submission
          fetch(
            `http://localhost/group_project_1.0/public/Jobrollcontroller/applyforjobs/${userID}`,
            {
              // Replace with your actual API endpoint
              method: "POST", // HTTP method
              headers: {
                "Content-Type": "application/json", // Tell the server you're sending JSON data
              },
              body: JSON.stringify(applicationData), // Convert the JavaScript object into a JSON string
            }
          )
            .then((response) => response.json()) // Parse the JSON response from the server
            .then((data) => {
              console.log("Application submitted successfully:", data);

              // Redirect or close the form after submission
              alert("Application submitted successfully!");
              window.location.href = `http://localhost/group_project_1.0/public/By_institute`;
              closeApply(); // Close the popup
            })
            .catch((error) => {
              console.error("Error submitting application:", error);
              alert(
                "There was an error submitting your application. Please try again."
              );
            });
        }
      })
      .catch((error) => {
        console.error("Error checking application status:", error);
        alert(
          "There was an error checking your application status. Please try again."
        );
      });
  } else {
    alert("Please fill out all fields.");
  }
}

// Close the popup form
function closePopup() {
  document.getElementById("popupForm").style.display = "none";
}
