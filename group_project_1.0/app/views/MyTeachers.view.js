document.addEventListener("DOMContentLoaded", () => {

    const userDataElement = document.getElementById("user-data");
    if (!userDataElement) {
      console.error("User data element not found.");
      return;
    }
  
    // Get the user ID from the data attribute
    const ID = userDataElement.dataset.userId;
  
    const fetchAndRenderClasses = () => {
      fetch(`Institute_teacher/My_teachers/${ID}`)
        .then((response) => {
          if (!response.ok) {
            if (response.status === 403) {
              throw new Error("Access denied. Not a premium teacher.");
            } else if (response.status === 404) {
              throw new Error("No classes found for the given teacher.");
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
              <div class="card-content">
                <div class="card-details">
                  <p><strong>ID:</strong> ${teacher.Teacher_ID}</p>
                  <p><strong>Name:</strong> ${teacher.FirstName} ${teacher.LastName}</p>
                  <p><strong>Email:</strong> ${teacher.Email}</p>
                  <p><strong>Role:</strong> ${teacher.Role}</p>
                  <p><strong>Subject:</strong> ${teacher.Subject}</p>
                </div>
                <button class="remove-btn" onclick=Remove()>Remove</button>
              </div>
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
  
    // Initial fetch when the page loads
    fetchAndRenderClasses();
  });
  

  function Remove(){
    alert("not implemented")
  }