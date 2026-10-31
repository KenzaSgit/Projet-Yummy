document.addEventListener("DOMContentLoaded", function () {
  // Galerie
  const galleryContainer = document.querySelector(".gallery-container");
  const galleryItems = document.querySelectorAll(".gallery-item");
  const leftArrow = document.querySelector(".left-arrow");
  const rightArrow = document.querySelector(".right-arrow");
  const dotsContainer = document.querySelector(".pagination-dots");

  let imagesParPage = Math.floor(galleryContainer.clientWidth / galleryItems[0].clientWidth);
  let totalPages = Math.ceil(galleryItems.length / imagesParPage);
  let currentIndex = 0;
  let dots = [];

  function createPaginationDots() {
    dotsContainer.innerHTML = "";
    dots = [];

    for (let i = 0; i < totalPages; i++) {
      const dot = document.createElement("span");
      dot.classList.add("dot");
      if (i === 0) dot.classList.add("active");
      dot.addEventListener("click", () => goToPage(i));
      dotsContainer.appendChild(dot);
      dots.push(dot);
    }
  }

  function updateDots() {
    dots.forEach(dot => dot.classList.remove("active"));
    dots[currentIndex]?.classList.add("active");
  }

  function moveSlider(direction) {
    if (direction === 'next') {
      currentIndex = (currentIndex + 1) % totalPages;
    } else if (direction === 'prev') {
      currentIndex = (currentIndex - 1 + totalPages) % totalPages;
    }
    galleryContainer.style.transform = `translateX(${-currentIndex * 100}%)`;
    updateDots();
  }

  function goToPage(index) {
    currentIndex = Math.max(0, Math.min(index, totalPages - 1));
    galleryContainer.style.transform = `translateX(${-currentIndex * 100}%)`;
    updateDots();
  }

  rightArrow.addEventListener("click", () => moveSlider('next'));
  leftArrow.addEventListener("click", () => moveSlider('prev'));

  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight') moveSlider('next');
    else if (e.key === 'ArrowLeft') moveSlider('prev');
  });

  // Réservation
const reserveButton = document.querySelector('.reserve-button');
const reservationModal = document.querySelector('.reservation-modal');
const closeButton = document.querySelector('.close-button');

reserveButton?.addEventListener('click', () => {
  reservationModal.style.display = 'flex';
});

closeButton?.addEventListener('click', () => {
  reservationModal.style.display = 'none';
});

reservationModal?.addEventListener('click', (event) => {
  if (event.target === reservationModal) {
    reservationModal.style.display = 'none';
  }
});


// Recalculer les points si la taille de l'écran change
window.addEventListener("resize", () => {
  imagesParPage = Math.floor(galleryContainer.clientWidth / galleryItems[0].clientWidth);
  totalPages = Math.ceil(galleryItems.length / imagesParPage);
  createPaginationDots();
});

window.addEventListener('scroll', function() {
  const navbar = document.getElementById('navbar');
  const logo1 = document.getElementById('logo1');
  
  if (window.scrollY > 50) {
    navbar.classList.add('scrolled');
    logo1.src = "../IMG/logo_yummy-removebg-preview.png"; // Mets ici l'image que tu veux après scroll
  } else {
    navbar.classList.remove('scrolled');
    logo1.src = "../IMG/logoblanc-removebg-preview.png"; // Image originale
  }
});




createPaginationDots();
});