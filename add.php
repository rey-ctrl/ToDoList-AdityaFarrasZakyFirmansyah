<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <!-- Tampilkan pesan berhasil atau gagal -->
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-<?= $_SESSION['type']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            
            <?php
                unset($_SESSION['message']);
                unset($_SESSION['type']);
            ?>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-dark text-white">Add Tasks</div>
            <div class="card-body">
                <?php
                    $edit_mode = false;
                    $edit_id = -1;
                    if (isset($_GET['edit'])) {
                        $edit_id = $_GET['edit'];
                        $edit_mode = true;
                        $task = $_SESSION['task'][$edit_id];
                    }
                ?>
                <form method="POST" action="index.php">
                    <input type="hidden" name="edit_id" value="<?= $edit_mode ? $edit_id : -1; ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Task Name</label>
                        <input type="text" class="form-control" name="name" value="<?= $edit_mode ? $task['Task'] : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select name="category" id="priority" class="form-select">
                            <option value="low" <?= $edit_mode && $task['Priority'] == 'low' ? 'selected' : ''; ?>>Low</option>
                            <option value="medium" <?= $edit_mode && $task['Priority'] == 'medium' ? 'selected' : ''; ?>>Medium</option>
                            <option value="high" <?= $edit_mode && $task['Priority'] == 'high' ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Task Description</label>
                        <textarea class="form-control" name="description" required><?= $edit_mode ? $task['description'] : '' ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= $edit_mode ? 'Update Task' : 'Add Task' ?></button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
