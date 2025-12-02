export function initCasesSlider() {
    const sliderContainer = document.querySelector('.cases__slider-container');
    const cards = document.querySelectorAll('.cases__card');
    const filterButtons = document.querySelectorAll('.cases__filter-btn');
    const indicatorProgress = document.querySelector('.cases__slider-indicator-progress');
    const indicator = document.querySelector('.cases__slider-indicator');

    if (!sliderContainer || cards.length === 0) {
        return;
    }

    let currentIndex = 0;
    const gap = 20;
    let isDragging = false;
    let isIndicatorDragging = false;
    let startX = 0;
    let currentX = 0;
    let initialTranslateX = 0;

    const getCardWidth = (index) => {
        return cards[index]?.offsetWidth || 500;
    };

    const getTranslateX = () => {
        let translateX = 0;
        for (let i = 0; i < currentIndex; i++) {
            translateX -= getCardWidth(i) + gap;
        }
        return translateX;
    };

    const goToSlide = (index) => {
        if (index >= 0 && index < cards.length) {
            currentIndex = index;
            updateSlider();
        }
    };

    const updateSlider = (offsetX = 0) => {
        const baseTranslateX = getTranslateX();
        const translateX = baseTranslateX + offsetX;
        sliderContainer.style.transform = `translateX(${translateX}px)`;
        sliderContainer.style.transition = isDragging ? 'none' : 'transform 0.3s ease';

        // Обновляем активное состояние карточек
        cards.forEach((card, index) => {
            if (index === currentIndex) {
                card.classList.add('active');
            } else {
                card.classList.remove('active');
            }
        });

        // Обновляем активное состояние кнопок фильтров
        filterButtons.forEach((btn, index) => {
            const slideIndex = parseInt(btn.getAttribute('data-slide-index'), 10);
            if (slideIndex === currentIndex) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        // Обновляем индикатор-ползунок
        if (indicatorProgress && indicator && !isIndicatorDragging) {
            const indicatorWidth = indicator.offsetWidth;
            const progressWidth = indicatorWidth * 0.2; // 20% от ширины индикатора
            const maxPosition = indicatorWidth - progressWidth;
            const position = cards.length > 1 ? (currentIndex / (cards.length - 1)) * maxPosition : 0;
            indicatorProgress.style.left = `${position}px`;
        }
    };

    // Обработчики для кнопок фильтров
    filterButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const slideIndex = parseInt(btn.getAttribute('data-slide-index'), 10);
            goToSlide(slideIndex);
        });
    });

    // Обработчики для перетаскивания мышью
    const handleMouseDown = (e) => {
        // Не обрабатываем, если клик был на индикаторе
        if (indicator && indicator.contains(e.target)) {
            return;
        }
        
        isDragging = true;
        startX = e.clientX;
        initialTranslateX = getTranslateX();
        sliderContainer.style.cursor = 'grabbing';
        e.preventDefault();
    };

    const handleMouseMove = (e) => {
        if (!isDragging) return;
        
        currentX = e.clientX;
        const offsetX = currentX - startX;
        updateSlider(offsetX);
    };

    const handleMouseUp = () => {
        if (!isDragging) return;
        
        isDragging = false;
        sliderContainer.style.cursor = 'grab';
        
        const offsetX = currentX - startX;
        const cardWidth = getCardWidth(currentIndex);
        const threshold = cardWidth * 0.3; // 30% от ширины карточки
        
        if (Math.abs(offsetX) > threshold) {
            if (offsetX > 0 && currentIndex > 0) {
                // Свайп вправо - предыдущий слайд
                goToSlide(currentIndex - 1);
            } else if (offsetX < 0 && currentIndex < cards.length - 1) {
                // Свайп влево - следующий слайд
                goToSlide(currentIndex + 1);
            } else {
                updateSlider();
            }
        } else {
            // Возврат к текущему слайду
            updateSlider();
        }
        
        startX = 0;
        currentX = 0;
    };

    // Обработчики для индикатора-ползунка
    let indicatorClickStartX = 0;
    let indicatorClickStartY = 0;
    let indicatorWasDragged = false;

    const handleIndicatorClick = (e) => {
        if (!indicator || !indicatorProgress) return;
        
        // Если был перетаскивание, не обрабатываем клик
        if (indicatorWasDragged) {
            indicatorWasDragged = false;
            return;
        }
        
        // Если клик был на самом ползунке, не обрабатываем
        if (e.target === indicatorProgress) {
            return;
        }
        
        const indicatorRect = indicator.getBoundingClientRect();
        const clickX = e.clientX - indicatorRect.left;
        const indicatorWidth = indicator.offsetWidth;
        const progressWidth = indicatorWidth * 0.2;
        const maxPosition = indicatorWidth - progressWidth;
        
        // Вычисляем индекс слайда на основе позиции клика
        const position = Math.max(0, Math.min(clickX - progressWidth / 2, maxPosition));
        const newIndex = Math.round((position / maxPosition) * (cards.length - 1));
        
        goToSlide(newIndex);
    };

    const handleIndicatorMouseDown = (e) => {
        if (!indicator || !indicatorProgress) return;
        
        isIndicatorDragging = true;
        indicatorWasDragged = false;
        indicatorClickStartX = e.clientX;
        indicatorClickStartY = e.clientY;
        startX = e.clientX;
        e.preventDefault();
        e.stopPropagation();
    };

    const handleIndicatorMouseMove = (e) => {
        if (!isIndicatorDragging || !indicator || !indicatorProgress) return;
        
        // Проверяем, было ли движение (перетаскивание)
        const deltaX = Math.abs(e.clientX - indicatorClickStartX);
        const deltaY = Math.abs(e.clientY - indicatorClickStartY);
        if (deltaX > 3 || deltaY > 3) {
            indicatorWasDragged = true;
        }
        
        const indicatorRect = indicator.getBoundingClientRect();
        const moveX = e.clientX - indicatorRect.left;
        const indicatorWidth = indicator.offsetWidth;
        const progressWidth = indicatorWidth * 0.2;
        const maxPosition = indicatorWidth - progressWidth;
        
        // Ограничиваем позицию ползунка
        const position = Math.max(0, Math.min(moveX - progressWidth / 2, maxPosition));
        indicatorProgress.style.left = `${position}px`;
        indicatorProgress.style.transition = 'none';
        
        // Вычисляем индекс слайда
        const newIndex = Math.round((position / maxPosition) * (cards.length - 1));
        if (newIndex !== currentIndex && newIndex >= 0 && newIndex < cards.length) {
            currentIndex = newIndex;
            updateSlider();
        }
    };

    const handleIndicatorMouseUp = () => {
        if (!isIndicatorDragging) return;
        
        isIndicatorDragging = false;
        if (indicatorProgress) {
            indicatorProgress.style.transition = 'left 0.3s ease, width 0.3s ease';
        }
        updateSlider();
    };

    // Добавляем обработчики событий для слайдера
    sliderContainer.style.cursor = 'grab';
    sliderContainer.style.userSelect = 'none';
    
    sliderContainer.addEventListener('mousedown', handleMouseDown);
    document.addEventListener('mousemove', handleMouseMove);
    document.addEventListener('mouseup', handleMouseUp);

    // Добавляем обработчики событий для индикатора
    if (indicator) {
        indicator.addEventListener('click', handleIndicatorClick);
        if (indicatorProgress) {
            indicatorProgress.addEventListener('mousedown', handleIndicatorMouseDown);
        }
        document.addEventListener('mousemove', handleIndicatorMouseMove);
        document.addEventListener('mouseup', handleIndicatorMouseUp);
    }

    // Инициализация
    updateSlider();

    // Обработка изменения размера окна
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            updateSlider();
        }, 250);
    });
}

