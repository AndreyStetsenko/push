<?php
// Получаем данные из Carbon Fields для Services секции
$services_title_group = get_field('services_title_group', 'option');
$services_title_part1 = $services_title_group && isset($services_title_group['part1']) ? $services_title_group['part1'] : '';
$services_title_part2 = $services_title_group && isset($services_title_group['part2']) ? $services_title_group['part2'] : '';

$services_items = get_field('services_items', 'option');
?>
<div class="services" id="services">
    <div class="container">
        <h2 class="services__title"><?php echo esc_html($services_title_part1); ?> <span><?php echo esc_html($services_title_part2); ?></span></h2>

        <div class="services__slider">
            <div class="light">
                <div class="l1"></div>
                <div class="l2"></div>
                <div class="l3"></div>
                <div class="l4"></div>
            </div>
            <div class="swiper-wrapper">
                <?php if ($services_items && is_array($services_items) && !empty($services_items)): ?>
                    <?php foreach ($services_items as $service): ?>
                        <?php 
                        $service_image_id = isset($service['image']) ? $service['image'] : null;
                        $service_title = isset($service['title']) ? $service['title'] : '';
                        $service_description = isset($service['description']) ? $service['description'] : '';
                        
                        // Получаем размеры текста из Carbon Fields
                        $title_size_desktop = isset($service['title_size_desktop']) && !empty($service['title_size_desktop']) ? floatval($service['title_size_desktop']) : null;
                        $title_size_mobile = isset($service['title_size_mobile']) && !empty($service['title_size_mobile']) ? floatval($service['title_size_mobile']) : null;
                        $description_size_desktop = isset($service['description_size_desktop']) && !empty($service['description_size_desktop']) ? floatval($service['description_size_desktop']) : null;
                        $description_size_mobile = isset($service['description_size_mobile']) && !empty($service['description_size_mobile']) ? floatval($service['description_size_mobile']) : null;
                        
                        // Формируем inline стили для заголовка
                        $title_styles = '';
                        if ($title_size_desktop !== null || $title_size_mobile !== null) {
                            $title_styles = ' style="';
                            if ($title_size_desktop !== null) {
                                $title_styles .= '--title-size-desktop: ' . esc_attr($title_size_desktop) . 'rem;';
                            }
                            if ($title_size_mobile !== null) {
                                $title_styles .= '--title-size-mobile: ' . esc_attr($title_size_mobile) . 'rem;';
                            }
                            $title_styles .= '"';
                        }
                        
                        // Формируем inline стили для описания
                        $description_styles = '';
                        if ($description_size_desktop !== null || $description_size_mobile !== null) {
                            $description_styles = ' style="';
                            if ($description_size_desktop !== null) {
                                $description_styles .= '--description-size-desktop: ' . esc_attr($description_size_desktop) . 'rem;';
                            }
                            if ($description_size_mobile !== null) {
                                $description_styles .= '--description-size-mobile: ' . esc_attr($description_size_mobile) . 'rem;';
                            }
                            $description_styles .= '"';
                        }
                        
                        // Преобразуем ID изображения в массив с url и alt
                        $service_image = $service_image_id ? crb_get_image($service_image_id) : null;
                        ?>
                        <?php if ($service_image && isset($service_image['url'])): ?>
                            <div class="swiper-slide slide">
                                <div class="item">
                                    <div class="item-bg"></div>
                                    <div class="item-head">
                                        <?php echo push_optimized_image($service_image, 'full', array(
                                            'loading' => 'lazy',
                                            'fetchpriority' => 'auto'
                                        )); ?>
                                    </div>
                                    <div class="item-body">
                                        <span class="title"<?php echo $title_styles; ?>><?php echo esc_html($service_title); ?></span>
                                        <span class="description"<?php echo $description_styles; ?>><?php echo esc_html($service_description); ?></span>
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