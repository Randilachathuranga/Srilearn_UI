document.addEventListener("DOMContentLoaded", () => {
  fetch("./getAllClass.php") // Replace with your PHP script URL if different
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      const container = document.getElementById("class-container");
      data.forEach((className) => {
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
          <img src="${className.ImageURL}" alt="${className.Name}" class="card-image">
          <div class="card-content">
            <h3>${className.Name}</h3>
            <p>Subject: ${className.Subject}</p>
            <button class="card-button" onclick="ViewClass()">View</button>
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
function ViewClass(className) {
  document.getElementById("popupForm").style.display = "flex";  
}


