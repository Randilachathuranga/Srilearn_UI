<?php 
include "C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Filter</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Byclasses/class.css">
</head>
<body>

<!-- Page Content Container -->
<div class="container">
    <!-- Title Section -->
    <div class="header-container">
        <h1 class="header-title">Classes</h1>
    </div>

    <!-- Banner Image -->
    <div class="banner-container">
        <img src="../../../../../group_project_1.0/public/views/General/Byclasses/teacher.jpg" alt="Teacher Image">
    </div>

    <!-- Filter Section -->
    <div class="filter-container">
        <h2>Filter Classes</h2>
        <div class="dropdown-container">
            <label for="subject">Select Subject:</label>
            <select id="subject">
                <option value="">--Select Subject--</option>
                <option value="Buddhism">Buddhism</option>
                <option value="Civics">Civics</option>
                <option value="Commerce">Commerce</option>
                <option value="Dance">Dance</option>
                <option value="Drama">Drama</option>
                <option value="Eastern Music">Eastern Music</option>
                <option value="English">English</option>
                <option value="Geography">Geography</option>
                <option value="Health">Health</option>
                <option value="History">History</option>
                <option value="ICT">ICT</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Pali">Pali</option>
                <option value="Physical Education">Physical Education</option>
                <option value="Physics">Physics</option>
                <option value="Political Science">Political Science</option>
                <option value="Religion">Religion</option>
                <option value="Science">Science</option>
                <option value="Sinhala">Sinhala</option>
                <option value="Tamil">Tamil</option>
                <option value="Technology">Technology</option>
                <option value="Western Music">Western Music</option>
            </select>

            <label for="grade">Select Grade:</label>
            <select id="grade">
                <option value="">--Select Grade--</option>
                <option value="1">Grade 1</option>
                <option value="2">Grade 2</option>
                <option value="3">Grade 3</option>
                <option value="4">Grade 4</option>
                <option value="5">Grade 5</option>
                <option value="6">Grade 6</option>
                <option value="7">Grade 7</option>
                <option value="8">Grade 8</option>
                <option value="9">Grade 9</option>
                <option value="10">Grade 10</option>
                <option value="11">Grade 11</option>
                <option value="12">Grade 12</option>
                <option value="13">Grade 13</option>
            </select>
        </div>
    </div>

    <!-- Classes Display Section -->
    <div class="classes-container" id="classes-container">
        <!-- Classes will be dynamically rendered here -->
    </div>
</div>

<!-- Inject user role into JS -->
<script>
    const userRole = "<?php echo $_SESSION['Role'] ?? ''; ?>";
</script>

<!-- Main Script -->
<script>
    document.addEventListener('DOMContentLoaded', fetchAllClasses);
    document.getElementById("subject").addEventListener("change", fetchFilteredClasses);
    document.getElementById("grade").addEventListener("change", fetchFilteredClasses);

    function fetchAllClasses() {
        const individualURL = 'http://localhost/group_project_1.0/public/Student/allindividual';
        const instituteURL = 'http://localhost/group_project_1.0/public/Student/allinstitute';

        Promise.all([
            fetch(individualURL).then(res => res.ok ? res.json() : []),
            fetch(instituteURL).then(res => res.ok ? res.json() : [])
        ])
        .then(([individualData, instituteData]) => {
            const allClasses = [...individualData, ...instituteData];
            renderClasses(allClasses);
        })
        .catch(error => console.error('Error fetching class data:', error));
    }

    function fetchFilteredClasses() {
        const subject = document.getElementById("subject").value;
        const grade = document.getElementById("grade").value;

        const fetchUrl1 = fetch(`http://localhost/group_project_1.0/public/Student/viewindividual/${subject}/${grade}`)
            .then(response => response.ok ? response.json() : []);

        const fetchUrl2 = fetch(`http://localhost/group_project_1.0/public/Student/viewinstitute/${subject}/${grade}`)
            .then(response => response.ok ? response.json() : []);

        Promise.all([fetchUrl1, fetchUrl2])
            .then(([data1, data2]) => {
                const combinedResults = [...(Array.isArray(data1) ? data1 : []), ...(Array.isArray(data2) ? data2 : [])];
                renderClasses(combinedResults);
            })
            .catch(error => {
                console.error('Error fetching filtered classes:', error);
                renderClasses([]);
            });
    }

    async function hasteachsubbedpayment(classId) {
        try {
            const response = await fetch(`http://localhost/group_project_1.0/public/Subscriptions/hassubbedteachpayment/${classId}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
            });
            if (!response.ok) throw new Error('Failed to check teacher subscription payment');
            return await response.json();
        } catch (error) {
            console.error('Error checking teacher payment:', error);
            return false;
        }
    }

    async function renderClasses(classes) {
        const container = document.getElementById('classes-container');
        container.innerHTML = "";

        if (!classes || classes.length === 0) {
            container.innerHTML = "<p>No classes available for the selected filters.</p>";
            return;
        }

        for (const record of classes) {
            let ispayavail = 1;
            if (record.Type === "Individual") {
                ispayavail = await hasteachsubbedpayment(record.Class_id);
            }

            const rec = document.createElement('div');
            rec.className = 'record';

            const subjectImages = {
                Accounting: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Accwebp.webp",
                Agriculture: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Agriculture.jpeg",
                Art: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Art.jpeg",
                BioSystemsTechnology: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/B.jpeg",
                Biology: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Bio.png",
                Buddhism: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Buddhism.webp",
                Physics: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
                Mathematics: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Maths.png",
                English: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/English.png",
                Chemistry: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
                History: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/History.png",
                IT: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/It.png",
                BusinessStudies: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/BusinessStudies.png",
                Catholicism: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Catholicism.jpeg",
                CivicEducation: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/CivicEducation.jpeg",
                Commerce: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Commerce.png",
                Drama: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Drama.jpeg",
                Engineering: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Engineering.jpeg",
                Geography: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Geography.jpeg",
                Health: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/H.jpeg",
                Science: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Science.jpeg",
                Sinhala: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Sinhala.jpeg",
                Tamil: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Sinhala.jpeg",
            };

            const subjectImage = subjectImages[record.Subject] || "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/default.png";
            
            rec.innerHTML = `
                <img src="${subjectImage}" alt="${record.Subject}" class="subject-image">
                <h2>Subject: ${record.Subject}</h2>
                <h5>Teacher: ${record.F_name || "N/A"} ${record.L_name || ""}</h5>
                <h3>Grade: ${record.Grade}</h3>
                <p>Type: ${record.Type}</p>
                <p>Address: ${record.Location}</p>
                <h5>Fee: ${record.fee}</h5>
                <p>Date: ${record.Def_Date}</p>
                <p>Time: ${record.Def_Time}</p>
            `;

            if (userRole === 'student') {
                const btn = document.createElement('button');
                btn.textContent = 'Join Class';
                btn.onclick = () => proceedtopayment(
                    record.Class_id,
                    record.Subject,
                    `${record.F_name || ''} ${record.L_name || ''}`.trim(),
                    record.fee,
                    ispayavail
                );
                rec.appendChild(btn);
            }

            container.appendChild(rec);
        }
    }

    function proceedtopayment(classID, subject, teacher, fee, ispayavail) {
        if (ispayavail == 1) {
            const url = new URL('http://localhost/group_project_1.0/public/Payment/enrollpayment');
            url.searchParams.set('classID', classID);
            url.searchParams.set('subject', subject);
            url.searchParams.set('teacher', teacher);
            url.searchParams.set('fee', fee);
            window.location.href = url.toString();
        } else {
            const recordData = {
                classID: classID,
                subject: subject,
                teacher: teacher,
                fee: fee
            };

            fetch(`http://localhost/group_project_1.0/public/Enrollment/postfree`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(recordData)
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                alert(data.error || data.message || 'Enrollment status unknown.');
                window.location.href = 'http://localhost/group_project_1.0/public/Enrollment';
            })
            .catch(error => {
                console.error('Error during enrollment:', error);
                alert('Could not complete enrollment. You are already enrolled in this class.');
            });
        }
    }
</script>

</body>
</html>

<?php
require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
?>
