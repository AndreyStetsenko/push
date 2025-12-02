// Компонент бонус-бокса
export function initBonusBox() {
    const bonusItem = document.querySelector('.bonus__item');
    const bonusClose = document.querySelector('.bonus__item-close');
    const bonusOpen = document.querySelector('.bonus__item-open');

    if (!bonusItem || !bonusClose || !bonusOpen) return;

    let isOpened = false;

    // Обработчик клика
    bonusItem.addEventListener('click', () => {
        if (isOpened) return;

        isOpened = true;
        bonusItem.classList.add('is-opened');
        
        // Добавляем эффект дымки
        const smoke = document.createElement('div');
        smoke.className = 'bonus__smoke';
        bonusItem.appendChild(smoke);
    });
}

