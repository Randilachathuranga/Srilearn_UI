<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Analytics Dashboard</title>
  <!-- jsPDF & html2pdf -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary: #2563eb;
      --primary-light: #3b82f6;
      --primary-dark: #1d4ed8;
      --primary-bg: #eff6ff;
      --secondary: #10b981;
      --danger: #ef4444;
      --warning: #f59e0b;
      --text-primary: #1f2937;
      --text-secondary: #4b5563;
      --text-tertiary: #6b7280;
      --border: #e5e7eb;
      --border-light: #f3f4f6;
      --surface: #ffffff;
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
      --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
      --radius-sm: 6px;
      --radius: 8px;
      --radius-lg: 12px;
      --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: var(--primary-bg);
      color: var(--text-primary);
      line-height: 1.5;
      padding: 2rem;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
      background-color: var(--surface);
      padding: 2.5rem;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-md);
    }

    h2 {
      text-align: center;
      margin-bottom: 2rem;
      color: var(--primary-dark);
      font-weight: 600;
      font-size: 1.75rem;
      letter-spacing: -0.5px;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: var(--text-secondary);
      font-size: 0.9375rem;
    }

    select {
      width: 100%;
      padding: 0.875rem 1rem;
      border: 1px solid var(--border);
      border-radius: var(--radius-sm);
      font-size: 1rem;
      color: var(--text-primary);
      background-color: var(--surface);
      transition: var(--transition);
      appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 0.75rem center;
      background-size: 1rem;
    }

    select:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    button {
      width: 100%;
      padding: 1rem;
      background-color: var(--primary);
      color: white;
      border: none;
      border-radius: var(--radius-sm);
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    button:hover {
      background-color: var(--primary-dark);
      box-shadow: var(--shadow-md);
    }

    button:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }

    .result-section {
      display: none;
      margin-top: 2rem;
      animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--primary-dark);
      margin: 2rem 0 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid var(--border);
    }

    .table-wrapper {
      margin-bottom: 2.5rem;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5rem;
      box-shadow: var(--shadow-sm);
      border-radius: var(--radius-sm);
      overflow: hidden;
    }

    th, td {
      padding: 1rem 1.25rem;
      text-align: left;
      border: 1px solid var(--border-light);
    }

    th {
      background-color: var(--primary);
      color: white;
      font-weight: 500;
      text-transform: uppercase;
      font-size: 0.8125rem;
      letter-spacing: 0.5px;
    }

    tr:nth-child(even) {
      background-color: var(--border-light);
    }

    tr:hover {
      background-color: rgba(59, 130, 246, 0.05);
    }

    .no-data {
      background-color: var(--border-light);
      padding: 1.5rem;
      border-radius: var(--radius-sm);
      text-align: center;
      color: var(--text-secondary);
      font-style: italic;
      border-left: 4px solid var(--primary);
    }

    .stats-container {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: var(--surface);
      padding: 1.5rem;
      border-radius: var(--radius-sm);
      box-shadow: var(--shadow-sm);
      border-left: 4px solid var(--primary);
    }

    .stat-card h3 {
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--text-secondary);
      margin-bottom: 0.5rem;
    }

    .stat-card p {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--primary-dark);
    }

    .loading {
      display: inline-block;
      width: 1.25rem;
      height: 1.25rem;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
      body {
        padding: 1rem;
      }
      
      .container {
        padding: 1.5rem;
      }
      
      .stats-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Payment Analytics Dashboard</h2>

    <div class="form-group">
      <label for="month">Select Month</label>
      <select id="month">
        <option value="">-- Select Month --</option>
      </select>
    </div>

    <div class="form-group">
      <label for="year">Select Year</label>
      <select id="year">
        <option value="">-- Select Year --</option>
      </select>
    </div>

    <button id="fetchBtn" onclick="fetchPayments()">Generate Report</button>

    <div id="result" class="result-section">
      <div class="stats-container" id="statsContainer"></div>
      <div id="teachersSection" class="table-wrapper"></div>
      <div id="institutesSection" class="table-wrapper"></div>
      <button onclick="downloadPDF()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="7 10 12 15 17 10"></polyline>
          <line x1="12" y1="15" x2="12" y2="3"></line>
        </svg>
        Download Report as PDF
      </button>
    </div>
  </div>

  <script>
    const monthSelect = document.getElementById('month');
    const yearSelect = document.getElementById('year');
    const resultDiv = document.getElementById('result');
    const teachersSection = document.getElementById('teachersSection');
    const institutesSection = document.getElementById('institutesSection');
    const statsContainer = document.getElementById('statsContainer');
    const fetchBtn = document.getElementById('fetchBtn');

    // Populate months
    const months = [
      'January', 'February', 'March', 'April', 
      'May', 'June', 'July', 'August',
      'September', 'October', 'November', 'December'
    ];
    
    months.forEach((month, index) => {
      const option = document.createElement('option');
      option.value = (index + 1).toString().padStart(2, '0');
      option.textContent = month;
      monthSelect.appendChild(option);
    });

    // Populate years
    const currentYear = new Date().getFullYear();
    for (let y = currentYear; y >= 2000; y--) {
      const option = document.createElement('option');
      option.value = y;
      option.textContent = y;
      yearSelect.appendChild(option);
    }

    // Set current month/year as default
    monthSelect.value = (new Date().getMonth() + 1).toString().padStart(2, '0');
    yearSelect.value = currentYear;

    function fetchPayments() {
      const month = monthSelect.value;
      const year = yearSelect.value;

      if (!month || !year) {
        showToast('Please select both month and year', 'warning');
        return;
      }

      // Show loading state
      fetchBtn.disabled = true;
      fetchBtn.innerHTML = `<span class="loading"></span> Generating Report...`;

      fetch('http://localhost/group_project_1.0/public/Sysadmin/analatics', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ month, year })
      })
      .then(response => response.json())
      .then(data => {
        if (data?.status === 'success' && Array.isArray(data.records)) {
          const teachers = data.records.filter(r => r.Role === 'teacher');
          const institutes = data.records.filter(r => r.Role === 'institute');
          
          // Generate stats
          generateStats(teachers, institutes, month, year);
          
          // Generate tables
          teachersSection.innerHTML = generateTable(teachers, 'Teacher Payments');
          institutesSection.innerHTML = generateTable(institutes, 'Institute Payments');

          resultDiv.style.display = 'block';
          showToast('Report generated successfully', 'success');
        } else {
          resultDiv.style.display = 'block';
          statsContainer.innerHTML = '';
          teachersSection.innerHTML = `<div class="no-data">${data.message || 'No payment records found for this period.'}</div>`;
          institutesSection.innerHTML = '';
          showToast(data.message || 'No data available', 'info');
        }
      })
      .catch(error => {
        console.error("Fetch error:", error);
        resultDiv.style.display = 'block';
        statsContainer.innerHTML = '';
        teachersSection.innerHTML = `<div class="no-data">An error occurred while fetching data.</div>`;
        institutesSection.innerHTML = '';
        showToast('Failed to fetch data', 'error');
      })
      .finally(() => {
        fetchBtn.disabled = false;
        fetchBtn.textContent = 'Generate Report';
      });
    }

    function generateStats(teachers, institutes, month, year) {
      const totalTeachers = teachers.length;
      const totalInstitutes = institutes.length;
      const totalPayments = totalTeachers + totalInstitutes;
      
      const teacherAmount = teachers.reduce((sum, t) => sum + parseFloat(t.amount || 0), 0);
      const instituteAmount = institutes.reduce((sum, i) => sum + parseFloat(i.amount || 0), 0);
      const totalAmount = teacherAmount + instituteAmount;
      
      statsContainer.innerHTML = `
        <div class="stat-card">
          <h3>Selected Period</h3>
          <p>${months[parseInt(month) - 1]} ${year}</p>
        </div>
        <div class="stat-card">
          <h3>Total Payments</h3>
          <p>${totalPayments}</p>
        </div>
        <div class="stat-card">
          <h3>Teacher Payments</h3>
          <p>$${teacherAmount.toFixed(2)}</p>
        </div>
        <div class="stat-card">
          <h3>Institute Payments</h3>
          <p>$${instituteAmount.toFixed(2)}</p>
        </div>
        <div class="stat-card">
          <h3>Total Amount</h3>
          <p>$${totalAmount.toFixed(2)}</p>
        </div>
        <div class="stat-card">
          <h3>Average Payment</h3>
          <p>$${totalPayments > 0 ? (totalAmount / totalPayments).toFixed(2) : '0.00'}</p>
        </div>
      `;
    }

    function generateTable(records, title) {
      if (records.length === 0) {
        return `<div class="no-data">No ${title.toLowerCase()} found for this period.</div>`;
      }

      const rows = records.map(r => `
        <tr>
          <td>${r.date || '-'}</td>
          <td>${r.time || '-'}</td>
          <td>$${parseFloat(r.amount || 0).toFixed(2)}</td>
          <td>${r.Role || '-'}</td>
          <td>${r.Email || '-'}</td>
        </tr>`).join('');

      return `
        <div class="section-title">${title}</div>
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Amount</th>
              <th>Role</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>${rows}</tbody>
        </table>`;
    }

    function downloadPDF() {
      const element = document.createElement('div');
      const dateStr = new Date().toLocaleString();
      const month = monthSelect.options[monthSelect.selectedIndex].text;
      const year = yearSelect.value;
      
      // Clone sections to avoid modifying the original
      const teachersClone = teachersSection.cloneNode(true);
      const institutesClone = institutesSection.cloneNode(true);
      
      // Remove buttons from PDF
      teachersClone.querySelectorAll('button').forEach(btn => btn.remove());
      institutesClone.querySelectorAll('button').forEach(btn => btn.remove());
      
      element.innerHTML = `
        <div style="text-align: center; margin-bottom: 20px;">
          <h1 style="color: #2563eb; font-size: 24px; margin-bottom: 5px;">Payment Analytics Report</h1>
          <h2 style="color: #4b5563; font-size: 18px; font-weight: 500;">${month} ${year}</h2>
          <p style="color: #6b7280; font-size: 12px; margin-top: 10px;">Generated on ${dateStr}</p>
        </div>
        <div style="margin-bottom: 30px;">
          ${statsContainer.innerHTML}
        </div>
        ${teachersClone.innerHTML}
        ${institutesClone.innerHTML}
      `;

      const opt = {
        margin: [0.5, 0.5],
        filename: `payment-report-${month}-${year}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { 
          scale: 2,
          scrollY: 0,
          windowHeight: document.body.scrollHeight
        },
        jsPDF: { 
          unit: 'in', 
          format: 'letter', 
          orientation: 'portrait',
          hotfixes: ["px_scaling"] 
        }
      };

      html2pdf().set(opt).from(element).save();
    }

    function showToast(message, type) {
      const toast = document.createElement('div');
      toast.style.position = 'fixed';
      toast.style.bottom = '20px';
      toast.style.right = '20px';
      toast.style.padding = '12px 24px';
      toast.style.borderRadius = '6px';
      toast.style.color = 'white';
      toast.style.fontWeight = '500';
      toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
      toast.style.zIndex = '1000';
      toast.style.transform = 'translateY(30px)';
      toast.style.opacity = '0';
      toast.style.transition = 'all 0.3s ease';
      
      if (type === 'success') {
        toast.style.backgroundColor = '#10b981';
      } else if (type === 'error') {
        toast.style.backgroundColor = '#ef4444';
      } else if (type === 'warning') {
        toast.style.backgroundColor = '#f59e0b';
      } else {
        toast.style.backgroundColor = '#3b82f6';
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