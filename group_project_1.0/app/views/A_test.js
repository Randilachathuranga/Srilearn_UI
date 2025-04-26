//view all data
document.addEventListener("DOMContentLoaded", () => {
  fetch(`http://localhost/group_project_1.0/public/A_testController/viewall`)
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      const container = document.getElementById("container");
      data.forEach((Test) => {
        const card = document.createElement("div");
        card.className = "card";
        // U_id = Test.U_id;
        // getElementById()
        card.innerHTML = `
          <br>
              <div class="card-content">
                <h3>${Test.Name}</h3>
                <p>Age: ${Test.Age}</p>
                <p>DOB: ${Test.DOB}</p>
                <button class="card-button" onclick="View(${Test.U_id})">View</button>
              </div>
            `;
        container.appendChild(card);
      });
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
});

function viewform() {
  const form = document.getElementById("form");
  form.style.display = "block";
  document.getElementById("overlay").style.display = "block";
}

function closeForm() {
  const form = document.getElementById("form");
  form.style.display = "none";
  const editform = document.getElementById("editform");
  editform.style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

//create data
document.getElementById("form").addEventListener("submit", (event) => {
  event.preventDefault();
  const formData = new FormData(event.target);
  const data = Object.fromEntries(formData.entries());
  const Send_data = {
    Name: data.Name,
    Age: data.Age,
    DOB: data.DOB,
  };
  console.log(Send_data);
  fetch(
    `http://localhost/group_project_1.0/public/A_testController/insertpayrollrequest`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(Send_data),
    }
  )
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((result) => {
      alert("Record created successfully!");
      location.reload();
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
});

//delete
function Delete_rec() {
  const id = document.getElementById("U_id").value;
  if (confirm("Are you sure you want to delete this record?")) {
    fetch(
      `http://localhost/group_project_1.0/public/A_testController/del/${id}`,
      {
        method: "DELETE",
      }
    )
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
      })
      .then((data) => {
        alert("Record deleted successfully!");
        location.reload();
      })
      .catch((error) => {
        console.error("There was a problem with the fetch operation:", error);
      });
  }
}

//view
function View(id) {
  document.getElementById("overlay").style.display = "block";
  fetch(
    `http://localhost/group_project_1.0/public/A_testController/viewspecific/${id}`
  )
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((data) => {
      console.log("wa", data);
      document.getElementById("editform").style.display = "block";
      document.getElementById("edit_Name").value = data[0].Name || "";
      document.getElementById("edit_Age").value = data[0].Age || "";
      document.getElementById("edit_DOB").value = data[0].DOB || "";
      document.getElementById("U_id").value = data[0].U_id || "";
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
}

//enable edit form
function Edit() {
  const inputs = document.querySelectorAll("#editform input");
  inputs.forEach((input) => {
    input.removeAttribute("disabled");
  });
  document.getElementById("editButton").style.display = "none";
  document.getElementById("CancelButton").style.display = "block";
  document.getElementById("UpdateButton").style.display = "block";
  document.getElementById("DeleteButton").style.display = "block";
}

function Cancel() {
  const inputs = document.querySelectorAll("#editform input");
  inputs.forEach((input) => {
    input.setAttribute("disabled", "true");
  });
  document.getElementById("editButton").style.display = "block";
  document.getElementById("CancelButton").style.display = "none";
  document.getElementById("UpdateButton").style.display = "none";
  document.getElementById("DeleteButton").style.display = "none";
}

//update data
function Update() {
  const id = document.getElementById("U_id").value;
  const name = document.getElementById("edit_Name").value;
  const age = document.getElementById("edit_Age").value;
  const dob = document.getElementById("edit_DOB").value;

  if (!name || !age || !dob) {
    alert("Please fill all required fields");
    return;
  }
  const Send_data = {
    Name: name,
    Age: age,
    DOB: dob,
  };

  fetch(
    `http://localhost/group_project_1.0/public/A_testController/updatepayrollrequest/${id}`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(Send_data),
    }
  )
    .then((response) => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then((result) => {
      alert("Record updated successfully!");
      closeForm();
      location.reload();
    })
    .catch((error) => {
      console.error("There was a problem with the update operation:", error);
      alert("Update failed. Please try again.");
    });
}
