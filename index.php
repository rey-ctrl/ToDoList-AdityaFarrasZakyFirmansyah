<?php
session_start();

// Handle POST request for adding or editing a task
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['name'];
    $priority = $_POST['category'];  
    $description = $_POST['description'];
    $status = $_POST['status'];
    $edit_id = $_POST['edit_id'];
    
    if (!isset($_SESSION['task'])) {
        $_SESSION['task'] = [];
    }

    if ($edit_id != -1 && isset($_SESSION['task'][$edit_id])) {
        $_SESSION['task'][$edit_id]['Task'] = $task_name;
        $_SESSION['task'][$edit_id]['Priority'] = $priority;
        $_SESSION['task'][$edit_id]['description'] = $description;
        $_SESSION['task'][$edit_id]['status'] = $status;
    } else {
        $_SESSION['task'][] = [
            'Task' => $task_name,
            'Priority' => $priority,
            'description' => $description,
            'status' => $status
        ];
    }

    // Set success message
    $_SESSION['message'] = 'Task successfully saved';
    $_SESSION['type'] = 'success';

    header("Location: index.php");
    exit();
}

function sort_by_priority($a, $b) {
    $priorities = ['high' => 1, 'medium' => 2, 'low' => 3];
    return $priorities[$a['Priority']] - $priorities[$b['Priority']];
}

if (isset($_SESSION['task']) && count($_SESSION['task']) > 0) {
    usort($_SESSION['task'], 'sort_by_priority');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-<?= $_SESSION['type']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['type']); ?>
        <?php endif; ?>

        <h1 class="text-center mb-4 p-2">Aplikasi To-Do List</h1>

        <?php if (isset($_SESSION['task']) && count($_SESSION['task']) > 0) : ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Task Name</th>
                        <th>Priority</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['task'] as $index => $task) : ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($task['Task']); ?></td>
                            <td><?= htmlspecialchars($task['Priority']); ?></td>
                            <td><?= htmlspecialchars($task['description']); ?></td>
                            <td>
                                <a href="add.php?edit=<?= $index; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?index=<?= $index; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No tasks found, Add some tasks.</p>
        <?php endif; ?>

        <a href="add.php" class="btn btn-secondary">Add Task</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
