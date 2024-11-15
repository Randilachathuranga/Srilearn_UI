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
                        <button class="card-button" onclick="showDetails(${classItem.id})">More Details</button>
                        <button class="button" onclick="editSchedule()">
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

// Function to show class details when "More Details" button is clicked
function showDetails(id) {
    fetch(`./More_details/more.php`) // Pass the class ID to PHP for fetching details
        .then(response => response.json())
        .then(details => {
            document.getElementById('classImage').src = details.image;
            document.getElementById('classTitle').textContent = details.title;
            document.getElementById('classSubject').textContent = details.subject;
            document.getElementById('classInstitute').textContent = details.institute;
            document.getElementById('classGrade').textContent = details.grade;
            document.getElementById('classFee').textContent = details.fee;
            document.getElementById('classTime').textContent = `${details.start_time} - ${details.end_time}`;

            // Show modal
            document.getElementById('modalBackground').style.display = 'block';
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Function to close the modal
function closeModal() {
    document.getElementById('modalBackground').style.display = 'none';
}

// Function to show the edit schedule popup form
function editSchedule() {
    document.getElementById("popupEditForm").style.display = "flex";
}
