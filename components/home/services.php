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
            <?php if ($services_items && is_array($services_items) && !empty($services_items)): ?>
                <?php foreach ($services_items as $service): ?>
                    <?php 
                    $service_image_id = isset($service['image']) ? $service['image'] : null;
                    $service_title = isset($service['title']) ? $service['title'] : '';
                    $service_description = isset($service['description']) ? $service['description'] : '';
                    
                    // Преобразуем ID изображения в массив с url и alt
                    $service_image = $service_image_id ? crb_get_image($service_image_id) : null;
                    ?>
                    <?php if ($service_image && isset($service_image['url'])): ?>
                        <div class="slide">
                            <div class="item">
                                <div class="item-head">
                                    <img src="<?php echo esc_url($service_image['url']); ?>" alt="<?php echo esc_attr($service_image['alt'] ?: $service_title); ?>">
                                </div>
                                <div class="item-body">
                                    <span class="title"><?php echo esc_html($service_title); ?></span>
                                    <span class="description"><?php echo esc_html($service_description); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>