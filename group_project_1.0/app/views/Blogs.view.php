<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
</head>
<body>
    <?php
    // Corrected the condition to check for 'sysadmin' role
    if (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'UserNavBar.php';
    }
    ?>
    <script>
        const userId = <?php echo json_encode($_SESSION['User_id'] ?? ''); ?>;
    </script>
    <h1>BLOGS</h1>
    <button onclick="myblogs()">My blogs</button>
    <button onclick="handleform()">Write Blogs</button>
    <div id="container"></div> <!-- Updated to use id="container" -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('http://localhost/group_project_1.0/public/Blog/api')
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
                            <h2>Title: ${record.Title}</h2>
                            <h3>By: ${record.user.F_name}</h3>
                            <p>Content: ${record.Content}</p>
                            <h5>Date: ${record.Post_date}</h5>
                            <h5>Likes: ${record.Likes}</h5>
                        `;
                        container.appendChild(rec);
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        });

        function handleform() {
            window.location.href = `Blog/post/`;
        }

        function myblogs() {
            window.location.href = `Blog/myblogs`;
        }
    </script>
</body>
</html>
