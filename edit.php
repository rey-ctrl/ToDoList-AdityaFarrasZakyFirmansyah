<?php 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edit_id = $_POST['edit_id'] ?? -1;
    $name = trim($_POST['name']);
    $category = $_POST['category'] ?? '';
    $description = trim($_POST['description']);

    // Validasi input
    if (empty($name) || empty($category) || empty($description)) {
        $_SESSION['type'] = 'danger';
        $_SESSION['message'] = 'Semua bidang harus diisi!';
        header("Location: add.php");
        exit();
    }

    $task = [
        "name" => htmlspecialchars($name),
        "category" => htmlspecialchars($category),
        "description" => htmlspecialchars($description)
    ];

    if ($edit_id != -1 && isset($_SESSION['task'][$edit_id])) {
        // Jika sedang mengedit, update task di index yang sesuai
        $_SESSION['task'][$edit_id] = $task;
        $_SESSION['type'] = 'success';
        $_SESSION['message'] = 'Task berhasil diperbarui!';
    } else {
        if (!isset($_SESSION['task'])) {
            $_SESSION['task'] = [];
        }
        $_SESSION['task'][] = $task;
        $_SESSION['type'] = "success";
        $_SESSION['message'] = "Task berhasil ditambahkan";
    }

    header("Location: add.php");
    exit();
}
