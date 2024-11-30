<?php
include 'db.php';

// Mengambil semua kategori
$query = "SELECT * FROM categories";
$result = $conn->query($query);
?>

<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Music Streaming</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                    <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active text-white" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="songs.php">Songs</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="add_category.php">Add Category</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="add_song.php">Add Song</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-primary mb-5">Categories</h1>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($category = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center position-relative">
                                <h5 class="card-title"><?php echo $category['name']; ?></h5>
                                <a href="category_songs.php?category_id=<?php echo $category['id']; ?>" class="btn btn-primary">View Songs</a>
                                
                                <!-- Dropdown for Edit and Delete -->
                                <div class="dropdown position-absolute top-0 end-0">
                                    <button class="btn dropdown-hidden" type="button" id="dropdownCategory<?php echo $category['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownCategory<?php echo $category['id']; ?>">
                                        <li><a class="dropdown-item" href="edit_category.php?id=<?php echo $category['id']; ?>">Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="delete_category.php?id=<?php echo $category['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No categories found. <a href="add_category.php">Add a category</a></p>
            <?php endif; ?>
        </div>
    </div>

    <script src="assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
