<?php
// Получаем данные из ACF полей для Cases секции
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
                            <?php foreach ($cases_cards as $card): ?>
                                <div class="cases__card cases__card--white">
                                    <h3 class="cases__card-title"><?php echo esc_html(isset($card['title']) ? $card['title'] : ''); ?></h3>
                                    <p class="cases__card-description">
                                        <?php echo esc_html(isset($card['description']) ? $card['description'] : ''); ?>
                                    </p>
                                    <div>
                                        <button class="cases__card-button">
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