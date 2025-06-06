<?php
    // Corrected the condition to check for 'sysadmin' role
    if (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
        require 'C:xampp/htdocs/group_project_1.0/app/views/General/NavBar/User_NavBar/UserNavBar.view.php';
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blogs</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Blogs/myblogs.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header-container">
        <h1 class="header-title">My Blogs</h1>
        <img src="../../../../../group_project_1.0/public/views/General/Blogs/blogs1.png" alt="Blogs Banner" class="banner-image">
    </div>
    <div id="container"></div> 

    <script>
        // Fetch User ID from PHP and store it as a JavaScript variable
        const userId = <?php echo json_encode($_SESSION['User_id'] ?? ''); ?>;

        // Ensure that userId is defined
        if (userId) {
            document.addEventListener('DOMContentLoaded', () => {
                fetch(`http://localhost/group_project_1.0/public/Blog/myapi/${userId}`)
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
                                <p>Content: ${record.Content}</p>
                                <h5>Date: ${record.Post_date}</h5>
                                <button onclick="handleDelete(${record.Blog_id})">Delete</button>
                                <button onclick="toggleUpdateForm(${record.Blog_id})">Update</button>
                                
                                <!-- Update Form (initially hidden) -->
                                <form id="updateForm-${record.Blog_id}" style="display:none;" onsubmit="handleUpdate(event, ${record.Blog_id})">
                                    <label>
                                        Title: 
                                        <input type="text" name="Title"  required>
                                    </label>
                                    <br>
                                    <label>
                                        Content: 
                                        <textarea name="Content" required></textarea>
                                    </label>
                                    <br>
                                    <button type="submit">Save Changes</button>
                                    <button type="button" onclick="cancelUpdate(${record.Blog_id})">Cancel</button> <!-- Cancel button -->
                                </form>
                            `;
                            container.appendChild(rec);
                        });
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        } else {
            console.error("User ID not found in session.");
        }

        // Function to toggle the visibility of the update form
        function toggleUpdateForm(blogId) {
            const form = document.getElementById(`updateForm-${blogId}`);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        // Function to handle blog deletion
        function handleDelete(blogId) {
            if (confirm('Are you sure you want to delete this blog?')) {
            fetch(`http://localhost/group_project_1.0/public/Blog/mydeleteapi/${blogId}`, {
                method: 'DELETE',
                headers: {
                'Content-Type': 'application/json',
                }
            })
            .then(() => {
                location.reload(); // Reload the page to reflect deletion
            })
            .catch(error => {
                console.error('Error deleting record:', error);
            });
            }
        }

        // Function to handle blog update
        function handleUpdate(event, blogId) {
            event.preventDefault(); // Prevent the form from submitting the traditional way
            
            // Get form data from the event target
            const form = event.target;
            const formData = new FormData(form);
            
            // Convert form data to JSON
            const data = {
            Title: formData.get('Title'),
            Content: formData.get('Content')
            };
            console.log(data);
            fetch(`http://localhost/group_project_1.0/public/Blog/myupdateapi/${blogId}`, {
            method: 'POST', // Change to 'POST' for sending data
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data) // Send the data as a JSON string
            })
            .then(response => {
            if (!response.ok) throw new Error('Update failed');
            return response.json();
            })
            .then(() => {
            location.reload();
            })
            .catch(error => {
            console.error('Error updating record:', error);
            });
        }

        // Function to pre-fill the update form with existing data
        function toggleUpdateForm(blogId) {
            const form = document.getElementById(`updateForm-${blogId}`);
            const recordDiv = form.parentElement;

            // Pre-fill the form with existing data
            const titleElement = recordDiv.querySelector('h2');
            const contentElement = recordDiv.querySelector('p');

            if (titleElement && contentElement) {
                const title = titleElement.textContent.replace('Title: ', '');
                const content = contentElement.textContent.replace('Content: ', '');

                form.querySelector('input[name="Title"]').value = title;
                form.querySelector('textarea[name="Content"]').value = content;
            } else {
                console.error('Unable to find title or content elements for pre-filling the form.');
            }

            // Toggle form visibility
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        // Function to cancel the update and hide the form
        function cancelUpdate(blogId) {
            const form = document.getElementById(`updateForm-${blogId}`);
            form.style.display = 'none'; // Hide the form
        }
    </script>
</body>
</html>

<?php
 
 if (!(isset($_SESSION['Role']) && $_SESSION['Role'] === 'sysadmin')) {
    require 'C:xampp/htdocs/group_project_1.0/app/views/General/Footer/Footer.php';
}
    ?>
