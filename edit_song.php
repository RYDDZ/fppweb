<?php
include 'db.php';

if (isset($_GET['id'])) {
    $song_id = $_GET['id'];

    // Mengambil data lagu berdasarkan ID
    $query = "SELECT * FROM songs WHERE id = $song_id";
    $result = $conn->query($query);
    $song = $result->fetch_assoc();

    // Jika data lagu tidak ditemukan
    if (!$song) {
        echo "<div class='alert alert-danger'>Song not found!</div>";
        exit();
    }
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $lyrics = $_POST['lyrics'];
    
    // Proses file upload jika ada
    if (isset($_FILES['audio']) && $_FILES['audio']['error'] == 0) {
        $file_name = $_FILES['audio']['name'];
        $file_tmp = $_FILES['audio']['tmp_name'];
        $file_size = $_FILES['audio']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $allowed_extensions = ['mp3', 'm4a', 'wav'];
        if (in_array($file_ext, $allowed_extensions)) {
            if ($file_size <= 10485760) { // Maksimal 10MB
                $new_file_name = uniqid('', true) . '.' . $file_ext;
                $upload_path = 'assets/uploads/' . $new_file_name;
                
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Hapus file lama jika ada
                    unlink($song['file_path']);
                    $query = "UPDATE songs SET title = ?, category_id = ?, file_path = ?, lyrics = ? WHERE id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sisss", $title, $category_id, $upload_path, $lyrics, $song_id);
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Song updated successfully!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Failed to update song!</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Failed to upload file.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>File size exceeds limit (10MB).</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Invalid file type. Only mp3, m4a, and wav are allowed.</div>";
        }
    } else {
        // Update tanpa mengupload file baru
        $query = "UPDATE songs SET title = ?, category_id = ?, lyrics = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $title, $category_id, $lyrics, $song_id);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Song updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to update song!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Song</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Music Streaming</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link active" href="songs.php">Songs</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_category.php">Add Category</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_song.php">Add Song</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h1 class="my-4">Edit Song</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label text-primary">Song Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $song['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label text-primary">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php
                    $categories = $conn->query("SELECT * FROM categories");
                    while ($category = $categories->fetch_assoc()) {
                        echo "<option value='" . $category['id'] . "'" . ($category['id'] == $song['category_id'] ? ' selected' : '') . ">" . $category['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="lyrics" class="form-label text-primary">Lyrics</label>
                <textarea class="form-control" id="lyrics" name="lyrics" rows="5"><?php echo $song['lyrics']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="audio" class="form-label text-primary">Audio File</label>
                <input type="file" class="form-control" id="audio" name="audio" accept="audio/mp3, audio/m4a, audio/wav">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Update Song</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
