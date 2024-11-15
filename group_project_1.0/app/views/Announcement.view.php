<!DOCTYPE html>
<html>
<head>
    <title>System Announcements</title>
</head>
<body>

<div class='header'><h1>Announcements</h1></div>
<div id='container' class='container'>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetch('http://localhost/group_project_1.0/public/Announcement/api') // Adjust this URL to match your routing structure
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                const container = document.getElementById('container'); // Using the correct ID
                data.forEach(record => {
                    const rec = document.createElement('div');
                    rec.className = 'record';
                    rec.innerHTML = `
                        <h3>Title: ${record.title}</h3>
                        <p>Announcement: ${record.announcement}</p>
                        <h5>Date: ${record.date}</h5>
                    `;
                    container.appendChild(rec); // Appending the `rec` div correctly
                });
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });
</script>

</body>
</html>
