<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Streaming</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">Music Streaming</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active text-white" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="songs.php">Songs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="add_category.php">Add Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="add_song.php">Add Song</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h1 class="text-center text-white">Music Streaming Platform</h1>
    <a href="categories.php" class="btn btn-primary">Manage Categories</a>
    <a href="songs.php" class="btn btn-success">Manage Songs</a>

    <h2 class="mt-4 text-white">Songs</h2>
    <div class="list-group">
        <?php
        $query = "SELECT songs.*, categories.name AS category_name FROM songs 
                  JOIN categories ON songs.category_id = categories.id";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo '<a href="#" class="list-group-item list-group-item-action">';
            echo '<h5>' . $row['title'] . ' (' . $row['category_name'] . ')</h5>';
            echo '<p>' . substr($row['lyrics'], 0, 100) . '...</p>';
            echo '</a>';
        }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>