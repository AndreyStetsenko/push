<?php
// Получаем данные из Carbon Fields для Cases секции
$cases_title_group = get_field('cases_title_group', 'option');
$cases_title_part1 = $cases_title_group && isset($cases_title_group['part1']) ? $cases_title_group['part1'] : '';
$cases_title_part2 = $cases_title_group && isset($cases_title_group['part2']) ? $cases_title_group['part2'] : '';
$cases_description = get_field('cases_description', 'option') ?: '';
$cases_filter_buttons = get_field('cases_filter_buttons', 'option');
$cases_cards = get_field('cases_cards', 'option');
?>
<div id="cases" class="cases">
    <div class="container">
        <div class="row cases__row">
            <div class="col-1-2">
                <div class="cases__wrap">
                    <h2 class="cases__title">
                        <span><?php echo esc_html($cases_title_part1); ?></span>
                        <span><?php echo esc_html($cases_title_part2); ?></span>
                    </h2>

                    <p class="cases__description">
                        <?php echo esc_html($cases_description); ?>
                    </p>

                    <div class="cases__buttons">
                        <?php if ($cases_filter_buttons && is_array($cases_filter_buttons) && !empty($cases_filter_buttons)): ?>
                            <?php foreach ($cases_filter_buttons as $button): ?>
                                <button class="cases__filter-btn" data-slide-index="<?php echo esc_attr(isset($button['slide_index']) ? $button['slide_index'] : 0); ?>">
                                    <?php echo esc_html(isset($button['text']) ? $button['text'] : ''); ?>
                                </button>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="cases__slider">
                    <div class="cases__slider-container">
                        <?php if ($cases_cards && is_array($cases_cards) && !empty($cases_cards)): ?>
                            <?php foreach ($cases_cards as $index => $card): ?>
                                <div class="cases__card cases__card--white">
                                    <h3 class="cases__card-title"><?php echo esc_html(isset($card['title']) ? $card['title'] : ''); ?></h3>
                                    <p class="cases__card-description">
                                        <?php echo esc_html(isset($card['description']) ? $card['description'] : ''); ?>
                                    </p>
                                    <div>
                                        <button class="cases__card-button" data-card-index="<?php echo esc_attr($index); ?>">
                                            <span><?php echo esc_html(isset($card['button_text']) ? $card['button_text'] : 'Детальніше'); ?></span>
                                            <div class="cases__card-button-icon">
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"/>
                                                </svg>
                                            </div>
                                        </button>
                                    </div>
                                    <?php if (!empty($card['kpi']) && is_array($card['kpi'])): ?>
                                        <div class="cases__card-kpi">
                                            <?php foreach ($card['kpi'] as $kpi): ?>
                                                <div class="cases__card-kpi-item">
                                                    <span class="cases__card-kpi-value"><?php echo esc_html(isset($kpi['kpi_value']) ? $kpi['kpi_value'] : ''); ?></span>
                                                    <span class="cases__card-kpi-label"><?php echo esc_html(isset($kpi['label']) ? $kpi['label'] : ''); ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="cases__slider-indicator">
                        <div class="cases__slider-indicator-progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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