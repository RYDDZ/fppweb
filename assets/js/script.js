// scripts.js

// Konfirmasi saat menghapus kategori atau lagu
function confirmDelete(message) {
    return confirm(message);
}

// Validasi form upload lagu
document.querySelector('form').addEventListener('submit', function(event) {
    let audioInput = document.querySelector('#audio');
    if (audioInput.files.length === 0) {
        alert('Please select an audio file to upload!');
        event.preventDefault();
    }
});

// Validasi form kategori
document.querySelector('#category-form').addEventListener('submit', function(event) {
    let nameInput = document.querySelector('#name');
    if (nameInput.value.trim() === '') {
        alert('Category name cannot be empty!');
        event.preventDefault();
    }
});
