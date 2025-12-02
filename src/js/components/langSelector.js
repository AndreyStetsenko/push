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
        // Обработчик клика на кнопку переключения
        this.toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleDropdown();
        });

        // Обработчики выбора языка
        this.options.forEach(option => {
            option.addEventListener('click', (e) => {
                e.stopPropagation();
                this.selectLanguage(option);
            });
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

    selectLanguage(option) {
        const lang = option.getAttribute('data-lang');
        const text = option.textContent.trim();
        
        // Обновляем текущий язык
        this.current.textContent = text;
        
        // Закрываем список
        this.close();
        
        // Здесь можно добавить логику смены языка
        // Например, обновление URL или перезагрузка страницы с новым языком
        console.log('Selected language:', lang);
        
        // Можно добавить сохранение в localStorage
        // localStorage.setItem('language', lang);
    }
}

// Инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
    const langContainer = document.querySelector('.header__lang');
    if (langContainer) {
        new LangSelector(langContainer);
    }
});

export default LangSelector;

