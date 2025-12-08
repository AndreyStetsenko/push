// Компонент выпадающего списка языков
class LangSelector {
    constructor(container) {
        this.container = container;
        this.toggle = container.querySelector('.header__lang-toggle');
        this.current = container.querySelector('.header__lang-current');
        this.list = container.querySelector('.header__lang-list');
        this.options = container.querySelectorAll('.header__lang-option');
        
        this.init();
    }

    init() {
        if (!this.toggle || !this.list) {
            return;
        }

        // Обработчик клика на кнопку переключения
        this.toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            this.toggleDropdown();
        });

        // Обработчики выбора языка (для ссылок и кнопок)
        this.options.forEach(option => {
            // Если это не disabled кнопка, обрабатываем клик
            if (!option.hasAttribute('disabled')) {
                option.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Если это кнопка с data-lang-url, переходим по URL
                    const langUrl = option.getAttribute('data-lang-url');
                    if (langUrl && option.tagName === 'BUTTON') {
                        e.preventDefault();
                        // Закрываем список перед переходом
                        this.close();
                        // Небольшая задержка для визуального закрытия
                        setTimeout(() => {
                            window.location.href = langUrl;
                        }, 100);
                    } else {
                        // Закрываем список перед переходом
                        this.close();
                    }
                });
            }
        });

        // Закрытие при клике вне компонента
        // Используем setTimeout чтобы обработчик сработал после обработчика toggle
        document.addEventListener('click', (e) => {
            // Проверяем, что клик был не на элементах компонента
            if (!this.container.contains(e.target)) {
                // Небольшая задержка, чтобы обработчик toggle успел сработать
                setTimeout(() => {
                    if (this.isOpen()) {
                        this.close();
                    }
                }, 0);
            }
        });

        // Закрытие при нажатии Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen()) {
                this.close();
                this.toggle.focus();
            }
        });
    }

    toggleDropdown() {
        if (this.isOpen()) {
            this.close();
        } else {
            this.open();
        }
    }

    open() {
        this.container.classList.add('is-open');
        this.toggle.setAttribute('aria-expanded', 'true');
    }

    close() {
        this.container.classList.remove('is-open');
        this.toggle.setAttribute('aria-expanded', 'false');
    }

    isOpen() {
        return this.container.classList.contains('is-open');
    }
}

// Инициализация компонента
export function initLangSelector() {
    const langContainer = document.querySelector('.header__lang');
    if (langContainer) {
        new LangSelector(langContainer);
    }
}

export default LangSelector;

