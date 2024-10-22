/* js for slider-image */

let currentSlide = 0;

function changeSlide(direction) {
    const slides = document.querySelector('.slider-container');
    const totalSlides = document.querySelectorAll('.slide').length;

    currentSlide += direction;

    // If the slide index exceeds bounds, wrap around
    if (currentSlide < 0) {
        currentSlide = totalSlides - 1;
    } else if (currentSlide >= totalSlides) {
        currentSlide = 0;
    }

    // Move the slider container to show the selected slide
    slides.style.transform = `translateX(-${currentSlide * 100}%)`;
}

/* end js for slider-image */