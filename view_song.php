<?php
require 'db.php';

$category_id = $_GET['category_id'];
$songs = $conn->query("SELECT * FROM songs WHERE category_id = $category_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Songs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <a class="nav-link active" href="index.php">Home</a>
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
                    <a class="nav-link" href="add_song.php">Add Song</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <h1>View Songs</h1>
    <ul>
        <?php while ($row = $songs->fetch_assoc()) : ?>
            <li>
                <h2><?= $row['title'] ?> by <?= $row['artist'] ?></h2>
                <audio controls>
                    <source src="<?= $row['file_path'] ?>" type="audio/mpeg">
                </audio>
                <p>Lyrics: <?= $row['lyrics'] ?></p>
            </li>
        <?php endwhile; ?>
    </ul>
<script src="assets/js/scripts.js"></script>
</body>
</html>
