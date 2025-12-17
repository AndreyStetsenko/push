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
                            $media_type = isset($actor['media_type']) ? $actor['media_type'] : 'image';
                            $actor_title = isset($actor['title']) ? $actor['title'] : '';
                            
                            $media_url = null;
                            $media_alt = '';
                            $actor_image = null;
                            
                            if ($media_type === 'gif') {
                                // Получаем GIF/WebP файл
                                $gif_webp_id = isset($actor['gif_webp']) ? $actor['gif_webp'] : null;
                                if ($gif_webp_id) {
                                    $gif_webp_file = crb_get_image($gif_webp_id);
                                    if ($gif_webp_file && isset($gif_webp_file['url'])) {
                                        $media_url = $gif_webp_file['url'];
                                        $media_alt = isset($gif_webp_file['alt']) ? $gif_webp_file['alt'] : $actor_title;
                                    }
                                }
                            } else {
                                // Получаем обычное изображение
                                $actor_image_id = isset($actor['image']) ? $actor['image'] : null;
                                if ($actor_image_id) {
                                    $actor_image = crb_get_image($actor_image_id);
                                    if ($actor_image && isset($actor_image['url'])) {
                                        $media_url = $actor_image['url'];
                                        $media_alt = isset($actor_image['alt']) ? $actor_image['alt'] : $actor_title;
                                    }
                                }
                            }
                            ?>
                            <?php if ($media_url): ?>
                                <div class="swiper-slide">
                                    <div class="item">
                                        <div class="image <?php echo $media_type === 'gif' ? 'gif' : ''; ?>">
                                            <?php if ($media_type === 'gif'): ?>
                                                <img src="<?php echo esc_url($media_url); ?>" alt="<?php echo esc_attr($media_alt); ?>" loading="lazy" fetchpriority="auto" decoding="async">
                                            <?php else: ?>
                                                <?php echo push_optimized_image($actor_image, 'full', array(
                                                    'loading' => 'lazy',
                                                    'fetchpriority' => 'auto'
                                                )); ?>
                                            <?php endif; ?>
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