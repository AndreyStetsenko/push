<?php
/**
 * Главный шаблон темы
 *
 * @package Push
 */

get_header(); ?>

<?php get_template_part('components/home/hero'); ?>
<?php get_template_part('components/home/services'); ?>
<?php get_template_part('components/home/whyus'); ?>
<?php get_template_part('components/home/pushstart'); ?>
<?php get_template_part('components/home/cases'); ?>
<?php get_template_part('components/home/actors'); ?>
<?php get_template_part('components/home/collab'); ?>
<?php get_template_part('components/home/faq'); ?>
<?php get_template_part('components/home/bonus'); ?>

<!-- Модальное окно для кейсов -->
<div class="cases-modal" id="casesModal">
    <div class="cases-modal__overlay"></div>
    <div class="cases-modal__content">
        <button class="cases-modal__close" aria-label="Закрыть">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
        
        <div class="cases-modal__header">
            <h2 class="cases-modal__title">
                <span class="cases-modal__title-orange">СТРАТЕГІЯ РОСТУ</span>
                <span class="cases-modal__title-black">ДЛЯ GLOWUP STUDIO</span>
            </h2>
            <p class="cases-modal__subtitle">SMM / Контент-стратегія / Візуальна айдентика</p>
            <p class="cases-modal__sub">ЛОГО КОМПАНІЇ</p>
        </div>

        <div class="cases-modal__body">
            <div class="cases-modal__content-left">
                <div class="cases-modal__section">
                    <h3 class="cases-modal__section-title">ЗАВДАННЯ</h3>
                    <p class="cases-modal__section-text">
                        GlowUp Studio — новий бренд спортивного харчування, який прагнув увійти на ринок з професійним іміджем та чіткою позицією. Основна мета — створити стратегію росту, що поєднує контент, дизайн та комунікацію з аудиторією.
                    </p>
                </div>

                <div class="cases-modal__section">
                    <h3 class="cases-modal__section-title">РІШЕННЯ</h3>
                    <p class="cases-modal__section-text">
                        Було створено комплексну стратегію розвитку бренду, що включала:
                    </p>
                    <ul class="cases-modal__section-list">
                        <li>Унікальний візуальний стиль для соціальних мереж (кольори, шрифти, tone of voice)</li>
                        <li>Контент-план, що балансує експертний, мотиваційний та промо-контент</li>
                        <li>Запуск рубрикатора stories для системної комунікації з аудиторією</li>
                        <li>Створення гайду для постів та stories для автономності команди клієнта</li>
                        <li>Розробка місячного SMM-плану з чіткими KPI та форматами контенту</li>
                    </ul>
                </div>

                <div class="cases-modal__section">
                    <h3 class="cases-modal__section-title">РЕЗУЛЬТАТИ</h3>
                    <p class="cases-modal__section-text">
                        За перший місяць після запуску:
                    </p>
                    <ul class="cases-modal__section-list">
                        <li>+450 продажів з органічного контенту</li>
                        <li>+320% охоплення сторінки Instagram</li>
                        <li>Підвищення впізнаваності бренду серед аудиторії спортивного харчування</li>
                        <li>Формування стабільної спільноти навколо бренду</li>
                    </ul>
                </div>

                <div class="cases-modal__section">
                    <h3 class="cases-modal__section-title">ВИСНОВКИ</h3>
                    <p class="cases-modal__section-text">
                        Успішна стратегія росту базується на послідовності, єдиній візуальній системі, якісному контенті та активній взаємодії з аудиторією, що дозволило GlowUp Studio побудувати повноцінну спільноту, яка передає енергію та довіру до бренду.
                    </p>
                </div>
            </div>

            <div class="cases-modal__content-right">
                <div class="cases-modal__logo">
                    <div class="cases-modal__image-placeholder">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 16L8 12L12 16L20 8" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 8H16V12" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="cases-modal__images">
                    <div class="cases-modal__image-placeholder cases-modal__image-placeholder--small">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 16L8 12L12 16L20 8" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 8H16V12" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="cases-modal__image-placeholder cases-modal__image-placeholder--small">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 16L8 12L12 16L20 8" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 8H16V12" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="cases-modal__video">
                    <div class="cases-modal__image-placeholder cases-modal__image-placeholder--video">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#9CA3AF" stroke-width="2"/>
                            <path d="M10 8L16 12L10 16V8Z" fill="#9CA3AF"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();

