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

        // Обработчики выбора языка (для ссылок)
        this.options.forEach(option => {
            // Если это ссылка (не disabled кнопка), закрываем список при клике
            if (option.tagName === 'A' && !option.hasAttribute('disabled')) {
                option.addEventListener('click', () => {
                    // Закрываем список перед переходом
                    this.close();
                });
            }
        });

        // Закрытие при клике вне компонента
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target)) {
                this.close();
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

// Автоматическая инициализация при загрузке DOM (для обратной совместимости)
document.addEventListener('DOMContentLoaded', () => {
    initLangSelector();
});

export default LangSelector;

