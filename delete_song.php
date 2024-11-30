<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil file audio untuk dihapus dari server
    $query = "SELECT file_path FROM songs WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $song = $result->fetch_assoc();
        $file_path = $song['file_path'];

        // Hapus file audio dari server jika ada
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Hapus data lagu dari database
        $delete_query = "DELETE FROM songs WHERE id = $id";
        if ($conn->query($delete_query)) {
            header("Location: songs.php?message=Song deleted successfully.");
            exit();
        } else {
            echo "Error deleting song: " . $conn->error;
        }
    } else {
        echo "Song not found!";
        exit();
    }
} else {
    header("Location: songs.php");
    exit();
}
?>