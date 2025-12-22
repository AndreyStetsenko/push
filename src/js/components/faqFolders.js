import performanceDetector from '../utils/performanceDetector.js';

// Флаг для предотвращения множественных обновлений
let isUpdatingHeight = false;

// Получаем конфигурацию анимаций в зависимости от производительности устройства
const animationConfig = performanceDetector.getAnimationConfig();

// Функция для вычисления и установки высоты контейнера папок
function updateFoldersContainerHeight() {
    if (isUpdatingHeight) return;
    isUpdatingHeight = true;
    
    const foldersContainer = document.querySelector('.faq__folders');
    if (!foldersContainer) {
        isUpdatingHeight = false;
        return;
    }
    
    const folders = document.querySelectorAll('.folder');
    if (folders.length === 0) {
        isUpdatingHeight = false;
        return;
    }
    
    // Используем requestAnimationFrame для плавного обновления
    requestAnimationFrame(() => {
        let maxBottom = 0;
        
        folders.forEach(folder => {
            // Вычисляем позицию напрямую из стилей для лучшей производительности
            const topValue = parseFloat(folder.style.top || getComputedStyle(folder).top) || 0;
            const folderHeight = folder.offsetHeight;
            const bottom = topValue + folderHeight;
            
            if (bottom > maxBottom) {
                maxBottom = bottom;
            }
        });
        
        // Добавляем отступ снизу
        const paddingBottom = window.innerWidth <= 768 ? 50 : 0;
        const minHeight = maxBottom + paddingBottom;
        
        // Используем transform вместо margin для лучшей производительности
        foldersContainer.style.minHeight = `${minHeight}px`;
        foldersContainer.style.paddingBottom = `${paddingBottom}px`;
        
        isUpdatingHeight = false;
    });
}

// Функция для получения индекса папки из класса (например, folder--1 -> 1)
function getFolderIndex(folder) {
    const classes = Array.from(folder.classList);
    const folderClass = classes.find(cls => cls.startsWith('folder--'));
    if (folderClass) {
        const index = parseInt(folderClass.replace('folder--', ''));
        return isNaN(index) ? 0 : index;
    }
    return 0;
}

// Функция для сдвига папок вниз при открытии
function shiftFoldersDown(openFolder, folders) {
    // Добавляем класс для предотвращения hover эффектов во время анимации
    openFolder.classList.add('is-animating');
    
    // Ждем один кадр для применения CSS стилей после добавления класса is-open
    requestAnimationFrame(() => {
        // Получаем высоту открытой папки с учетом всего контента
        const openFolderHeight = openFolder.offsetHeight;
        
        // Получаем высоту закрытой папки из сохраненного значения или вычисляем
        const closedHeight = openFolder.dataset.closedHeight 
            ? parseFloat(openFolder.dataset.closedHeight) 
            : (() => {
                const isMobile = window.innerWidth <= 768;
                return isMobile ? 48 : 101; // Высота вкладки
            })();
        
        // Вычисляем дополнительную высоту, на которую увеличилась папка при открытии
        const additionalHeight = Math.max(0, openFolderHeight - closedHeight);
        
        // Получаем исходную позицию открытой папки
        const openFolderOriginalTop = openFolder.dataset.originalTop 
            ? parseFloat(openFolder.dataset.originalTop) 
            : 0;
        
        // Сохраняем информацию о том, какие папки нужно сдвинуть
        const foldersToShift = [];
        
        folders.forEach(folder => {
            // Пропускаем саму открытую папку
            if (folder === openFolder) {
                return;
            }
            
            // Используем исходную позицию из data-атрибута
            const originalTop = folder.dataset.originalTop 
                ? parseFloat(folder.dataset.originalTop) 
                : 0;
            
            // Сдвигаем все папки, которые визуально находятся ниже открытой папки
            if (originalTop > openFolderOriginalTop) {
                foldersToShift.push({
                    element: folder,
                    originalTop: originalTop,
                    newTop: originalTop + additionalHeight
                });
            }
        });
        
        // Применяем трансформации одновременно для всех папок
        foldersToShift.forEach(({ element, newTop }) => {
            // Используем CSS custom property для более плавной анимации
            element.style.setProperty('--shift-top', `${newTop}px`);
            element.style.top = `${newTop}px`;
        });
        
        // Убираем класс анимации после завершения (используем конфиг)
        setTimeout(() => {
            openFolder.classList.remove('is-animating');
        }, animationConfig.transitionDuration);
    });
}

// Функция для возврата папок в исходное положение
function resetFoldersPosition(folders) {
    folders.forEach(folder => {
        if (folder.dataset.originalTop) {
            folder.style.top = `${folder.dataset.originalTop}px`;
        } else {
            // Если originalTop не сохранен, получаем из computed style
            const computedStyle = getComputedStyle(folder);
            const currentTop = parseFloat(computedStyle.top) || 0;
            folder.style.top = `${currentTop}px`;
        }
    });
}

// Throttle функция для оптимизации событий
function throttle(func, delay) {
    let lastCall = 0;
    return function(...args) {
        const now = Date.now();
        if (now - lastCall >= delay) {
            lastCall = now;
            func(...args);
        }
    };
}

// Debounce функция для оптимизации событий
function debounce(func, delay) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), delay);
    };
}

// Компонент для разворачивания FAQ папок
export function initFaqFolders() {
    const folders = document.querySelectorAll('.folder');
    const foldersContainer = document.querySelector('.faq__folders');
    
    if (!foldersContainer) return;
    
    // Устанавливаем CSS переменную для времени анимации
    document.documentElement.style.setProperty('--faq-transition-duration', `${animationConfig.transitionDuration}ms`);
    
    // Добавляем класс для оптимизации производительности
    foldersContainer.classList.add('faq-folders-initialized');
    
    // Переменная для отслеживания текущей открытой папки
    let currentOpenFolder = null;
    
    // Функция инициализации позиций папок
    const initFolderPositions = () => {
        requestAnimationFrame(() => {
            folders.forEach(folder => {
                // Получаем top из computed style (CSS), игнорируя inline стили
                const computedStyle = getComputedStyle(folder);
                const currentTop = parseFloat(computedStyle.top) || 0;
                
                // Сохраняем исходную позицию
                folder.dataset.originalTop = currentTop.toString();
                
                // Сохраняем высоту закрытой папки (высота вкладки)
                const isMobile = window.innerWidth <= 768;
                const closedHeight = isMobile ? 48 : 101; // Высота вкладки
                folder.dataset.closedHeight = closedHeight.toString();
                
                // Добавляем CSS класс для оптимизации
                folder.classList.add('folder-initialized');
            });
            
            // Инициализация высоты после загрузки всех позиций
            updateFoldersContainerHeight();
        });
    };
    
    // Инициализируем позиции папок
    initFolderPositions();
    
    // Оптимизированный обработчик клика
    folders.forEach(folder => {
        const tab = folder.querySelector('.folder__tab');
        const content = folder.querySelector('.folder__content');
        
        if (!tab || !content) return;
        
        // Предотвращаем двойные клики
        let isProcessing = false;
        
        // Обработчик клика на tab
        const handleClick = (e) => {
            e.stopPropagation();
            
            // Игнорируем повторные клики во время анимации
            if (isProcessing) return;
            isProcessing = true;
            
            const isOpen = folder.classList.contains('is-open');
            
            // Закрываем все другие папки
            folders.forEach(otherFolder => {
                if (otherFolder !== folder && otherFolder.classList.contains('is-open')) {
                    otherFolder.classList.remove('is-open');
                }
            });
            
            // Возвращаем все папки в исходное положение перед переключением
            resetFoldersPosition(folders);
            
            // Переключаем текущую папку
            if (isOpen) {
                folder.classList.remove('is-open');
                currentOpenFolder = null;
            } else {
                folder.classList.add('is-open');
                currentOpenFolder = folder;
                
                // Сдвигаем папки вниз с оптимизацией
                requestAnimationFrame(() => {
                    shiftFoldersDown(folder, folders);
                });
            }
            
            // Обновляем высоту контейнера после изменения состояния папки
            setTimeout(() => {
                updateFoldersContainerHeight();
                isProcessing = false;
            }, animationConfig.transitionDuration + 50);
        };
        
        // Используем только один обработчик на tab для лучшей производительности
        tab.addEventListener('click', handleClick, { passive: true });
    });
    
    // Закрытие всех папок при клике вне них (один обработчик для всех)
    const handleOutsideClick = debounce((e) => {
        let hasOpenFolder = false;
        
        folders.forEach(folder => {
            if (folder.classList.contains('is-open') && !folder.contains(e.target)) {
                folder.classList.remove('is-open');
                hasOpenFolder = true;
            }
        });
        
        // Возвращаем все папки в исходное положение при закрытии
        if (hasOpenFolder) {
            currentOpenFolder = null;
            resetFoldersPosition(folders);
            setTimeout(() => {
                updateFoldersContainerHeight();
            }, animationConfig.transitionDuration + 50);
        }
    }, animationConfig.reducedMotion ? 50 : 100);
    
    document.addEventListener('click', handleOutsideClick);
    
    // Обновление высоты при изменении размера окна с оптимизацией
    const handleResize = debounce(() => {
        // Закрываем все открытые папки при ресайзе для предотвращения проблем
        folders.forEach(folder => {
            folder.classList.remove('is-open');
        });
        currentOpenFolder = null;
        
        // При изменении размера окна возвращаем папки в исходное положение
        resetFoldersPosition(folders);
        
        // Пересчитываем исходные позиции и высоты после изменения размера
        requestAnimationFrame(() => {
            folders.forEach(folder => {
                const currentTop = parseFloat(getComputedStyle(folder).top) || 0;
                folder.dataset.originalTop = currentTop.toString();
                
                // Обновляем высоту закрытой папки
                const isMobile = window.innerWidth <= 768;
                const closedHeight = isMobile ? 48 : 101;
                folder.dataset.closedHeight = closedHeight.toString();
            });
            
            updateFoldersContainerHeight();
        });
    }, 200);
    
    window.addEventListener('resize', handleResize, { passive: true });
    
    // Очистка при выгрузке страницы
    window.addEventListener('beforeunload', () => {
        window.removeEventListener('resize', handleResize);
        document.removeEventListener('click', handleOutsideClick);
    });
}


