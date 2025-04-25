document.addEventListener("DOMContentLoaded", () => {
  fetch(
    `http://localhost/group_project_1.0/public/Normalteacher_Controller/findmyinstitutes/${Userid}`
  )
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
              <button class="card-button" onclick="Leave('${institute.User_id}')">Leave</button>
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
            // Fixed the typo here from "nstitutei" to "institute"
            console.error(
              `Failed to fetch image for institute ${institute.User_id}:`,
              error
            );
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

// Close the popup form
function closePopup() {
  document.getElementById("popupForm").style.display = "none";
}


function Leave(Institute_ID) {
    const confirmLeave = confirm("Are you sure you want to leave this institute?");
    if (!confirmLeave) return;

    fetch(`http://localhost/group_project_1.0/public/Normalteacher_Controller/leaveinstitute/${Userid}/${Institute_ID}`)
        .then(response => {
            if (!response.ok) throw new Error("Failed to leave institute");
            return response.json();
        })
        .then(data => {
            console.log("Leave response:", data);
            alert(data.message || "You have left the institute.");
            location.reload(); // Reload to reflect the change
        })
        .catch(error => {
            console.error("Error leaving institute:", error);
            alert("Something went wrong while trying to leave the institute.");
        });
}
