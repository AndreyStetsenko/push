// Функция для вычисления и установки высоты контейнера папок
function updateFoldersContainerHeight() {
    const foldersContainer = document.querySelector('.faq__folders');
    if (!foldersContainer) return;
    
    const folders = document.querySelectorAll('.folder');
    if (folders.length === 0) return;
    
    let maxBottom = 0;
    
    folders.forEach(folder => {
        const rect = folder.getBoundingClientRect();
        const containerRect = foldersContainer.getBoundingClientRect();
        
        // Вычисляем позицию папки относительно контейнера
        const relativeTop = rect.top - containerRect.top;
        const folderHeight = rect.height;
        const bottom = relativeTop + folderHeight;
        
        // Обновляем максимальную нижнюю границу
        if (bottom > maxBottom) {
            maxBottom = bottom;
        }
    });
    
    // Добавляем отступ снизу (в пикселях)
    const paddingBottom = window.innerWidth <= 768 ? 50 : 0;
    const minHeight = maxBottom + paddingBottom;
    
    // Устанавливаем минимальную высоту контейнера
    foldersContainer.style.minHeight = `${minHeight}px`;
    foldersContainer.style.marginBottom = `${paddingBottom}px`;
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
    // Ждем один кадр для применения CSS стилей после добавления класса is-open
    requestAnimationFrame(() => {
        // Получаем высоту открытой папки
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
            : (parseFloat(getComputedStyle(openFolder).top) || 0);
        
        folders.forEach(folder => {
            // Пропускаем саму открытую папку
            if (folder === openFolder || folder.classList.contains('is-open')) {
                return;
            }
            
            // Используем исходную позицию из data-атрибута
            const originalTop = folder.dataset.originalTop 
                ? parseFloat(folder.dataset.originalTop) 
                : (parseFloat(getComputedStyle(folder).top) || 0);
            
            // Сдвигаем все папки, которые визуально находятся ниже открытой папки
            // Сравниваем исходные позиции (top), а не индексы
            if (originalTop > openFolderOriginalTop) {
                // Вычисляем новую позицию: исходная позиция + дополнительная высота открытой папки
                const newTop = originalTop + additionalHeight;
                
                // Устанавливаем новый top
                folder.style.top = `${newTop}px`;
            }
        });
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

// Компонент для разворачивания FAQ папок
export function initFaqFolders() {
    const folders = document.querySelectorAll('.folder');
    const foldersContainer = document.querySelector('.faq__folders');
    
    if (!foldersContainer) return;
    
    // Сохраняем исходные позиции и высоты папок при инициализации
    // Используем requestAnimationFrame для гарантии, что CSS применен
    requestAnimationFrame(() => {
        folders.forEach(folder => {
            // Получаем top из computed style (CSS), игнорируя inline стили
            const computedStyle = getComputedStyle(folder);
            const currentTop = parseFloat(computedStyle.top) || 0;
            
            // Сохраняем исходную позицию только если еще не сохранено
            if (!folder.dataset.originalTop) {
                folder.dataset.originalTop = currentTop.toString();
            }
            
            // Сохраняем высоту закрытой папки (высота вкладки)
            if (!folder.dataset.closedHeight) {
                const isMobile = window.innerWidth <= 768;
                const closedHeight = isMobile ? 48 : 101; // Высота вкладки
                folder.dataset.closedHeight = closedHeight.toString();
            }
        });
    });
    
    folders.forEach(folder => {
        const tab = folder.querySelector('.folder__tab');
        const content = folder.querySelector('.folder__content');
        
        if (!tab || !content) return;
        
        // Переменные для отслеживания touch событий
        let touchStartX = 0;
        let touchStartY = 0;
        let touchMoved = false;
        let isScrolling = false;
        
        // Обработчик начала касания
        const handleTouchStart = (e) => {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
            touchMoved = false;
            isScrolling = false;
        };
        
        // Обработчик движения пальца
        const handleTouchMove = (e) => {
            if (!touchStartX || !touchStartY) return;
            
            const touchEndX = e.touches[0].clientX;
            const touchEndY = e.touches[0].clientY;
            const deltaX = Math.abs(touchEndX - touchStartX);
            const deltaY = Math.abs(touchEndY - touchStartY);
            
            // Если движение больше 10px, считаем это скроллом/движением
            if (deltaX > 10 || deltaY > 10) {
                touchMoved = true;
                // Если вертикальное движение больше горизонтального, это скролл
                if (deltaY > deltaX) {
                    isScrolling = true;
                }
            }
        };
        
        // Обработчик клика на tab или folder
        const handleClick = (e) => {
            e.stopPropagation();
            
            // На touch-устройствах проверяем, был ли это скролл
            if (touchMoved || isScrolling) {
                touchMoved = false;
                isScrolling = false;
                return;
            }
            
            const isOpen = folder.classList.contains('is-open');
            
            // Закрываем все другие папки
            folders.forEach(otherFolder => {
                if (otherFolder !== folder) {
                    otherFolder.classList.remove('is-open');
                }
            });
            
            // Возвращаем все папки в исходное положение перед переключением
            resetFoldersPosition(folders);
            
            // Переключаем текущую папку
            if (isOpen) {
                folder.classList.remove('is-open');
            } else {
                folder.classList.add('is-open');
                
                // Ждем задержки для начала анимации открытия и применения CSS
                // Затем сдвигаем папки вниз
                // Используем двойной requestAnimationFrame для гарантии применения стилей
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        shiftFoldersDown(folder, folders);
                    });
                });
            }
            
            // Обновляем высоту контейнера после изменения состояния папки
            setTimeout(() => {
                updateFoldersContainerHeight();
            }, 500);
            
            // Сбрасываем флаги после обработки
            touchMoved = false;
            isScrolling = false;
        };
        
        // Добавляем обработчики для touch событий
        tab.addEventListener('touchstart', handleTouchStart, { passive: true });
        tab.addEventListener('touchmove', handleTouchMove, { passive: true });
        folder.addEventListener('touchstart', handleTouchStart, { passive: true });
        folder.addEventListener('touchmove', handleTouchMove, { passive: true });
        
        // Обработчики клика
        tab.addEventListener('click', handleClick);
        folder.addEventListener('click', handleClick);
    });
    
    // Закрытие всех папок при клике вне них (один обработчик для всех)
    document.addEventListener('click', (e) => {
        let hasOpenFolder = false;
        folders.forEach(folder => {
            if (folder.classList.contains('is-open') && !folder.contains(e.target)) {
                folder.classList.remove('is-open');
                hasOpenFolder = true;
            }
        });
        
        // Возвращаем все папки в исходное положение при закрытии
        if (hasOpenFolder) {
            resetFoldersPosition(folders);
            setTimeout(() => {
                updateFoldersContainerHeight();
            }, 450);
        }
    });
    
    // Инициализация высоты при загрузке
    updateFoldersContainerHeight();
    
    // Обновление высоты при изменении размера окна
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            // При изменении размера окна возвращаем папки в исходное положение
            resetFoldersPosition(folders);
            
            // Пересчитываем исходные позиции и высоты после изменения размера
            folders.forEach(folder => {
                const currentTop = parseFloat(getComputedStyle(folder).top) || 0;
                folder.dataset.originalTop = currentTop.toString();
                
                // Обновляем высоту закрытой папки
                const isMobile = window.innerWidth <= 768;
                const closedHeight = isMobile ? 48 : 101;
                folder.dataset.closedHeight = closedHeight.toString();
            });
            
            updateFoldersContainerHeight();
        }, 150);
    });
}

