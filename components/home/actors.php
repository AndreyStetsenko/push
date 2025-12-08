<?php
// Получаем данные из ACF полей для Actors секции
$actors_emoji = get_field('actors_emoji', 'option');
$actors_title_group = get_field('actors_title_group', 'option');
$actors_title_part1 = $actors_title_group && isset($actors_title_group['part1']) ? $actors_title_group['part1'] : '';
$actors_title_part2 = $actors_title_group && isset($actors_title_group['part2']) ? $actors_title_group['part2'] : '';
$actors_subtitle = get_field('actors_subtitle', 'option') ?: '';
$actors_items = get_field('actors_items', 'option');
?>
<div id="actors" class="actors">
    <div class="container">
        <div class="actors__head">
            <div class="actors__title">
                <div class="title"><?php echo esc_html($actors_title_part1); ?> <span><?php echo esc_html($actors_title_part2); ?></span></div>
                <div class="sub"><?php echo wp_kses_post($actors_subtitle); ?></div>
            </div>
            <div class="actors__emoji">
                <?php if ($actors_emoji && isset($actors_emoji['url'])): ?>
                    <img src="<?php echo esc_url($actors_emoji['url']); ?>" alt="<?php echo esc_attr($actors_emoji['alt'] ?: 'emoji'); ?>">
                <?php else: ?>
                    <img src="<?= img_url('actors/emoji.png'); ?>" alt="emoji">
                <?php endif; ?>
            </div>
        </div>

        <div class="actors__slider">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php if ($actors_items && is_array($actors_items) && !empty($actors_items)): ?>
                        <?php foreach ($actors_items as $actor): ?>
                            <?php 
                            $actor_image = isset($actor['image']) ? $actor['image'] : null;
                            $actor_title = isset($actor['title']) ? $actor['title'] : '';
                            ?>
                            <?php if ($actor_image && isset($actor_image['url'])): ?>
                                <div class="swiper-slide">
                                    <div class="item">
                                        <div class="image">
                                            <img src="<?php echo esc_url($actor_image['url']); ?>" alt="<?php echo esc_attr($actor_image['alt'] ?: $actor_title); ?>">
                                        </div>
                                        <div class="body">
                                            <h3 class="title"><?php echo esc_html($actor_title); ?></h3>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>