<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./../../../group_project_1.0/app/views/A_test.css">

</head>
<body>

    <h1>Test</h1>

    <div>
        <button id="create" onclick="viewform()">Create</button>
    </div>
   
    <!-- fetch all details -->
    <div class="container" id="container">

    <!-- create form -->
    <div class="form" id="form" style="display: none;">
        <button id="close" onclick="closeForm()">X</button>
        <h2>Insert</h2>
        <form id="insertForm" method="post" action="">
            <input type="text" name="Name" id="Name" placeholder="Name" required>
            <input type="text" name="Age" id="Age" placeholder="Age" required>
            <input type="date" name="DOB" id="DOB" placeholder="DOB" required>
            <button type="submit">Insert</button>
        </form>
    </div>

    <div id="overlay"></div>

   <!-- View and Update Form HTML -->
<div class="editform" id="editform" style="display: none;">
    <button id="close" onclick="closeForm()">X</button>
    <form id="insertForm">
        <input type="hidden" name="U_id" id="U_id" value="">
        <div class="form-group">
            <label for="edit_Name">Name:</label>
            <input type="text" name="Name" id="edit_Name" disabled>
        </div>
        <div class="form-group">
            <label for="edit_Age">Age:</label>
            <input type="text" name="Age" id="edit_Age" disabled>
        </div>
        <div class="form-group">
            <label for="edit_DOB">Date of Birth:</label>
            <input type="date" name="DOB" id="edit_DOB" disabled>
        </div>
        <div class="button-group">
            <button type="button" id="editButton" onclick="Edit()">Edit</button>
            <button type="button" id="CancelButton" onclick="Cancel()" style="display: none;">Cancel</button>
            <button type="button" id="UpdateButton" onclick="Update()" style="display: none;">Update</button>
            <button type="button" id="DeleteButton" onclick="Delete_rec()" style="display: none;">Delete</button>
        </div>
    </form>
</div>

</body>
<script src="./../../../group_project_1.0/app/views/A_test.js"></script>
</html>