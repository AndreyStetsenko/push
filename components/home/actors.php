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
                            $file_type = null; // 'webp', 'webm', 'gif' или null
                            $actor_image = null;
                            
                            if ($media_type === 'gif') {
                                // Получаем GIF/WebP/WebM файл
                                $gif_webp_webm_id = isset($actor['gif_webp_webm']) ? $actor['gif_webp_webm'] : null;
                                if ($gif_webp_webm_id) {
                                    // Для файлов используем wp_get_attachment_url вместо crb_get_image
                                    $media_url = wp_get_attachment_url($gif_webp_webm_id);
                                    if ($media_url) {
                                        // Определяем тип файла по расширению
                                        $file_extension = strtolower(pathinfo($media_url, PATHINFO_EXTENSION));
                                        if (in_array($file_extension, ['webp', 'webm', 'gif'])) {
                                            $file_type = $file_extension;
                                        }
                                        // Получаем alt текст из метаданных
                                        $media_alt = get_post_meta($gif_webp_webm_id, '_wp_attachment_image_alt', true);
                                        if (empty($media_alt)) {
                                            $media_alt = $actor_title;
                                        }
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
                                        <div class="image <?php echo $media_type === 'gif' ? 'gif' : ''; ?> <?php echo $file_type ? $file_type : ''; ?>">
                                            <?php if ($media_type === 'gif'): ?>
                                                <?php if ($file_type === 'webm'): ?>
                                                    <video src="<?php echo esc_url($media_url); ?>" autoplay loop muted playsinline loading="lazy">
                                                        <?php echo esc_html($media_alt); ?>
                                                    </video>
                                                <?php else: ?>
                                                    <img src="<?php echo esc_url($media_url); ?>" alt="<?php echo esc_attr($media_alt); ?>" loading="lazy" fetchpriority="auto" decoding="async">
                                                <?php endif; ?>
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