document.addEventListener("DOMContentLoaded", () => {
  const userDataElement = document.getElementById("user-data");
  if (!userDataElement) {
    console.error("User data element not found.");
    return;
  }

  const P_id = userDataElement.dataset.userId;
  const N_id = userDataElement.dataset.userId;
  const formElement = document.getElementById("filter");
  const selectElement = formElement.querySelector("#filter-type");

  if (!formElement || !selectElement) {
    console.error("Required DOM elements not found.");
    return;
  }

  const fetchAndRenderClasses = (filterType) => {
    const fetchUrls = [
      fetch(`Ind_Myclass/MyclassApi/${P_id}`),
      fetch(`Ind_Myclass/MyinstituteClass/${P_id}`),
    ];

    Promise.allSettled(fetchUrls)
      .then((results) => {
        const jsonPromises = results.map((result) => {
          if (result.status === "fulfilled" && result.value.ok) {
            return result.value.json();
          }
          return Promise.resolve([]);
        });

        return Promise.all(jsonPromises);
      })
      .then((dataArrays) => {
        const combinedData = [...dataArrays[0], ...dataArrays[1]];

        const container = document.getElementById("class-container");
        if (!container) {
          console.error(
            "Container element with ID 'class-container' not found."
          );
          return;
        }

        container.innerHTML = "";

        if (combinedData.length === 0) {
          container.innerHTML = "<p>No classes found for this teacher.</p>";
          return;
        }

        const filteredData =
          filterType === "All"
            ? combinedData
            : combinedData.filter((classItem) => classItem.Type === filterType);

        if (filteredData.length === 0) {
          container.innerHTML = `<p>No ${filterType.toLowerCase()} classes found.</p>`;
          return;
        }

        const subjectImages = {
          Accounting:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Accwebp.webp",
          Agriculture:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Agriculture.jpeg",
          Art: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Art.jpeg",
          BioSystemsTechnology:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/B.jpeg",
          Biology:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Bio.png",
          Buddhism:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Buddhism.webp",
          Physics:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
          Mathematics:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Maths.png",
          English:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/English.png",
          Chemistry:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
          History:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/History.png",
          IT: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/It.png",
          BusinessStudies:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/BusinessStudies.png",
          Catholicism:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Catholicism.jpeg",
          CivicEducation:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/CivicEducation.jpeg",
          Commerce:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Commerce.png",
          Drama:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Drama.jpeg",
          Engineering:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Engineering.jpeg",
          Geography:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Geography.jpeg",
          Health:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/H.jpeg",
          Science:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Science.jpeg",
          Sinhala:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Sinhala.jpeg",
          Tamil:
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Sinhala.jpeg",
        };

        filteredData.forEach((classItem) => {
          const card = document.createElement("div");
          card.className = "card";

          const imageUrl =
            subjectImages[classItem.Subject] ||
            "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/defult.jpg";

          card.innerHTML = `
            <div class="card-content">
              <img src="${imageUrl}" alt="${classItem.Subject}">
              <h3>${classItem.Subject} - Grade ${classItem.Grade}</h3>          
              <br>
              <p><h3>Address:</h3> ${classItem.Location}</p>
              <br>
              <p>Date: ${classItem.Def_Date}</p>
                <p>Time: ${classItem.Def_Time}</p>
                <br>
              <p>Start date: ${classItem.Start_date || "N/A"}</p>
              <p>End date: ${classItem.End_date || "N/A"}</p>
              <br>
              <button class="card-button" onclick="showDetails(${
                classItem.Class_id
              })">More Details</button>
              <button class="button" onclick="editclass(${classItem.Class_id})">
                <img src="../../../../../group_project_1.0/public/views/TeacherView/Myclass/icon/pencil.png" alt="Edit" class="icon"> Edit
              </button>
            
          `;

          container.appendChild(card);
        });
      })
      .catch((error) => {
        const container = document.getElementById("class-container");
        if (container) {
          container.innerHTML = `<p class="error">Failed to load classes: ${error.message}</p>`;
        }
        console.error("There was a problem with the fetch operation:", error);
      });
  };

  selectElement.addEventListener("change", () => {
    const selectedType = selectElement.value;
    console.log("Selected item: ", selectedType);
    fetchAndRenderClasses(selectedType);
  });

  fetchAndRenderClasses(selectElement.value);

  let instituteDataMap = {};

  async function fetchInstitutes(P_id) {
    try {
      const response = await fetch(
        `http://localhost/group_project_1.0/public/Normalteacher_Controller/findmyinstitutes/${P_id}`
      );
      const institutes = await response.json();

      const instituteSelect = document.getElementById("Institute_name");
      instituteSelect.innerHTML =
        '<option value="" disabled selected>Select Institute</option><option value="None">None</option>';

      institutes.forEach((institute) => {
        const fullName = `${institute.F_name} ${institute.L_name}`;
        const option = document.createElement("option");
        option.value = fullName;
        option.textContent = fullName;
        instituteSelect.appendChild(option);

        instituteDataMap[fullName] = institute;
      });
    } catch (error) {
      console.error("Error fetching institutes:", error);
    }
  }

  document
    .getElementById("Institute_name")
    .addEventListener("change", function () {
      const selectedName = this.value;
      console.log("sss", instituteDataMap[selectedName]);
      if (selectedName !== "None" && instituteDataMap[selectedName]) {
        const selectedInstitute = instituteDataMap[selectedName];
        const address = selectedInstitute.Address;
        document.getElementById("Location").value = address;
      } else {
        document.getElementById("Location").value = "";
      }
    });

  document
    .getElementById("Institute_name")
    .addEventListener("change", function () {
      const selectedName = this.value;

      if (selectedName !== "None" && instituteDataMap[selectedName]) {
        const selectedInstitute = instituteDataMap[selectedName];
        const inst_id = selectedInstitute.Institute_ID;
        document.getElementById("inst_id").value = inst_id;
      }
    });

  fetchInstitutes(P_id);

  document
    .getElementById("editScheduleForm")
    .addEventListener("submit", (event) => createSchedule(event, P_id));

  async function createSchedule(event, P_id) {
    console.log("createSchedule called with P_id:", P_id);
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    const grade = parseInt(formData.get("Grade"), 10);
    const maxStd = parseInt(formData.get("Max_std"), 10);
    const fee = parseFloat(formData.get("Fee"));

    let isValid = true;

    if (isNaN(grade) || grade < 1 || grade > 13) {
      alert("Grade must be a number between 1 and 13.");
      isValid = false;
    }

    if (isNaN(maxStd) || maxStd <= 0) {
      alert("Max students must be a positive number.");
      isValid = false;
    }

    if (isNaN(fee) || fee < 0) {
      alert("Fee cannot be a negative value.");
      isValid = false;
    }

    if (!isValid) {
      return;
    }

    const table1 = {
      Type: formData.get("Type"),
      Subject: formData.get("Subject"),
      Grade: formData.get("Grade"),
      Max_std: parseInt(formData.get("Max_std"), 10),
      fee: parseFloat(formData.get("Fee")),
      Def_Date: formData.get("Date"),
      Def_Time: formData.get("Time"),
      Stream: formData.get("Stream"),
    };
    const table2 = {
      P_id: P_id,
      Location: formData.get("Location"),
      Start_date: formData.get("Start_date"),
      End_date: formData.get("End_date"),
    };

    const table3 = {
      N_id: N_id,
      Location: formData.get("Location"),
      Start_date: formData.get("Start_date"),
      End_date: formData.get("End_date"),
      Hall_number: formData.get("Hallnumber"),
      inst_id: formData.get("inst_id"),
    };

    console.log("sssssssssssssssss", table1.Stream);
    const institute = formData.get("Institute_name");
    console.log("id ekd = ", table3);
    if (
      institute == "None" &&
      table1.Type == "Individual" &&
      table2.Start_date < table2.End_date
    ) {
      const data = { table1, table2 };
      console.log("ClassData being sent:", data);

      fetch(
        `http://localhost/group_project_1.0/public/Ind_Myclass/CreateclassApi/${P_id}`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        }
      )
        .then(async (response) => {
          const contentType = response.headers.get("content-type");
          if (!response.ok) {
            const errorText = await response.text();
            console.error("Server response:", errorText);
            throw new Error(
              `HTTP error! Status: ${response.status}, Body: ${errorText}`
            );
          }
          if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.warn("Unexpected response format:", text);
            return { message: text };
          }
          return response.json();
        })
        .then((data) => {
          console.log("Schedule submitted successfully:", data);
          alert("Class created successfully!");
          window.location.href =
            "http://localhost/group_project_1.0/public/Ind_Myclass";
        })
        .catch((error) => {
          console.error("Error submitting schedule:", error);
          alert("There was an error submitting the Class. Please try again.");
        });
    } else if (
      institute !== "None" &&
      table1.Type == "Institute" &&
      table3.Start_date < table3.End_date
    ) {
      const data2 = { table1, table3 };
      console.log("ClassData being sent:", data2);

      fetch(
        `http://localhost/group_project_1.0/public/Ind_Myclass/CreateinstituteclassApi/${N_id}`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data2),
        }
      )
        .then(async (response) => {
          const contentType = response.headers.get("content-type");
          if (!response.ok) {
            const errorText = await response.text();
            console.error("Server response:", errorText);
            throw new Error(
              `HTTP error! Status: ${response.status}, Body: ${errorText}`
            );
          }
          if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.warn("Unexpected response format:", text);
            return { message: text };
          }
          return response.json();
        })
        .then((data) => {
          console.log("Schedule submitted successfully:", data);
          alert("Class created successfully!");
          window.location.href =
            "http://localhost/group_project_1.0/public/Ind_Myclass";
        })
        .catch((error) => {
          console.error("Error submitting schedule:", error);
          alert("There was an error submitting the Class. Please try again.");
        });
    } else {
      alert(
        "Institute name should be 'None' for individual classes and Institute name should not be None for institute classes."
      );
    }
  }
});

function showDetails(Class_id) {
  const individualUrl = `Ind_Myclass/MoredetailsApi/${Class_id}`;
  const instituteUrl = `Ind_Myclass/Moredetailsinstitute/${Class_id}`;

  Promise.allSettled([fetch(individualUrl), fetch(instituteUrl)])
    .then((results) => {
      const successful = results.filter(
        (r) => r.status === "fulfilled" && r.value.ok
      );
      if (successful.length === 0) {
        throw new Error("No valid response from any API.");
      }

      return Promise.all(successful.map((r) => r.value.json()));
    })
    .then((dataArrays) => {
      const [individualClassData = [], instituteClassData = []] = dataArrays;

      const classDetail =
        (individualClassData.length > 0 && individualClassData[0]) ||
        (instituteClassData.length > 0 && instituteClassData[0]);

      if (!classDetail) {
        console.error("No class details found.");
        alert("Class details not available.");
        return;
      }

      const subjectImages = {
        Accounting:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Accwebp.webp",
        Agriculture:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Agriculture.jpeg",
        Art: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Art.jpeg",
        BioSystemsTechnology:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/B.jpeg",
        Biology:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Bio.png",
        Buddhism:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Buddhism.webp",
        Physics:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
        Mathematics:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Maths.png",
        English:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/English.png",
        Chemistry:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/science.png",
        History:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/History.png",
        IT: "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/It.png",
        BusinessStudies:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/BusinessStudies.png",
        Catholicism:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Catholicism.jpeg",
        CivicEducation:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/CivicEducation.jpeg",
        Commerce:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Commerce.png",
        Drama:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Drama.jpeg",
        Engineering:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Engineering.jpeg",
        Geography:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Geography.jpeg",
        Health:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/H.jpeg",
        Science:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Science.jpeg",
        Sinhala:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Sinhala.jpeg",
        Tamil:
          "../../../../../group_project_1.0/public/views/TeacherView/Myclass/Class_images/Sinhala.jpeg",
      };

      const imageBasePath =
        "../../../../../group_project_1.0/public/views/TeacherView/Myclass/";
      const imageUrl =
        classDetail.image ||
        imageBasePath +
          (subjectImages[classDetail.Subject] || "Class_images/defult.jpg");

      document.getElementById("classImage").src = imageUrl;
      document.getElementById("moreSubject").textContent =
        classDetail.Subject || "N/A";
      document.getElementById("classType").textContent =
        classDetail.Type || "N/A";
      document.getElementById("locat").textContent =
        classDetail.Location || classDetail.Hall_number || "N/A";
      document.getElementById("Hall_no").textContent =
        classDetail.Hall_number || "N/A";
      document.getElementById("moreGrade").textContent =
        classDetail.Grade || "N/A";
      document.getElementById("classid").textContent =
        classDetail.Class_id || "N/A";
      document.getElementById("classFee").textContent =
        classDetail.fee || "N/A";
      document.getElementById("maxstu").textContent =
        classDetail.Max_std || "N/A";
      document.getElementById("Date").textContent =
        classDetail.Def_Date || "N/A";
      document.getElementById("Time").textContent =
        classDetail.Def_Time || "N/A";
      document.getElementById("modalBackground").style.display = "block";

      console.log("Class Details:", classDetail);
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
      alert("Failed to load class details.");
    });
}

function closeModal() {
  document.getElementById("modalBackground").style.display = "none";
}

function editclass(class_id) {
  currentClassId = class_id;
  console.log(`Editing schedule for Class ID: ${class_id}`);

  const allfetch = [
    fetch(`Ind_Myclass/MoredetailsApi/${class_id}`),
    fetch(`Ind_Myclass/Moredetailsinstitute/${class_id}`),
  ];

  Promise.all(allfetch)
    .then((responses) => {
      for (const response of responses) {
        if (!response.ok) {
          console.warn("Some data might be missing. Status:", response.status);
        }
      }

      return Promise.all(
        responses.map((response) => {
          return response.ok ? response.json() : [];
        })
      );
    })
    .then((dataArrays) => {
      const individualClassData = dataArrays[0];
      const instituteClassData = dataArrays[1];

      let classDetail = null;
      if (individualClassData && individualClassData.length > 0) {
        classDetail = individualClassData[0];
      } else if (instituteClassData && instituteClassData.length > 0) {
        classDetail = instituteClassData[0];
      }

      if (!classDetail) {
        console.error("No class details found.");
        alert("No class details found for the selected ID.");
        return;
      }

      console.log("Class Detail Object:", classDetail);

      document.getElementById("classSubject").value = classDetail.Subject || "";
      document.getElementById("classGrade").value = classDetail.Grade || "";
      if (classDetail.Type === "Institute") {
        document.getElementById("Hall_number").value =
          classDetail.Hall_number || "";
        Hall_number.disabled = false;
      } else {
        document.getElementById("Hall_number").value = "None";
        Hall_number.disabled = true;
      }
      document.getElementById("classfee").value = classDetail.fee || "";
      document.getElementById("classMax_std").value = classDetail.Max_std || "";
      document.getElementById("classStart_date").value =
        classDetail.Start_date || "";
      document.getElementById("classEnd_date").value =
        classDetail.End_date || "";
      document.getElementById("classLocation").value =
        classDetail.Location || classDetail.Hall_number || "";

      document.getElementById("Date_").value =
        classDetail.Def_Date || classDetail.Def_Date || "";
      document.getElementById("Time_").value =
        classDetail.Def_Time || classDetail.Def_Time || "";

      document.getElementById("popupEditForm").style.display = "flex";
    })
    .catch((error) => {
      console.error("Error fetching class details:", error);
      alert("Failed to load class details. Please try again.");
    });
}

function createclass() {
  document.getElementById("popupForm").style.display = "flex";
}

function closePopup() {
  document.getElementById("popupForm").style.display = "none";
}

function viewinst(Class_id) {
  sessionStorage.setItem("class_id", Class_id);
  window.location.href =
    "http://localhost/group_project_1.0/public/ViewinstituteController";
  console.log("Class ID stored in sessionStorage:", Class_id);
}

function UploadMat(Class_id) {
  sessionStorage.setItem("class_id", Class_id);
  window.location.href =
    "http://localhost/group_project_1.0/public/Learning_mat";
  console.log("Class ID stored in sessionStorage:", Class_id);
}

function UploadASS(Class_id) {
  sessionStorage.setItem("class_id", Class_id);
  window.location.href =
    "http://localhost/group_project_1.0/public/AssignmentController";
  console.log("Class ID stored in sessionStorage:", Class_id);
}

function viewschedule(Class_id) {
  sessionStorage.setItem("class_id", Class_id);
  window.location.href =
    "http://localhost/group_project_1.0/public/ClassShcedules";
  console.log("Class ID stored in sessionStorage:", Class_id);
}

function getClassId() {
  return document.getElementById("classid").textContent.trim();
}

function freeCard(Class_id) {
  sessionStorage.setItem("class_id", Class_id);
  window.location.href = "http://localhost/group_project_1.0/public/FreeCard";
  console.log("Class ID stored in sessionStorage:", Class_id);
}

function reqPay() {
  window.location.href =
    "../../../../../group_project_1.0/app/views/TeacherView/Options/RequestPayrolls/RequestPayrolls.php";
}

function viewStudents(Class_id) {
  sessionStorage.setItem("class_id", Class_id);
  window.location.href =
    "http://localhost/group_project_1.0/public/ClassStudents";
  console.log("Class ID stored in sessionStorage:", Class_id);
}
