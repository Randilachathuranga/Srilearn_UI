document.addEventListener('DOMContentLoaded', () => {
    fetch('getClasses.php') // Replace with your PHP script that fetches classes
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const container = document.getElementById('class-container');
            data.forEach(classItem => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <img src="${classItem.image}" alt="${classItem.title}">
                    <div class="card-content">
                        <h3>${classItem.title}</h3>
                        <p>Subject: ${classItem.subject}</p>
                        <p>Institute: ${classItem.institute}</p>
                        <button class="card-button" onclick="showDetails('${classItem.title}')">More Details</button>
                        <button class="button" onclick="editshcedule()">
                          <img src="./icon/pencil.png" alt="Edit" class="icon"> Edit
                      </button>
                    </div>
                `;
                container.appendChild(card);
            });
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
  });
  
  // Function to show class details when button is clicked
  
  function showDetails(){
    alert("view");
  }

  function editshcedule(){
    document.getElementById("popupEditForm").style.display = "flex";
  }

