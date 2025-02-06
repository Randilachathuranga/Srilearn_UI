const handleSubmit = () => {
  const contactForm = document.getElementById('contactForm');
  
  contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      
      fetch(`http://localhost/group_project_1.0/public/ContactUS/send/1`, {
          method: 'POST',
          body: formData
      })
      .then(response => {
          if (!response.ok) {
              throw new Error('Network response was not ok');
          }
          return response.json();
      })
      .then(data => {
          if (data.status === 'success') {
              alert('Message sent successfully!');
              this.reset();
          } else {
              alert(data.message || 'Failed to send message. Please try again.');
          }
      })
      .catch(error => {
          console.error('Error:', error);
          alert('An error occurred. Please try again.');
      });
  });
};

// Initialize form handler
document.addEventListener('DOMContentLoaded', handleSubmit);