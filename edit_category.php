<?php
include 'db.php';

// Periksa apakah parameter ID diterima
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data kategori berdasarkan ID
    $query = "SELECT * FROM categories WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
    } else {
        echo "Category not found!";
        exit();
    }
} else {
    header("Location: categories.php");
    exit();
}

// Perbarui data kategori
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);

    $update_query = "UPDATE categories SET name = '$name', description = '$description' WHERE id = $id";

    if ($conn->query($update_query)) {
        header("Location: categories.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_category.php">Add Category</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-primary">Edit Category</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label text-primary">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['name']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="categories.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>