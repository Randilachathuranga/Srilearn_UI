<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Learning Materials</title>
  <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/TeacherView/Options/UploadMat/Styles.css">
</head>
<body>
  <div class="container">
    <h1>Upload Learning Materials</h1>

    <div class="upload-box" id="uploadBox">
      <p>Drag and drop files here, or click to select files</p>
      <input type="file" id="fileInput" multiple>
    </div>

    <ul class="file-list" id="fileList"></ul>

    <div class="button-container">
      <button onclick="saveChanges()">Save Changes</button>
      <button class="cancel" onclick="cancelChanges()">Cancel</button>
    </div>
  </div>
  <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/UploadMat/script.js"></script>
</body>
</html>
