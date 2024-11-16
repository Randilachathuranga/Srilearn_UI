document.addEventListener('DOMContentLoaded', () => {
   
    const P_id = 7/* Your logic to get P_id, e.g., from localStorage or query params */
    
    fetch(`Ind_Myclass/MyclassApi/${P_id}`)
        .then(response => {
            if (!response.ok) {
                if (response.status === 403) {
                    throw new Error('Access denied. Not a premium teacher.');
                } else if (response.status === 404) {
                    throw new Error('No classes found for the given teacher.');
                } else {
                    throw new Error('An unexpected error occurred.');
                }
            }
            return response.json(); // Parse the response JSON
        })
        .then(data => {
            const container = document.getElementById('class-container');
            if (!container) {
                console.error("Container element with ID 'class-container' not found.");
                return;
            }

            container.innerHTML = ''; // Clear any existing content
            if (!data || data.length === 0) {
                container.innerHTML = '<p>No classes found for this teacher.</p>';
                return;
            }
            data.forEach(classItem => {
                const card = document.createElement('div');
                card.className = 'card';

                const subjectImages = {
                    Physics: '../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/science.png',
                    Mathematics: '../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/Maths.png',
                    English: '../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/English.png',
                    Chemistry: '../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/science.png',
                    History: '../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/History.png',
                    IT: '../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/It.png',
                    Biology: '../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/Bio.png',


                    // Add more subjects and their images as needed
                };
                const imageUrl = subjectImages[classItem.Subject] || '../../../../../group_project_1.0/app/views/TeacherView/Myclass/Class_images/defult.jpg';

                
                card.innerHTML = `
                    <div class="card-content">
                        <img src="${imageUrl}" alt="${classItem.title}">
                        <h3>${classItem.Subject} - ${classItem.Grade}</h3>
                        <p>Location: ${classItem.Location}</p>
                        <p>id: ${classItem.Class_id}</p>
                        <p>Start Time: ${classItem.Start_Time}</p>
                        <p>End Time: ${classItem.End_time}</p>
                        <button class="card-button" onclick="showDetails(${classItem.Class_id})">More Details</button>
                        <button class="button" onclick="editSchedule(${classItem.Class_id})">
                            <img src="../../../../../group_project_1.0/app/views/TeacherView/Myclass/icon/pencil.png" alt="Edit" class="icon"> Edit
                        </button>
                    </div>
                `;
                container.appendChild(card);
            });
        })
        .catch(error => {
            const container = document.getElementById('class-container');
            if (container) {
                container.innerHTML = `<p class="error">${error.message}</p>`;
            }
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
