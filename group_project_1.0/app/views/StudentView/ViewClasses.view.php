<h1>Available Classes for <?= htmlspecialchars($subject) ?> (<?= htmlspecialchars($grade) ?>)</h1>

<?php if (!empty($classes)): ?>
    <ul>
        <?php foreach ($classes as $class): ?>
            <li>
                <strong>Class ID:</strong> <?= htmlspecialchars($class['Class_id']); ?><br>
                <strong>Subject:</strong> <?= htmlspecialchars($class['Subject']); ?><br>
                <strong>Grade:</strong> <?= htmlspecialchars($class['Grade']); ?><br>
                <strong>Type:</strong> <?= htmlspecialchars($class['Type']); ?><br>
                <strong>Fee:</strong> <?= htmlspecialchars($class['Fee']); ?><br>
                
                <!-- Enroll button -->
                <form action="/srilearn_UI/group_project_1.0/public/student/enrollClass/<?= $class['Class_id'] ?>" method="POST">
                    <button type="submit">Enroll</button>
                </form>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No classes found for the specified subject and grade.</p>
<?php endif; ?>
