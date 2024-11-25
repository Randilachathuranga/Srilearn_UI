<?php

// Teacher Controller
class TeacherController extends Controller {

    // View all teachers
    public function index() {
        $teacher = new Teacher();
        $teachers = $teacher->findall(); // Fetch all teachers
        $this->view('teachers.index', ['teachers' => $teachers]); // Load the view
    }

    // Show form to add a new teacher
    public function create() {
        $this->view('teachers.create'); // Load the create teacher view
    }

    // Store a new teacher
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Create teacher instance and populate with POST data
            $teacher = new Teacher();
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'subject' => $_POST['subject'],
            ];
            
            if ($teacher->insert($data)) {
                redirect('teacher'); // Redirect to teacher list page after insertion
            } else {
                echo "Error in adding teacher";
            }
        }
    }

    // Show form to update a teacher
    public function edit($id) {
        $teacher = new Teacher();
        $teacher_data = $teacher->first(['id' => $id]); // Fetch teacher by id
        if ($teacher_data) {
            $this->view('teachers.edit', ['teacher' => $teacher_data]); // Load the edit form with teacher data
        } else {
            echo "Teacher not found";
        }
    }

    // Update teacher details
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $teacher = new Teacher();
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'subject' => $_POST['subject'],
            ];

            if ($teacher->update($id, $data)) {
                redirect('teacher'); // Redirect to teacher list page after update
            } else {
                echo "Error in updating teacher";
            }
        }
    }

    // Delete a teacher
    public function delete($id) {
        $teacher = new Teacher();
        if ($teacher->delete($id)) {
            redirect('teacher'); // Redirect to teacher list page after deletion
        } else {
            echo "Error in deleting teacher";
        }
    }
}

// Teacher Model
class Teacher {
    use Model; // Use the Model trait for CRUD operations

    // Table name for this model
    protected $table = 'teachers'; // Assuming a table named 'teachers'

    // Columns that are allowed for insertion/updating
    protected $allowedColumns = ['name', 'email', 'phone', 'subject'];
}

// Teacher Views

// teachers.index.php (List all teachers)
?>
<h1>All Teachers</h1>
<a href="/group_project_1.0/public/teacher/create">Add New Teacher</a>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Subject</th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($teachers as $teacher): ?>
        <tr>
            <td><?= $teacher->name ?></td>
            <td><?= $teacher->email ?></td>
            <td><?= $teacher->phone ?></td>
            <td><?= $teacher->subject ?></td>
            <td>
                <a href="/group_project_1.0/public/teacher/edit/<?= $teacher->id ?>">Edit</a>
                <a href="/group_project_1.0/public/teacher/delete/<?= $teacher->id ?>" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
// teachers.create.php (Create new teacher form)
?>
<h1>Add New Teacher</h1>
<form method="POST" action="/group_project_1.0/public/teacher/store">
    <label for="name">Name:</label>
    <input type="text" name="name" required>
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <label for="phone">Phone:</label>
    <input type="text" name="phone" required>
    <label for="subject">Subject:</label>
    <input type="text" name="subject" required>
    <button type="submit">Add Teacher</button>
</form>

<?php
// teachers.edit.php (Edit existing teacher form)
?>
<h1>Edit Teacher</h1>
<form method="POST" action="/group_project_1.0/public/teacher/update/<?= $teacher->id ?>">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?= $teacher->name ?>" required>
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?= $teacher->email ?>" required>
    <label for="phone">Phone:</label>
    <input type="text" name="phone" value="<?= $teacher->phone ?>" required>
    <label for="subject">Subject:</label>
    <input type="text" name="subject" value="<?= $teacher->subject ?>" required>
    <button type="submit">Update Teacher</button>
</form>

<?php
// In your App.php, add the necessary routing
// Modify the splitURL function for routing:
$URL = $this->splitURL();

if ($URL[0] == 'teacher') {
    $controller = 'TeacherController';
    unset($URL[0]);

    $controllerInstance = new $controller;
    
    if (isset($URL[1])) {
        if ($URL[1] == 'create') {
            $controllerInstance->create();
        } elseif ($URL[1] == 'store') {
            $controllerInstance->store();
        } elseif ($URL[1] == 'edit') {
            $controllerInstance->edit($URL[2]);
        } elseif ($URL[1] == 'update') {
            $controllerInstance->update($URL[2]);
        } elseif ($URL[1] == 'delete') {
            $controllerInstance->delete($URL[2]);
        } else {
            $controllerInstance->index();
        }
    } else {
        $controllerInstance->index();
    }
} 
?>
