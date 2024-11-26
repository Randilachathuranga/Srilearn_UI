document.addEventListener('DOMContentLoaded', () => {
  fetch('http://localhost/group_project_1.0/public/Blog/api')
      .then(response => {
          if (!response.ok) throw new Error('Network response was not ok');
          return response.json();
      })
      .then(data => {
          const container = document.getElementById('class-container');
          data.forEach(record => {
              const card = document.createElement('div');
              card.className = 'card';
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
              container.appendChild(card);
          });
      })
      .catch(error => {
          console.error('There was a problem with the fetch operation:', error);
      });
});


function gotomyBlog(){
    window.location.href=`Blog/myblogs`;
}

