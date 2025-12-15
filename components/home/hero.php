<?php
// Получаем данные из Carbon Fields (через функцию-хелпер для совместимости)
$hero_title_group = get_field('hero_title_group', 'option');
$hero_title_line1 = $hero_title_group && isset($hero_title_group['line1']) ? $hero_title_group['line1'] : '';
$hero_title_line2 = $hero_title_group && isset($hero_title_group['line2']) ? $hero_title_group['line2'] : '';
$hero_title_size = $hero_title_group && isset($hero_title_group['size']) ? $hero_title_group['size'] : '';

// Новые поля для размера текста и line height
$hero_title_size_desktop = $hero_title_group && isset($hero_title_group['size_desktop']) ? $hero_title_group['size_desktop'] : '';
$hero_title_line_height_desktop = $hero_title_group && isset($hero_title_group['line_height_desktop']) ? $hero_title_group['line_height_desktop'] : '';
$hero_title_size_mobile = $hero_title_group && isset($hero_title_group['size_mobile']) ? $hero_title_group['size_mobile'] : '';
$hero_title_line_height_mobile = $hero_title_group && isset($hero_title_group['line_height_mobile']) ? $hero_title_group['line_height_mobile'] : '';

$hero_description = get_field('hero_description', 'option') ?: '';

$hero_button_group = get_field('hero_button_group', 'option');
$hero_button_text = $hero_button_group && isset($hero_button_group['text']) ? $hero_button_group['text'] : '';
$hero_button_link = $hero_button_group && isset($hero_button_group['link']) ? $hero_button_group['link'] : '#';
$hero_button_target = $hero_button_group && isset($hero_button_group['target']) ? $hero_button_group['target'] : '_self';

$hero_push_image = get_field('hero_push_image', 'option');
$hero_bg_items = get_field('hero_bg_items', 'option');

// Формируем стили для заголовка, если заданы значения
$hero_title_styles = '';
if ($hero_title_size_desktop || $hero_title_line_height_desktop || $hero_title_size_mobile || $hero_title_line_height_mobile) {
    $hero_title_styles = '<style>';
    $hero_title_styles .= '#hero .hero__title .span {';
    
    // Стили для десктопа (по умолчанию)
    if ($hero_title_size_desktop) {
        $hero_title_styles .= 'font-size: ' . esc_attr($hero_title_size_desktop) . 'rem;';
    }
    if ($hero_title_line_height_desktop) {
        $hero_title_styles .= 'line-height: ' . esc_attr($hero_title_line_height_desktop) . ';';
    }
    
    $hero_title_styles .= '}';
    
    // Стили для мобильных устройств
    if ($hero_title_size_mobile || $hero_title_line_height_mobile) {
        $hero_title_styles .= '@media (max-width: 767.98px) {';
        $hero_title_styles .= '#hero .hero__title .span {';
        if ($hero_title_size_mobile) {
            $hero_title_styles .= 'font-size: ' . esc_attr($hero_title_size_mobile) . 'rem;';
        }
        if ($hero_title_line_height_mobile) {
            $hero_title_styles .= 'line-height: ' . esc_attr($hero_title_line_height_mobile) . ';';
        }
        $hero_title_styles .= '}';
        $hero_title_styles .= '}';
    }
    
    $hero_title_styles .= '</style>';
}
?>
<?php echo $hero_title_styles; ?>
<div class="hero" id="hero">
    <div class="container" style="z-index: 2">
        <div class="row">
            <div class="col-1"></div>
            <div class="col">
                <div class="hero__content">
                    <div class="hero__title">
                        <div class="span"><?php echo esc_html($hero_title_line1); ?></div>
                        <div class="span"><?php echo esc_html($hero_title_line2); ?></div>
                    </div>

                    <div class="hero__wrapp">
                        <span class="hero__description">
                            <?php echo esc_html($hero_description); ?>
                        </span>

                        <div class="hero__button">
                            <a href="<?php echo esc_url($hero_button_link); ?>" class="hero__button-link" target="<?php echo esc_attr($hero_button_target); ?>">
                                <span><?php echo esc_html($hero_button_text); ?></span>
                                <div class="hero__button-icon-wrapp">
                                    <svg class="hero__button-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <div class="hero__wrapp-push">
                            <?php if ($hero_push_image): ?>
                                <?php 
                                $push_image = crb_get_image($hero_push_image);
                                if ($push_image && isset($push_image['url'])): ?>
                                    <?php echo push_optimized_image($push_image, 'full', array(
                                        'loading' => 'eager',
                                        'fetchpriority' => 'high',
                                        'class' => ''
                                    )); ?>
                                <?php else: ?>
                                    <img src="<?= img_url('hero/push.png'); ?>" alt="push" loading="eager" fetchpriority="high" decoding="async">
                                <?php endif; ?>
                            <?php else: ?>
                                <img src="<?= img_url('hero/push.png'); ?>" alt="push" loading="eager" fetchpriority="high" decoding="async">
                            <?php endif; ?>

                            <div class="hero__wrapp-push-shadow">
                                <div class="hero__wrapp-push-shadow-circle"></div>
                                <div class="hero__wrapp-push-shadow-circle"></div>
                                <div class="hero__wrapp-push-shadow-circle"></div>
                                <div class="hero__wrapp-push-shadow-circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hero__bg">
        <?php if ($hero_bg_items && is_array($hero_bg_items)): ?>
            <?php foreach ($hero_bg_items as $item): ?>
                <?php 
                $item_image = isset($item['image']) ? $item['image'] : null;
                $item_class = isset($item['css_class']) ? $item['css_class'] : '';
                $item_alt = isset($item['alt']) ? $item['alt'] : '';
                $shadows_count = intval(isset($item['shadows_count']) ? $item['shadows_count'] : 0);
                ?>
                <?php if ($item_image): ?>
                    <?php 
                    $item_image_data = crb_get_image($item_image);
                    if ($item_image_data && isset($item_image_data['url'])): ?>
                        <div class="item <?php echo esc_attr($item_class); ?>">
                            <?php echo push_optimized_image($item_image_data, 'full', array(
                                'loading' => 'lazy',
                                'fetchpriority' => 'auto'
                            )); ?>
                        
                        <?php if ($shadows_count > 0): ?>
                            <div class="item-shadow">
                                <?php for ($i = 0; $i < $shadows_count; $i++): ?>
                                    <div class="item-shadow__item"></div>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback к статическому контенту, если поля не заполнены -->
            <div class="item item-inst">
                <img src="<?= img_url('hero/btn-inst.png'); ?>" alt="inst" loading="lazy" decoding="async">
            </div>
            <div class="item item-fb">
                <img src="<?= img_url('hero/btn-fb.png'); ?>" alt="fb" loading="lazy" decoding="async">
            </div>
            <div class="item item-tiktok">
                <img src="<?= img_url('hero/btn-tiktok.png'); ?>" alt="tiktok" loading="lazy" decoding="async">
                <div class="item-shadow">
                    <div class="item-shadow__item"></div>
                </div>
            </div>
            <div class="item item-reddit">
                <img src="<?= img_url('hero/btn-reddit.png'); ?>" alt="reddit" loading="lazy" decoding="async">
                <div class="item-shadow">
                    <div class="item-shadow__item"></div>
                    <div class="item-shadow__item"></div>
                </div>
            </div>
            <div class="item item-twitter">
                <img src="<?= img_url('hero/btn-twitter.png'); ?>" alt="twitter" loading="lazy" decoding="async">
            </div>
            <div class="item item-link">
                <img src="<?= img_url('hero/btn-link.png'); ?>" alt="link" loading="lazy" decoding="async">
            </div>
            <div class="item item-youtube">
                <img src="<?= img_url('hero/btn-youtube.png'); ?>" alt="youtube" loading="lazy" decoding="async">
                <div class="item-shadow">
                    <div class="item-shadow__item"></div>
                    <div class="item-shadow__item"></div>
                    <div class="item-shadow__item"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>