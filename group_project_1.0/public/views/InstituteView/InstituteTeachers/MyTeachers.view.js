document.addEventListener("DOMContentLoaded", () => {
  const userDataElement = document.getElementById("user-data");
  if (!userDataElement) {
    console.error("User data element not found.");
    return;
  }

  const userId = userDataElement.dataset.userId;

  const fetchAndRenderTeachers = async () => {
    const container = document.getElementById("class-container");
    if (!container) {
      console.error("Container element with ID 'class-container' not found.");
      return;
    }

    container.innerHTML = "<p>Loading...</p>";

    try {
      const response = await fetch(`Institute_teacher/My_teachers/${userId}`);

      if (!response.ok) {
        if (response.status === 403) {
          throw new Error("Access denied. Not a premium teacher.");
        } else if (response.status === 404) {
          throw new Error("No teachers found.");
        } else {
          throw new Error("An unexpected error occurred.");
        }
      }

      const data = await response.json();
      container.innerHTML = ""; // Clear the loading message

      if (!data || data.length === 0) {
        container.innerHTML = "<p>No teachers found.</p>";
        return;
      }
      console.log(data);
      data.forEach((teacher) => {
        const card = document.createElement("div");
        card.classList.add("card");

        card.innerHTML = `
          <div class="card-details">
            <p><strong>ID:</strong> ${teacher.Teach_id}</p>
            <p><strong>Name:</strong> ${teacher.F_name} ${teacher.L_name}</p>
            <p><strong>Email:</strong> ${teacher.Email}</p>
            <p><strong>Subject:</strong> ${teacher.Subject}</p>
          </div>
          <button class="remove-btn" onclick="removeTeacher(${teacher.Teach_id})">Remove</button>
        `;

        container.appendChild(card);
      });
    } catch (error) {
      container.innerHTML = `<p class="error">${error.message}</p>`;
      console.error("Fetch error:", error);
    }
  };

  // Initial fetch
  fetchAndRenderTeachers();
});

function removeTeacher(teacherId) {
  if (confirm("Are you sure you want to delete this record?")) {
    fetch(
      `http://localhost/group_project_1.0/public/Institute_teacher/deleteTeacher/${teacherId}`,
      {
        method: "DELETE",
      }
    )
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
      })
      .then((data) => {
        alert("Record deleted successfully!");
        location.reload();
      })
      .catch((error) => {
        console.error("There was a problem with the fetch operation:", error);
      });
  }
}
