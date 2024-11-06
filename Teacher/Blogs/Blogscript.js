document.addEventListener("DOMContentLoaded", () => {
  fetch("./getBlogs.php")
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      const container = document.getElementById("class-container");
      data.forEach((blogs) => {
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
          <div class="card-content">
              <div class="card-header">
                  <h3 class="card-title">${blogs.title}</h3>
                  <div class="button-container">
                      <button class="button" onclick="likeBlog('${blogs.id}')">
                          <img src="./icon/heart.png" alt="Like" class="icon"> 459
                      </button>
                      <button class="button" onclick="showDetails('${blogs.title}')">
                         <img src="./icon/chevron.png" alt="down" class="icon">See more
                        </button>
                  </div>
              </div>
              <p class="card-creator">Creator: ${blogs.creator}</p>
          </div>
        `;
        container.appendChild(card);
      });
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
});

function showDetails(title) {
  alert("More details about the blog titled: " + title);
}

function editBlog(blogId) {
  alert("Edit blog with ID: " + blogId);
}

function likeBlog(blogId) {
  alert("Liked blog with ID: " + blogId);
}

