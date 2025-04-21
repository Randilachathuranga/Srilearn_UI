<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Lookup</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f7fa;
      padding: 30px;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    label {
      display: block;
      margin-top: 15px;
      margin-bottom: 8px;
      font-weight: bold;
    }

    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    button {
      width: 100%;
      padding: 14px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      margin-bottom: 20px;
    }

    button:hover {
      background-color: #0056b3;
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
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #007bff;
      color: #fff;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .section-title {
      font-size: 20px;
      margin: 25px 0 10px;
      color: #333;
      border-bottom: 2px solid #007bff;
      padding-bottom: 5px;
    }

    .no-data {
      background-color: #ffe6e6;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 20px;
      border-left: 4px solid #ff4d4d;
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
