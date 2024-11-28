document.addEventListener("DOMContentLoaded", () => {
  const userDataElement = document.getElementById("user-data");
  if (!userDataElement) {
    console.error("User data element not found.");
    return;
  }

  // Get the user ID from the data attribute
  const userId = userDataElement.dataset.userId;

  const fetchAndRenderTeachers = () => {
    fetch(`Institute_teacher/My_teachers/${userId}`)
      .then((response) => {
        if (!response.ok) {
          if (response.status === 403) {
            throw new Error("Access denied. Not a premium teacher.");
          } else if (response.status === 404) {
            throw new Error("No teachers found.");
          } else {
            throw new Error("An unexpected error occurred.");
          }
        }
        return response.json();
      })
      .then((data) => {
        const container = document.getElementById("class-container");
        if (!container) {
          console.error("Container element with ID 'class-container' not found.");
          return;
        }

        container.innerHTML = ""; // Clear previous cards

        if (!data || data.length === 0) {
          container.innerHTML = "<p>No teachers found.</p>";
          return;
        }

        data.forEach((teacher) => {
          const card = document.createElement("div");
          card.classList.add("card");

          card.innerHTML = `
            <div class="card-details">
              <p><strong>ID:</strong> ${teacher.Teacher_ID}</p>
              <p><strong>Name:</strong> ${teacher.FirstName} ${teacher.LastName}</p>
              <p><strong>Email:</strong> ${teacher.Email}</p>
              <p><strong>Subject:</strong> ${teacher.Subject}</p>
            </div>
            <button class="remove-btn" onclick="removeTeacher(${teacher.Teacher_ID})">Remove</button>
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

  // Initial fetch
  fetchAndRenderTeachers();
});

function removeTeacher(teacherId) {
  alert(`Remove functionality not implemented yet for Teacher ID: ${teacherId}`);
}
