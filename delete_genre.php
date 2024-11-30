<?php include 'db.php'; ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM categories WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        echo "<div class='alert alert-success mt-3'>Category deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
    }
}
?>
