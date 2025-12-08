<?php
// Получаем данные из ACF полей для Collab секции
$collab_title_group = get_field('collab_title_group', 'option');
$collab_title_part1 = $collab_title_group && isset($collab_title_group['part1']) ? $collab_title_group['part1'] : '';
$collab_title_part2 = $collab_title_group && isset($collab_title_group['part2']) ? $collab_title_group['part2'] : '';
$collab_subtitle = get_field('collab_subtitle', 'option') ?: '';
$collab_buttons = get_field('collab_buttons', 'option');
$collab_steps = get_field('collab_steps', 'option');
?>
<div id="collab" class="collab">
    <div class="container">
        <div class="collab__title">
            <div class="title"><?php echo esc_html($collab_title_part1); ?> <span><?php echo esc_html($collab_title_part2); ?></span></div>
            <div class="sub"><?php echo esc_html($collab_subtitle); ?></div>

            <div class="buttons">
                <?php if ($collab_buttons && is_array($collab_buttons) && !empty($collab_buttons)): ?>
                    <?php foreach ($collab_buttons as $button): ?>
                        <div class="buttons__item <?php echo esc_attr(isset($button['css_class']) ? $button['css_class'] : ''); ?>">
                            <span><?php echo esc_html(isset($button['text']) ? $button['text'] : ''); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="collab__steps">
            <?php if ($collab_steps && is_array($collab_steps) && !empty($collab_steps)): ?>
                <?php foreach ($collab_steps as $step): ?>
                    <div class="item">
                        <div class="num"><?php echo esc_html(isset($step['number']) ? $step['number'] : ''); ?></div>
                        <div class="content">
                            <span class="title"><?php echo esc_html(isset($step['title']) ? $step['title'] : ''); ?></span>
                            <p class="description"><?php echo esc_html(isset($step['description']) ? $step['description'] : ''); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>