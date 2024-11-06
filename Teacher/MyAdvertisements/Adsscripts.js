document.addEventListener("DOMContentLoaded", () => {
    fetch("./getAllAdd.php") // Ensure the correct path to your PHP file
        .then((response) => {
            if (!response.ok) throw new Error("Network response was not ok");
            return response.json();
        })
        .then((data) => {
            const container = document.getElementById("class-container");
            data.forEach((ad) => {
                const card = document.createElement("div");
                card.className = "card";
                card.innerHTML = `
                    <div class="card-content">
                        <img src="${ad.image_url}" alt="${ad.title} image" class="card-image">
                        <div class="card-details">
                            <h3 class="card-title">${ad.title}</h3>
                            <p class="card-description">${ad.description}</p>
                            <div class="button-container">
                                <button class="button" onclick="editAd('${ad.title}')">
                                    <img src="./icon/pencil.png" alt="Edit" class="icon"> Edit
                                </button>
                                <button class="button" onclick="likeAd('${ad.title}')">
                                    <img src="./icon/heart.png" alt="Like" class="icon"> 459
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        })
        .catch((error) => {
            console.error("There was a problem with the fetch operation:", error);
        });
  });
  
  function showDetails(title, description) {
    alert("More details about the ad titled: " + title + "\n\n" + description);
  }
  
  function editAd(adsid) {
    document.getElementById("popupEditForm").style.display = "flex";
  
  }
  function likeAd(title) {
    alert("Liked ad titled: " + title);
  }
  
