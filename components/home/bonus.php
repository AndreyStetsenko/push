<?php
// Получаем данные из ACF полей для Bonus секции
$bonus_title_group = get_field('bonus_title_group', 'option');
$bonus_title_first = $bonus_title_group && isset($bonus_title_group['first']) ? $bonus_title_group['first'] : '';
$bonus_title_second = $bonus_title_group && isset($bonus_title_group['second']) ? $bonus_title_group['second'] : '';
$bonus_image_close = get_field('bonus_image_close', 'option');
$bonus_image_open = get_field('bonus_image_open', 'option');
$bonus_content_title = get_field('bonus_content_title', 'option') ?: '';
?>
<div id="bonus" class="bonus">
    <div class="container">
        <div class="bonus__title">
            <span class="bonus__title-first"><?php echo esc_html($bonus_title_first); ?></span>
            <span class="bonus__title-second"><?php echo esc_html($bonus_title_second); ?></span>
        </div>

        <div class="bonus__wrapp">
            <div class="bonus__item">
                <div class="bonus__item-close">
                    <?php if ($bonus_image_close && isset($bonus_image_close['url'])): ?>
                        <img src="<?php echo esc_url($bonus_image_close['url']); ?>" alt="<?php echo esc_attr(isset($bonus_image_close['alt']) ? $bonus_image_close['alt'] : ''); ?>">
                    <?php else: ?>
                        <img src="<?= img_url('bonus/bonus-close.png'); ?>" alt="">
                    <?php endif; ?>
                </div>

                <div class="bonus__item-open">
                    <?php if ($bonus_image_open && isset($bonus_image_open['url'])): ?>
                        <img src="<?php echo esc_url($bonus_image_open['url']); ?>" alt="<?php echo esc_attr(isset($bonus_image_open['alt']) ? $bonus_image_open['alt'] : ''); ?>">
                    <?php else: ?>
                        <img src="<?= img_url('bonus/bonus-open.png'); ?>" alt="">
                    <?php endif; ?>

                    <div class="bonus__item-content">
                        <span class="bonus__item-content-title"><?php echo esc_html($bonus_content_title); ?></span>
                    </div>
                </div>

                <div class="bonus__item-shadow"></div>
            </div>
        </div>
    </div>
</div>