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

    // Инициализация слайдера услуг (services)
    initServicesSlider();
}

function initServicesSlider() {
    let items = document.querySelectorAll('.services__slider .slide');
    if (items.length === 0) {
        console.log('Services slider not found, skipping');
        return;
    }
    
    // let active = Math.min(5, Math.floor(items.length / 2));
    let active = 0;
    
    // Функция для получения значения смещения в зависимости от размера экрана
    function getOffsetValue() {
        return window.innerWidth <= 768 ? 220 : 340;
    }
    
    function loadShow(){
        if (!items[active]) return;
        
        // Удаляем все классы prev и next
        items.forEach(item => {
            item.classList.remove('prev', 'next');
        });
        
        items[active].style.transform = `none`;
        items[active].style.zIndex = 1;
        items[active].style.filter = 'none';
        items[active].style.opacity = 1;
        items[active].classList.add('active');
        
        const offset = getOffsetValue();
        
        // show after
        let stt = 0;
        for(var i = active + 1; i < items.length; i ++){
            stt++;
            items[i].style.transform = `translateX(${offset*stt}px) scale(${1 - 0.2*stt}) perspective(16px) rotateY(-1deg)`;
            items[i].style.opacity = stt > 2 ? 0 : 0.6;
            items[i].classList.remove('active');
            items[i].classList.add('next');
        }
        stt = 0;
        for(var i = (active - 1); i >= 0; i --){
            stt++;
            items[i].style.transform = `translateX(${-offset*stt}px) scale(${1 - 0.2*stt}) perspective(16px) rotateY(1deg)`;
            items[i].style.opacity = stt > 2 ? 0 : 0.6;
            items[i].classList.remove('active');
            items[i].classList.add('prev');
        }
    }
    loadShow();

    // Добавляем свайп мышью и тач-события
    let sliderContainer = document.querySelector('.services__slider');
    if (sliderContainer && items.length > 0) {
        let isDragging = false;
        let isTouching = false;
        let startX = 0;
        let currentX = 0;
        let threshold = 50; // минимальное расстояние для свайпа

        // Обработчики для мыши
        sliderContainer.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.clientX;
            sliderContainer.style.cursor = 'grabbing';
            e.preventDefault();
        });

        sliderContainer.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            currentX = e.clientX;
        });

        sliderContainer.addEventListener('mouseup', (e) => {
            if (!isDragging) return;
            isDragging = false;
            sliderContainer.style.cursor = 'grab';
            
            let diffX = startX - currentX;
            
            if (Math.abs(diffX) > threshold) {
                if (diffX > 0) {
                    // Свайп влево - следующий слайд (зациклено)
                    active = active + 1 < items.length ? active + 1 : 0;
                } else {
                    // Свайп вправо - предыдущий слайд (зациклено)
                    active = active - 1 >= 0 ? active - 1 : items.length - 1;
                }
                loadShow();
            }
        });

        sliderContainer.addEventListener('mouseleave', () => {
            if (isDragging) {
                isDragging = false;
                sliderContainer.style.cursor = 'grab';
            }
        });

        // Обработчики для touch-событий (мобильные устройства)
        sliderContainer.addEventListener('touchstart', (e) => {
            isTouching = true;
            startX = e.touches[0].clientX;
            e.preventDefault();
        }, { passive: false });

        sliderContainer.addEventListener('touchmove', (e) => {
            if (!isTouching) return;
            currentX = e.touches[0].clientX;
            e.preventDefault();
        }, { passive: false });

        sliderContainer.addEventListener('touchend', (e) => {
            if (!isTouching) return;
            isTouching = false;
            
            let diffX = startX - currentX;
            
            if (Math.abs(diffX) > threshold) {
                if (diffX > 0) {
                    // Свайп влево - следующий слайд (зациклено)
                    active = active + 1 < items.length ? active + 1 : 0;
                } else {
                    // Свайп вправо - предыдущий слайд (зациклено)
                    active = active - 1 >= 0 ? active - 1 : items.length - 1;
                }
                loadShow();
            }
            
            e.preventDefault();
        }, { passive: false });

        sliderContainer.addEventListener('touchcancel', () => {
            isTouching = false;
        });

        // Обновление при изменении размера окна
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                loadShow();
            }, 100);
        });

        sliderContainer.style.cursor = 'grab';
    }

    console.log('Services slider initialized successfully');
}
