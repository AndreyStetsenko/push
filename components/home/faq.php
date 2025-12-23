<?php
// Получаем данные из Carbon Fields (через обертку get_field)
$faq_title = get_field('faq_title', 'option');
if (empty($faq_title)) {
    $faq_title = 'FAQ';
}

// Получаем папки FAQ через Carbon Fields
// Функция get_field() автоматически добавляет префикс языка, поэтому не добавляем его вручную
$faq_folders = get_field('faq_folders', 'option');
if (!is_array($faq_folders)) {
    $faq_folders = array();
}

// Carbon Fields для complex/repeater полей возвращает массив массивов
// Фильтруем пустые элементы (где нет названия и это не секция контактов)
if (is_array($faq_folders) && !empty($faq_folders)) {
    $filtered_folders = array();
    foreach ($faq_folders as $folder) {
        if (!is_array($folder) && !is_object($folder)) {
            continue;
        }
        // Преобразуем объект в массив если нужно
        if (is_object($folder)) {
            $folder = (array) $folder;
        }
        // Проверяем наличие названия (не пустая строка, не пробелы)
        $title = isset($folder['title']) ? trim($folder['title']) : '';
        $has_title = !empty($title);
        // Проверяем флаг контактов (Carbon Fields может вернуть 'yes', true, 1 или массив)
        $is_contacts = false;
        if (isset($folder['is_contacts'])) {
            $contacts_value = $folder['is_contacts'];
            if (is_array($contacts_value)) {
                $is_contacts = !empty($contacts_value) && (in_array('yes', $contacts_value) || in_array(true, $contacts_value, true) || in_array(1, $contacts_value, true));
            } else {
                // Carbon Fields checkbox с set_option_value('yes') возвращает 'yes' при активации
                $is_contacts = ($contacts_value === 'yes' || $contacts_value === true || $contacts_value === 1 || $contacts_value === '1');
            }
        }
        // Добавляем только если есть название (для обычных папок) или это секция контактов
        if ($has_title || $is_contacts) {
            $filtered_folders[] = $folder;
        }
    }
    $faq_folders = $filtered_folders;
}

// SVG иконка для вопросов
$question_icon = '<svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
</svg>';

// SVG иконка для кнопок контактов
$button_icon = '<svg class="contacts__button-icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"></path>
</svg>';

// SVG иконки для контактов
$telegram_icon = '<svg class="contacts__button-icon" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_16_1286)">
    <path d="M33.8292 3.26628L1.21006 15.91C-0.102596 16.4988 -0.546572 17.6779 0.892789 18.3179L9.26101 20.991L29.4943 8.42176C30.5991 7.63269 31.7301 7.8431 30.7569 8.71113L13.3792 24.5268L12.8333 31.2199C13.3389 32.2533 14.2647 32.2582 14.8552 31.7445L19.663 27.1718L27.8971 33.3695C29.8096 34.5076 30.8502 33.7732 31.2617 31.6873L36.6625 5.98141C37.2233 3.41384 36.267 2.28254 33.8292 3.26628Z" fill="white"/>
    </g>
    <defs>
    <clipPath id="clip0_16_1286">
    <rect width="36.8182" height="36.8182" fill="white"/>
    </clipPath>
    </defs>
</svg>';

$email_icon = '<svg class="contacts__button-icon" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M32.5 4H4.5C2.575 4 1.0175 5.575 1.0175 7.5L1 28.5C1 30.425 2.575 32 4.5 32H32.5C34.425 32 36 30.425 36 28.5V7.5C36 5.575 34.425 4 32.5 4ZM31.8 11.4375L19.4275 19.1725C18.8675 19.5225 18.1325 19.5225 17.5725 19.1725L5.2 11.4375C5.02452 11.339 4.87086 11.2059 4.74831 11.0463C4.62575 10.8867 4.53686 10.7039 4.48701 10.5089C4.43716 10.3139 4.42738 10.1109 4.45827 9.91204C4.48917 9.71319 4.56009 9.52267 4.66674 9.35203C4.7734 9.18138 4.91357 9.03415 5.07877 8.91924C5.24397 8.80434 5.43077 8.72414 5.62787 8.68352C5.82496 8.6429 6.02825 8.64269 6.22542 8.68291C6.4226 8.72313 6.60956 8.80293 6.775 8.9175L18.5 16.25L30.225 8.9175C30.3904 8.80293 30.5774 8.72313 30.7746 8.68291C30.9718 8.64269 31.175 8.6429 31.3721 8.68352C31.5692 8.72414 31.756 8.80434 31.9212 8.91924C32.0864 9.03415 32.2266 9.18138 32.3333 9.35203C32.4399 9.52267 32.5108 9.71319 32.5417 9.91204C32.5726 10.1109 32.5628 10.3139 32.513 10.5089C32.4631 10.7039 32.3743 10.8867 32.2517 11.0463C32.1291 11.2059 31.9755 11.339 31.8 11.4375Z" fill="white"/>
</svg>';

$phone_icon = '<svg class="contacts__button-icon" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M28.1518 34.558C26.7465 34.558 24.7724 34.0497 21.8162 32.3981C18.2215 30.3823 15.441 28.5212 11.8657 24.9552C8.41857 21.5103 6.74107 19.2798 4.3933 15.0076C1.74099 10.1839 2.19312 7.65545 2.69853 6.57479C3.30041 5.28319 4.18883 4.51068 5.33716 3.74393C5.9894 3.31659 6.67964 2.95026 7.39911 2.6496C7.47111 2.61864 7.53806 2.58912 7.59782 2.56248C7.9542 2.40193 8.49416 2.15931 9.17812 2.41849C9.63457 2.58984 10.0421 2.94046 10.6799 3.57042C11.9881 4.86058 13.7758 7.73392 14.4352 9.14503C14.878 10.0961 15.171 10.7239 15.1717 11.428C15.1717 12.2524 14.7571 12.8881 14.2538 13.5742C14.1595 13.7031 14.0659 13.8262 13.9752 13.9457C13.4273 14.6656 13.3071 14.8737 13.3863 15.2452C13.5468 15.9918 14.7441 18.2143 16.7117 20.1776C18.6794 22.1409 20.8378 23.2626 21.5873 23.4225C21.9746 23.5053 22.187 23.38 22.93 22.8127C23.0365 22.7313 23.146 22.6471 23.2604 22.5628C24.0279 21.9919 24.6341 21.588 25.439 21.588H25.4433C26.1439 21.588 26.7436 21.8918 27.7371 22.3929C29.033 23.0466 31.9928 24.8113 33.2909 26.1209C33.9223 26.7573 34.2743 27.1633 34.4464 27.6191C34.7056 28.3052 34.4615 28.843 34.3024 29.203C34.2758 29.2627 34.2462 29.3283 34.2153 29.401C33.9122 30.1192 33.5437 30.8079 33.1145 31.4586C32.3492 32.6033 31.5738 33.4896 30.2793 34.0922C29.6146 34.4067 28.8871 34.5659 28.1518 34.558Z" fill="white"/>
</svg>';

// Функция для получения URL изображения
function get_faq_image_url($image_id) {
    if (empty($image_id)) {
        return '';
    }
    return crb_get_image_url($image_id);
}

// Функция для получения иконки контакта по названию
function get_contact_icon($name) {
    global $telegram_icon, $email_icon, $phone_icon;
    $name_lower = strtolower($name);
    if (strpos($name_lower, 'telegram') !== false) {
        return $telegram_icon;
    } elseif (strpos($name_lower, 'email') !== false || strpos($name_lower, 'mail') !== false) {
        return $email_icon;
    } elseif (strpos($name_lower, 'телефон') !== false || strpos($name_lower, 'phone') !== false) {
        return $phone_icon;
    }
    return '';
}
?>

<div id="faq" class="faq">
    <div class="container">
        <span class="faq__title"><?php echo esc_html($faq_title); ?></span>
    </div>

    <div class="faq__folders accordion">
        <?php if (!empty($faq_folders) && is_array($faq_folders)): ?>
            <?php 
            // Нормализуем массив для получения числовых индексов (после фильтрации выше)
            $faq_folders = array_values($faq_folders);
            $folder_counter = 0;
            ?>
            <?php foreach ($faq_folders as $folder): ?>
                <?php
                // Преобразуем объект в массив если нужно
                if (is_object($folder)) {
                    $folder = (array) $folder;
                }
                
                $folder_counter++;
                $folder_index = $folder_counter;
                $folder_title = isset($folder['title']) ? $folder['title'] : '';
                $folder_color = isset($folder['color']) ? $folder['color'] : 'black';
                $tab_max_width_mobile = isset($folder['tab_max_width_mobile']) ? trim($folder['tab_max_width_mobile']) : '';
                $image_type = isset($folder['image_type']) ? $folder['image_type'] : 'single';
                // Проверяем флаг контактов (ACF может вернуть массив, строку 'yes' или true)
                $is_contacts = false;
                if (isset($folder['is_contacts'])) {
                    $contacts_value = $folder['is_contacts'];
                    if (is_array($contacts_value)) {
                        $is_contacts = !empty($contacts_value) && (in_array('yes', $contacts_value) || in_array(true, $contacts_value, true));
                    } else {
                        $is_contacts = ($contacts_value === 'yes' || $contacts_value === true || $contacts_value === 1);
                    }
                }
                $questions = isset($folder['questions']) && is_array($folder['questions']) ? $folder['questions'] : array();
                ?>
                
                <div class="folder folder--<?php echo esc_attr($folder_color); ?> folder--<?php echo esc_attr($folder_index); ?>">
                    <input type="checkbox" name="faq-accordion" id="faq-<?php echo esc_attr($folder_index); ?>" class="folder__input">
                    <label for="faq-<?php echo esc_attr($folder_index); ?>" class="folder__tab"<?php if (!empty($tab_max_width_mobile)): ?> style="--tab-max-width-mobile: <?php echo esc_attr($tab_max_width_mobile); ?>;"<?php endif; ?>>
                        <span class="title"><?php echo esc_html($folder_title); ?></span>
                    </label>
                    <div class="temp"></div>
                    <div class="folder__content <?php if ($is_contacts): ?>folder__content--contacts<?php endif; ?>">
                        <?php if ($is_contacts): ?>
                            <?php
                            // Секция контактов - данные теперь внутри самой папки
                            $contacts_title = isset($folder['contacts_title']) ? $folder['contacts_title'] : 'контакти';
                            $contacts_description = isset($folder['contacts_description']) ? $folder['contacts_description'] : '';
                            $contacts_buttons = isset($folder['contacts_buttons']) && is_array($folder['contacts_buttons']) ? $folder['contacts_buttons'] : array();
                            $contacts_items = isset($folder['contacts_items']) && is_array($folder['contacts_items']) ? $folder['contacts_items'] : array();
                            ?>
                            <div class="container" id="faq-contacts">
                                <div class="folder__content--wrapp">
                                    <div class="contacts">
                                        <div class="contacts__wrapp">
                                            <div class="contacts__left">
                                                <div class="contacts__info">
                                                    <h3 class="contacts__title"><?php echo esc_html($contacts_title); ?></h3>
                                                    <?php if (!empty($contacts_description)): ?>
                                                        <p class="contacts__description"><?php echo esc_html($contacts_description); ?></p>
                                                    <?php endif; ?>

                                                    <?php if (!empty($contacts_buttons)): ?>
                                                        <div class="contacts__actions">
                                                            <?php foreach ($contacts_buttons as $button): ?>
                                                                <?php
                                                                // Преобразуем объект в массив если нужно
                                                                if (is_object($button)) {
                                                                    $button = (array) $button;
                                                                }
                                                                $button_text = isset($button['text']) ? $button['text'] : '';
                                                                $button_link = isset($button['link']) ? $button['link'] : '#';
                                                                ?>
                                                                <button class="contacts__button" onclick="window.location.href='<?php echo esc_url($button_link); ?>'">
                                                                    <span><?php echo esc_html($button_text); ?></span>
                                                                    <div class="contacts__button-icon-wrapp">
                                                                        <?php echo $button_icon; ?>
                                                                    </div>
                                                                </button>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="contacts__right">
                                                <?php if (!empty($contacts_items)): ?>
                                                    <div class="contacts__contacts">
                                                        <?php foreach ($contacts_items as $contact): ?>
                                                            <?php
                                                            // Преобразуем объект в массив если нужно
                                                            if (is_object($contact)) {
                                                                $contact = (array) $contact;
                                                            }
                                                            $contact_name = isset($contact['name']) ? $contact['name'] : '';
                                                            $contact_value = isset($contact['contact_value']) ? $contact['contact_value'] : '';
                                                            $contact_icon_image = isset($contact['icon']) ? $contact['icon'] : null;
                                                            
                                                            // Если есть загруженное изображение, используем его, иначе используем SVG иконку по умолчанию
                                                            $has_custom_icon = false;
                                                            $custom_icon_url = '';
                                                            if (!empty($contact_icon_image)) {
                                                                $icon_data = crb_get_image($contact_icon_image);
                                                                if ($icon_data && isset($icon_data['url'])) {
                                                                    $has_custom_icon = true;
                                                                    $custom_icon_url = $icon_data['url'];
                                                                }
                                                            }
                                                            
                                                            if (!$has_custom_icon) {
                                                                $contact_icon = get_contact_icon($contact_name);
                                                            }
                                                            ?>
                                                            <button class="contacts__button">
                                                                <div class="info">
                                                                    <span class="name"><?php echo esc_html($contact_name); ?></span>
                                                                    <span class="sub"><?php echo esc_html($contact_value); ?></span>
                                                                </div>
                                                                <div class="contacts__button-icon-wrapp">
                                                                    <?php if ($has_custom_icon): ?>
                                                                        <img src="<?php echo esc_url($custom_icon_url); ?>" alt="<?php echo esc_attr($contact_name); ?>" class="contacts__button-icon-img">
                                                                    <?php else: ?>
                                                                        <?php echo $contact_icon; ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </button>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php
                            // Обычная папка с вопросами
                            $image_url = '';
                            if ($image_type === 'single' && !empty($folder['image'])) {
                                $image_url = get_faq_image_url($folder['image']);
                            }
                            ?>
                            <?php if ($image_type !== 'none'): ?>
                                <div class="folder__content--image">
                                    <?php if ($image_type === 'socials'): ?>
                                        <div class="socials">
                                            <?php if (!empty($folder['social_fb'])): ?>
                                                <img src="<?php echo esc_url(get_faq_image_url($folder['social_fb'])); ?>" alt="Facebook">
                                            <?php endif; ?>
                                            <?php if (!empty($folder['social_tt'])): ?>
                                                <img src="<?php echo esc_url(get_faq_image_url($folder['social_tt'])); ?>" alt="TikTok">
                                            <?php endif; ?>
                                            <?php if (!empty($folder['social_inst'])): ?>
                                                <img src="<?php echo esc_url(get_faq_image_url($folder['social_inst'])); ?>" alt="Instagram">
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif (!empty($image_url)): ?>
                                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($folder_title); ?>">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="container">
                                <div class="folder__content--wrapp">
                                    <?php if (!empty($questions) && is_array($questions)): ?>
                                        <?php foreach ($questions as $key => $question): ?>
                                            <?php
                                            // Преобразуем объект в массив если нужно
                                            if (is_object($question)) {
                                                $question = (array) $question;
                                            }
                                            $question_number = $key + 1;
                                            $question_text = isset($question['text']) ? $question['text'] : '';
                                            $question_answer = isset($question['answer']) ? $question['answer'] : '';
                                            ?>
                                            <div class="item">
                                                <div class="item__content">
                                                    <span><?php echo esc_html($question_number . '/' . $question_text); ?></span>
                                                    <p><?php echo esc_html($question_answer); ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <?php
            // Fallback: статический контент по умолчанию, если поля не заполнены
            // Это можно оставить для обратной совместимости или удалить
            ?>
        <?php endif; ?>
    </div>
</div>
