const slider = document.querySelector('.slider');
const slides = document.querySelectorAll('.slider__slider');
const totalSlides = slides.length;
let currentSlide = 0;
let slideInterval;

function showSlide(index) {
    slides.forEach((slide, i) => {
        if (i === index) {
            slide.style.display = 'block';
        } else {
            slide.style.display = 'none';
        }
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

function startSlider() {
    slideInterval = setInterval(nextSlide, 4000);
}

function stopSlider() {
    clearInterval(slideInterval);
}

const leftArrow = document.querySelector('.left-arrow');
const rightArrow = document.querySelector('.right-arrow');

leftArrow.addEventListener('click', () => {
    prevSlide();
    stopSlider(); 
});

rightArrow.addEventListener('click', () => {
    nextSlide();
    stopSlider(); 
});

startSlider();

slider.addEventListener('mouseenter', stopSlider);

slider.addEventListener('mouseleave', startSlider);
