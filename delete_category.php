<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus kategori berdasarkan ID
    $delete_query = "DELETE FROM categories WHERE id = $id";

    if ($conn->query($delete_query)) {
        header("Location: categories.php?message=Category deleted successfully.");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: categories.php");
    exit();
}
?>