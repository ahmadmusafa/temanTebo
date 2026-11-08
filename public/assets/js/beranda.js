
document.addEventListener('DOMContentLoaded', function () {

    // SLIDESHOW OTOMATIS
    const slides = document.querySelectorAll('#heroSlider .hero-slide');

    if (slides.length > 1) {
        let current = 0;

        setInterval(function () {
            slides[current].classList.remove('active');

            current = (current + 1) % slides.length;

            slides[current].classList.add('active');
        }, 5000);
    }

    // ANIMASI ANGKA STATISTIK
    const counters = document.querySelectorAll('.counter');

    counters.forEach(function (counter) {
        const target = Number(counter.dataset.target);
        const duration = 1800;
        const startTime = performance.now();

        function updateCounter(currentTime) {
            const progress = Math.min(
                (currentTime - startTime) / duration,
                1
            );

            const easeOut = 1 - Math.pow(1 - progress, 3);
            const value = Math.floor(target * easeOut);

            counter.textContent = value.toLocaleString('id-ID');

            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString('id-ID');
            }
        }

        requestAnimationFrame(updateCounter);
    });

});
