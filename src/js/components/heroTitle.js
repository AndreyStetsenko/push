/**
 * Добавляет отступ слева для второй и последующих строк в hero заголовке
 */
export function initHeroTitle() {
    const heroTitle = document.querySelector('.hero__title');
    if (!heroTitle) return;

    const spans = heroTitle.querySelectorAll('.span');
    
    spans.forEach((span) => {
        const text = span.textContent.trim();
        if (!text) return;

        // Разбиваем текст на слова
        const words = text.split(/\s+/);
        
        // Очищаем содержимое и создаем обертку для слов
        span.innerHTML = '';
        const wordsContainer = document.createElement('span');
        wordsContainer.style.display = 'inline-block';
        
        // Создаем span для каждого слова
        words.forEach((word, index) => {
            const wordSpan = document.createElement('span');
            wordSpan.textContent = word;
            wordSpan.style.whiteSpace = 'nowrap';
            wordsContainer.appendChild(wordSpan);
            
            // Добавляем пробел после слова (кроме последнего)
            if (index < words.length - 1) {
                wordsContainer.appendChild(document.createTextNode(' '));
            }
        });
        
        span.appendChild(wordsContainer);
        
        // Функция для добавления отступов
        const addIndents = () => {
            const wordSpans = wordsContainer.querySelectorAll('span');
            if (wordSpans.length === 0) return;
            
            const firstLineTop = wordSpans[0].offsetTop;
            const indentValue = '1.5em'; // Можно настроить значение отступа
            let lastLineTop = firstLineTop;
            
            wordSpans.forEach((wordSpan) => {
                const currentTop = wordSpan.offsetTop;
                
                if (currentTop > firstLineTop) {
                    // Это не первая строка
                    if (currentTop > lastLineTop) {
                        // Это первое слово на новой строке - добавляем отступ
                        wordSpan.style.paddingLeft = indentValue;
                        lastLineTop = currentTop;
                    } else {
                        // Это не первое слово на этой строке - убираем отступ
                        wordSpan.style.paddingLeft = '';
                    }
                } else {
                    // Первая строка - убираем отступ
                    wordSpan.style.paddingLeft = '';
                }
            });
        };
        
        // Добавляем отступы после загрузки и при изменении размера окна
        setTimeout(addIndents, 0);
        window.addEventListener('resize', addIndents);
    });
}

