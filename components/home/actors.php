<?php
// Получаем данные из Carbon Fields для Actors секции
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
        </div>

        <div class="actors__slider">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php if ($actors_items && is_array($actors_items) && !empty($actors_items)): ?>
                        <?php foreach ($actors_items as $actor): ?>
                            <?php 
                            $actor_image_id = isset($actor['image']) ? $actor['image'] : null;
                            $actor_title = isset($actor['title']) ? $actor['title'] : '';
                            
                            // Преобразуем ID изображения в массив с url и alt
                            $actor_image = $actor_image_id ? crb_get_image($actor_image_id) : null;
                            ?>
                            <?php if ($actor_image && isset($actor_image['url'])): ?>
                                <div class="swiper-slide">
                                    <div class="item">
                                        <div class="image">
                                            <?php echo push_optimized_image($actor_image, 'full', array(
                                                'loading' => 'lazy',
                                                'fetchpriority' => 'auto'
                                            )); ?>
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