<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Class Materials</title>
  <link rel="stylesheet" href="../../../../../../group_project_1.0/public/views/TeacherView/Options/UploadMat/Styles.css">
</head>
<body>
  <h1>Class Materials</h1>

  <div id="uploadMat" onclick="showUploadForm()">Upload Material</div>

  <div id="overlay" onclick="hideUploadForm()"></div>

  <form id="uploadForm" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="Class_id" value="123"> 
    <label for="topic">Topic:</label>
    <input type="text" id="topic" name="topic" required>

    <label for="sub_topic">Sub-topic:</label>
    <input type="text" id="sub_topic" name="sub_topic" required>

    <label for="Description">Description:</label>
    <textarea id="Description" name="Description" required></textarea>

    <label for="pdf">Upload PDF:</label>
    <input type="file" id="pdf" name="pdf" accept=".pdf" required>

    <button type="submit">Upload</button>
  </form>

  <div id="materialsList">
    <!-- Materials will be displayed here -->
  </div>




  <script src="../../../../../../group_project_1.0/public/views/TeacherView/Options/UploadMat/script.js"></script>
</body>
</html>
