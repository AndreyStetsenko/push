export function initCasesModal() {
    const modal = document.getElementById('casesModal');
    const closeButton = modal?.querySelector('.cases-modal__close');
    const overlay = modal?.querySelector('.cases-modal__overlay');
    const buttons = document.querySelectorAll('.cases__card-button');
    const modalBody = modal?.querySelector('.cases-modal__body');
    const modalHeader = modal?.querySelector('.cases-modal__header');

    if (!modal) return;

    const openModal = () => {
        document.body.style.overflow = 'hidden';
        modal.classList.add('is-open');
    };

    const closeModal = () => {
        document.body.style.overflow = '';
        modal.classList.remove('is-open');
    };

    const loadModalContent = (cardIndex) => {
        // Показываем индикатор загрузки
        if (modalBody) {
            modalBody.innerHTML = '<div class="cases-modal__loading" style="text-align: center; padding: 40px;">Завантаження...</div>';
        }

        // Отправляем AJAX запрос
        if (typeof pushAjax === 'undefined') {
            console.error('pushAjax не определен');
            return;
        }

        fetch(pushAjax.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'push_get_case_modal',
                nonce: pushAjax.caseModalNonce,
                card_index: cardIndex
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data && data.data.html) {
                // Заменяем контент модального окна
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.data.html;
                
                // Обновляем заголовок
                const newHeader = tempDiv.querySelector('.cases-modal__header');
                if (newHeader && modalHeader) {
                    modalHeader.innerHTML = newHeader.innerHTML;
                } else if (newHeader && !modalHeader) {
                    // Если заголовка нет, создаем его
                    const headerContainer = modal.querySelector('.cases-modal__content');
                    if (headerContainer) {
                        headerContainer.insertBefore(newHeader, headerContainer.firstChild);
                    }
                }
                
                // Обновляем тело
                const newBody = tempDiv.querySelector('.cases-modal__body');
                if (newBody && modalBody) {
                    modalBody.innerHTML = newBody.innerHTML;
                }
                
                openModal();
            } else {
                console.error('Ошибка загрузки контента:', data.data?.message || 'Неизвестная ошибка');
                if (modalBody) {
                    modalBody.innerHTML = '<div class="cases-modal__error" style="text-align: center; padding: 40px; color: red;">Помилка завантаження контенту</div>';
                }
            }
        })
        .catch(error => {
            console.error('Ошибка AJAX запроса:', error);
            if (modalBody) {
                modalBody.innerHTML = '<div class="cases-modal__error" style="text-align: center; padding: 40px; color: red;">Помилка завантаження контенту</div>';
            }
        });
    };

    // Обработчики для кнопок "Детальніше"
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            const cardIndex = button.getAttribute('data-card-index');
            if (cardIndex !== null) {
                loadModalContent(parseInt(cardIndex));
            } else {
                // Если индекс не указан, просто открываем модальное окно
                openModal();
            }
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

