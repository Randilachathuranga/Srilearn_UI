<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php';
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Classes</title>
  <link rel="stylesheet" href="../../../../group_project_1.0/public/views/InstituteView/Class.view.css"> <!-- Link to the separate CSS file -->
</head>
<body>

  <div class="top-bar">
    <button onclick="requestMonthlyPayment()">Request Monthly Payment</button>
  </div>

  <div id="container"></div>

  <script>
    var userID = "<?php echo $_SESSION['User_id'] ?? ''; ?>";
    var userRole = "<?php echo $_SESSION['role'] ?? ''; ?>";

    document.addEventListener('DOMContentLoaded', () => {
      fetch(`http://localhost/group_project_1.0/public/Institute/classapi/${userID}`)
        .then(response => {
          if (!response.ok) throw new Error('Network response was not ok');
          return response.json();
        })
        .then(data => {
          const container = document.getElementById('container');
          data.forEach(record => {
            const rec = document.createElement('div');
            rec.className = 'record';
            rec.innerHTML = `
              <h2 ><strong>Subject:</strong> ${record.Subject}</h2>
              <h3>${record.F_name} ${record.L_name}</h3>
              <p><strong>Location:</strong> ${record.Location}</p>
              <p><strong>Hall:</strong> ${record.Hall_number}</p>
              <p><strong>Start Date:</strong> ${record.Start_date}</p>
              <p><strong>End Date:</strong> ${record.End_date}</p>
              <p><strong>Grade:</strong> ${record.Grade}</p>
              <p><strong>Max Students:</strong> ${record.Max_std}</p>
              <p><strong>Fee:</strong> Rs.${record.fee}</p>
                <p><strong>Date:</strong> ${record.Def_Date}</p>
              <p><strong>Time:</strong> Rs.${record.Def_Time}</p>
              <div class="btn-group">
                <button onclick="viewStudents(${record.InstClass_id})">View Students</button>
                <button  onclick="payteacher(${record.InstClass_id})">Pay Teacher</button>
                <button class="red" onclick="handleDelete(${record.InstClass_id})">Delete</button>
                <button  onclick="viewclassschedules(${record.InstClass_id})">Class Shedules</button>
              </div>
            `;
            container.appendChild(rec);
          });
        })
        .catch(error => console.error('There was an error!', error));
    });

    function payteacher(id) {
      fetch(`http://localhost/group_project_1.0/public/Institute/payfee/${id}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
      })
      .then(async (response) => {
        const data = await response.json();
        if (!response.ok) {
          alert(data.message || 'Unknown error');
          throw new Error(data.message || 'Unknown error');
        }
        if (data.status === 'success') {
          alert('✅ Monthly payment request sent successfully!');
          location.reload();
        } else {
          alert(`❌ Failed: ${data.message}`);
        }
      })
      .catch(error => {
        console.error('Request error:', error);
        alert('⚠️ Something went wrong. Try again later.');
      });
    }

    function handleDelete(classId) {
      console.log('Deleting class with ID:', classId);
    }

    function viewStudents(Class_id) {
    sessionStorage.setItem("class_id", Class_id);
    window.location.href =
    "http://localhost/group_project_1.0/public/ClassStudents";
    console.log("Class ID stored in sessionStorage:", Class_id);
}

  
    //
    function requestMonthlyPayment() {
    // First check if a payment request already exists for this month
    fetch(`http://localhost/group_project_1.0/public/Payment/checkinstpayreq`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            // Payment request already exists for this month
            alert(data.message);
        } else {
            // No payment request for this month, proceed with creating one
            createPaymentRequest();
        }
    })
    .catch(error => {
        console.error('There was an error checking payment request status!', error);
    });
}

function createPaymentRequest() {
    fetch(`http://localhost/group_project_1.0/public/Payment/requestMonthlyPayment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ userID })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Monthly payment request sent successfully!');
            location.reload(); // Reload the page to see updated data
        } else {
            alert('Failed to send monthly payment request.');
        }
    })
    .catch(error => {
        console.error('There was an error creating payment request!', error);
    });
}
    
    //
    function viewclassschedules(Class_id) {
    sessionStorage.setItem("class_id", Class_id);
    window.location.href =
    "http://localhost/group_project_1.0/public/ClassShcedules";
    console.log("Class ID stored in sessionStorage:", Class_id);
}
  </script>
   <script>
    const Role = "<?php echo $_SESSION['teacher']; ?>";
  </script>
</body>
</html>

<?php
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
        ?>
