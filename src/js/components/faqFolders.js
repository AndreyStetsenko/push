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

// Компонент для разворачивания FAQ папок
export function initFaqFolders() {
    const folders = document.querySelectorAll('.folder');
    const foldersContainer = document.querySelector('.faq__folders');
    
    if (!foldersContainer) return;
    
    folders.forEach(folder => {
        const tab = folder.querySelector('.folder__tab');
        const content = folder.querySelector('.folder__content');
        
        if (!tab || !content) return;
        
        // Обработчик клика на tab или folder
        const handleClick = (e) => {
            e.stopPropagation();
            
            const isOpen = folder.classList.contains('is-open');
            
            // Закрываем все другие папки
            folders.forEach(otherFolder => {
                if (otherFolder !== folder) {
                    otherFolder.classList.remove('is-open');
                }
            });
            
            // Переключаем текущую папку
            if (isOpen) {
                folder.classList.remove('is-open');
            } else {
                folder.classList.add('is-open');
            }
            
            // Обновляем высоту контейнера после изменения состояния папки
            // Используем небольшую задержку для завершения CSS-переходов
            setTimeout(() => {
                updateFoldersContainerHeight();
            }, 350);
        };
        
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
        
        // Обновляем высоту только если была закрыта хотя бы одна папка
        if (hasOpenFolder) {
            setTimeout(() => {
                updateFoldersContainerHeight();
            }, 350);
        }
    });
    
    // Инициализация высоты при загрузке
    updateFoldersContainerHeight();
    
    // Обновление высоты при изменении размера окна
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            updateFoldersContainerHeight();
        }, 150);
    });
}

