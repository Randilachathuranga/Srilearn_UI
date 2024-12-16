// Sample schedules
const schedules = [
    { id: 101, start: '08:00 AM', end: '10:00 AM', date: '2024-11-25' },
    { id: 102, start: '10:30 AM', end: '12:30 PM', date: '2024-11-26' },
    { id: 103, start: '01:00 PM', end: '03:00 PM', date: '2024-11-27' },
    { id: 104, start: '03:30 PM', end: '05:30 PM', date: '2024-11-28' },
    { id: 105, start: '06:00 PM', end: '08:00 PM', date: '2024-11-29' },
  ];
  
  // DOM Elements
  const scheduleTable = document.getElementById('scheduleTable');
  
  // Function to render the schedules in the table
  function renderSchedules() {
    scheduleTable.innerHTML = ''; // Clear existing rows
    schedules.forEach((schedule, index) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${schedule.id}</td>
        <td>${schedule.start}</td>
        <td>${schedule.end}</td>
        <td>${schedule.date}</td>
        <td>
          <button class="update" onclick="updateSchedule(${index})">Update</button>
          <button class="delete" onclick="deleteSchedule(${index})">Delete</button>
        </td>
      `;
      scheduleTable.appendChild(row);
    });
  }
  
  // Function to delete a schedule
  function deleteSchedule(index) {
    if (confirm('Are you sure you want to delete this schedule?')) {
      schedules.splice(index, 1);
      renderSchedules();
    }
  }
  
  // Function to update a schedule
  function updateSchedule(index) {
    const newStartTime = prompt('Enter new start time (e.g., 09:00 AM):', schedules[index].start);
    const newEndTime = prompt('Enter new end time (e.g., 11:00 AM):', schedules[index].end);
    const newDate = prompt('Enter new date (e.g., 2024-12-01):', schedules[index].date);
  
    if (newStartTime && newEndTime && newDate) {
      schedules[index].start = newStartTime;
      schedules[index].end = newEndTime;
      schedules[index].date = newDate;
      renderSchedules();
    } else {
      alert('Update canceled. All fields must be filled.');
    }
  }
  
  // Initial rendering of schedules
  renderSchedules();
  