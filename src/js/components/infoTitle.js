export function initInfoTitle() {
    const titleElement = document.querySelector('.info-content__title');
    
    if (!titleElement) {
        return;
    }
    
    // Получаем текст заголовка
    const text = titleElement.textContent.trim();
    
    // Разбиваем на слова
    const words = text.split(/\s+/);
    
    if (words.length === 0) {
        return;
    }
    
    // Очищаем содержимое и создаем span для каждого слова
    titleElement.innerHTML = '';
    
    words.forEach((word, index) => {
        const span = document.createElement('span');
        span.textContent = word;
        
        // Благодаря flex-direction: column каждый span будет на новой строке
        // Стили применяются через CSS, но можно и через inline для надежности
        if (index === 0) {
            // Первое слово - черное
            span.style.color = '#000';
        } else {
            // Остальные слова - оранжевые
            span.style.color = '#FF6B00';
        }
        
        titleElement.appendChild(span);
    });
}

