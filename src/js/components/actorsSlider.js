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
        items[active].style.cursor = 'default';
        
        const offset = getOffsetValue();
        
        // show after
        let stt = 0;
        for(var i = active + 1; i < items.length; i++){
            stt++;
            items[i].style.transform = `translateX(${offset*stt}px) scale(${1 - 0.2*stt}) perspective(16px) rotateY(-1deg)`;
            items[i].style.opacity = stt > 2 ? 0 : 0.6;
            items[i].classList.remove('active');
            items[i].classList.add('next');
            items[i].style.cursor = 'pointer';
        }
        stt = 0;
        for(var i = (active - 1); i >= 0; i--){
            stt++;
            items[i].style.transform = `translateX(${-offset*stt}px) scale(${1 - 0.2*stt}) perspective(16px) rotateY(1deg)`;
            items[i].style.opacity = stt > 2 ? 0 : 0.6;
            items[i].classList.remove('active');
            items[i].classList.add('prev');
            items[i].style.cursor = 'pointer';
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
        let hasMoved = false; // Флаг для отслеживания движения
        let wasSwiped = false; // Флаг для отслеживания свайпа
        let startActive = 0; // Активный слайд в начале перетаскивания

        // Функция для получения threshold в зависимости от размера экрана
        function getThreshold() {
            return window.innerWidth <= 768 ? 150 : 220; // Порог для переключения одного слайда
        }

        // Функция для вычисления нового активного слайда на основе пройденного расстояния
        function calculateNewActive(diffX) {
            let threshold = getThreshold();
            // Вычисляем количество слайдов на основе пройденного расстояния
            let slidesToMove = Math.floor(Math.abs(diffX) / threshold);
            
            if (diffX > 0) {
                // Свайп влево - следующий слайд
                return (startActive + slidesToMove) % items.length;
            } else {
                // Свайп вправо - предыдущий слайд
                return (startActive - slidesToMove + items.length) % items.length;
            }
        }

        // Обработчики для мыши
        sliderContainer.addEventListener('mousedown', (e) => {
            isDragging = true;
            hasMoved = false;
            startX = e.clientX;
            currentX = e.clientX;
            startActive = active; // Сохраняем начальный активный слайд
            sliderContainer.style.cursor = 'grabbing';
            e.preventDefault();
        });

        sliderContainer.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            currentX = e.clientX;
            
            let diffX = startX - currentX;
            
            if (Math.abs(diffX) > 5) {
                hasMoved = true;
                
                // Вычисляем новый активный слайд во время перетаскивания
                let newActive = calculateNewActive(diffX);
                if (newActive !== active) {
                    active = newActive;
                    loadShow();
                }
            }
        });

        sliderContainer.addEventListener('mouseup', (e) => {
            if (!isDragging) return;
            isDragging = false;
            sliderContainer.style.cursor = 'grab';
            
            let diffX = startX - currentX;
            let threshold = getThreshold();
            
            if (Math.abs(diffX) > threshold / 2) {
                wasSwiped = true;
                // Финальное вычисление активного слайда
                let newActive = calculateNewActive(diffX);
                active = newActive;
                loadShow();
                // Сбрасываем флаг через небольшую задержку, чтобы предотвратить случайный клик
                setTimeout(() => {
                    wasSwiped = false;
                }, 300);
            } else {
                // Если движение было слишком маленьким, возвращаемся к начальному слайду
                active = startActive;
                loadShow();
                wasSwiped = false;
            }
            
            hasMoved = false;
        });

        sliderContainer.addEventListener('mouseleave', (e) => {
            if (isDragging) {
                // При выходе за пределы контейнера применяем финальное переключение
                let diffX = startX - currentX;
                let threshold = getThreshold();
                if (Math.abs(diffX) > threshold / 2) {
                    wasSwiped = true;
                    let newActive = calculateNewActive(diffX);
                    active = newActive;
                    loadShow();
                    setTimeout(() => {
                        wasSwiped = false;
                    }, 300);
                } else {
                    active = startActive;
                    loadShow();
                }
                isDragging = false;
                sliderContainer.style.cursor = 'grab';
                hasMoved = false;
            }
        });

        // Обработчики для touch-событий (мобильные устройства)
        sliderContainer.addEventListener('touchstart', (e) => {
            isTouching = true;
            hasMoved = false;
            startX = e.touches[0].clientX;
            currentX = e.touches[0].clientX;
            startActive = active; // Сохраняем начальный активный слайд
            // Не вызываем preventDefault для touchstart
        });

        sliderContainer.addEventListener('touchmove', (e) => {
            if (!isTouching) return;
            currentX = e.touches[0].clientX;
            
            let diffX = startX - currentX;
            
            if (Math.abs(diffX) > 5) {
                hasMoved = true;
                
                // Вычисляем новый активный слайд во время перетаскивания
                let newActive = calculateNewActive(diffX);
                if (newActive !== active) {
                    active = newActive;
                    loadShow();
                }
            }
            
            // Проверяем, что это горизонтальный свайп
            if (Math.abs(diffX) > 10) {
                // Предотвращаем скролл только при горизонтальном движении
                e.preventDefault();
            }
        }, { passive: false });

        sliderContainer.addEventListener('touchend', (e) => {
            if (!isTouching) return;
            isTouching = false;
            
            let diffX = startX - currentX;
            let threshold = getThreshold();
            
            if (Math.abs(diffX) > threshold / 2) {
                wasSwiped = true;
                // Финальное вычисление активного слайда
                let newActive = calculateNewActive(diffX);
                active = newActive;
                loadShow();
                // Сбрасываем флаг через небольшую задержку, чтобы предотвратить случайный клик
                setTimeout(() => {
                    wasSwiped = false;
                }, 300);
            } else {
                // Если движение было слишком маленьким, возвращаемся к начальному слайду
                active = startActive;
                loadShow();
                wasSwiped = false;
            }
            
            hasMoved = false;
        });

        sliderContainer.addEventListener('touchcancel', () => {
            if (isTouching) {
                // При отмене возвращаемся к начальному слайду
                active = startActive;
                loadShow();
            }
            isTouching = false;
            hasMoved = false;
        });

        // Добавляем обработчики клика на слайды
        items.forEach((item, index) => {
            item.addEventListener('click', (e) => {
                // Проверяем, что это не активный слайд, не было движения и не было свайпа
                if (!hasMoved && !wasSwiped && !isDragging && !isTouching && index !== active) {
                    active = index;
                    loadShow();
                }
            });
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
