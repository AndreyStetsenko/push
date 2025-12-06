// Компонент для позиционирования light элементов в секции whyus
export function initWhyusLight() {
    const whyusSection = document.getElementById('whyus');
    if (!whyusSection) return;

    const items = whyusSection.querySelectorAll('.whyus__item.item-3');
    if (items.length === 0) return;

    const lightElements = [];

    // Создаем light элементы для каждого item-3
    items.forEach((item, index) => {
        const lightContainer = document.createElement('div');
        lightContainer.className = 'whyus-light';
        lightContainer.setAttribute('data-item-index', index);

        // Клонируем структуру light из оригинального элемента
        const originalLight = item.querySelector('.light');
        if (originalLight) {
            lightContainer.innerHTML = originalLight.innerHTML;
            whyusSection.appendChild(lightContainer);
            lightElements.push({
                item,
                light: lightContainer,
                originalLight
            });
        }
    });

    // Функция для обновления позиций
    const updatePositions = () => {
        // Проверяем, мобильное ли устройство
        const isMobile = window.innerWidth <= 768;
        const scale = isMobile ? 0.2 : 1;

        lightElements.forEach(({ item, light }) => {
            // Вычисляем позицию относительно #whyus
            // Используем простой способ: получаем позицию элемента и вычитаем позицию родителя
            let itemTop = item.offsetTop;
            let itemLeft = item.offsetLeft;
            let parent = item.offsetParent;

            // Суммируем все offsetTop до #whyus
            while (parent && parent !== whyusSection) {
                itemTop += parent.offsetTop;
                itemLeft += parent.offsetLeft;
                parent = parent.offsetParent;
            }

            // Устанавливаем позицию с учетом масштаба
            const width = item.offsetWidth * scale;
            const height = item.offsetHeight * scale;
            
            light.style.top = `${itemTop}px`;
            light.style.left = `${itemLeft}px`;
            light.style.width = `${width}px`;
            light.style.height = `${height}px`;

            // Позиционируем элементы light-1
            const light1 = light.querySelector('.light-1');
            if (light1) {
                const l1 = light1.querySelector('.l1');
                const l2 = light1.querySelector('.l2');
                const l3 = light1.querySelector('.l3');

                if (l1) {
                    l1.style.top = '0';
                    l1.style.right = '-150px';
                }
                if (l2) {
                    l2.style.top = '-100px';
                    l2.style.right = '-250px';
                }
                if (l3) {
                    l3.style.top = '-200px';
                    l3.style.right = '-300px';
                }
            }

            // Позиционируем элементы light-2
            const light2 = light.querySelector('.light-2');
            if (light2) {
                const l1 = light2.querySelector('.l1');
                const l2 = light2.querySelector('.l2');
                const l3 = light2.querySelector('.l3');
                const l4 = light2.querySelector('.l4');

                if (l1) {
                    l1.style.top = '0';
                    l1.style.right = '-150px';
                }
                if (l2) {
                    l2.style.top = '-100px';
                    l2.style.right = '-250px';
                }
                if (l3) {
                    l3.style.top = '-200px';
                    l3.style.right = '-300px';
                }
                if (l4) {
                    l4.style.top = '-200px';
                    l4.style.right = '-300px';
                }
            }
        });
    };

    // Обновляем позиции при загрузке (с небольшой задержкой для корректного расчета)
    setTimeout(updatePositions, 0);

    // Обновляем при изменении размера окна
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(updatePositions, 100);
    });

    // Используем ResizeObserver для отслеживания изменений размеров элементов
    const resizeObserver = new ResizeObserver(() => {
        updatePositions();
    });

    items.forEach(item => {
        resizeObserver.observe(item);
    });

    resizeObserver.observe(whyusSection);
}

