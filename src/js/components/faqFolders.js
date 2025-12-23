/**
 * FAQ Folders Component
 * Управляет выдвижением папок FAQ
 * Папки всегда открыты, при клике выбранная папка выдвигается, а папки ниже сдвигаются вниз
 */

export function initFaqFolders() {
    const foldersContainer = document.querySelector('.faq__folders');
    if (!foldersContainer) return;

    const folders = Array.from(foldersContainer.querySelectorAll('.folder'));
    if (folders.length === 0) return;

    // Проверка на мобильную версию
    const isMobile = () => window.innerWidth <= 768;

    // Инициализация: сохраняем базовые позиции папок из CSS
    function initializeFolders() {
        // Ждем, пока стили применятся
        requestAnimationFrame(() => {
            folders.forEach((folder, index) => {
                const tab = folder.querySelector('.folder__tab');
                const content = folder.querySelector('.folder__content');
                
                if (!tab || !content) return;
                
                // Получаем текущую позицию из CSS (уже установлена через классы --1, --2, и т.д.)
                // Используем getBoundingClientRect для получения реальной позиции относительно родителя
                const folderRect = folder.getBoundingClientRect();
                const containerRect = foldersContainer.getBoundingClientRect();
                const relativeTop = folderRect.top - containerRect.top;
                
                // Если позиция не установлена через CSS, используем вычисленную
                const computedStyle = window.getComputedStyle(folder);
                const cssTop = parseFloat(computedStyle.top);
                const currentTop = (cssTop && !isNaN(cssTop)) ? cssTop : relativeTop;
                
                // Сохраняем базовую позицию
                folder.dataset.baseTop = currentTop;
                folder.style.top = currentTop + 'px';
                
                // Сохраняем высоты для расчетов
                const tabHeight = tab.offsetHeight;
                
                // Временно показываем контент для измерения его высоты
                const originalMaxHeight = content.style.maxHeight;
                const originalPaddingTop = content.style.paddingTop;
                const originalPaddingBottom = content.style.paddingBottom;
                
                content.style.maxHeight = 'none';
                content.style.paddingTop = '';
                content.style.paddingBottom = '';
                content.style.visibility = 'hidden';
                content.style.position = 'absolute';
                
                const contentHeight = content.scrollHeight;
                
                // Восстанавливаем стили
                content.style.maxHeight = originalMaxHeight;
                content.style.paddingTop = originalPaddingTop;
                content.style.paddingBottom = originalPaddingBottom;
                content.style.visibility = '';
                content.style.position = '';
                
                folder.dataset.tabHeight = tabHeight;
                folder.dataset.contentHeight = contentHeight;
            });
            
            // Устанавливаем общую высоту контейнера
            updateContainerHeight();
        });
    }

    // Обновление высоты контейнера
    function updateContainerHeight() {
        let maxBottom = 0;
        
        folders.forEach(folder => {
            const top = parseFloat(folder.style.top) || 0;
            const height = folder.offsetHeight;
            const bottom = top + height;
            maxBottom = Math.max(maxBottom, bottom);
        });
        
        foldersContainer.style.minHeight = maxBottom + 100 + 'px'; // +100 для отступа снизу
    }

    // Активация папки (выдвижение)
    function activateFolder(clickedFolder, clickedIndex) {
        // Убираем активное состояние со всех папок
        folders.forEach((folder, index) => {
            if (folder.classList.contains('is-active')) {
                deactivateFolder(folder, index);
            }
        });
        
        // Активируем выбранную папку
        clickedFolder.classList.add('is-active', 'is-animating');
        
        const content = clickedFolder.querySelector('.folder__content');
        if (!content) return;
        
        // Временно показываем контент для измерения высоты
        const originalMaxHeight = content.style.maxHeight;
        const originalPaddingTop = content.style.paddingTop;
        const originalPaddingBottom = content.style.paddingBottom;
        
        // Временно устанавливаем стили для измерения
        content.style.maxHeight = 'none';
        content.style.paddingTop = '';
        content.style.paddingBottom = '';
        content.style.visibility = 'hidden';
        content.style.position = 'absolute';
        
        // Получаем полную высоту раскрытого контента
        const fullContentHeight = content.scrollHeight;
        
        // Восстанавливаем стили
        content.style.maxHeight = originalMaxHeight;
        content.style.paddingTop = originalPaddingTop;
        content.style.paddingBottom = originalPaddingBottom;
        content.style.visibility = '';
        content.style.position = '';
        
        // Вычисляем дополнительную высоту для выдвижения
        // Базовый padding: 80px top + 300px bottom = 380px (на десктопе)
        // Расширенный padding: 120px top + 400px bottom = 520px (на десктопе)
        // На мобильных: padding меньше, поэтому уменьшаем разницу
        const baseContentHeight = parseFloat(clickedFolder.dataset.contentHeight) || 0;
        const paddingDifference = isMobile() ? 80 : 140; // Меньшая разница для мобильных
        const expandHeight = fullContentHeight - baseContentHeight + paddingDifference;
        
        // Сохраняем высоту расширения
        clickedFolder.dataset.expandHeight = expandHeight;
        clickedFolder.dataset.fullContentHeight = fullContentHeight;
        
        // Сдвигаем все папки ниже текущей на величину расширения
        for (let i = clickedIndex + 1; i < folders.length; i++) {
            const nextFolder = folders[i];
            const currentTop = parseFloat(nextFolder.style.top) || 0;
            const newTop = currentTop + expandHeight;
            nextFolder.style.top = newTop + 'px';
        }
        
        // Обновляем высоту контейнера
        updateContainerHeight();
        
        // Убираем класс анимации после завершения
        setTimeout(() => {
            clickedFolder.classList.remove('is-animating');
        }, 400);
    }

    // Деактивация папки (возврат в нормальное состояние)
    function deactivateFolder(folder, index) {
        folder.classList.remove('is-active');
        folder.classList.add('is-animating');
        
        // Получаем высоту расширения
        const expandHeight = parseFloat(folder.dataset.expandHeight) || 0;
        
        // Сдвигаем все папки ниже текущей обратно вверх к их базовым позициям
        for (let i = index + 1; i < folders.length; i++) {
            const nextFolder = folders[i];
            const baseTop = parseFloat(nextFolder.dataset.baseTop) || 0;
            nextFolder.style.top = baseTop + 'px';
        }
        
        // Обновляем высоту контейнера
        updateContainerHeight();
        
        // Убираем класс анимации после завершения
        setTimeout(() => {
            folder.classList.remove('is-animating');
        }, 400);
    }

    // Обработчик клика на tab
    folders.forEach(folder => {
        const tab = folder.querySelector('.folder__tab');
        if (tab) {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const folderIndex = folders.indexOf(folder);
                const isActive = folder.classList.contains('is-active');
                
                if (isActive) {
                    // Если папка уже активна, деактивируем её
                    deactivateFolder(folder, folderIndex);
                } else {
                    // Активируем папку
                    activateFolder(folder, folderIndex);
                }
            });
        }
    });

    // Инициализация при загрузке
    initializeFolders();
    
    // Пересчет при изменении размера окна
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            // Перечитываем базовые позиции из CSS и применяем их
            folders.forEach((folder, index) => {
                const tab = folder.querySelector('.folder__tab');
                const content = folder.querySelector('.folder__content');
                if (!tab || !content) return;
                
                // Получаем базовую позицию из CSS (через computed style)
                const computedStyle = window.getComputedStyle(folder);
                const baseTop = parseFloat(computedStyle.top) || 0;
                
                // Обновляем базовую позицию
                folder.dataset.baseTop = baseTop;
                
                // Если папка не активна, возвращаем её к базовой позиции
                if (!folder.classList.contains('is-active')) {
                    folder.style.top = baseTop + 'px';
                }
                
                // Обновляем высоты
                const tabHeight = tab.offsetHeight;
                const contentHeight = content.offsetHeight;
                folder.dataset.tabHeight = tabHeight;
                folder.dataset.contentHeight = contentHeight;
            });
            
            // Пересчитываем позиции активных папок и папок ниже них
            folders.forEach((folder, index) => {
                if (folder.classList.contains('is-active')) {
                    // Используем сохраненное значение или вычисляем заново с учетом мобильной версии
                    const savedExpandHeight = parseFloat(folder.dataset.expandHeight);
                    const defaultExpandHeight = isMobile() ? 80 : 200;
                    const expandHeight = savedExpandHeight || defaultExpandHeight;
                    const baseTop = parseFloat(folder.dataset.baseTop) || 0;
                    
                    // Сдвигаем все папки ниже активной
                    for (let i = index + 1; i < folders.length; i++) {
                        const nextFolder = folders[i];
                        const nextBaseTop = parseFloat(nextFolder.dataset.baseTop) || 0;
                        nextFolder.style.top = (nextBaseTop + expandHeight) + 'px';
                    }
                }
            });
            
            updateContainerHeight();
        }, 250);
    });
}
