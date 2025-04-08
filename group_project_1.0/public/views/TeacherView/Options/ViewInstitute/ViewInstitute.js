const classInfoContainer = document.getElementById("classInfo");
const errorContainer = document.getElementById("error");
const classId = sessionStorage.getItem("class_id");

async function fetchClassData() {
  const classInfoContainer = document.getElementById("classInfo");
  const errorContainer = document.getElementById("error");
  const buttonContainer = document.querySelector(".button-container");

  // Hide button initially
  buttonContainer.style.display = "none";

  try {
    const response = await fetch(
      `http://localhost/group_project_1.0/public/ViewinstituteController/viewmyinstitute/${classId}`
    );
    if (!response.ok) throw new Error("Failed to fetch data");

    const data = await response.json();
    if (data.length === 0) {
      classInfoContainer.innerHTML = "<p>No class information found.</p>";
      errorContainer.textContent = "This class hasn't institute";
      return;
    }

    const item = data[0]; // Use the first item only

    classInfoContainer.innerHTML = `
      <div><span class="label">Institute Name:</span> ${item.F_name} ${item.L_name}</div>
      <div><span class="label">Location:</span> ${item.Location}</div>
      <div><span class="label">Email:</span> ${item.Email}</div>
      <div><span class="label">Phone Number:</span> ${item.Phone_number}</div>
        <div><span class="label">District:</span> ${item.District}</div>
      <div><span class="label">Address:</span> ${item.Address}</div>
    `;

    // If everything succeeded, show the button
    buttonContainer.style.display = "flex";
  } catch (error) {
    console.error("Error:", error);
    errorContainer.textContent = "This class hasn't institute";
    buttonContainer.style.display = "none"; // Keep button hidden if error
  }
}

fetchClassData();

function requestPayroll() {
  const popup = document.getElementById("payrollPopup");
  const form = document.getElementById("payrollForm");

  // Prefill values
  fetch(
    `http://localhost/group_project_1.0/public/ViewinstituteController/viewmyinstitute/${classId}`
  )
    .then((response) => response.json())
    .then((data) => {
      const item = data[0];

      document.getElementById("Institute_ID").value = item.Institute_ID;
      document.getElementById("N_id").value = item.N_id;
      document.getElementById("InstClass_id").value = item.InstClass_id;

      // Set current date
      const today = new Date().toISOString().split("T")[0];
      document.getElementById("current_date").value = today;

      // Show popup
      popup.style.display = "flex";
    })
    .catch((error) => {
      console.error("Failed to load payroll info", error);
      alert("Could not load payroll data.");
    });
}

function closePopup() {
  document.getElementById("payrollPopup").style.display = "none";
}

document.getElementById("payrollForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  const payload = Object.fromEntries(formData.entries());

  console.log("Submitting Payroll Request:", payload);

  // You can replace this with a real API POST
  alert("Payroll request submitted successfully!");
  closePopup();
});
