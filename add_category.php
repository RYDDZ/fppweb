<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
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
                    <a class="nav-link active" href="add_category.php">Add Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_song.php">Add Song</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h1>Add New Category</h1>
    <form action="add_category.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label text-primary">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Add Category</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $query = "INSERT INTO categories (name) VALUES ('$name')";
        if ($conn->query($query) === TRUE) {
            echo "<div class='alert alert-success mt-3'>Category added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
        }
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>
