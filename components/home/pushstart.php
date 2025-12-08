<?php
// Получаем данные из Carbon Fields для Push Start секции
$pushstart_cursor_image_id = get_field('pushstart_cursor_image', 'option');
$pushstart_title_group = get_field('pushstart_title_group', 'option');
$pushstart_title_line1 = $pushstart_title_group && isset($pushstart_title_group['line1']) ? $pushstart_title_group['line1'] : '';
$pushstart_title_line2 = $pushstart_title_group && isset($pushstart_title_group['line2']) ? $pushstart_title_group['line2'] : '';
$pushstart_description = get_field('pushstart_description', 'option') ?: '';
$pushstart_form_group = get_field('pushstart_form_group', 'option');
$pushstart_name_placeholder = $pushstart_form_group && isset($pushstart_form_group['name_placeholder']) ? $pushstart_form_group['name_placeholder'] : '';
$pushstart_phone_placeholder = $pushstart_form_group && isset($pushstart_form_group['phone_placeholder']) ? $pushstart_form_group['phone_placeholder'] : '';
$pushstart_button_text = $pushstart_form_group && isset($pushstart_form_group['button_text']) ? $pushstart_form_group['button_text'] : '';
$pushstart_form_action = $pushstart_form_group && isset($pushstart_form_group['form_action']) ? $pushstart_form_group['form_action'] : '';
$pushstart_social_link = get_field('pushstart_social_link', 'option') ?: '#';

// Преобразуем ID изображения курсора в массив и определяем URL
$pushstart_cursor_image = $pushstart_cursor_image_id ? crb_get_image($pushstart_cursor_image_id) : null;
$cursor_url = '';
if ($pushstart_cursor_image && isset($pushstart_cursor_image['url'])) {
    $cursor_url = $pushstart_cursor_image['url'];
} else {
    $cursor_url = img_url('icons/cursor.png');
}
?>
<div id="pushstart" class="pushstart">
    <div class="container">
        <div class="pushstart__wrapp">
            <div class="pushstart__cursors">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-1">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-2">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-3">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-4">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-5">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-6">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-7">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-8">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-9">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-10">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-11">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-12">
                <img src="<?php echo esc_url($cursor_url); ?>" alt="cursor" class="cursor cursor-13">
            </div>
            <div class="content">
                <div class="title">
                    <span><?php echo esc_html($pushstart_title_line1); ?></span>
                    <span><?php echo esc_html($pushstart_title_line2); ?></span>
                </div>

                <p class="description"><?php echo esc_html($pushstart_description); ?></p>

                <form action="<?php echo esc_attr($pushstart_form_action); ?>">
                    <div class="form">
                        <input type="text" placeholder="<?php echo esc_attr($pushstart_name_placeholder); ?>">
                        <input type="text" placeholder="<?php echo esc_attr($pushstart_phone_placeholder); ?>">
                        <div class="buttons">
                            <button class="send">
                                <?php echo esc_html($pushstart_button_text); ?>

                                <div class="icon-wrap">
                                    <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"></path>
                                    </svg>
                                </div>
                            </button>
                            <a href="<?php echo esc_url($pushstart_social_link); ?>" class="social">
                                <svg class="icon" viewBox="0 0 37 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M33.8208 8.18363L29.1496 30.6432C28.8012 32.225 27.907 32.5812 26.6151 31.8671L19.6082 26.5598L16.178 29.9275C15.8311 30.2854 15.4827 30.6432 14.6872 30.6432L15.2345 23.2411L28.3048 11.0431C28.8505 10.481 28.1552 10.2768 27.4599 10.7375L11.2092 21.2509L4.2008 19.0564C2.66068 18.5465 2.66068 17.473 4.54922 16.7605L31.7828 5.8878C33.124 5.4793 34.2679 6.19496 33.8208 8.18363Z" fill="white"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>