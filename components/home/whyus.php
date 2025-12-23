<?php
// Получаем данные из Carbon Fields для Why Us секции
$whyus_emoji = get_field('whyus_emoji', 'option');
$whyus_title_group = get_field('whyus_title_group', 'option');
$whyus_title_first = $whyus_title_group && isset($whyus_title_group['first']) ? $whyus_title_group['first'] : '';
$whyus_title_second = $whyus_title_group && isset($whyus_title_group['second']) ? $whyus_title_group['second'] : '';

// Получаем размеры текста из Carbon Fields
$title_size_desktop = isset($whyus_title_group['font_size_desktop']) && !empty($whyus_title_group['font_size_desktop']) ? floatval($whyus_title_group['font_size_desktop']) : null;
$title_size_mobile = isset($whyus_title_group['font_size_mobile']) && !empty($whyus_title_group['font_size_mobile']) ? floatval($whyus_title_group['font_size_mobile']) : null;

// Формируем inline стили для заголовка
$title_styles = '';
if ($title_size_desktop !== null || $title_size_mobile !== null) {
    $title_styles = ' style="';
    if ($title_size_desktop !== null) {
        $title_styles .= '--title-font-size-desktop: ' . esc_attr($title_size_desktop) . 'rem;';
    }
    if ($title_size_mobile !== null) {
        $title_styles .= '--title-font-size-mobile: ' . esc_attr($title_size_mobile) . 'rem;';
    }
    $title_styles .= '"';
}

$whyus_items = get_field('whyus_items', 'option');

// Преобразуем ID изображения эмодзи в массив
$whyus_emoji_image = $whyus_emoji ? crb_get_image($whyus_emoji) : null;
?>
<div class="whyus" id="whyus">
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col">
                <div class="whyus__head">
                    <h2 class="whyus__title"<?php echo $title_styles; ?>>
                        <span class="whyus__title-first"><?php echo esc_html($whyus_title_first); ?></span>
                        <span><?php echo esc_html($whyus_title_second); ?></span>
                    </h2>
                </div>
            </div>
        </div>

        <div class="whyus__wrapp">
            <?php if ($whyus_items && is_array($whyus_items) && !empty($whyus_items)): ?>
                <?php 
                // Разбиваем элементы на группы для правильной разметки
                $items_count = count($whyus_items);
                $first_row_items = array_slice($whyus_items, 0, 2);
                $second_row_items = array_slice($whyus_items, 2);
                ?>
                <div class="row">
                    <div class="col-1"></div>
                    <?php if (isset($first_row_items[0])): ?>
                        <div class="col-2">
                            <div class="whyus__item">
                                <div class="content">
                                    <span class="num"><?php echo esc_html(isset($first_row_items[0]['number']) ? $first_row_items[0]['number'] : ''); ?></span>
                                    <span class="title"><?php echo esc_html(isset($first_row_items[0]['title']) ? $first_row_items[0]['title'] : ''); ?></span>
                                    <span class="description"><?php echo esc_html(isset($first_row_items[0]['description']) ? $first_row_items[0]['description'] : ''); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($first_row_items[1])): ?>
                        <div class="col-3-4">
                            <?php 
                            $item = $first_row_items[1];
                            $css_classes = !empty($item['css_classes']) ? esc_attr($item['css_classes']) : '';
                            $bg_image_id = isset($item['bg_image']) ? $item['bg_image'] : null;
                            $has_light = !empty($item['has_light']);
                            ?>
                            <div class="whyus__item <?php echo $css_classes; ?>">
                                <div class="content">
                                    <span class="num"><?php echo esc_html(isset($item['number']) ? $item['number'] : ''); ?></span>
                                    <span class="title"><?php echo esc_html(isset($item['title']) ? $item['title'] : ''); ?></span>
                                    <span class="description"><?php echo esc_html(isset($item['description']) ? $item['description'] : ''); ?></span>
                                </div>
                                <?php if ($has_light): ?>
                                    <div class="light">
                                        <div class="light-1">
                                            <div class="l1"></div>
                                            <div class="l2"></div>
                                            <div class="l3"></div>
                                        </div>
                                        <div class="light-2">
                                            <div class="l1"></div>
                                            <div class="l2"></div>
                                            <div class="l3"></div>
                                            <div class="l4"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row row-2">
                    <?php if (isset($second_row_items[0])): ?>
                        <div class="col-1">
                            <?php 
                            $item = $second_row_items[0];
                            $css_classes = !empty($item['css_classes']) ? esc_attr($item['css_classes']) : '';
                            $bg_image_id = isset($item['bg_image']) ? $item['bg_image'] : null;
                            $has_light = !empty($item['has_light']);
                            ?>
                            <div class="whyus__item <?php echo $css_classes; ?>">
                                <div class="content">
                                    <span class="num"><?php echo esc_html(isset($item['number']) ? $item['number'] : ''); ?></span>
                                    <span class="title"><?php echo esc_html(isset($item['title']) ? $item['title'] : ''); ?></span>
                                    <span class="description"><?php echo esc_html(isset($item['description']) ? $item['description'] : ''); ?></span>
                                </div>
                                <?php if ($has_light): ?>
                                    <div class="light">
                                        <div class="light-1">
                                            <div class="l1"></div>
                                            <div class="l2"></div>
                                            <div class="l3"></div>
                                        </div>
                                        <div class="light-2">
                                            <div class="l1"></div>
                                            <div class="l2"></div>
                                            <div class="l3"></div>
                                            <div class="l4"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-2"></div>
                    <?php if (isset($second_row_items[1])): ?>
                        <div class="col-3">
                            <div class="whyus__item">
                                <div class="content">
                                    <span class="num"><?php echo esc_html(isset($second_row_items[1]['number']) ? $second_row_items[1]['number'] : ''); ?></span>
                                    <span class="title"><?php echo esc_html(isset($second_row_items[1]['title']) ? $second_row_items[1]['title'] : ''); ?></span>
                                    <span class="description"><?php echo esc_html(isset($second_row_items[1]['description']) ? $second_row_items[1]['description'] : ''); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>