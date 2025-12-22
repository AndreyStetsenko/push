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
                // Вызываем сразу, но также с задержкой для гарантированной отрисовки DOM
                adjustTextSizes();
                setTimeout(() => adjustTextSizes(), 100);
            },
            slideChange: function() {
                updateSlideClasses(this);
                // Дополнительная задержка для гарантированной отрисовки DOM
                setTimeout(() => adjustTextSizes(), 100);
            },
            resize: function() {
                updateSlideClasses(this);
                setTimeout(() => adjustTextSizes(), 100);
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
        
        // Принудительно вызываем reflow для применения CSS классов и transform
        void document.body.offsetHeight;
        
        // Обрабатываем все слайды после применения стилей
        requestAnimationFrame(() => {
            adjustTextSizes();
        });
    }

    /**
     * Динамически уменьшает размер текста, чтобы слова помещались в блок без переноса
     */
    function adjustTextSizes() {
        const slides = document.querySelectorAll('#services .services__slider .swiper-slide');
        
        slides.forEach(slide => {
            const title = slide.querySelector('.item-body .title');
            const description = slide.querySelector('.item-body .description');
            
            // Проверяем, что слайд существует и видим
            if (!slide) return;
            
            if (title) {
                fitTextToContainer(title, slide);
            }
            
            if (description) {
                fitTextToContainer(description, slide);
            }
        });
    }

    /**
     * Подгоняет размер текста элемента под ширину контейнера
     * Уменьшает размер шрифта до тех пор, пока все слова помещаются в блок без разрыва
     * @param {HTMLElement} element - Элемент с текстом
     * @param {HTMLElement} slide - Родительский слайд для контекста
     */
    function fitTextToContainer(element, slide) {
        // Временно удаляем inline стиль font-size, чтобы получить исходный размер из CSS
        const savedFontSize = element.style.fontSize;
        element.style.fontSize = '';
        
        const computedStyle = window.getComputedStyle(element);
        
        // Получаем исходный размер шрифта (из CSS переменных или computed style)
        let originalSize = parseFloat(computedStyle.fontSize);
        if (isNaN(originalSize) || originalSize <= 0) {
            originalSize = 16; // fallback
        }
        
        // Если был сохраненный inline стиль, используем его как исходный
        if (savedFontSize) {
            const savedSize = parseFloat(savedFontSize);
            if (!isNaN(savedSize) && savedSize > 0) {
                originalSize = savedSize;
            }
        }
        
        // Получаем контейнер (item-body) и родительский item
        const container = element.closest('.item-body');
        const item = slide.querySelector('.item');
        
        if (!container) {
            // Восстанавливаем сохраненный стиль
            if (savedFontSize) {
                element.style.fontSize = savedFontSize;
            }
            return;
        }
        
        // Определяем, имеет ли слайд transform scale (для prev/next слайдов)
        // Нужно проверить ДО получения размеров, чтобы правильно рассчитать доступную ширину
        let scaleFactor = 1;
        if (item) {
            const itemStyle = window.getComputedStyle(item);
            const transform = itemStyle.transform;
            if (transform && transform !== 'none') {
                // Извлекаем значение scale из transform матрицы
                // transform: scale(0.75) создает матрицу вида matrix(0.75, 0, 0, 0.75, ...)
                const matrixMatch = transform.match(/matrix\(([^)]+)\)/);
                if (matrixMatch) {
                    const values = matrixMatch[1].split(',').map(v => parseFloat(v.trim()));
                    if (values.length >= 4) {
                        // Первое значение матрицы - это scaleX
                        scaleFactor = Math.abs(values[0]);
                    }
                } else {
                    // Пробуем найти scale() напрямую
                    const scaleMatch = transform.match(/scale\(([^)]+)\)/);
                    if (scaleMatch) {
                        scaleFactor = parseFloat(scaleMatch[1]);
                    }
                }
            }
        }
        
        // Получаем РЕАЛЬНУЮ визуальную ширину контейнера через getBoundingClientRect
        // Это даст ширину УЖЕ с учетом transform scale
        const containerRect = container.getBoundingClientRect();
        let containerWidth = containerRect.width;
        
        // Если ширина равна 0 (элемент скрыт), пробуем получить базовую ширину
        if (containerWidth === 0 || isNaN(containerWidth)) {
            containerWidth = container.offsetWidth;
            
            // Если и это не помогло, пробуем через родительский item
            if ((containerWidth === 0 || isNaN(containerWidth)) && item) {
                const itemWidth = item.offsetWidth;
                if (itemWidth > 0) {
                    // Вычитаем padding item, если есть, чтобы получить ширину контента
                    const itemStyle = window.getComputedStyle(item);
                    const itemPadding = parseFloat(itemStyle.paddingLeft || '0') + 
                                      parseFloat(itemStyle.paddingRight || '0');
                    containerWidth = itemWidth - itemPadding;
                }
            }
        }
        
        // Проверяем, что контейнер видим и имеет валидную ширину
        if (containerWidth === 0 || isNaN(containerWidth) || containerWidth < 50) {
            // Восстанавливаем сохраненный стиль
            if (savedFontSize) {
                element.style.fontSize = savedFontSize;
            }
            return;
        }
        
        // Поскольку getBoundingClientRect() уже дает ширину с учетом scale,
        // мы используем эту ширину напрямую, НО нужно учесть, что текст тоже масштабируется
        // Если scale = 0.75, то визуальная ширина контейнера уменьшена,
        // но текст внутри тоже уменьшен на 0.75, поэтому расчет должен быть:
        // доступная ширина = визуальная ширина контейнера (уже с scale)
        const padding = parseFloat(computedStyle.paddingLeft || '0') + 
                       parseFloat(computedStyle.paddingRight || '0');
        const availableWidth = containerWidth - padding - 2; // Небольшой запас
        
        // Устанавливаем нормальные стили переноса
        element.style.whiteSpace = 'normal';
        element.style.wordBreak = 'normal';
        element.style.overflowWrap = 'normal';
        element.style.hyphens = 'none';
        
        // Создаем временный элемент для измерения ширины слов
        const measurer = document.createElement('span');
        measurer.style.position = 'absolute';
        measurer.style.visibility = 'hidden';
        measurer.style.whiteSpace = 'nowrap';
        measurer.style.fontFamily = computedStyle.fontFamily;
        measurer.style.fontWeight = computedStyle.fontWeight;
        measurer.style.letterSpacing = computedStyle.letterSpacing;
        measurer.style.textTransform = computedStyle.textTransform;
        document.body.appendChild(measurer);
        
        // Получаем все слова из текста
        const text = element.textContent.trim();
        const words = text.split(/\s+/).filter(word => word.length > 0);
        
        if (words.length === 0) {
            document.body.removeChild(measurer);
            // Восстанавливаем сохраненный стиль
            if (savedFontSize) {
                element.style.fontSize = savedFontSize;
            }
            return;
        }
        
        // Функция для проверки, помещается ли самое длинное слово при заданном размере
        // Учитываем, что если контейнер имеет scale, то текст тоже масштабируется
        const checkFits = (fontSize) => {
            measurer.style.fontSize = fontSize + 'px';
            let longestWordWidth = 0;
            for (const word of words) {
                measurer.textContent = word;
                const wordWidth = measurer.offsetWidth;
                // Если контейнер масштабирован, текст тоже масштабируется
                // Поэтому визуальная ширина слова = измеренная_ширина * scaleFactor
                const visualWordWidth = wordWidth * scaleFactor;
                if (visualWordWidth > longestWordWidth) {
                    longestWordWidth = visualWordWidth;
                }
            }
            return longestWordWidth <= availableWidth;
        };
        
        // Всегда находим оптимальный размер, начиная с исходного и уменьшая при необходимости
        // Это гарантирует, что сразу будет установлен правильный размер без "мигания"
        let currentSize = originalSize;
        let minSize = 10; // Минимальный размер шрифта
        let optimalSize = minSize;
        const step = 0.5; // Шаг уменьшения
        
        // Начинаем с исходного размера и уменьшаем до тех пор, пока текст не поместится
        while (currentSize >= minSize) {
            if (checkFits(currentSize)) {
                optimalSize = currentSize;
                break;
            }
            currentSize -= step;
        }
        
        // Устанавливаем оптимальный размер (даже если он равен исходному)
        element.style.fontSize = optimalSize + 'px';
        
        // Удаляем временный элемент
        document.body.removeChild(measurer);
    }

    // Вызываем при изменении размера окна
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            adjustTextSizes();
        }, 200);
    });
}