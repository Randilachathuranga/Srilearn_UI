// Sample Class Schedule Data
const schedules = [
    { id: 101, start: '08:00 AM', end: '10:00 AM', date: '2024-11-25' },
    { id: 102, start: '10:30 AM', end: '12:30 PM', date: '2024-11-26' },
    { id: 103, start: '01:00 PM', end: '03:00 PM', date: '2024-11-27' },
  ];
  
  // Sample Student Data
  const students = [
    { id: 1, name: 'John Doe' },
    { id: 2, name: 'Jane Smith' },
    { id: 3, name: 'Emily Johnson' },
    { id: 4, name: 'Michael Brown' },
  ];
  
  // DOM Elements
  const classScheduleFilter = document.getElementById('classScheduleFilter');
  const studentIdFilter = document.getElementById('studentIdFilter');
  const issueCardBtn = document.getElementById('issueCardBtn');
  const issuedCardsTable = document.getElementById('issuedCardsTable');
  
  // Issued Cards Array
  const issuedCards = [];
  
  // Populate Class Schedule Dropdown
  function populateClassScheduleDropdown() {
    schedules.forEach(schedule => {
      const option = document.createElement('option');
      option.value = schedule.id;
      option.textContent = `Schedule ID: ${schedule.id} (${schedule.date})`;
      classScheduleFilter.appendChild(option);
    });
  }
  
  // Populate Student Dropdown
  function populateStudentDropdown() {
    studentIdFilter.innerHTML = '<option value="">Select Student</option>';
    students.forEach(student => {
      const option = document.createElement('option');
      option.value = student.id;
      option.textContent = `${student.id} - ${student.name}`;
      studentIdFilter.appendChild(option);
    });
  }
  
  // Enable/Disable Filters and Button
  classScheduleFilter.addEventListener('change', () => {
    if (classScheduleFilter.value) {
      studentIdFilter.disabled = false;
      populateStudentDropdown();
    } else {
      studentIdFilter.disabled = true;
      issueCardBtn.disabled = true;
    }
  });
  
  studentIdFilter.addEventListener('change', () => {
    issueCardBtn.disabled = !studentIdFilter.value;
  });
  
  // Issue Free Card
  function issueFreeCard() {
    const scheduleId = classScheduleFilter.value;
    const studentId = studentIdFilter.value;
  
    // Generate Unique Card ID
    const cardId = `CARD-${Math.floor(Math.random() * 10000)}`;
  
    // Get Current Date
    const issuedDate = new Date().toISOString().split('T')[0];
  
    // Add to Issued Cards
    issuedCards.push({ cardId, scheduleId, studentId, issuedDate });
  
    // Render Issued Cards Table
    renderIssuedCards();
  }
  
  // Render Issued Cards Table
  function renderIssuedCards() {
    issuedCardsTable.innerHTML = '';
    issuedCards.forEach(card => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${card.cardId}</td>
        <td>${card.scheduleId}</td>
        <td>${card.studentId}</td>
        <td>${card.issuedDate}</td>
      `;
      issuedCardsTable.appendChild(row);
    });
  }
  
  // Event Listener for Issue Card Button
  issueCardBtn.addEventListener('click', issueFreeCard);
  
  // Initialize Page
  populateClassScheduleDropdown();
  