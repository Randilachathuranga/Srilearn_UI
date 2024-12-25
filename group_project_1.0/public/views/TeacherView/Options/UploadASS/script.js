const uploadBox = document.getElementById('uploadBox');
const fileInput = document.getElementById('fileInput');
const fileList = document.getElementById('fileList');

// Trigger file input when clicking the upload box
uploadBox.addEventListener('click', () => {
  fileInput.click();
});

// Handle file selection
fileInput.addEventListener('change', (event) => {
  const files = event.target.files;
  fileList.innerHTML = '';
  for (let i = 0; i < files.length; i++) {
    const li = document.createElement('li');
    li.textContent = files[i].name;
    fileList.appendChild(li);
  }
});

// Save changes function
function saveChanges() {
  if (fileList.children.length > 0) {
    alert('Files saved successfully!');
  } else {
    alert('No files to save!');
  }
}

// Cancel changes function
function cancelChanges() {
  fileList.innerHTML = '';
  fileInput.value = '';
  alert('File upload canceled.');
}
