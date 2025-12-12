// Компонент бонус-бокса
export function initBonusBox() {
    const bonusItem = document.querySelector('.bonus__item');
    const bonusClose = document.querySelector('.bonus__item-close');
    const bonusOpen = document.querySelector('.bonus__item-open');
    const bonusTitle = document.querySelector('.bonus__item-content-title');

    if (!bonusItem || !bonusClose || !bonusOpen) return;

    let isOpened = false;

    // Функция для определения мобильного устройства
    function isMobile() {
        return window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    // Функция для динамического изменения размера текста
    function adjustTextSize() {
        if (!bonusTitle) return;

        const container = bonusTitle.parentElement; // .bonus__item-content
        if (!container) return;

        const mobile = isMobile();
        
        // Получаем максимальную ширину контейнера
        const containerWidth = container.offsetWidth;
        const padding = mobile ? 30 : 20; // Больше отступы на мобильных для безопасности
        const maxWidth = containerWidth - padding;

        // Минимальный и максимальный размер шрифта в зависимости от устройства
        const minFontSize = mobile ? 24 : 60; // px
        const maxFontSize = mobile ? 50 : 120; // px

        // На мобильных разрешаем перенос текста, на десктопе - нет
        bonusTitle.style.whiteSpace = mobile ? 'normal' : 'nowrap';

        // Временно устанавливаем максимальный размер для измерения
        bonusTitle.style.fontSize = maxFontSize + 'px';

        // Бинарный поиск оптимального размера
        let low = minFontSize;
        let high = maxFontSize;
        let optimalSize = minFontSize;

        while (low <= high) {
            const mid = Math.floor((low + high) / 2);
            bonusTitle.style.fontSize = mid + 'px';

            // Проверяем, помещается ли текст
            // На мобильных проверяем высоту, чтобы текст не выходил за границы
            if (mobile) {
                const textHeight = bonusTitle.offsetHeight;
                const containerHeight = container.offsetHeight || window.innerHeight * 0.3;
                const textWidth = bonusTitle.scrollWidth;
                
                if (textWidth <= maxWidth && textHeight <= containerHeight) {
                    optimalSize = mid;
                    low = mid + 1;
                } else {
                    high = mid - 1;
                }
            } else {
                if (bonusTitle.scrollWidth <= maxWidth) {
                    optimalSize = mid;
                    low = mid + 1;
                } else {
                    high = mid - 1;
                }
            }
        }

        // Устанавливаем оптимальный размер
        bonusTitle.style.fontSize = optimalSize + 'px';
    }

    // Вызываем при загрузке и изменении размера окна
    if (bonusTitle) {
        const container = bonusTitle.parentElement;
        if (container) {
            // Используем ResizeObserver для отслеживания изменений размера контейнера
            if (typeof ResizeObserver !== 'undefined') {
                const resizeObserver = new ResizeObserver(() => {
                    // Небольшая задержка для стабилизации размеров
                    setTimeout(adjustTextSize, 50);
                });
                resizeObserver.observe(container);
            }

            // Обработка изменения размера окна с debounce
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(adjustTextSize, 150);
            });

            // Обработка изменения ориентации на мобильных
            window.addEventListener('orientationchange', () => {
                setTimeout(adjustTextSize, 300);
            });
        }
        // Первоначальная настройка с задержкой для загрузки шрифтов
        setTimeout(adjustTextSize, 200);
    }

    // Обработчик клика
    bonusItem.addEventListener('click', () => {
        if (isOpened) return;

        isOpened = true;
        bonusItem.classList.add('is-opened');
        
        // Добавляем эффект дымки
        const smoke = document.createElement('div');
        smoke.className = 'bonus__smoke';
        bonusItem.appendChild(smoke);

        // Пересчитываем размер текста после открытия (если контейнер изменился)
        // Увеличиваем задержку для мобильных, чтобы анимация успела завершиться
        const delay = isMobile() ? 300 : 150;
        setTimeout(adjustTextSize, delay);
    });
}

