import Swiper from 'swiper';
import 'swiper/css';

export function initActorsSlider() {
    console.log('initActorsSlider called');
    
    // Находим контейнер слайдера акторов
    const actorsSliderContainer = document.querySelector('#actors .actors__slider .swiper');
    
    if (!actorsSliderContainer) {
        console.error('Actors slider container not found');
        console.log('Available actors elements:', {
            actors: document.querySelector('#actors'),
            actorsSlider: document.querySelector('.actors__slider'),
            allSwipers: document.querySelectorAll('.swiper')
        });
        return;
    }

    console.log('Actors slider container found:', actorsSliderContainer);

    // Получаем все слайды
    const slides = actorsSliderContainer.querySelectorAll('.swiper-slide');
    if (!slides || slides.length === 0) {
        console.error('No slides found in actors slider');
        return;
    }

    console.log('Found slides:', slides.length);

    // Костыль: дублируем слайды для правильной работы слайдера (когда слайдов мало)
    const swiperWrapper = actorsSliderContainer.querySelector('.swiper-wrapper');
    if (swiperWrapper && slides.length > 0) {
        // Клонируем все слайды и добавляем их в конец
        slides.forEach((slide) => {
            const clonedSlide = slide.cloneNode(true);
            swiperWrapper.appendChild(clonedSlide);
        });
        console.log('Slides duplicated. Total slides now:', swiperWrapper.querySelectorAll('.swiper-slide').length);
    }

    // Вычисляем начальный слайд (средний)
    // const initialSlide = Math.floor(slides.length / 2); // закомментированно для того чтобы начать с первого слайда

    // Инициализируем Swiper для слайдера акторов
    const actorsSwiper = new Swiper(actorsSliderContainer, {
        slidesPerView: 2,
        spaceBetween: 30,
        centeredSlides: true,
        initialSlide: 0,
        loop: true,
        grabCursor: true,
        watchSlidesProgress: true,
        breakpoints: {
            320: {
                slidesPerView: 1.5,
                spaceBetween: 20,
            },
            480: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2.5,
                spaceBetween: 25,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1440: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
            1920: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });

    console.log('Actors slider initialized successfully');
}