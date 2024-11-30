<?php
include 'db.php';

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Ambil kategori berdasarkan ID
    $category_query = "SELECT * FROM categories WHERE id = $category_id";
    $category_result = $conn->query($category_query);
    $category = $category_result->fetch_assoc();

    // Ambil semua lagu dari kategori ini
    $songs_query = "SELECT * FROM songs WHERE category_id = $category_id";
    $songs_result = $conn->query($songs_query);
} else {
    header("Location: categories.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category['name']; ?> - Songs</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="index.php">Music Streaming</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="songs.php">Songs</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="add_category.php">Add Category</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="add_song.php">Add Song</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-primary mb-5"><?php echo $category['name']; ?> - Songs</h1>
        <?php if ($songs_result->num_rows > 0): ?>
            <div class="row">
                <?php while ($song = $songs_result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <!-- Card for Each Song -->
                        <div class="card h-100">
                            <img src="assets/img/default-song-cover.jpg" class="card-img-top" alt="Song Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $song['title']; ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo $category['name']; ?></h6>
                                <p class="card-text"><?php echo nl2br($song['lyrics']); ?></p>

                                <!-- Play Button -->
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#audioModal<?php echo $song['id']; ?>">Play</button>

                                <!-- Dropdown for Edit and Delete -->
                                <div class="dropdown position-absolute top-0 end-0">
                                    <button class="btn dropdown-hidden" type="button" id="dropdownSong<?php echo $song['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownSong<?php echo $song['id']; ?>">
                                        <li><a class="dropdown-item" href="edit_song.php?id=<?php echo $song['id']; ?>">Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="delete_song.php?id=<?php echo $song['id']; ?>" onclick="return confirm('Are you sure you want to delete this song?');">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Audio Player -->
                    <div class="modal fade" id="audioModal<?php echo $song['id']; ?>" tabindex="-1" aria-labelledby="audioModalLabel<?php echo $song['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="audioModalLabel<?php echo $song['id']; ?>"><?php echo $song['title']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <audio id="audioPlayer<?php echo $song['id']; ?>" controls class="w-100">
                                        <source src="<?php echo $song['file_path']; ?>" type="audio/<?php echo pathinfo($song['file_path'], PATHINFO_EXTENSION); ?>">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-white">No songs found in this category.</p>
        <?php endif; ?>
    </div>

    <script>
        // Menangani event ketika modal dibuka
        var audioModalElements = document.querySelectorAll('.modal');
        audioModalElements.forEach(function(modalElement) {
            modalElement.addEventListener('shown.bs.modal', function(event) {
                var modal = event.target;
                var audioElement = modal.querySelector('audio');
                if (audioElement) {
                    audioElement.play();
                }
            });

            // Menangani event ketika modal ditutup (untuk menghentikan musik jika diperlukan)
            modalElement.addEventListener('hidden.bs.modal', function(event) {
                var modal = event.target;
                var audioElement = modal.querySelector('audio');
                if (audioElement) {
                    audioElement.pause();
                    audioElement.currentTime = 0; // Reset audio to the beginning
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>