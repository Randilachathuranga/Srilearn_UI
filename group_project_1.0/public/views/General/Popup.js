let confirmCallback = null;

function showPopup(message, success, onConfirm = null) {
  const popupBox = document.getElementById("popupBox");
  const popupOverlay = document.getElementById("popupOverlay");
  const popupMessage = document.getElementById("popupMessage");
  const okBtn = document.getElementById("popupOkBtn");
  const cancelBtn = document.getElementById("popupCancelBtn");

  popupMessage.textContent = message;
  popupMessage.style.color =
    success === true ? "green" : success === false ? "red" : "#333";

  popupBox.classList.remove("hidden");
  popupOverlay.classList.remove("hidden");

  confirmCallback = onConfirm;

  // Toggle Cancel button visibility
  if (onConfirm) {
    cancelBtn.style.display = "inline-block";
  } else {
    cancelBtn.style.display = "none";
  }

  okBtn.onclick = function () {
    closePopup();
    if (typeof confirmCallback === "function") {
      confirmCallback();
    }
  };
}

function closePopup() {
  document.getElementById("popupBox").classList.add("hidden");
  document.getElementById("popupOverlay").classList.add("hidden");

  const msg = document.getElementById("popupMessage").textContent.toLowerCase();
  if (msg.includes("successfully")) {
    window.location.reload();
  }
}

{
  /* <link rel="stylesheet" href="./../../../../../group_project_1.0/public/views/General/Popup.css"> */
}

{
  /* <div class="popup-overlay hidden" id="popupOverlay"></div>
<div class="popup hidden" id="popupBox">
    <p class="popup-message" id="popupMessage"></p>
    <div class="popup-buttons">
        <button class="ok-btn" id="popupOkBtn">OK</button>
        <button class="cancel-btn" id="popupCancelBtn" onclick="closePopup()">Cancel</button>
    </div>
</div> */
}

// showPopup('Advertisement created successfully!', true);

// async function handleDelete(id) {
//     showPopup("Are you sure you want to delete this advertisement?", null, async () => {
//         try {
//             const response = await fetch(`http://localhost/group_project_1.0/public/Advertisements/deleteapi/${id}`, {
//                 method: 'DELETE'
//             });

//             const result = await response.json();

//             if (response.ok) {
//                 showPopup("Advertisement deleted successfully!", true);
//             } else {
//                 showPopup(result.error || "Deletion failed.", false);
//             }
//         } catch (error) {
//             console.error("Delete error:", error);
//             showPopup("Something went wrong while deleting.", false);
//         }
//     });
// }
