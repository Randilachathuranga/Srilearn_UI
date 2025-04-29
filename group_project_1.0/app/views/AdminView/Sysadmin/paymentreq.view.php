<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Requests Dashboard</title>
  <style>
    :root {
      --primary: #1976d2;
      --primary-light: #63a4ff;
      --primary-dark: #004ba0;
      --secondary: #dc3545;
      --secondary-light: #ff6b6b;
      --secondary-dark: #c82333;
      --background: #f5f9ff;
      --surface: #ffffff;
      --text-primary: #2c3e50;
      --text-secondary: #546e7a;
      --border: #e0e0e0;
      --success: #28a745;
      --error: #dc3545;
      --warning: #ffc107;
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
      --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
      --radius-sm: 4px;
      --radius: 8px;
      --radius-lg: 12px;
      --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--background);
      color: var(--text-primary);
      line-height: 1.6;
      padding: 2rem;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    h2 {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--primary-dark);
      margin: 2rem 0 1rem;
      padding-bottom: 0.75rem;
      border-bottom: 2px solid var(--primary-light);
    }

    .container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.5rem;
      max-width: 1400px;
      margin: 0 auto;
      padding: 1rem 0;
    }

    .section {
      margin-bottom: 3rem;
      width: 100%;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .record {
      background: var(--surface);
      padding: 1.25rem;
      border-radius: var(--radius);
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      border: 1px solid var(--border);
      position: relative;
      overflow: hidden;
    }

    .record:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-lg);
      border-color: var(--primary-light);
    }

    .record h3 {
      color: var(--primary);
      font-size: 1rem;
      font-weight: 600;
      margin-bottom: 0.75rem;
      padding-bottom: 0.5rem;
      border-bottom: 1px solid var(--border);
    }

    .record p {
      color: var(--text-secondary);
      font-size: 0.875rem;
      margin: 0.5rem 0;
    }

    .record h5 {
      color: var(--text-primary);
      font-size: 0.875rem;
      font-weight: 500;
      margin: 0.5rem 0;
    }

    .record .amount {
      font-weight: 600;
      color: var(--primary-dark);
      font-size: 1rem;
      margin: 0.75rem 0;
    }

    .button-container {
      display: flex;
      gap: 0.75rem;
      margin-top: 1rem;
    }

    .record button {
      flex: 1;
      padding: 0.625rem;
      border: none;
      border-radius: var(--radius-sm);
      cursor: pointer;
      transition: var(--transition);
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .record button.approve {
      background-color: var(--primary);
      color: white;
    }

    .record button.reject {
      background-color: var(--secondary);
      color: white;
    }

    .record button.approve:hover {
      background-color: var(--primary-dark);
      box-shadow: 0 2px 8px rgba(25, 118, 210, 0.3);
    }

    .record button.reject:hover {
      background-color: var(--secondary-dark);
      box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }

    .empty-message {
      font-style: italic;
      color: var(--text-secondary);
      text-align: center;
      width: 100%;
      padding: 2rem;
      background: var(--surface);
      border-radius: var(--radius);
      box-shadow: var(--shadow-sm);
      grid-column: 1 / -1;
    }

    .status-badge {
      position: absolute;
      top: 0;
      right: 0;
      padding: 0.25rem 0.75rem;
      font-size: 0.7rem;
      font-weight: 600;
      text-transform: uppercase;
      border-bottom-left-radius: var(--radius-sm);
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }

    @media (max-width: 768px) {
      body {
        padding: 1rem;
      }
      
      .container {
        grid-template-columns: 1fr;
      }
      
      h2 {
        font-size: 1.25rem;
        margin: 1.5rem 0 1rem;
      }
    }

    /* Loading state */
    .loading {
      display: inline-block;
      width: 1rem;
      height: 1rem;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

  <div class="section" id="institute-section">
    <div class="section-header">
      <h2>Institute Payment Requests</h2>
    </div>
    <div class="container" id="institute-container"></div>
  </div>

  <div class="section" id="teacher-section">
    <div class="section-header">
      <h2>Teacher Payment Requests</h2>
    </div>
    <div class="container" id="teacher-container"></div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Show loading state
      const instituteContainer = document.getElementById('institute-container');
      const teacherContainer = document.getElementById('teacher-container');
      
      instituteContainer.innerHTML = '<div class="empty-message">Loading institute requests...</div>';
      teacherContainer.innerHTML = '<div class="empty-message">Loading teacher requests...</div>';

      fetch(`http://localhost/group_project_1.0/public/Sysadmin/payreqapi`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          let hasInstitute = false;
          let hasTeacher = false;

          if (!Array.isArray(data) || data.length === 0) {
            instituteContainer.innerHTML = '<div class="empty-message">No institute payment requests found.</div>';
            teacherContainer.innerHTML = '<div class="empty-message">No teacher payment requests found.</div>';
            return;
          }

          // Clear loading messages
          instituteContainer.innerHTML = '';
          teacherContainer.innerHTML = '';

          data.forEach(record => {
            const rec = document.createElement('div');
            rec.className = 'record';
            rec.innerHTML = `
              <div class="status-badge status-pending">Pending</div>
              <h3>Request #${record.req_id}</h3>
              <p>Institute ID: ${record.inst_id}</p>
              <h5 class="amount">$${record.amount}</h5>
              <h5>Requested: ${record.date} at ${record.time}</h5>
              <div class="button-container">
                <button class="approve" onclick="handleAction(${record.req_id}, 'approve')">
                  Approve
                </button>
                <button class="reject" onclick="handleAction(${record.req_id}, 'reject')">
                  Reject
                </button>
              </div>
            `;

            if (record.Role === 'institute') {
              instituteContainer.appendChild(rec);
              hasInstitute = true;
            } else if (record.Role === 'teacher') {
              teacherContainer.appendChild(rec);
              hasTeacher = true;
            }
          });

          if (!hasInstitute) {
            instituteContainer.innerHTML = '<div class="empty-message">No institute payment requests found.</div>';
          }

          if (!hasTeacher) {
            teacherContainer.innerHTML = '<div class="empty-message">No teacher payment requests found.</div>';
          }
        })
        .catch(error => {
          console.error('There was an error!', error);
          instituteContainer.innerHTML = '<div class="empty-message">Failed to load institute requests. Please try again.</div>';
          teacherContainer.innerHTML = '<div class="empty-message">Failed to load teacher requests. Please try again.</div>';
        });
    });

    function handleAction(reqId, action) {
      const buttons = document.querySelectorAll(`button[onclick*="${reqId}"]`);
      buttons.forEach(button => {
        button.disabled = true;
        const actionText = button.textContent.trim();
        button.innerHTML = `<span class="loading"></span> ${actionText}ing...`;
      });

      fetch(`http://localhost/group_project_1.0/public/Sysadmin/${action}/${reqId}`, {
        method: 'POST'
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          showToast(`${action.charAt(0).toUpperCase() + action.slice(1)} successful!`, 'success');
          setTimeout(() => location.reload(), 1500);
        } else {
          showToast(`Failed to ${action} request`, 'error');
          buttons.forEach(button => {
            button.disabled = false;
            button.textContent = button.textContent.replace('ing...', '');
          });
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred', 'error');
        buttons.forEach(button => {
          button.disabled = false;
          button.textContent = button.textContent.replace('ing...', '');
        });
      });
    }

    function showToast(message, type) {
      const toast = document.createElement('div');
      toast.style.position = 'fixed';
      toast.style.bottom = '20px';
      toast.style.right = '20px';
      toast.style.padding = '12px 24px';
      toast.style.borderRadius = '4px';
      toast.style.color = 'white';
      toast.style.fontWeight = '500';
      toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
      toast.style.zIndex = '1000';
      toast.style.transform = 'translateY(30px)';
      toast.style.opacity = '0';
      toast.style.transition = 'all 0.3s ease';
      
      if (type === 'success') {
        toast.style.backgroundColor = 'var(--success)';
      } else {
        toast.style.backgroundColor = 'var(--error)';
      }
      
      toast.textContent = message;
      document.body.appendChild(toast);
      
      setTimeout(() => {
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';
      }, 10);
      
      setTimeout(() => {
        toast.style.transform = 'translateY(30px)';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
      }, 3000);
    }
  </script>
</body>
</html>