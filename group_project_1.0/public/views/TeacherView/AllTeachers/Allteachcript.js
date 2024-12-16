document.addEventListener("DOMContentLoaded", () => {
  fetch(
    // "../../../../../group_project_1.0/app/views/TeacherView/AllTeachers/getallteachers.php"
    "../../../../group_project_1.0/app/views/TeacherView/AllTeachers/getallteachers.php"
  ) // Replace with your PHP script URL if different
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      const container = document.getElementById("class-container");
      data.forEach((teacher) => {
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
          <img src="${teacher.ImageURL}" alt="${
          teacher.Name
        }" class="card-image">
          <div class="card-content">
            <h3>${teacher.Name}</h3>
            <p>Subject: ${teacher.Subject}</p>
            <p>Phone: ${teacher["Phone number"]}</p>
            <p>Email: ${teacher.email || "N/A"}</p>
            <button class="card-button" onclick="Viewteacher()">View</button>
          </div>
        `;
        container.appendChild(card);
      });
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
});

// Function for searching (if needed)
function search(city) {
  alert("Searching for " + city);
}

// Show the popup form
function Viewteacher(teacher) {
  document.getElementById("popupForm").style.display = "flex";
}
