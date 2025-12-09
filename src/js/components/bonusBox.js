// Компонент бонус-бокса
export function initBonusBox() {
    const bonusItem = document.querySelector('.bonus__item');
    const bonusClose = document.querySelector('.bonus__item-close');
    const bonusOpen = document.querySelector('.bonus__item-open');
    const bonusTitle = document.querySelector('.bonus__item-content-title');

    if (!bonusItem || !bonusClose || !bonusOpen) return;

    let isOpened = false;

    // Функция для динамического изменения размера текста
    function adjustTextSize() {
        if (!bonusTitle) return;

        const container = bonusTitle.parentElement; // .bonus__item-content
        if (!container) return;

        // Получаем максимальную ширину контейнера
        const containerWidth = container.offsetWidth;
        const padding = 20; // Отступы для безопасности
        const maxWidth = containerWidth - padding;

        // Минимальный и максимальный размер шрифта
        const minFontSize = 60; // px
        const maxFontSize = 120; // px

        // Временно устанавливаем максимальный размер для измерения
        bonusTitle.style.fontSize = maxFontSize + 'px';
        bonusTitle.style.whiteSpace = 'nowrap';

        // Бинарный поиск оптимального размера
        let low = minFontSize;
        let high = maxFontSize;
        let optimalSize = minFontSize;

        while (low <= high) {
            const mid = Math.floor((low + high) / 2);
            bonusTitle.style.fontSize = mid + 'px';

            // Проверяем, помещается ли текст
            if (bonusTitle.scrollWidth <= maxWidth) {
                optimalSize = mid;
                low = mid + 1;
            } else {
                high = mid - 1;
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
                    adjustTextSize();
                });
                resizeObserver.observe(container);
            }

            // Fallback для старых браузеров
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(adjustTextSize, 100);
            });
        }
        // Первоначальная настройка
        setTimeout(adjustTextSize, 100);
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
        setTimeout(adjustTextSize, 100);
    });
}

