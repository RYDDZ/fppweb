<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Song</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Music Streaming</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="songs.php">Songs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_category.php">Add Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="add_song.php">Add Song</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h1>Add New Song</h1>
    <form action="add_song.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label text-primary">Song Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label text-primary">Category</label>
            <select class="form-control" id="category" name="category_id" required>
                <option value="">-- Select Category --</option>
                <?php
                $categories = $conn->query("SELECT * FROM categories");
                while ($row = $categories->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="audio" class="form-label text-primary">Upload Audio File (mp3, m4a, wav)</label>
            <input type="file" class="form-control" id="audio" name="audio" accept=".mp3,.m4a,.wav" required>
        </div>
        <div class="mb-3">
            <label for="lyrics" class="form-label text-primary">Lyrics</label>
            <textarea class="form-control" id="lyrics" name="lyrics" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Add Song</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $category_id = $_POST['category_id'];
        $lyrics = $_POST['lyrics'];
        $audio = $_FILES['audio'];
        $file_name = $audio['name'];
        $file_tmp = $audio['tmp_name'];
        $file_error = $audio['error'];
        $file_size = $audio['size'];

        $allowed_extensions = ['mp3', 'm4a', 'wav'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_error === 0) {
            if (in_array($file_ext, $allowed_extensions)) {
                if ($file_size <= 10 * 1024 * 1024) { // Max 10MB
                    $new_file_name = uniqid('', true) . '.' . $file_ext;
                    $upload_path = 'assets/uploads/' . $new_file_name;
                    if (move_uploaded_file($file_tmp, $upload_path)) {
                        $stmt = $conn->prepare("INSERT INTO songs (title, category_id, file_path, lyrics) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("siss", $title, $category_id, $upload_path, $lyrics);
                        if ($stmt->execute()) {
                            echo "Song uploaded successfully!";
                        } else {
                            echo "Failed to save song.";
                        }
                        $stmt->close();
                    } else {
                        echo "File upload failed.";
                    }
                } else {
                    echo "File size exceeds limit (10MB).";
                }
            } else {
                echo "Invalid file type. Only mp3, m4a, and wav are allowed.";
            }
        }
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>