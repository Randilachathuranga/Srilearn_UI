// Declare variables in global scope
let allTeachers = [];
const teachersPerPage = 10;
let currentPage = 0;

document.addEventListener("DOMContentLoaded", () => {
  loadAllTeachers();

  // Function to load all teachers
  function loadAllTeachers() {
    fetch(`http://localhost/group_project_1.0/public/By_teacher/viewallteachers`)
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
      })
      .then((data) => {
        allTeachers = data;
        displayTeachers(currentPage);
        setupPagination();
      })
      .catch((error) => {
        console.error("There was a problem with the fetch operation:", error);
        document.getElementById("class-container").innerHTML = 
          "<p>Error loading teachers. Please try again.</p>";
      });
  }
});

// Function to display teachers for a specific page
function displayTeachers(page) {
  const container = document.getElementById("class-container");

  // Clear container first
  container.innerHTML = "";

  // Show message if no teachers are found
  if (allTeachers.length === 0) {
    container.innerHTML = "<p>No teachers found matching your criteria.</p>";
    document.getElementById("pagination-controls").style.display = "none";
    return;
  }

  // Show pagination controls if there are teachers
  if (document.getElementById("pagination-controls")) {
    document.getElementById("pagination-controls").style.display = "flex";
  }

  // Calculate start and end indices for current page
  const startIndex = page * teachersPerPage;
  const endIndex = Math.min(startIndex + teachersPerPage, allTeachers.length);

  // Display teachers for the current page
  for (let i = startIndex; i < endIndex; i++) {
    const teacher = allTeachers[i];

    // Create card element with placeholder image
    const card = document.createElement("div");
    card.className = "card";

    // Create a unique ID for this teacher's image
    const imageId = `teacher-image-${teacher.User_id}`;

    card.innerHTML = `
      <img id="${imageId}" src="../../../../../group_project_1.0/public/views/General/Myprofile/user.jpg" 
           alt="${teacher.F_name} ${teacher.L_name}" class="card-image">
      <div class="card-content">
        <h3>${teacher.F_name} ${teacher.L_name}</h3>
        <p>Subject: ${teacher.Subject}</p>
        <p>Phone: ${teacher.Phone_number}</p>
        <p>Email: ${teacher.Email || "N/A"}</p>
        <button class="card-button" onclick="Viewteacher(${
          teacher.User_id
        })">View</button>
      </div>
    `;

    container.appendChild(card);

    // Fetch the image for this specific teacher
    fetch(
      `http://localhost/group_project_1.0/public/Profile/view_image/${teacher.User_id}`
    )
      .then((response) => response.json())
      .then((result) => {
        if (result.length > 0 && result[0].Src) {
          // Update the image source with the fetched data
          const imgElement = document.getElementById(imageId);
          if (imgElement) {
            imgElement.src = result[0].Src;
          }
        }
      })
      .catch(() => {
        // Image fetch failed - default image already set
        console.error(`Failed to fetch image for teacher ${teacher.User_id}`);
      });
  }

  // Update pagination status text
  updatePaginationStatus();
}

// Function to setup pagination controls
function setupPagination() {
  // Create pagination container if it doesn't exist
  if (!document.getElementById("pagination-controls")) {
    const paginationContainer = document.createElement("div");
    paginationContainer.id = "pagination-controls";
    paginationContainer.className = "pagination-controls";

    paginationContainer.innerHTML = `
      <button id="prev-page" class="pagination-button">&laquo; Previous</button>
      <span id="pagination-status"></span>
      <button id="next-page" class="pagination-button">Next &raquo;</button>
    `;

    // Add pagination after the class container
    const classContainer = document.getElementById("class-container");
    classContainer.parentNode.insertBefore(
      paginationContainer,
      classContainer.nextSibling
    );

    // Add event listeners to pagination buttons
    document.getElementById("prev-page").addEventListener("click", () => {
      if (currentPage > 0) {
        currentPage--;
        displayTeachers(currentPage);
      }
    });

    document.getElementById("next-page").addEventListener("click", () => {
      const maxPages = Math.ceil(allTeachers.length / teachersPerPage);
      if (currentPage < maxPages - 1) {
        currentPage++;
        displayTeachers(currentPage);
      }
    });
  }

  // Initial update of pagination status
  updatePaginationStatus();
}

// Function to update pagination status text
function updatePaginationStatus() {
  const statusElement = document.getElementById("pagination-status");
  if (statusElement) {
    const totalPages = Math.ceil(allTeachers.length / teachersPerPage);
    statusElement.textContent = `Page ${currentPage + 1} of ${totalPages}`;

    // Enable/disable buttons based on current page
    const prevButton = document.getElementById("prev-page");
    const nextButton = document.getElementById("next-page");
    
    if (prevButton) prevButton.disabled = currentPage === 0;
    if (nextButton) nextButton.disabled = currentPage === totalPages - 1 || totalPages === 0;
  }
}

// Search function
function search() {
  const subject = document.getElementById("city-dropdown").value;

  // Check if a valid subject is selected
  if (subject === "Subject") {
    alert("Please select a subject");
    return;
  }

  // Show loading state
  const container = document.getElementById("class-container");
  container.innerHTML = "<p>Loading teachers...</p>";

  // Reset to first page when searching
  currentPage = 0;

  let url = '';
  if (subject === "All") {
    url = `http://localhost/group_project_1.0/public/By_teacher/viewallteachers`;
  } else {
    url = `http://localhost/group_project_1.0/public/By_teacher/teachers_by_subject/${subject}`;
  }

  // Fetch teachers based on the selected subject
  fetch(url)
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      allTeachers = data;
      displayTeachers(currentPage);
      setupPagination();
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
      container.innerHTML = "<p>Error loading teachers. Please try again.</p>";
    });
}

// Show the popup form and fetch teacher data
function Viewteacher(userId) {
  // Show the popup
  document.getElementById("popupForm").style.display = "flex";

  // Fetch teacher details
  fetch(
    `http://localhost/group_project_1.0/public/By_teacher/specificteacher/${userId}`
  )
    .then((response) => {
      if (!response.ok) throw new Error("Failed to fetch teacher details");
      return response.json();
    })
    .then((data) => {
      const teacher = data[0]; // Adjust based on your backend response format
      console.log("Teacher data:", teacher);

      // Fill popup with data
      document.getElementById(
        "teacher-name"
      ).textContent = `${teacher.F_name} ${teacher.L_name}`;
      document.getElementById("teacher-subject").textContent =
        teacher.Subject || "N/A";
      document.getElementById("teacher-phone").textContent =
        teacher.Phone_number || "N/A";
      document.getElementById("teacher-email").textContent =
        teacher.Email || "N/A";
      document.getElementById("teacher-address").textContent =
        teacher.Address || "N/A";
      document.getElementById("teacher-district").textContent =
        teacher.District || "N/A";

      // Fetch teacher's institutes separately
      fetch(
        `http://localhost/group_project_1.0/public/Normalteacher_Controller/findmyinstitutes/${userId}`
      )
        .then((response) => {
          if (!response.ok)
            throw new Error("Failed to fetch teacher institutes");
          return response.json();
        })
        .then((institutes) => {
          console.log("Institutes data:", institutes);

          // Display institutes
          const instituteElement = document.getElementById("teacher-institute");
          if (institutes && institutes.length > 0) {
            // Create a comma-separated list of institute names
            const instituteNames = institutes
              .map((inst) => inst.Address)
              .join(", ");
            instituteElement.textContent = instituteNames;
          } else {
            instituteElement.textContent = "N/A";
          }
        })
        .catch((error) => {
          console.error("Error loading teacher institutes:", error);
          document.getElementById("teacher-institute").textContent = "N/A";
        });

      // Load profile image
      fetch(
        `http://localhost/group_project_1.0/public/Profile/view_image/${teacher.User_id}`
      )
        .then((response) => response.json())
        .then((result) => {
          const imageSrc =
            result.length > 0 && result[0].Src
              ? result[0].Src
              : "../../../../../group_project_1.0/public/views/General/Myprofile/user.jpg";

          document.getElementById("teacher-image").src = imageSrc;
        })
        .catch(() => {
          document.getElementById("teacher-image").src =
            "../../../../../group_project_1.0/public/views/General/Myprofile/user.jpg";
        });
    })
    .catch((error) => {
      console.error("Error loading teacher details:", error);
    });
}

// Close the popup form
function closePopup() {
  document.getElementById("popupForm").style.display = "none";
}