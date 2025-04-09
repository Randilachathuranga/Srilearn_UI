document.addEventListener("DOMContentLoaded", () => {
  // Global variable to store all teachers
  let allTeachers = [];
  // Number of teachers to display per page
  const teachersPerPage = 10;
  // Current page index
  let currentPage = 0;

  // Fetch all teachers data first
  fetch(`http://localhost/group_project_1.0/public/By_teacher/viewallteachers`)
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      // Store all teachers data
      allTeachers = data;
      
      // Display the first page of teachers
      displayTeachers(currentPage);
      
      // Setup pagination controls
      setupPagination();
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
  
  // Function to display teachers for a specific page
  function displayTeachers(page) {
    const container = document.getElementById("class-container");
    
    // Clear container first
    container.innerHTML = '';
    
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
          <p>Subject: ${teacher.subject}</p>
          <p>Phone: ${teacher.Phone_number}</p>
          <p>Email: ${teacher.Email || "N/A"}</p>
          <button class="card-button" onclick="Viewteacher(${teacher.User_id})">View</button>
        </div>
      `;
      
      container.appendChild(card);
      
      // Fetch the image for this specific teacher
      fetch(`http://localhost/group_project_1.0/public/Profile/view_image/${teacher.User_id}`)
        .then(response => response.json())
        .then(result => {
          if (result.length > 0 && result[0].Src) {
            // Update the image source with the fetched data
            document.getElementById(imageId).src = result[0].Src;
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
    if (!document.getElementById('pagination-controls')) {
      const paginationContainer = document.createElement('div');
      paginationContainer.id = 'pagination-controls';
      paginationContainer.className = 'pagination-controls';
      
      paginationContainer.innerHTML = `
        <button id="prev-page" class="pagination-button">&laquo; Previous</button>
        <span id="pagination-status"></span>
        <button id="next-page" class="pagination-button">Next &raquo;</button>
      `;
      
      // Add pagination after the class container
      const classContainer = document.getElementById('class-container');
      classContainer.parentNode.insertBefore(paginationContainer, classContainer.nextSibling);
      
      // Add event listeners to pagination buttons
      document.getElementById('prev-page').addEventListener('click', () => {
        if (currentPage > 0) {
          currentPage--;
          displayTeachers(currentPage);
        }
      });
      
      document.getElementById('next-page').addEventListener('click', () => {
        const maxPages = Math.ceil(allTeachers.length / teachersPerPage);
        if (currentPage < maxPages - 1) {
          currentPage++;
          displayTeachers(currentPage);
        }
      });
      
      // Initial update of pagination status
      updatePaginationStatus();
    }
  }
  
  // Function to update pagination status text
  function updatePaginationStatus() {
    const statusElement = document.getElementById('pagination-status');
    if (statusElement) {
      const totalPages = Math.ceil(allTeachers.length / teachersPerPage);
      statusElement.textContent = `Page ${currentPage + 1} of ${totalPages}`;
      
      // Enable/disable buttons based on current page
      document.getElementById('prev-page').disabled = currentPage === 0;
      document.getElementById('next-page').disabled = currentPage === totalPages - 1;
    }
  }
});

// Function for searching (if needed)
function search(city) {
  alert("Searching for " + city);
}

// Show the popup form and fetch teacher data
function Viewteacher(userId) {
  // Show the popup
  document.getElementById("popupForm").style.display = "flex";
  
  // Fetch teacher details
  fetch(`http://localhost/group_project_1.0/public/By_teacher/specificteacher/${userId}`)
    .then((response) => {
      if (!response.ok) throw new Error("Failed to fetch teacher details");
      return response.json();
    })
    .then((data) => {
      const teacher = data[0]; // Adjust based on your backend response format
      console.log("Teacher data:", teacher);
      
      // Fill popup with data
      document.getElementById("teacher-name").textContent = `${teacher.F_name} ${teacher.L_name}`;
      document.getElementById("teacher-subject").textContent = teacher.Subject || "N/A";
      document.getElementById("teacher-phone").textContent = teacher.Phone_number || "N/A";
      document.getElementById("teacher-email").textContent = teacher.Email || "N/A";
      document.getElementById("teacher-address").textContent = teacher.Address || "N/A";
      document.getElementById("teacher-district").textContent = teacher.District || "N/A";
      
      // Fetch teacher's institutes separately
      fetch(`http://localhost/group_project_1.0/public/Normalteacher_Controller/findmyinstitutes/${userId}`)
        .then(response => {
          if (!response.ok) throw new Error("Failed to fetch teacher institutes");
          return response.json();
        })
        .then(institutes => {
          console.log("Institutes data:", institutes);
          
          // Display institutes
          const instituteElement = document.getElementById("teacher-institute");
          if (institutes && institutes.length > 0) {
            // Create a comma-separated list of institute names
            const instituteNames = institutes.map(inst => inst.Address).join(", ");
            instituteElement.textContent = instituteNames;
          } else {
            instituteElement.textContent = "N/A";
          }
        })
        .catch(error => {
          console.error("Error loading teacher institutes:", error);
          document.getElementById("teacher-institute").textContent = "N/A";
        });

      // Load profile image
      fetch(`http://localhost/group_project_1.0/public/Profile/view_image/${teacher.User_id}`)
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