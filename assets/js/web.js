let currentIndex = 0;
const imageSources = [
    "assets/img/web/gymfacility1.jpg",
    "assets/img/web/gymfacility2.jpg",
    "assets/img/web/gymfacility3.jpg",
    "assets/img/web/gymfacility4.jpg"
];

const mainImage = document.getElementById('main-image');
const thumbnails = document.querySelectorAll('.thumbnails img');

// Display the current image
function updateDisplay() {
    mainImage.src = imageSources[currentIndex];

    thumbnails.forEach((thumb, index) => {
        thumb.classList.toggle('active', index === currentIndex);
    });
}

function changeImage(direction) {
    currentIndex += direction;
    if (currentIndex < 0) currentIndex = imageSources.length - 1;
    else if (currentIndex >= imageSources.length) currentIndex = 0;
    updateDisplay();
}

function changeMainImage(index) {
    currentIndex = index;
    updateDisplay();
}

// Initial display
window.addEventListener('DOMContentLoaded', updateDisplay);
