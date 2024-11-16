// Show the popup form

  // Close the popup form
  function closeeditPopup() {
    document.getElementById("popupEditForm").style.display = "none";
  }
  

  function UpdateBlogs() {
    const blogId = document.getElementById("blogId").value;  // Assuming there's an input for the blog ID
    const title = document.getElementById("title").value;
    const description = document.getElementById("description").value;
  
    // Ensure the form fields are populated
    if (title && description && blogId) {
      // Prepare the data to send to the server
      const blogData = {
        id: blogId,
        title: title,
        description: description
      };
  
      // Log the data to check if it's correct
      console.log("Sending data:", blogData);
  
      // Send the data using fetch
      fetch('./updateBlog.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(blogData), // Send data as JSON
      })
      .then(response => response.json())  // Parse response as JSON
      .then(data => {
        if (data.success) {
          alert("Blog updated successfully!");
          closeeditPopup(); // Close the popup after successful update
        } else {
          alert("Failed to update the blog.");
        }
      })
      .catch(error => {
        console.error('Error updating blog:', error);
        alert('An error occurred while updating the blog.');
      });
    } else {
      alert("Please fill out all fields.");
    }
  }
  

  


  
// Function to handle deleting a blog
function deleteBlogs(blogId) {
  const confirmDelete = confirm("Are you sure you want to delete this blog?");
  
  if (confirmDelete) {
    // Send the request to the server to delete the blog
    fetch('./deleteBlog.php', {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ id: blogId }), // Send the blog ID in the body as JSON
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Blog deleted successfully!");
        closeeditPopup(); // Close the form after deletion
      } else {
        alert("Failed to delete the blog.");
      }
    })
    .catch(error => {
      console.error('Error deleting blog:', error);
      alert('An error occurred while deleting the blog.');
    });
  }
}

  // // Function to handle form submission (e.g., updating a blog)
  // function UpdateBlog() {
  //   const title = document.getElementById("title").value;
  //   const description = document.getElementById("description").value;
    
  //   if (title && description) {
  //     // Send data to server or handle it as needed
  //     console.log("Blog Title:", title);
  //     console.log("Blog Description:", description);
  
  //     closePopup(); // Close the form after submission
  //   } else {
  //     alert("Please fill out all fields.");
  //   }
  // }
  
  // // Function to handle deleting a blog
  // function deleteBlog() {
  //   const confirmDelete = confirm("Are you sure you want to delete this blog?");
  //   if (confirmDelete) {
  //     console.log("Blog deleted.");
  //     closePopup(); // Close the form after deletion
  //   }
  // }
  