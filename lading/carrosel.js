// Script do carrossel
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('.carousel');
    const slides = carousel.querySelectorAll('.carousel-item');
    let currentSlide = 0;
    let isTransitioning = false;

    const nextButton = carousel.querySelector('.carousel-control-next');
    const prevButton = carousel.querySelector('.carousel-control-prev');
    const indicators = carousel.querySelectorAll('.carousel-indicators button');

    // Função para mudar slide
    const goToSlide = (index) => {
        if (isTransitioning) return;
        isTransitioning = true;

        slides[currentSlide].classList.remove('active');
        indicators[currentSlide].classList.remove('active');
        currentSlide = index;
        slides[currentSlide].classList.add('active');
        indicators[currentSlide].classList.add('active');

        setTimeout(() => {
            isTransitioning = false;
        }, 600);
    };

    // Próximo slide
    nextButton.addEventListener('click', () => {
        const nextSlide = (currentSlide + 1) % slides.length;
        goToSlide(nextSlide);
    });

    // Slide anterior
    prevButton.addEventListener('click', () => {
        const prevSlide = (currentSlide - 1 + slides.length) % slides.length;
        goToSlide(prevSlide);
    });

    // Controle dos indicadores
    indicators.forEach((button, index) => {
        button.addEventListener('click', () => goToSlide(index));
    });

    // Muda slide automaticamente a cada 5 segundos
    setInterval(() => {
        const nextSlide = (currentSlide + 1) % slides.length;
        goToSlide(nextSlide);
    }, 5000);
});
