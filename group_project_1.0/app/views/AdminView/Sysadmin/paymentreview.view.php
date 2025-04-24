<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Lookup</title>
  <style>
    :root {
      --primary: #1e40af;
      --primary-light: #3b82f6;
      --primary-hover: #1e3a8a;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #e2ece5;
      padding: 30px;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
      background-color:rgb(147, 197, 244);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: var(--primary);
    }

    label {
      display: block;
      margin-top: 15px;
      margin-bottom: 8px;
      font-weight: bold;
      color: var(--primary);
    }

    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 6px;
      border: 1px solid var(--primary-light);
      font-size: 16px;
    }

    button {
      width: 100%;
      padding: 14px;
      background-color: var(--primary);
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      margin-bottom: 20px;
      transition: background-color 0.2s;
    }

    button:hover {
      background-color: var(--primary-hover);
    }

    .result-section {
      display: none;
    }

    .table-wrapper {
      margin-top: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 40px;
    }

    th, td {
      padding: 12px 15px;
      border: 1px solid #e2e8f0;
      text-align: left;
    }

    th {
      background-color: var(--primary);
      color: #fff;
    }

    tr:nth-child(even) {
      background-color: #f8fafc;
    }

    .section-title {
      font-size: 20px;
      margin: 25px 0 10px;
      color: var(--primary);
      border-bottom: 2px solid var(--primary);
      padding-bottom: 5px;
    }

    .no-data {
      background-color: #e2e8f0;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 20px;
      border-left: 4px solid var(--primary);
      color: var(--primary);
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Check Payments</h2>

    <label for="month">Select Month</label>
    <select id="month">
      <option value="">-- Select Month --</option>
    </select>

    <label for="year">Select Year</label>
    <select id="year">
      <option value="">-- Select Year --</option>
    </select>

    <button onclick="fetchPayments()">Check Payments</button>

    <div id="result" class="result-section">
      <div id="teachersSection" class="table-wrapper"></div>
      <div id="institutesSection" class="table-wrapper"></div>
    </div>
  </div>

  <script>
    const monthSelect = document.getElementById('month');
    const yearSelect = document.getElementById('year');
    const resultDiv = document.getElementById('result');
    const teachersSection = document.getElementById('teachersSection');
    const institutesSection = document.getElementById('institutesSection');

    // Populate months
    for (let m = 1; m <= 12; m++) {
      const option = document.createElement('option');
      option.value = m.toString().padStart(2, '0');
      option.textContent = m;
      monthSelect.appendChild(option);
    }

    // Populate years
    const currentYear = new Date().getFullYear();
    for (let y = currentYear; y >= 2000; y--) {
      const option = document.createElement('option');
      option.value = y;
      option.textContent = y;
      yearSelect.appendChild(option);
    }

    function fetchPayments() {
      const month = monthSelect.value;
      const year = yearSelect.value;

      if (!month || !year) {
        alert("Please select both month and year.");
        return;
      }

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

          teachersSection.innerHTML = generateTable(teachers, 'Teachers');
          institutesSection.innerHTML = generateTable(institutes, 'Institutes');

          resultDiv.style.display = 'block';
        } else {
          resultDiv.style.display = 'block';
          teachersSection.innerHTML = `<div class="no-data">${data.message || 'No teacher records found.'}</div>`;
          institutesSection.innerHTML = '';
        }
      })
      .catch(error => {
        console.error("Fetch error:", error);
        resultDiv.style.display = 'block';
        teachersSection.innerHTML = `<div class="no-data">An error occurred while fetching data.</div>`;
        institutesSection.innerHTML = '';
      });
    }

    function generateTable(records, title) {
      if (records.length === 0) {
        return `<div class="no-data">No ${title.toLowerCase()} payments found for this period.</div>`;
      }

      const rows = records.map(r => `
        <tr>
          <td>${r.date || ''}</td>
          <td>${r.time || ''}</td>
          <td>${r.amount || ''}</td>
          <td>${r.Role || ''}</td>
          <td>${r.Email || ''}</td>
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
  </script>
</body>
</html>
