import QRCode from 'qrcode';

window.generateYourWishlyQr = async function generateYourWishlyQr(url) {
    return QRCode.toDataURL(url, {
        width: 320,
        margin: 1,
        errorCorrectionLevel: 'M',
        color: {
            dark: '#0f172a',
            light: '#ffffff',
        },
    });
};

function setActiveDot(dots, activeIndex) {
    dots.forEach((dot, index) => {
        dot.classList.toggle('bg-rose-500', index === activeIndex);
        dot.classList.toggle('scale-125', index === activeIndex);
        dot.classList.toggle('bg-slate-300', index !== activeIndex);
    });
}

function initYourWishlyCarousel(root) {
    const track = root.querySelector('.carousel-track');
    const slides = Array.from(root.querySelectorAll('.carousel-slide'));
    const prevButton = root.querySelector('.carousel-prev');
    const nextButton = root.querySelector('.carousel-next');
    const dots = Array.from(root.querySelectorAll('.carousel-dot'));

    if (!track || slides.length === 0 || dots.length === 0) {
        return;
    }

    let activeIndex = 0;
    let timer = null;

    const render = () => {
        track.style.transform = `translateX(-${activeIndex * 100}%)`;
        setActiveDot(dots, activeIndex);
    };

    const goTo = (index) => {
        activeIndex = (index + slides.length) % slides.length;
        render();
    };

    const next = () => goTo(activeIndex + 1);
    const prev = () => goTo(activeIndex - 1);

    prevButton?.addEventListener('click', () => {
        prev();
        restartAutoplay();
    });

    nextButton?.addEventListener('click', () => {
        next();
        restartAutoplay();
    });

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goTo(index);
            restartAutoplay();
        });
    });

    const startAutoplay = () => {
        timer = window.setInterval(next, 5000);
    };

    const stopAutoplay = () => {
        if (timer) {
            window.clearInterval(timer);
            timer = null;
        }
    };

    const restartAutoplay = () => {
        stopAutoplay();
        startAutoplay();
    };

    root.addEventListener('mouseenter', stopAutoplay);
    root.addEventListener('mouseleave', startAutoplay);
    root.addEventListener('focusin', stopAutoplay);
    root.addEventListener('focusout', startAutoplay);

    render();
    startAutoplay();
}

function initPasswordToggle(button) {
    const inputId = button.getAttribute('data-password-toggle');
    const input = inputId ? document.getElementById(inputId) : null;
    const showLabel = button.getAttribute('data-show-label') || 'Lihat';
    const hideLabel = button.getAttribute('data-hide-label') || 'Sembunyikan';

    if (!input) {
        return;
    }

    button.addEventListener('click', () => {
        const shouldShow = input.type === 'password';

        input.type = shouldShow ? 'text' : 'password';
        button.textContent = shouldShow ? hideLabel : showLabel;
        button.setAttribute('aria-pressed', shouldShow ? 'true' : 'false');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-yourwishly-carousel]').forEach(initYourWishlyCarousel);
    document.querySelectorAll('[data-password-toggle]').forEach(initPasswordToggle);
});
