<?php
session_start();

if (isset($_GET['index'])) {  // Pastikan menggunakan parameter yang sama
    $delete_id = (int) $_GET['index'];

    // Periksa apakah task dengan id tersebut ada
    if (isset($_SESSION['task'][$delete_id])) {
        unset($_SESSION['task'][$delete_id]); 
        $_SESSION['message'] = 'Task berhasil dihapus!';
        $_SESSION['type'] = 'success';
        
        // Reindex array agar tidak ada celah dalam indeks
        $_SESSION['task'] = array_values($_SESSION['task']);
    } else {
        $_SESSION['message'] = 'Task tidak ditemukan!';
        $_SESSION['type'] = 'danger';
    }
}

header("Location: index.php");
exit();
