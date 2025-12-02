import './components/langSelector.js';
import { initCasesSlider } from './components/casesSlider.js';
import { initCasesModal } from './components/casesModal.js';
import { initActorsSlider } from './components/actorsSlider.js';
import { initFaqFolders } from './components/faqFolders.js';
import { initBonusBox } from './components/bonusBox.js';
import { initMobileMenu } from './components/mobileMenu.js';
import { initWhyusLight } from './components/whyusLight.js';
import { initInfoTitle } from './components/infoTitle.js';

// Инициализация слайдеров
document.addEventListener('DOMContentLoaded', () => {
    initCasesSlider();
    initCasesModal();
    initActorsSlider();
    initFaqFolders();
    initBonusBox();
    initMobileMenu();
    initWhyusLight();
    initInfoTitle();
});
