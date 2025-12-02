// Компонент мобильного меню
export function initMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const burger = document.querySelector('.header__burger');
    const closeBtn = document.querySelector('.mobile-menu__close');
    const overlay = document.querySelector('.mobile-menu__overlay');
    const menuItems = document.querySelectorAll('.mobile-menu__item');

    if (!menu || !burger) return;

    // Открытие меню
    burger.addEventListener('click', () => {
        menu.classList.add('mobile-menu--open');
        document.body.style.overflow = 'hidden';
    });

    // Закрытие меню
    const closeMenu = () => {
        menu.classList.remove('mobile-menu--open');
        document.body.style.overflow = '';
    };

    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);

    // Закрытие при клике на пункт меню
    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            setTimeout(closeMenu, 100);
        });
    });

    // Закрытие при нажатии ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menu.classList.contains('mobile-menu--open')) {
            closeMenu();
        }
    });
}

