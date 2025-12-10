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
    let isTouching = false;
    let isIndicatorDragging = false;
    let isIndicatorTouching = false;
    let startX = 0;
    let currentX = 0;
    let initialTranslateX = 0;

    const getCardWidth = (index) => {
        return cards[index]?.offsetWidth || 500;
    };

    const getTranslateX = () => {
        let translateX = 0;
        for (let i = 0; i < currentIndex; i++) {
            translateX -= getCardWidth(i);
        }
        translateX -= currentIndex * gap;
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
        sliderContainer.style.transition = (isDragging || isTouching) ? 'none' : 'transform 0.3s ease';

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
        if (indicatorProgress && indicator && !isIndicatorDragging && !isIndicatorTouching) {
            const indicatorWidth = indicator.offsetWidth;
            const progressWidth = indicatorWidth * 0.2;
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

    // ============ ОБРАБОТЧИКИ ДЛЯ МЫШИ ============
    const handleMouseDown = (e) => {
        if (indicator && indicator.contains(e.target)) {
            return;
        }
        
        isDragging = true;
        startX = e.clientX;
        currentX = e.clientX;
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
        const threshold = cardWidth * 0.3;
        
        if (Math.abs(offsetX) > threshold) {
            if (offsetX > 0 && currentIndex > 0) {
                goToSlide(currentIndex - 1);
            } else if (offsetX < 0 && currentIndex < cards.length - 1) {
                goToSlide(currentIndex + 1);
            } else {
                updateSlider();
            }
        } else {
            updateSlider();
        }
        
        startX = 0;
        currentX = 0;
    };

    // ============ ОБРАБОТЧИКИ ДЛЯ TOUCH ============
    const handleTouchStart = (e) => {
        if (indicator && indicator.contains(e.target)) {
            return;
        }
        
        isTouching = true;
        startX = e.touches[0].clientX;
        currentX = e.touches[0].clientX;
        initialTranslateX = getTranslateX();
    };

    const handleTouchMove = (e) => {
        if (!isTouching) return;
        
        currentX = e.touches[0].clientX;
        const offsetX = currentX - startX;
        
        // Предотвращаем скролл только при горизонтальном движении
        if (Math.abs(offsetX) > 10) {
            e.preventDefault();
        }
        
        updateSlider(offsetX);
    };

    const handleTouchEnd = () => {
        if (!isTouching) return;
        
        isTouching = false;
        
        const offsetX = currentX - startX;
        const cardWidth = getCardWidth(currentIndex);
        const threshold = cardWidth * 0.3;
        
        if (Math.abs(offsetX) > threshold) {
            if (offsetX > 0 && currentIndex > 0) {
                goToSlide(currentIndex - 1);
            } else if (offsetX < 0 && currentIndex < cards.length - 1) {
                goToSlide(currentIndex + 1);
            } else {
                updateSlider();
            }
        } else {
            updateSlider();
        }
        
        startX = 0;
        currentX = 0;
    };

    // ============ ОБРАБОТЧИКИ ДЛЯ ИНДИКАТОРА (МЫШЬ) ============
    let indicatorClickStartX = 0;
    let indicatorClickStartY = 0;
    let indicatorWasDragged = false;

    const handleIndicatorClick = (e) => {
        if (!indicator || !indicatorProgress) return;
        
        if (indicatorWasDragged) {
            indicatorWasDragged = false;
            return;
        }
        
        if (e.target === indicatorProgress) {
            return;
        }
        
        const indicatorRect = indicator.getBoundingClientRect();
        const clickX = e.clientX - indicatorRect.left;
        const indicatorWidth = indicator.offsetWidth;
        const progressWidth = indicatorWidth * 0.2;
        const maxPosition = indicatorWidth - progressWidth;
        
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
        
        const position = Math.max(0, Math.min(moveX - progressWidth / 2, maxPosition));
        indicatorProgress.style.left = `${position}px`;
        indicatorProgress.style.transition = 'none';
        
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

    // ============ ОБРАБОТЧИКИ ДЛЯ ИНДИКАТОРА (TOUCH) ============
    let indicatorTouchStartX = 0;
    let indicatorTouchStartY = 0;
    let indicatorTouchWasDragged = false;

    const handleIndicatorTouchStart = (e) => {
        if (!indicator || !indicatorProgress) return;
        
        isIndicatorTouching = true;
        indicatorTouchWasDragged = false;
        indicatorTouchStartX = e.touches[0].clientX;
        indicatorTouchStartY = e.touches[0].clientY;
        e.stopPropagation();
    };

    const handleIndicatorTouchMove = (e) => {
        if (!isIndicatorTouching || !indicator || !indicatorProgress) return;
        
        const deltaX = Math.abs(e.touches[0].clientX - indicatorTouchStartX);
        const deltaY = Math.abs(e.touches[0].clientY - indicatorTouchStartY);
        if (deltaX > 3 || deltaY > 3) {
            indicatorTouchWasDragged = true;
            e.preventDefault();
        }
        
        const indicatorRect = indicator.getBoundingClientRect();
        const moveX = e.touches[0].clientX - indicatorRect.left;
        const indicatorWidth = indicator.offsetWidth;
        const progressWidth = indicatorWidth * 0.2;
        const maxPosition = indicatorWidth - progressWidth;
        
        const position = Math.max(0, Math.min(moveX - progressWidth / 2, maxPosition));
        indicatorProgress.style.left = `${position}px`;
        indicatorProgress.style.transition = 'none';
        
        const newIndex = Math.round((position / maxPosition) * (cards.length - 1));
        if (newIndex !== currentIndex && newIndex >= 0 && newIndex < cards.length) {
            currentIndex = newIndex;
            updateSlider();
        }
    };

    const handleIndicatorTouchEnd = () => {
        if (!isIndicatorTouching) return;
        
        isIndicatorTouching = false;
        if (indicatorProgress) {
            indicatorProgress.style.transition = 'left 0.3s ease, width 0.3s ease';
        }
        updateSlider();
    };

    // ============ ДОБАВЛЕНИЕ ОБРАБОТЧИКОВ ============
    sliderContainer.style.cursor = 'grab';
    sliderContainer.style.userSelect = 'none';
    
    // Обработчики мыши для слайдера
    sliderContainer.addEventListener('mousedown', handleMouseDown);
    document.addEventListener('mousemove', handleMouseMove);
    document.addEventListener('mouseup', handleMouseUp);

    // Обработчики touch для слайдера
    sliderContainer.addEventListener('touchstart', handleTouchStart);
    sliderContainer.addEventListener('touchmove', handleTouchMove, { passive: false });
    sliderContainer.addEventListener('touchend', handleTouchEnd);
    sliderContainer.addEventListener('touchcancel', handleTouchEnd);

    // Обработчики для индикатора
    if (indicator) {
        indicator.addEventListener('click', handleIndicatorClick);
        
        if (indicatorProgress) {
            // Мышь
            indicatorProgress.addEventListener('mousedown', handleIndicatorMouseDown);
            document.addEventListener('mousemove', handleIndicatorMouseMove);
            document.addEventListener('mouseup', handleIndicatorMouseUp);
            
            // Touch
            indicatorProgress.addEventListener('touchstart', handleIndicatorTouchStart);
            indicatorProgress.addEventListener('touchmove', handleIndicatorTouchMove, { passive: false });
            indicatorProgress.addEventListener('touchend', handleIndicatorTouchEnd);
            indicatorProgress.addEventListener('touchcancel', handleIndicatorTouchEnd);
        }
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