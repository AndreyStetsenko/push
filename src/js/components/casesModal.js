export function initCasesModal() {
    const modal = document.getElementById('casesModal');
    const closeButton = modal?.querySelector('.cases-modal__close');
    const overlay = modal?.querySelector('.cases-modal__overlay');
    const buttons = document.querySelectorAll('.cases__card-button');

    if (!modal) return;

    const openModal = () => {
        document.body.style.overflow = 'hidden';
        modal.classList.add('is-open');
    };

    const closeModal = () => {
        document.body.style.overflow = '';
        modal.classList.remove('is-open');
    };

    // Обработчики для кнопок "Детальніше"
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            openModal();
        });
    });

    // Закрытие по клику на overlay
    if (overlay) {
        overlay.addEventListener('click', closeModal);
    }

    // Закрытие по клику на кнопку закрытия
    if (closeButton) {
        closeButton.addEventListener('click', closeModal);
    }

    // Закрытие по Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) {
            closeModal();
        }
    });
}

