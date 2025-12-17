import Swiper from 'swiper';
import 'swiper/css';

export function initServicesSlider() {
    console.log('initServicesSlider called');

    const sliderContainer = document.querySelector('#services .services__slider');

    const servicesSwiper = new Swiper(sliderContainer, {
        slidesPerView: 4,
        centeredSlides: false,
        loop: true,
        grabCursor: true,
        spaceBetween: 0,
        on: {
            init: function() {
                updateSlideClasses(this);
            },
            slideChange: function() {
                updateSlideClasses(this);
            }
        },
        breakpoints: {
            320: {
                slidesPerView: 2,
                centeredSlides: true
            },
            480: {
                slidesPerView: 2,
                centeredSlides: true
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 3,
            },
            1440: {
                slidesPerView: 4,
            },
            1920: {
                slidesPerView: 4,
            }
        }
    });

    function updateSlideClasses(swiper) {
        // Удаляем все классы со всех слайдов
        swiper.slides.forEach(slide => {
            slide.classList.remove('active', 'next', 'prev');
        });

        const activeIndex = swiper.activeIndex;
        const slides = swiper.slides;

        // Добавляем класс active для активного слайда
        if (slides[activeIndex]) {
            slides[activeIndex].classList.add('active');
            slides[activeIndex].style.opacity = 1;
        }

        // Добавляем класс next для всех следующих слайдов
        for (let i = activeIndex + 1; i < slides.length; i++) {
            slides[i].classList.add('next');
            slides[i].style.opacity = 1;
        }

        // Добавляем класс prev для всех предыдущих слайдов
        for (let i = activeIndex - 1; i >= 0; i--) {
            slides[i].classList.add('prev');
            slides[i].style.opacity = 1;

        }

        // Прозрачность для следующих слайдов
        if (window.innerWidth <= 768) {
            for (let i = activeIndex + 1; i < slides.length; i++) {
                slides[i].style.opacity = 0.5;
            }
    
            for (let i = activeIndex - 1; i >= 0; i--) {
                slides[i].style.opacity = 0.5;
            }
        } else {
            for (let i = activeIndex + 2; i < slides.length; i++) {
                slides[i].style.opacity = 0.5;
            }
    
            for (let i = activeIndex - 2; i >= 0; i--) {
                slides[i].style.opacity = 0.5;
            }
        }
        
    }
}