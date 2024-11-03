document.addEventListener("DOMContentLoaded", () => {
  fetch("./getallInstitute.php") // Replace with your PHP script URL
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      const container = document.getElementById("class-container");
      data.forEach((institute) => {
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
          <img src="${institute.ImageURL}" alt="${institute.Name}" class="card-image">
          <div class="card-content">
            <h3>${institute.Name}</h3>
            <p>Phone: ${institute['Phone number']}</p>
            <p>District: ${institute.District}</p>
            <p>City: ${institute.City}</p>
            <button class="card-button" onclick="Applyinstitute('${institute.Name}')">Apply</button>
          </div>
        `;
        container.appendChild(card);
      });
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
});

// Function to show institute details when the button is clicked
function Applyinstitute(name) {
  alert("More details about " + name);
}

function serach(city){
  alert("searching");
}
