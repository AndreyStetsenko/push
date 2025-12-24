/**
 * FAQ Folders Component (Accordion)
 * Управляет классом .is-active при открытии/закрытии вкладок
 */

export function initFaqFolders() {
    const foldersContainer = document.querySelector('.faq__folders');
    if (!foldersContainer) return;

    const folders = Array.from(foldersContainer.querySelectorAll('.folder'));
    if (folders.length === 0) return;

    // Обработчик изменения состояния checkbox
    folders.forEach(folder => {
        const input = folder.querySelector('.folder__input');
        if (!input) return;

        // Функция для обновления класса
        const updateActiveClass = () => {
            if (input.checked) {
                folder.classList.add('is-active');
            } else {
                folder.classList.remove('is-active');
            }
        };

        // Проверяем начальное состояние
        updateActiveClass();

        // Слушаем изменения
        input.addEventListener('change', updateActiveClass);
    });
}
