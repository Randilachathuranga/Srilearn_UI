document.addEventListener("DOMContentLoaded", () => {
  fetch(`http://localhost/group_project_1.0/public/By_institute/viewallinstitute`)
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      const container = document.getElementById("class-container");
      
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
            <button class="card-button" onclick="Applyinstitute('${institute.Name}')">Apply</button>
          </div>
        `;
        container.appendChild(card);
        
        // Now fetch the specific image for this institute's user
        fetch(`http://localhost/group_project_1.0/public/Profile/view_image/${institute.User_id}`)
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
            // Fixed the typo here from "nstitutei" to "institute"
            console.error(`Failed to fetch image for institute ${institute.User_id}:`, error);
          });
      });
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
});

// Function to show institute details when the button is clicked


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
;

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


function Applyinstitute(institute) {
  document.getElementById("popupApply").style.display = "flex";
  
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
  if(district == 'All'){
    url = `http://localhost/group_project_1.0/public/By_institute/viewallinstitute`
  }else{
    url = `http://localhost/group_project_1.0/public/By_institute/searchbydistrict/${district}`
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
            <button class="card-button" onclick="Applyinstitute('${institute.Name}')">Apply</button>
          </div>
        `;
        container.appendChild(card);
        
        // Now fetch the specific image for this institute's user
        fetch(`http://localhost/group_project_1.0/public/Profile/view_image/${institute.User_id}`)
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
            console.error(`Failed to fetch image for institute ${institute.User_id}:`, error);
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

// Submit the blog and redirect to the main blog page
function submitApply() {
  const firstName = document.getElementById("firstName").value;
  const lastName = document.getElementById("lastName").value;
  const email = document.getElementById("email").value;
  const subject = document.getElementById("subject").value;
  const phone = document.getElementById("phone").value;
  const address = document.getElementById("address").value;
  const qualifications = document.getElementById("qualifications").value;

  // Check if all fields are filled
  if (firstName && lastName && email && subject && phone && address && qualifications) {
      // Prepare the data to be sent
      const applicationData = {
          firstName: firstName,
          lastName: lastName,
          email: email,
          subject: subject,
          phone: phone,
          address: address,
          qualifications: qualifications
      };

      // Use fetch to send the data to the server
      fetch('path/to/your/api/submitApplication', { // Replace with your actual API endpoint
          method: 'POST', // HTTP method
          headers: {
              'Content-Type': 'application/json' // Tell the server you're sending JSON data
          },
          body: JSON.stringify(applicationData) // Convert the JavaScript object into a JSON string
      })
      .then(response => response.json()) // Parse the JSON response from the server
      .then(data => {
          console.log('Application submitted successfully:', data);

          // Redirect or close the form after submission
          alert("Application submitted successfully!");
          closeApply(); // Close the popup
      })
      .catch(error => {
          console.error('Error submitting application:', error);
          alert("There was an error submitting your application. Please try again.");
      });
  } else {
      alert("Please fill out all fields.");
  }
}



  // Close the popup form
  function closePopup() {
    document.getElementById("popupForm").style.display = "none";
}
