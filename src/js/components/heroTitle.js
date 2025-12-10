export function initHeroTitle() {
    // ✅ ТОЛЬКО ДЕСКТОП
    if (window.innerWidth < 1024) return;

    const heroTitle = document.querySelector('.hero__title');
    if (!heroTitle) return;

    const spans = heroTitle.querySelectorAll('.span');
    
    spans.forEach((span) => {
        const text = span.textContent.trim();
        if (!text) return;

        const words = text.split(/\s+/);
        span.innerHTML = '';

        const wordsContainer = document.createElement('span');
        wordsContainer.style.display = 'inline-block';

        words.forEach((word, index) => {
            const wordSpan = document.createElement('span');
            wordSpan.textContent = word;
            wordSpan.style.whiteSpace = 'nowrap';
            wordsContainer.appendChild(wordSpan);

            if (index < words.length - 1) {
                wordsContainer.appendChild(document.createTextNode(' '));
            }
        });

        span.appendChild(wordsContainer);

        const addIndents = () => {
            // ✅ повторная проверка при ресайзе
            if (window.innerWidth < 1024) return;

            const wordSpans = wordsContainer.querySelectorAll('span');
            if (!wordSpans.length) return;

            const firstLineTop = wordSpans[0].offsetTop;
            const indentValue = '1.5em';
            let lastLineTop = firstLineTop;

            wordSpans.forEach((wordSpan) => {
                const currentTop = wordSpan.offsetTop;

                if (currentTop > firstLineTop) {
                    if (currentTop > lastLineTop) {
                        wordSpan.style.paddingLeft = indentValue;
                        lastLineTop = currentTop;
                    } else {
                        wordSpan.style.paddingLeft = '';
                    }
                } else {
                    wordSpan.style.paddingLeft = '';
                }
            });
        };

        setTimeout(addIndents, 0);
        window.addEventListener('resize', addIndents);
    });
}
