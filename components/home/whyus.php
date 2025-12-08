<?php
// Получаем данные из ACF полей для Why Us секции
$whyus_emoji = get_field('whyus_emoji', 'option');
$whyus_title_group = get_field('whyus_title_group', 'option');
$whyus_title_first = $whyus_title_group && isset($whyus_title_group['first']) ? $whyus_title_group['first'] : '';
$whyus_title_second = $whyus_title_group && isset($whyus_title_group['second']) ? $whyus_title_group['second'] : '';
$whyus_items = get_field('whyus_items', 'option');
?>
<div class="whyus" id="whyus">
    <div class="container">
        <div class="row">
            <div class="col-1">
                <div class="whyus__emoji-wrapp" style="display: none;">
                    <?php if ($whyus_emoji && isset($whyus_emoji['url'])): ?>
                        <img src="<?php echo esc_url($whyus_emoji['url']); ?>" alt="<?php echo esc_attr($whyus_emoji['alt'] ?: 'emoji'); ?>" class="whyus__emoji">
                    <?php else: ?>
                        <img src="<?= img_url('whyus/blckbtn.png'); ?>" alt="emoji" class="whyus__emoji">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col">
                <div class="whyus__head">
                    <div class="whyus__emoji-wrapp">
                        <?php if ($whyus_emoji && isset($whyus_emoji['url'])): ?>
                            <img src="<?php echo esc_url($whyus_emoji['url']); ?>" alt="<?php echo esc_attr($whyus_emoji['alt'] ?: 'emoji'); ?>" class="whyus__emoji mob">
                        <?php else: ?>
                            <img src="<?= img_url('whyus/blckbtn.png'); ?>" alt="emoji" class="whyus__emoji mob">
                        <?php endif; ?>
                    </div>
                    <h2 class="whyus__title">
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
                            $bg_image = isset($item['bg_image']) ? $item['bg_image'] : null;
                            $has_light = !empty($item['has_light']);
                            $bg_style = '';
                            if ($bg_image && isset($bg_image['url'])) {
                                $bg_style = 'style="background-image: url(\'' . esc_url($bg_image['url']) . '\');"';
                            } elseif (!$bg_image) {
                                // Fallback к дефолтному изображению, если есть классы
                                if (!empty($css_classes)) {
                                    $bg_style = 'style="background-image: url(\'' . img_url('bg/bg-whyus-item.png') . '\');"';
                                }
                            }
                            ?>
                            <div class="whyus__item <?php echo $css_classes; ?>">
                                <div class="content" <?php echo $bg_style; ?>>
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
                            $bg_image = isset($item['bg_image']) ? $item['bg_image'] : null;
                            $has_light = !empty($item['has_light']);
                            $bg_style = '';
                            if ($bg_image && isset($bg_image['url'])) {
                                $bg_style = 'style="background-image: url(\'' . esc_url($bg_image['url']) . '\');"';
                            } elseif (!$bg_image) {
                                // Fallback к дефолтному изображению, если есть классы
                                if (!empty($css_classes)) {
                                    $bg_style = 'style="background-image: url(\'' . img_url('bg/bg-whyus-item2.png') . '\');"';
                                }
                            }
                            ?>
                            <div class="whyus__item <?php echo $css_classes; ?>">
                                <div class="content" <?php echo $bg_style; ?>>
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