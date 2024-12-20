// DOM Elements
const payrollForm = document.getElementById('payrollForm');
const requestsTable = document.getElementById('requestsTable');

// Submitted Payroll Requests Array
const payrollRequests = [];

// Submit Payroll Request Form
payrollForm.addEventListener('submit', function (event) {
  event.preventDefault();

  // Get Form Data
  const teacherName = document.getElementById('teacherName').value;
  const classSchedule = document.getElementById('classSchedule').value;
  const month = document.getElementById('month').value;
  const amount = document.getElementById('amount').value;

  // Generate Request ID
  const requestId = `REQ-${Math.floor(Math.random() * 10000)}`;

  // Add Request to Array
  const newRequest = {
    requestId,
    teacherName,
    classSchedule,
    month,
    amount,
  };
  payrollRequests.push(newRequest);

  // Render Table
  renderRequestsTable();

  // Clear Form
  payrollForm.reset();
});

// Render Payroll Requests Table
function renderRequestsTable() {
  requestsTable.innerHTML = '';
  payrollRequests.forEach(request => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${request.requestId}</td>
      <td>${request.teacherName}</td>
      <td>${request.classSchedule}</td>
      <td>${request.month}</td>
      <td>$${parseFloat(request.amount).toFixed(2)}</td>
    `;
    requestsTable.appendChild(row);
  });
}
