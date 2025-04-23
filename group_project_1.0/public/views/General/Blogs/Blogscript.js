document.addEventListener("DOMContentLoaded", () => {
  let currentPage = 1;
  let totalPages = 1;
  let currentSearch = '';

  const searchInput = document.getElementById('blog-search-input');
  const searchButton = document.getElementById('search-button');

  function fetchBlogs(page = 1, search = '') {
      // Construct URL with page and search parameters
      const url = new URL('http://localhost/group_project_1.0/public/Blog/api');
      url.searchParams.set('page', page);
      if (search) {
          url.searchParams.set('search', search);
      }

      fetch(url)
          .then((response) => {
              if (!response.ok) throw new Error("Network response was not ok");
              return response.json();
          })
          .then((data) => {
              const container = document.getElementById("class-container");
              container.innerHTML = ''; // Clear existing content

              // Update pagination variables
              currentPage = data.currentPage;
              totalPages = data.totalPages;
              currentSearch = data.searchTerm;

              // Handle no results scenario
              if (data.blogs.length === 0) {
                  const noResultsMessage = document.createElement('div');
                  noResultsMessage.textContent = 'No blogs found.';
                  noResultsMessage.style.textAlign = 'center';
                  noResultsMessage.style.padding = '20px';
                  container.appendChild(noResultsMessage);
              } else {
                  // Render blogs
                  data.blogs.forEach((record) => {
                      const card = document.createElement("div");
                      card.className = "card";
                      card.innerHTML = `
                          <div class="card-content">
                              <div class="card-header">
                                  <h2>Title: ${record.Title}</h2>
                                  <h3>By: ${record.user.F_name}</h3>
                              </div>
                              <p>Content: ${record.Content}</p>
                              <h5>Date: ${record.Post_date}</h5>
                              <h5>Likes: ${record.Likes}</h5>
                          </div>
                      `;

                      // Add delete button for sysadmin
                      if (sessionData.Role === "sysadmin") {
                          const buttonContainer = document.createElement("div");
                          buttonContainer.className = "button-container";
                          
                          const deleteButton = document.createElement("button");
                          deleteButton.className = "delete-blog-button";
                          deleteButton.textContent = "Delete Blog";
                          deleteButton.onclick = () => deleteBlog(record);
                          
                          buttonContainer.appendChild(deleteButton);
                          card.appendChild(buttonContainer);
                      }

                      container.appendChild(card);
                  });
              }

              // Update pagination controls
              updatePaginationControls();
          })
          .catch((error) => {
              console.error("There was a problem with the fetch operation:", error);
          });
  }

  function updatePaginationControls() {
      // Create pagination container if it doesn't exist
      let paginationContainer = document.getElementById('pagination-container');
      if (!paginationContainer) {
          paginationContainer = document.createElement('div');
          paginationContainer.id = 'pagination-container';
          paginationContainer.className = 'pagination-container';
          document.querySelector('.container').after(paginationContainer);
      }

      // Clear existing pagination controls
      paginationContainer.innerHTML = '';

      // Previous button
      const prevButton = document.createElement('button');
      prevButton.textContent = 'Previous';
      prevButton.disabled = currentPage === 1;
      prevButton.onclick = () => {
          if (currentPage > 1) fetchBlogs(currentPage - 1, currentSearch);
      };
      paginationContainer.appendChild(prevButton);

      // Page info
      const pageInfo = document.createElement('span');
      pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
      paginationContainer.appendChild(pageInfo);

      // Next button
      const nextButton = document.createElement('button');
      nextButton.textContent = 'Next';
      nextButton.disabled = currentPage === totalPages;
      nextButton.onclick = () => {
          if (currentPage < totalPages) fetchBlogs(currentPage + 1, currentSearch);
      };
      paginationContainer.appendChild(nextButton);
  }

  // Search functionality
  function performSearch() {
      const searchTerm = searchInput.value.trim();
      currentPage = 1; // Reset to first page on new search
      fetchBlogs(1, searchTerm);
  }

  // Add event listeners for search
  searchButton.addEventListener('click', performSearch);
  
  // Optional: Add search on Enter key press
  searchInput.addEventListener('keyup', (event) => {
      if (event.key === 'Enter') {
          performSearch();
      }
  });

  // Optional: Debounced real-time search
  let searchTimeout;
  searchInput.addEventListener('input', () => {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
          performSearch();
      }, 500); // 500ms delay to prevent too frequent searches
  });

  // Initial fetch
  fetchBlogs();

  // Existing functions
  window.deleteBlog = function(record) {
      console.log(`Delete blog triggered for Blog ID: ${record.Blog_id}`);
      // Implement delete logic if needed
  };

  window.gotomyBlog = function() {
      window.location.href = 'Blog/myblogs';
  };
});