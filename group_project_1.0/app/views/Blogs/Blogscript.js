document.addEventListener("DOMContentLoaded", () => {
  fetch("http://localhost/group_project_1.0/public/Blog/api")
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      const container = document.getElementById("class-container");

      data.forEach((record) => {
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
            <div class="card-content">
                <div class="card-header">
                    <h2>Title: ${record.Title}</h2>
                    <h3>By: ${record.user.F_name}</h3>
                </div>
                <p>Content: ${record.Content}</p>
                <h5>Date: ${record.Post_date}</h5>
                <h5>Likes: ${record.Likes}</h5>
            </div>
          `;

        // Add a delete button if the user is a sysadmin
        if (sessionData.Role === "sysadmin") {
          const buttonContainer = document.createElement("div");
          buttonContainer.className = "button-container";

          const deleteButton = document.createElement("button");
          deleteButton.className = "delete-blog-button";
          deleteButton.textContent = "Delete Blog";

          // Add a console log in the deleteBlog function
          deleteButton.onclick = () => deleteBlog(record);

          buttonContainer.appendChild(deleteButton);
          card.appendChild(buttonContainer);
        }

        container.appendChild(card);
      });
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
});

// Function to log a message when the delete button is clicked
function deleteBlog(record) {
  console.log(`Delete blog triggered for Blog ID: ${record.Blog_id}`);
}

function gotomyBlog() {
  window.location.href = `Blog/myblogs`;
}
