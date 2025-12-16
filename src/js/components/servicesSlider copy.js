import Swiper from 'swiper';
import 'swiper/css';

export function initServicesSlider() {
    const sliderContainer = document.querySelector('.services__slider');
    const items = document.querySelectorAll('.services__slider .slide');
    
    if (items.length === 0 || !sliderContainer) {
        console.log('Services slider not found, skipping');
        return;
    }
    
    // Создаем структуру Swiper
    const swiperWrapper = document.createElement('div');
    swiperWrapper.className = 'swiper-wrapper';
    // Отключаем стандартные стили Swiper для wrapper
    swiperWrapper.style.display = 'block';
    swiperWrapper.style.transform = 'none';
    swiperWrapper.style.transitionDuration = '0ms';
    
    // Перемещаем все слайды в swiper-wrapper
    items.forEach((slide) => {
        const swiperSlide = document.createElement('div');
        swiperSlide.className = 'swiper-slide';
        // Отключаем стандартные стили Swiper для slide
        swiperSlide.style.width = 'auto';
        swiperSlide.style.height = 'auto';
        swiperSlide.style.display = 'block';
        swiperSlide.style.transform = 'none';
        // Клонируем slide и добавляем в swiper-slide
        const clonedSlide = slide.cloneNode(true);
        swiperSlide.appendChild(clonedSlide);
        swiperWrapper.appendChild(swiperSlide);
    });

    // Сохраняем элемент light если он есть
    const lightElement = sliderContainer.querySelector('.light');
    
    // Очищаем контейнер от старых слайдов
    items.forEach(item => item.remove());
    
    // Добавляем структуру Swiper (light должен остаться перед wrapper)
    if (lightElement) {
        sliderContainer.insertBefore(swiperWrapper, lightElement.nextSibling);
    } else {
        sliderContainer.appendChild(swiperWrapper);
    }
    
    // Функция для получения значения смещения в зависимости от размера экрана
    function getOffsetValue() {
        return window.innerWidth <= 768 ? 220 : 340;
    }
    
    // Функция для применения стилей к слайдам
    function applySlideStyles(swiper) {
        const slides = swiper.slides;
        const activeIndex = swiper.activeIndex;
        
        slides.forEach((slideEl, index) => {
            const slide = slideEl.querySelector('.slide');
            if (!slide) return;
        
        // Удаляем все классы prev и next
            slide.classList.remove('prev', 'next', 'active');
        
        const offset = getOffsetValue();
            const diff = index - activeIndex;
            
            if (diff === 0) {
                // Активный слайд
                slide.style.transform = 'none';
                slide.style.zIndex = '1';
                slide.style.filter = 'none';
                slide.style.opacity = '1';
                slide.classList.add('active');
                slide.style.cursor = 'default';
            } else if (diff > 0) {
                // Слайды справа (next)
                const stt = Math.abs(diff);
                slide.style.transform = `translateX(${offset * stt}px) scale(${1 - 0.2 * stt}) perspective(16px) rotateY(-1deg)`;
                slide.style.opacity = stt > 2 ? '0' : '0.6';
                slide.classList.add('next');
                slide.style.cursor = 'pointer';
                slide.style.zIndex = '0';
            } else {
                // Слайды слева (prev)
                const stt = Math.abs(diff);
                slide.style.transform = `translateX(${-offset * stt}px) scale(${1 - 0.2 * stt}) perspective(16px) rotateY(1deg)`;
                slide.style.opacity = stt > 2 ? '0' : '0.6';
                slide.classList.add('prev');
                slide.style.cursor = 'pointer';
                slide.style.zIndex = '0';
            }
        });
    }

    // Инициализируем Swiper
    const servicesSwiper = new Swiper(sliderContainer, {
        slidesPerView: 1,
        centeredSlides: false,
        loop: false,
        grabCursor: true,
        watchSlidesProgress: true,
        spaceBetween: 0,
        speed: 500,
        allowTouchMove: true,
        on: {
            init: function(swiper) {
                // Скрываем стандартные трансформации wrapper через CSS
                swiper.wrapperEl.style.transform = 'none !important';
                applySlideStyles(swiper);
            },
            slideChange: function(swiper) {
                applySlideStyles(swiper);
            },
            setTransition: function(swiper, duration) {
                // Применяем transition к слайдам
                swiper.slides.forEach((slideEl) => {
                    const slide = slideEl.querySelector('.slide');
                    if (slide) {
                        slide.style.transition = `${duration}ms`;
                    }
                });
            },
            setTranslate: function(swiper, translate) {
                // Обновляем стили во время перетаскивания на основе прогресса слайдов
                applySlideStyles(swiper);
            },
            touchStart: function(swiper) {
                // Отключаем transition во время перетаскивания для плавности
                swiper.slides.forEach((slideEl) => {
                    const slide = slideEl.querySelector('.slide');
                    if (slide) {
                        slide.style.transition = 'none';
                    }
                });
            },
            touchEnd: function(swiper) {
                // Восстанавливаем transition после перетаскивания
                swiper.slides.forEach((slideEl) => {
                    const slide = slideEl.querySelector('.slide');
                    if (slide) {
                        slide.style.transition = '500ms';
                    }
                });
            }
        }
    });
    
    // Скрываем стандартные трансформации Swiper через переопределение стилей
    const style = document.createElement('style');
    style.textContent = `
        .services__slider .swiper-wrapper {
            transform: none !important;
        }
        .services__slider .swiper-slide {
            width: auto !important;
            height: auto !important;
        }
    `;
    document.head.appendChild(style);

        // Добавляем обработчики клика на слайды
    servicesSwiper.slides.forEach((slideEl, index) => {
        const slide = slideEl.querySelector('.slide');
        if (slide) {
            slide.addEventListener('click', (e) => {
                // Проверяем, что это не активный слайд
                if (index !== servicesSwiper.activeIndex) {
                    servicesSwiper.slideTo(index);
                }
            });
        }
        });

        // Обновление при изменении размера окна
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
            applySlideStyles(servicesSwiper);
            servicesSwiper.update();
            }, 100);
        });

    // Устанавливаем курсор grab
        sliderContainer.style.cursor = 'grab';

    console.log('Services slider initialized successfully with Swiper');
}