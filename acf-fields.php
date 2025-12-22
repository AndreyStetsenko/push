<?php
/**
 * Регистрация Carbon Fields для темы Push
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Функция для добавления префикса мультиязычности к именам полей
 * @return string Префикс языка (например: '_ru', '_en') или пустая строка
 */
function carbon_lang_prefix() {
    $prefix = '';
    if ( ! defined( 'ICL_LANGUAGE_CODE' ) ) {
        return $prefix;
    }
    $prefix = '_' . ICL_LANGUAGE_CODE;
    return $prefix;
}

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {

    // Список всех подстраниц опций
    $subpages = array(
        array( 'title' => 'Header - Шапка сайта', 'slug' => 'header.php' ),
        array( 'title' => 'Hero Section - Главная секция', 'slug' => 'hero_section.php' ),
        array( 'title' => 'Services Section - Секция услуг', 'slug' => 'services_section.php' ),
        array( 'title' => 'Why Us Section - Секция "Почему мы"', 'slug' => 'why_us_section.php' ),
        array( 'title' => 'Push Start Section - Секция формы', 'slug' => 'push_start_section.php' ),
        array( 'title' => 'Cases Section - Секция кейсов', 'slug' => 'cases_section.php' ),
        array( 'title' => 'Actors Section - Секция актеров', 'slug' => 'actors_section.php' ),
        array( 'title' => 'Collab Section - Секция этапов сотрудничества', 'slug' => 'collab_section.php' ),
        array( 'title' => 'FAQ Section - Секция FAQ', 'slug' => 'faq_section_-_faq.php' ),
        array( 'title' => 'Bonus Section - Секция бонуса', 'slug' => 'bonus_section.php' ),
        array( 'title' => 'Footer Form Section - Секция формы в футере', 'slug' => 'footer_form_section.php' ),
    );
    
    // Формируем HTML с ссылками
    $nav_html = '<div style="padding: 20px; background: #f5f5f5; border-radius: 4px; margin-bottom: 20px;">
        <h3 style="margin-top: 0; margin-bottom: 15px;">Быстрая навигация по разделам настроек:</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px;">';
    
    foreach ( $subpages as $subpage ) {
        $page_url = admin_url( 'admin.php?page=crb_carbon_fields_container_' . $subpage['slug'] );
        $nav_html .= '<a href="' . esc_url( $page_url ) . '" style="display: block; padding: 12px 16px; background: #fff; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #2271b1; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onmouseover="this.style.background=\'#2271b1\'; this.style.color=\'#fff\'; this.style.borderColor=\'#2271b1\';" onmouseout="this.style.background=\'#fff\'; this.style.color=\'#2271b1\'; this.style.borderColor=\'#ddd\';">📄 ' . esc_html( $subpage['title'] ) . '</a>';
    }
    
    $nav_html .= '</div>
        <p style="margin-top: 15px; margin-bottom: 0; color: #666; font-size: 13px;">Нажмите на любую ссылку выше, чтобы перейти к настройкам соответствующего раздела.</p>
    </div>';
    
    $options = Container::make( 'theme_options', 'Опции' )
        ->set_icon( 'dashicons-palmtree' )
        ->add_fields( array(
            Field::make( 'html', 'crb_options_navigation', __( 'Навигация по разделам' ) )
                ->set_html( $nav_html ),
        ) );

    // Header - Шапка сайта
    Container::make( 'theme_options', __( 'Header - Шапка сайта' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( -1 )
        ->add_fields( array(
            Field::make( 'image', 'header_logo' . carbon_lang_prefix(), __( 'Логотип' ) )
                ->set_help_text( 'Загрузите логотип для шапки сайта. Если не указано, будет использован текст "Push".' ),
            // Кнопка контактов
            Field::make( 'complex', 'header_contacts_button' . carbon_lang_prefix(), __( 'Кнопка контактов' ) )
                ->set_help_text( 'Настройки кнопки "Контакти" в шапке сайта' )
                ->set_layout( 'tabbed-vertical' )
                ->set_max( 1 )
                ->add_fields( array(
                    Field::make( 'text', 'text', __( 'Текст кнопки' ) )
                        ->set_help_text( 'Текст на кнопке контактов' )
                        ->set_default_value( 'Контакти' )
                        ->set_attribute( 'placeholder', 'Контакти' )
                        ->set_required( true ),
                    Field::make( 'text', 'link', __( 'Ссылка' ) )
                        ->set_help_text( 'URL ссылки кнопки (например: #contacts, /contacts или полный URL)' )
                        ->set_default_value( '#' )
                        ->set_attribute( 'placeholder', '#' )
                        ->set_required( true ),
                    Field::make( 'select', 'target', __( 'Целевая ссылка' ) )
                        ->set_help_text( 'Куда откроется ссылка (сайт, новое окно)' )
                        ->set_options( array(
                            '_self' => 'На текущей странице',
                            '_blank' => 'В новом окне',
                        ) )
                        ->set_default_value( '_self' )
                        ->set_required( true ),
                ) ),
        ) );

    // Hero Section - Главная секция
    Container::make( 'theme_options', __( 'Hero Section - Главная секция' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( 0 )
        ->add_fields( array(
        // Группа: Заголовок
            Field::make( 'complex', 'hero_title_group' . carbon_lang_prefix(), __( 'Заголовок' ) )
                ->set_help_text( 'Настройки заголовка hero секции' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'line1', __( 'Первая строка' ) )
                        ->set_help_text( 'Первая строка заголовка (например: "Стильний")' )
                        ->set_default_value( 'Стильний' )
                        ->set_attribute( 'placeholder', 'Стильний' ),
                    Field::make( 'text', 'line2', __( 'Вторая строка' ) )
                        ->set_help_text( 'Вторая строка заголовка (например: "SMM для тебе")' )
                        ->set_default_value( 'SMM для тебе' )
                        ->set_attribute( 'placeholder', 'SMM для тебе' ),
                    Field::make( 'separator', 'hero_title_desktop_sep', __( 'Настройки для ПК' ) ),
                    Field::make( 'text', 'size_desktop', __( 'Размер текста (ПК)' ) )
                        ->set_help_text( 'Размер текста для десктопных устройств в rem (например: "7.5")' )
                        ->set_default_value( '7.5' )
                        ->set_attribute( 'placeholder', '7.5' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.1' ),
                    Field::make( 'text', 'line_height_desktop', __( 'Line Height (ПК)' ) )
                        ->set_help_text( 'Высота строки для десктопных устройств (например: "1.06" или "106%")' )
                        ->set_default_value( '1.06' )
                        ->set_attribute( 'placeholder', '1.06' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.01' ),
                    Field::make( 'separator', 'hero_title_mobile_sep', __( 'Настройки для мобильных' ) ),
                    Field::make( 'text', 'size_mobile', __( 'Размер текста (Мобильные)' ) )
                        ->set_help_text( 'Размер текста для мобильных устройств в rem (например: "2.1875")' )
                        ->set_default_value( '2.1875' )
                        ->set_attribute( 'placeholder', '2.1875' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.1' ),
                    Field::make( 'text', 'line_height_mobile', __( 'Line Height (Мобильные)' ) )
                        ->set_help_text( 'Высота строки для мобильных устройств (например: "1.06" или "106%")' )
                        ->set_default_value( '1.06' )
                        ->set_attribute( 'placeholder', '1.06' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.01' ),
                ) ),
        // Описание
            Field::make( 'textarea', 'hero_description' . carbon_lang_prefix(), __( 'Описание' ) )
                ->set_help_text( 'Текст описания в hero секции' )
                ->set_default_value( 'Ми – Push Agency, креативне агентство для соцмереж, яке поєднує системний підхід і нестандартні ідеї. Тут ти знайдеш сучасний дизайн, зрозумілу навігацію і рішення, які реально працюють.' )
                ->set_rows( 4 ),
        // Группа: Кнопка
            Field::make( 'complex', 'hero_button_group' . carbon_lang_prefix(), __( 'Кнопка' ) )
                ->set_help_text( 'Настройки кнопки в hero секции' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'text', __( 'Текст кнопки' ) )
                        ->set_help_text( 'Текст на кнопке' )
                        ->set_default_value( 'Зв\'язатись з нами' )
                        ->set_attribute( 'placeholder', 'Зв\'язатись з нами' )
                        ->set_required( true ),
                    Field::make( 'text', 'link', __( 'Ссылка' ) )
                        ->set_help_text( 'URL ссылки кнопки' )
                        ->set_default_value( '#' )
                        ->set_attribute( 'placeholder', '#' )
                        ->set_required( true ),
                    Field::make( 'select', 'target', __( 'Целевая ссылка' ) )
                        ->set_help_text( 'Куда откроется ссылка (сайт, новое окно)' )
                        ->set_options( array(
                        '_self' => 'На текущей странице',
                        '_blank' => 'В новом окне',
                        ) )
                        ->set_default_value( '_self' )
                        ->set_required( true ),
                ) ),
        // Изображение Push
            Field::make( 'image', 'hero_push_image' . carbon_lang_prefix(), __( 'Изображение Push' ) )
                ->set_help_text( 'Изображение Push в hero секции (если не указано, будет использовано изображение по умолчанию)' ),
            // Фоновые элементы (Complex вместо Repeater)
            Field::make( 'complex', 'hero_bg_items' . carbon_lang_prefix(), __( 'Фоновые элементы (соцсети)' ) )
                ->set_help_text( 'Добавьте элементы фона (иконки соцсетей). Если не заполнено, будут использованы элементы по умолчанию.' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'image', 'image', __( 'Изображение' ) )
                        ->set_help_text( 'Изображение иконки соцсети' )
                        ->set_required( true ),
                    Field::make( 'text', 'css_class', __( 'CSS класс' ) )
                        ->set_help_text( 'CSS класс для элемента (например: item-inst, item-fb, item-tiktok)' )
                        ->set_attribute( 'placeholder', 'item-inst' )
                        ->set_required( true ),
                    Field::make( 'text', 'alt', __( 'Alt текст' ) )
                        ->set_help_text( 'Alt текст для изображения' )
                        ->set_attribute( 'placeholder', 'inst' ),
                    Field::make( 'text', 'shadows_count', __( 'Количество теней' ) )
                        ->set_help_text( 'Количество элементов теней (0-3). Если 0, тени не будут отображаться.' )
                        ->set_default_value( 0 )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'data-min', 0 )
                        ->set_attribute( 'data-max', 3 )
                        ->set_attribute( 'data-step', 1 ),
                ) ),
        ) );

    // Services Section - Секция услуг
    Container::make( 'theme_options', __( 'Services Section - Секция услуг' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( 1 )
        ->add_fields( array(
        // Заголовок
            Field::make( 'complex', 'services_title_group' . carbon_lang_prefix(), __( 'Заголовок' ) )
                ->set_help_text( 'Настройки заголовка секции услуг' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'part1', __( 'Первая часть' ) )
                        ->set_help_text( 'Первая часть заголовка (например: "Наші")' )
                        ->set_default_value( 'Наші' )
                        ->set_attribute( 'placeholder', 'Наші' )
                        ->set_required( true ),
                    Field::make( 'text', 'part2', __( 'Вторая часть (в span)' ) )
                        ->set_help_text( 'Вторая часть заголовка, которая будет в span (например: "послуги")' )
                        ->set_default_value( 'послуги' )
                        ->set_attribute( 'placeholder', 'послуги' )
                        ->set_required( true ),
                ) ),
        // Repeater для услуг
            Field::make( 'complex', 'services_items' . carbon_lang_prefix(), __( 'Услуги' ) )
                ->set_help_text( 'Добавьте услуги для отображения в слайдере. Если не заполнено, будут использованы услуги по умолчанию.' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'image', 'image', __( 'Иконка' ) )
                        ->set_help_text( 'Иконка услуги' )
                        ->set_required( true ),
                    Field::make( 'text', 'title', __( 'Заголовок' ) )
                        ->set_help_text( 'Заголовок услуги (например: "01/SMM-консалтинг")' )
                        ->set_attribute( 'placeholder', '01/SMM-консалтинг' )
                        ->set_required( true ),
                    Field::make( 'textarea', 'description', __( 'Описание' ) )
                        ->set_help_text( 'Описание услуги' )
                        ->set_attribute( 'placeholder', 'Повний аудит профілю з обговоренням і наданням SMM стратегії' )
                        ->set_rows( 3 )
                        ->set_required( true ),
                    Field::make( 'separator', 'title_size_sep', __( 'Размеры текста заголовка' ) ),
                    Field::make( 'text', 'title_size_desktop', __( 'Размер заголовка (ПК)' ) )
                        ->set_help_text( 'Размер текста заголовка для десктопных устройств в rem (например: "1.5")' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.1' ),
                    Field::make( 'text', 'title_size_mobile', __( 'Размер заголовка (Мобильные)' ) )
                        ->set_help_text( 'Размер текста заголовка для мобильных устройств в rem (например: "1.2")' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.1' ),
                    Field::make( 'separator', 'description_size_sep', __( 'Размеры текста описания' ) ),
                    Field::make( 'text', 'description_size_desktop', __( 'Размер описания (ПК)' ) )
                        ->set_help_text( 'Размер текста описания для десктопных устройств в rem (например: "1")' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.1' ),
                    Field::make( 'text', 'description_size_mobile', __( 'Размер описания (Мобильные)' ) )
                        ->set_help_text( 'Размер текста описания для мобильных устройств в rem (например: "0.875")' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.1' ),
                ) ),
        ) );

    // Why Us Section - Секция "Почему мы"
    Container::make( 'theme_options', __( 'Why Us Section - Секция "Почему мы"' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( 2 )
        ->add_fields( array(
        // Эмодзи изображение
            Field::make( 'image', 'whyus_emoji' . carbon_lang_prefix(), __( 'Эмодзи изображение' ) )
                ->set_help_text( 'Изображение эмодзи для секции (если не указано, будет использовано изображение по умолчанию)' ),
        // Заголовок
            Field::make( 'complex', 'whyus_title_group' . carbon_lang_prefix(), __( 'Заголовок' ) )
                ->set_help_text( 'Настройки заголовка секции' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'first', __( 'Первая часть' ) )
                        ->set_help_text( 'Первая часть заголовка (например: "чому")' )
                        ->set_default_value( 'чому' )
                        ->set_attribute( 'placeholder', 'чому' )
                        ->set_required( true ),
                    Field::make( 'text', 'second', __( 'Вторая часть' ) )
                        ->set_help_text( 'Вторая часть заголовка (например: "саме ми?")' )
                        ->set_default_value( 'саме ми?' )
                        ->set_attribute( 'placeholder', 'саме ми?' )
                        ->set_required( true ),
                ) ),
        // Repeater для элементов
            Field::make( 'complex', 'whyus_items' . carbon_lang_prefix(), __( 'Элементы' ) )
                ->set_help_text( 'Добавьте элементы для секции "Почему мы". Если не заполнено, будут использованы элементы по умолчанию.' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'number', __( 'Номер' ) )
                        ->set_help_text( 'Номер элемента (например: "01", "02")' )
                        ->set_attribute( 'placeholder', '01' )
                        ->set_required( true ),
                    Field::make( 'text', 'title', __( 'Заголовок' ) )
                        ->set_help_text( 'Заголовок элемента' )
                        ->set_attribute( 'placeholder', 'Кожен крок має сенс' )
                        ->set_required( true ),
                    Field::make( 'textarea', 'description', __( 'Описание' ) )
                        ->set_help_text( 'Описание элемента' )
                        ->set_attribute( 'placeholder', 'Ми робимо тільки те, що реально працює...' )
                        ->set_rows( 3 )
                        ->set_required( true ),
                    Field::make( 'image', 'bg_image', __( 'Фоновое изображение' ) )
                        ->set_help_text( 'Фоновое изображение для элемента (опционально, для элементов с эффектами)' ),
                    Field::make( 'text', 'css_classes', __( 'CSS классы' ) )
                        ->set_help_text( 'CSS классы для элемента (например: "colorist item-3 i1" для элементов с эффектами)' )
                        ->set_attribute( 'placeholder', 'colorist item-3 i1' ),
                    Field::make( 'checkbox', 'has_light', __( 'Эффекты света' ) )
                        ->set_help_text( 'Включить эффекты света для элемента' )
                        ->set_option_value( 'yes' ),
                ) ),
        ) );

    // Push Start Section - Секция формы
    Container::make( 'theme_options', __( 'Push Start Section - Секция формы' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( 3 )
        ->add_fields( array(
        // Изображение курсора
            Field::make( 'image', 'pushstart_cursor_image' . carbon_lang_prefix(), __( 'Изображение курсора' ) )
                ->set_help_text( 'Изображение курсора (если не указано, будет использовано изображение по умолчанию)' ),
        // Заголовок
            Field::make( 'complex', 'pushstart_title_group' . carbon_lang_prefix(), __( 'Заголовок' ) )
                ->set_help_text( 'Настройки заголовка секции' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'line1', __( 'Первая строка' ) )
                        ->set_help_text( 'Первая строка заголовка (например: "PUSH-СТАРТ")' )
                        ->set_default_value( 'PUSH-СТАРТ' )
                        ->set_attribute( 'placeholder', 'PUSH-СТАРТ' )
                        ->set_required( true ),
                    Field::make( 'text', 'line2', __( 'Вторая строка' ) )
                        ->set_help_text( 'Вторая строка заголовка (например: "ДЛЯ ТВОГО БРЕНДУ")' )
                        ->set_default_value( 'ДЛЯ ТВОГО БРЕНДУ' )
                        ->set_attribute( 'placeholder', 'ДЛЯ ТВОГО БРЕНДУ' )
                        ->set_required( true ),
                ) ),
        // Описание
            Field::make( 'textarea', 'pushstart_description' . carbon_lang_prefix(), __( 'Описание' ) )
                ->set_help_text( 'Текст описания в секции' )
                ->set_default_value( 'Залиш свій телефон і ім\'я, і ми швидко зв\'яжемося з тобою, щоб зрозуміти твої цілі, підібрати найефективнішу стратегію, показати, як твої соцмережі можуть реально продавати.' )
                ->set_rows( 4 )
                ->set_required( true ),
        // Группа: Форма
            Field::make( 'complex', 'pushstart_form_group' . carbon_lang_prefix(), __( 'Настройки формы' ) )
                ->set_help_text( 'Настройки формы обратной связи' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'name_placeholder', __( 'Плейсхолдер для имени' ) )
                        ->set_help_text( 'Текст плейсхолдера для поля имени' )
                        ->set_default_value( 'Ваше Ім\'я' )
                        ->set_attribute( 'placeholder', 'Ваше Ім\'я' )
                        ->set_required( true ),
                    Field::make( 'text', 'phone_placeholder', __( 'Плейсхолдер для телефона' ) )
                        ->set_help_text( 'Текст плейсхолдера для поля телефона' )
                        ->set_default_value( 'Номер телефону' )
                        ->set_attribute( 'placeholder', 'Номер телефону' )
                        ->set_required( true ),
                    Field::make( 'text', 'button_text', __( 'Текст кнопки' ) )
                        ->set_help_text( 'Текст на кнопке отправки' )
                        ->set_default_value( 'Зв\'язатись з нами' )
                        ->set_attribute( 'placeholder', 'Зв\'язатись з нами' )
                        ->set_required( true ),
                    Field::make( 'text', 'form_action', __( 'Action формы' ) )
                        ->set_help_text( 'URL для отправки формы (оставьте пустым для текущей страницы)' )
                        ->set_attribute( 'placeholder', '' ),
                ) ),
        // Социальная ссылка
            Field::make( 'text', 'pushstart_social_link' . carbon_lang_prefix(), __( 'Социальная ссылка' ) )
                ->set_help_text( 'Ссылка на социальную сеть (Telegram, WhatsApp и т.д.)' )
                ->set_default_value( '#' )
                ->set_attribute( 'placeholder', '#' ),
        ) );

    // Cases Section - Секция кейсов
    Container::make( 'theme_options', __( 'Cases Section - Секция кейсов' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( 4 )
        ->add_fields( array(
        // Заголовок
            Field::make( 'complex', 'cases_title_group' . carbon_lang_prefix(), __( 'Заголовок' ) )
                ->set_help_text( 'Настройки заголовка секции' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'part1', __( 'Первая часть' ) )
                        ->set_help_text( 'Первая часть заголовка (например: "Наші")' )
                        ->set_default_value( 'Наші' )
                        ->set_attribute( 'placeholder', 'Наші' )
                        ->set_required( true ),
                    Field::make( 'text', 'part2', __( 'Вторая часть' ) )
                        ->set_help_text( 'Вторая часть заголовка (например: "Кейси")' )
                        ->set_default_value( 'Кейси' )
                        ->set_attribute( 'placeholder', 'Кейси' )
                        ->set_required( true ),
                ) ),
        // Описание
            Field::make( 'textarea', 'cases_description' . carbon_lang_prefix(), __( 'Описание' ) )
                ->set_help_text( 'Текст описания в секции кейсов' )
                ->set_default_value( 'Ми створюємо стратегії, які приносять реальні результати. Подивись, як ми допомагаємо брендам розвиватися в соціальних мережах, формувати впізнаваність і збільшувати продажі.' )
                ->set_rows( 4 )
                ->set_required( true ),
        // Кнопки фильтров
            Field::make( 'complex', 'cases_filter_buttons' . carbon_lang_prefix(), __( 'Кнопки фильтров' ) )
                ->set_help_text( 'Добавьте кнопки фильтров для категорий кейсов' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'text', __( 'Текст кнопки' ) )
                        ->set_help_text( 'Текст на кнопке фильтра' )
                        ->set_attribute( 'placeholder', 'SMM-консалтинг' )
                        ->set_required( true ),
                    Field::make( 'text', 'slide_index', __( 'Индекс слайда' ) )
                        ->set_help_text( 'Индекс слайда для фильтрации (data-slide-index)' )
                        ->set_default_value( 0 )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'data-min', 0 )
                        ->set_required( true ),
                ) ),
        // Карточки кейсов
            Field::make( 'complex', 'cases_cards' . carbon_lang_prefix(), __( 'Карточки кейсов' ) )
                ->set_help_text( 'Добавьте карточки кейсов. Если не заполнено, будут использованы карточки по умолчанию.' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'title', __( 'Заголовок' ) )
                        ->set_help_text( 'Заголовок кейса' )
                        ->set_attribute( 'placeholder', 'СТРАТЕГІЯ РОСТУ ДЛЯ GLOWUP STUDIO' )
                        ->set_required( true ),
                    Field::make( 'textarea', 'description', __( 'Описание' ) )
                        ->set_help_text( 'Описание кейса' )
                        ->set_attribute( 'placeholder', 'Ми допомогли сформувати сильний бренд...' )
                        ->set_rows( 4 )
                        ->set_required( true ),
                    Field::make( 'text', 'button_text', __( 'Текст кнопки' ) )
                        ->set_help_text( 'Текст на кнопке "Детальніше"' )
                        ->set_default_value( 'Детальніше' )
                        ->set_attribute( 'placeholder', 'Детальніше' ),
                    // KPI метрики (вложенный complex)
                    Field::make( 'complex', 'kpi', __( 'KPI метрики' ) )
                        ->set_help_text( 'Добавьте KPI метрики для кейса' )
                        ->set_layout( 'tabbed-vertical' )
                        ->add_fields( array(
                            Field::make( 'text', 'kpi_value', __( 'Значение' ) )
                                ->set_help_text( 'Значение метрики (например: "+450", "320%")' )
                                ->set_attribute( 'placeholder', '+450' )
                                ->set_required( true ),
                            Field::make( 'text', 'label', __( 'Подпись' ) )
                                ->set_help_text( 'Подпись метрики (например: "продажів за місяць")' )
                                ->set_attribute( 'placeholder', 'продажів за місяць' )
                                ->set_required( true ),
                        ) ),
                ) ),
        ) );

    // Actors Section - Секция актеров
    Container::make( 'theme_options', __( 'Actors Section - Секция актеров' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( 5 )
        ->add_fields( array(
        // Эмодзи изображение
            Field::make( 'image', 'actors_emoji' . carbon_lang_prefix(), __( 'Эмодзи изображение' ) )
                ->set_help_text( 'Изображение эмодзи для секции (если не указано, будет использовано изображение по умолчанию)' ),
        // Заголовок
            Field::make( 'complex', 'actors_title_group' . carbon_lang_prefix(), __( 'Заголовок' ) )
                ->set_help_text( 'Настройки заголовка секции' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'part1', __( 'Первая часть' ) )
                        ->set_help_text( 'Первая часть заголовка (например: "наші")' )
                        ->set_default_value( 'наші' )
                        ->set_attribute( 'placeholder', 'наші' )
                        ->set_required( true ),
                    Field::make( 'text', 'part2', __( 'Вторая часть (в span)' ) )
                        ->set_help_text( 'Вторая часть заголовка, которая будет в span (например: "актори")' )
                        ->set_default_value( 'актори' )
                        ->set_attribute( 'placeholder', 'актори' )
                        ->set_required( true ),
                ) ),
        // Подзаголовок
            Field::make( 'text', 'actors_subtitle' . carbon_lang_prefix(), __( 'Подзаголовок' ) )
                ->set_help_text( 'Подзаголовок секции' )
                ->set_default_value( 'Команда, яка вміє працювати на камеру.' )
                ->set_attribute( 'placeholder', 'Команда, яка вміє працювати на камеру.' )
                ->set_required( true ),
        // Repeater для актеров
            Field::make( 'complex', 'actors_items' . carbon_lang_prefix(), __( 'Актеры' ) )
                ->set_help_text( 'Добавьте актеров для слайдера. Если не заполнено, будут использованы актеры по умолчанию.' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'select', 'media_type', __( 'Тип медиа' ) )
                        ->set_help_text( 'Выберите тип медиа: обычное изображение или GIF/WebP/WebM' )
                        ->set_options( array(
                            'image' => 'Обычное изображение',
                            'gif' => 'GIF/WebP/WebM',
                        ) )
                        ->set_default_value( 'image' )
                        ->set_required( true ),
                    Field::make( 'image', 'image', __( 'Фото актера' ) )
                        ->set_help_text( 'Фотография актера (используется если выбран тип "Обычное изображение")' )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'media_type',
                                'value' => 'image',
                            )
                        ) ),
                    Field::make( 'file', 'gif_webp_webm', __( 'GIF/WebP/WebM файл' ) )
                        ->set_help_text( 'Загрузите GIF, WebP или WebM файл (используется если выбран тип "GIF/WebP/WebM")' )
                        ->set_type( array( 'image', 'video' ) )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'media_type',
                                'value' => 'gif',
                            )
                        ) ),
                    Field::make( 'text', 'title', __( 'Заголовок' ) )
                        ->set_help_text( 'Заголовок актера (например: "#Актор 1")' )
                        ->set_attribute( 'placeholder', '#Актор 1' )
                        ->set_required( true ),
                ) ),
        ) );

    // Collab Section - Секция этапов сотрудничества
    Container::make( 'theme_options', __( 'Collab Section - Секция этапов сотрудничества' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( 6 )
        ->add_fields( array(
        // Заголовок
            Field::make( 'complex', 'collab_title_group' . carbon_lang_prefix(), __( 'Заголовок' ) )
                ->set_help_text( 'Настройки заголовка секции' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'part1', __( 'Первая часть' ) )
                        ->set_help_text( 'Первая часть заголовка (например: "етапи")' )
                        ->set_default_value( 'етапи' )
                        ->set_attribute( 'placeholder', 'етапи' )
                        ->set_required( true ),
                    Field::make( 'text', 'part2', __( 'Вторая часть (в span)' ) )
                        ->set_help_text( 'Вторая часть заголовка, которая будет в span (например: "співпраці")' )
                        ->set_default_value( 'співпраці' )
                        ->set_attribute( 'placeholder', 'співпраці' )
                        ->set_required( true ),
                ) ),
        // Подзаголовок
            Field::make( 'text', 'collab_subtitle' . carbon_lang_prefix(), __( 'Подзаголовок' ) )
                ->set_help_text( 'Подзаголовок секции' )
                ->set_default_value( 'Ми розробляємо кожен крок співпраці з тобою, щоб створити найкращий результат.' )
                ->set_attribute( 'placeholder', 'Ми розробляємо кожен крок співпраці з тобою, щоб створити найкращий результат.' )
                ->set_required( true ),
        // Кнопки
            Field::make( 'complex', 'collab_buttons' . carbon_lang_prefix(), __( 'Кнопки' ) )
                ->set_help_text( 'Добавьте кнопки (обычно 3: Push, your, business)' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'text', __( 'Текст' ) )
                        ->set_help_text( 'Текст на кнопке' )
                        ->set_attribute( 'placeholder', 'Push' )
                        ->set_required( true ),
                    Field::make( 'text', 'css_class', __( 'CSS класс' ) )
                        ->set_help_text( 'CSS класс для кнопки (например: button-1, button-2, button-3)' )
                        ->set_attribute( 'placeholder', 'button-1' )
                        ->set_required( true ),
                ) ),
        // Этапы сотрудничества
            Field::make( 'complex', 'collab_steps' . carbon_lang_prefix(), __( 'Этапы сотрудничества' ) )
                ->set_help_text( 'Добавьте этапы сотрудничества. Если не заполнено, будут использованы этапы по умолчанию.' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'number', __( 'Номер' ) )
                        ->set_help_text( 'Номер этапа (например: "01", "02")' )
                        ->set_attribute( 'placeholder', '01' )
                        ->set_required( true ),
                    Field::make( 'text', 'title', __( 'Заголовок' ) )
                        ->set_help_text( 'Заголовок этапа' )
                        ->set_attribute( 'placeholder', 'Бриф' )
                        ->set_required( true ),
                    Field::make( 'textarea', 'description', __( 'Описание' ) )
                        ->set_help_text( 'Описание этапа' )
                        ->set_attribute( 'placeholder', 'Заповнюєш форму, де розповідаєш про бізнес...' )
                        ->set_rows( 3 )
                        ->set_required( true ),
                ) ),
        ) );

    // Bonus Section - Секция бонуса
    Container::make( 'theme_options', __( 'Bonus Section - Секция бонуса' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( 8 )
        ->add_fields( array(
        // Заголовок
            Field::make( 'complex', 'bonus_title_group' . carbon_lang_prefix(), __( 'Заголовок' ) )
                ->set_help_text( 'Настройки заголовка секции' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'first', __( 'Первая строка' ) )
                        ->set_help_text( 'Первая строка заголовка' )
                        ->set_default_value( 'Натисни на подарунок, щоб' )
                        ->set_attribute( 'placeholder', 'Натисни на подарунок, щоб' )
                        ->set_required( true ),
                    Field::make( 'separator', 'first_size_sep', __( 'Размеры текста первой строки' ) ),
                    Field::make( 'text', 'first_size_desktop', __( 'Размер первой строки (ПК)' ) )
                        ->set_help_text( 'Размер текста первой строки для десктопных устройств в rem (например: "2.5")' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.1' ),
                    Field::make( 'text', 'first_size_mobile', __( 'Размер первой строки (Мобильные)' ) )
                        ->set_help_text( 'Размер текста первой строки для мобильных устройств в rem (например: "1.5")' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.1' ),
                    Field::make( 'text', 'second', __( 'Вторая строка' ) )
                        ->set_help_text( 'Вторая строка заголовка' )
                        ->set_default_value( 'отримати бонус' )
                        ->set_attribute( 'placeholder', 'отримати бонус' )
                        ->set_required( true ),
                    Field::make( 'separator', 'second_size_sep', __( 'Размеры текста второй строки' ) ),
                    Field::make( 'text', 'second_size_desktop', __( 'Размер второй строки (ПК)' ) )
                        ->set_help_text( 'Размер текста второй строки для десктопных устройств в rem (например: "2.5")' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.1' ),
                    Field::make( 'text', 'second_size_mobile', __( 'Размер второй строки (Мобильные)' ) )
                        ->set_help_text( 'Размер текста второй строки для мобильных устройств в rem (например: "1.5")' )
                        ->set_attribute( 'type', 'number' )
                        ->set_attribute( 'step', '0.1' ),
                ) ),
        // Изображения
            Field::make( 'image', 'bonus_image_close' . carbon_lang_prefix(), __( 'Изображение закрытого подарка' ) )
                ->set_help_text( 'Изображение закрытого подарка (если не указано, будет использовано изображение по умолчанию)' ),
            Field::make( 'image', 'bonus_image_open' . carbon_lang_prefix(), __( 'Изображение открытого подарка' ) )
                ->set_help_text( 'Изображение открытого подарка (если не указано, будет использовано изображение по умолчанию)' ),
        // Заголовок контента
            Field::make( 'text', 'bonus_content_title' . carbon_lang_prefix(), __( 'Заголовок контента' ) )
                ->set_help_text( 'Заголовок, который отображается внутри открытого подарка' )
                ->set_default_value( 'Бонус' )
                ->set_attribute( 'placeholder', 'Бонус' )
                ->set_required( true ),
        ) );

    // FAQ Section - Секция FAQ
    Container::make( 'theme_options', __( 'FAQ Section - Секция FAQ' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( 7 )
        ->add_fields( array(
        // Заголовок секции
            Field::make( 'text', 'faq_title' . carbon_lang_prefix(), __( 'Заголовок секции' ) )
                ->set_help_text( 'Заголовок секции FAQ' )
                ->set_default_value( 'FAQ' )
                ->set_attribute( 'placeholder', 'FAQ' )
                ->set_required( true ),
        // Папки FAQ
            Field::make( 'complex', 'faq_folders' . carbon_lang_prefix(), __( 'Папки FAQ' ) )
                ->set_help_text( 'Добавьте папки для FAQ секции. Если не заполнено, будут использованы папки по умолчанию.' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'title', __( 'Название папки' ) )
                        ->set_help_text( 'Название папки (например: "SMM-консалтинг")' )
                        ->set_attribute( 'placeholder', 'SMM-консалтинг' )
                        ->set_required( true ),
                    Field::make( 'select', 'color', __( 'Цвет папки' ) )
                        ->set_help_text( 'Цвет папки (black или orange)' )
                        ->set_options( array(
                            'black' => 'Черный',
                            'orange' => 'Оранжевый',
                        ) )
                        ->set_default_value( 'black' )
                        ->set_required( true ),
                    Field::make( 'text', 'tab_max_width_mobile', __( 'Max-width для мобильной версии (tab)' ) )
                        ->set_help_text( 'Максимальная ширина вкладки для мобильной версии (например: 200px, 50%, auto). Оставьте пустым для значения по умолчанию.' )
                        ->set_attribute( 'placeholder', '200px' ),
                    Field::make( 'select', 'image_type', __( 'Тип изображения' ) )
                        ->set_help_text( 'Тип изображения: одно изображение или социальные сети' )
                        ->set_options( array(
                            'single' => 'Одно изображение',
                            'socials' => 'Социальные сети (3 изображения)',
                            'none' => 'Без изображения',
                        ) )
                        ->set_default_value( 'single' )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'is_contacts',
                                'value' => false,
                                'compare' => '=',
                            )
                        ) )
                        ->set_required( true ),
                    Field::make( 'image', 'image', __( 'Изображение' ) )
                        ->set_help_text( 'Изображение для папки (используется если тип "Одно изображение")' )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'image_type',
                                'value' => 'single',
                            )
                        ) ),
                    Field::make( 'image', 'social_fb', __( 'Facebook иконка' ) )
                        ->set_help_text( 'Иконка Facebook (используется если тип "Социальные сети")' )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'image_type',
                                'value' => 'socials',
                            )
                        ) ),
                    Field::make( 'image', 'social_tt', __( 'TikTok иконка' ) )
                        ->set_help_text( 'Иконка TikTok (используется если тип "Социальные сети")' )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'image_type',
                                'value' => 'socials',
                            )
                        ) ),
                    Field::make( 'image', 'social_inst', __( 'Instagram иконка' ) )
                        ->set_help_text( 'Иконка Instagram (используется если тип "Социальные сети")' )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'image_type',
                                'value' => 'socials',
                            )
                        ) ),
                    Field::make( 'complex', 'questions', __( 'Вопросы' ) )
                        ->set_help_text( 'Добавьте вопросы для этой папки' )
                        ->set_layout( 'tabbed-vertical' )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'is_contacts',
                                'value' => false,
                                'compare' => '=',
                            )
                        ) )
                        ->add_fields( array(
                            Field::make( 'text', 'text', __( 'Текст вопроса' ) )
                                ->set_help_text( 'Текст вопроса' )
                                ->set_attribute( 'placeholder', 'Що входить у послугу SMM-консалтингу?' )
                                ->set_required( true ),
                            Field::make( 'textarea', 'answer', __( 'Ответ на вопрос' ) )
                                ->set_help_text( 'Ответ на вопрос' )
                                ->set_attribute( 'placeholder', 'Що входить у послугу SMM-консалтингу?' )
                                ->set_rows( 2 )
                                ->set_required( false ),
                        ) ),
                    Field::make( 'checkbox', 'is_contacts', __( 'Это секция контактов' ) )
                        ->set_help_text( 'Отметьте, если это папка с контактами (вместо вопросов будут показаны контакты)' )
                        ->set_option_value( 'yes' ),
                    // Поля контактов (показываются только когда is_contacts активен)
                    Field::make( 'text', 'contacts_title', __( 'Заголовок контактов' ) )
                        ->set_help_text( 'Заголовок секции контактов' )
                        ->set_default_value( 'контакти' )
                        ->set_attribute( 'placeholder', 'контакти' )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'is_contacts',
                                'value' => true,
                            )
                        ) ),
                    Field::make( 'textarea', 'contacts_description', __( 'Описание контактов' ) )
                        ->set_help_text( 'Описание секции контактов' )
                        ->set_default_value( 'Хочеш обговорити проект або просто дізнатися, як ми можемо допомогти твоєму бізнесу рости? Зв\'яжись з нами будь-яким зручним способом — ми швидко відповімо!' )
                        ->set_rows( 4 )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'is_contacts',
                                'value' => true,
                            )
                        ) ),
                    Field::make( 'complex', 'contacts_buttons', __( 'Кнопки действий' ) )
                        ->set_help_text( 'Кнопки действий (Заповнити бриф, Зв\'язатись з нами)' )
                        ->set_layout( 'tabbed-vertical' )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'is_contacts',
                                'value' => true,
                            )
                        ) )
                        ->add_fields( array(
                            Field::make( 'text', 'text', __( 'Текст кнопки' ) )
                                ->set_help_text( 'Текст на кнопке' )
                                ->set_attribute( 'placeholder', 'Заповнити бриф' )
                                ->set_required( true ),
                            Field::make( 'text', 'link', __( 'Ссылка' ) )
                                ->set_help_text( 'Ссылка кнопки' )
                                ->set_default_value( '#' )
                                ->set_attribute( 'placeholder', '#' ),
                        ) ),
                    Field::make( 'complex', 'contacts_items', __( 'Контактные данные' ) )
                        ->set_help_text( 'Контактные данные (Telegram, Email, Телефон)' )
                        ->set_layout( 'tabbed-vertical' )
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'is_contacts',
                                'value' => true,
                            )
                        ) )
                        ->add_fields( array(
                            Field::make( 'text', 'name', __( 'Название' ) )
                                ->set_help_text( 'Название контакта (например: "telegram", "email", "телефон")' )
                                ->set_attribute( 'placeholder', 'telegram' )
                                ->set_required( true ),
                            Field::make( 'text', 'contact_value', __( 'Значение' ) )
                                ->set_help_text( 'Значение контакта (например: "@pushsmmagency", "pushsmmagency@gmail.com")' )
                                ->set_attribute( 'placeholder', '@pushsmmagency' )
                                ->set_required( true ),
                            Field::make( 'image', 'icon', __( 'Иконка' ) )
                                ->set_help_text( 'Загрузите кастомную иконку для контакта. Если не указано, будет использована иконка по умолчанию на основе названия.' ),
                        ) ),
                ) ),
        ) );

    // Footer Form Section - Секция формы в футере
    Container::make( 'theme_options', __( 'Footer Form Section - Секция формы в футере' ) )
        ->set_page_parent($options)
        ->set_page_menu_position( 9 )
        ->add_fields( array(
        // Заголовок
            Field::make( 'complex', 'footer_form_title_group' . carbon_lang_prefix(), __( 'Заголовок' ) )
                ->set_help_text( 'Настройки заголовка формы в футере' )
                ->set_layout( 'tabbed-vertical' )
                ->add_fields( array(
                    Field::make( 'text', 'first', __( 'Первая часть' ) )
                        ->set_help_text( 'Первая часть заголовка (например: "Push-старт")' )
                        ->set_default_value( 'Push-старт' )
                        ->set_attribute( 'placeholder', 'Push-старт' )
                        ->set_required( true ),
                    Field::make( 'text', 'second', __( 'Вторая часть' ) )
                        ->set_help_text( 'Вторая часть заголовка (например: "для твого бренду")' )
                        ->set_default_value( 'для твого бренду' )
                        ->set_attribute( 'placeholder', 'для твого бренду' )
                        ->set_required( true ),
                ) ),
        // Кнопка формы
            Field::make( 'text', 'footer_form_button_text' . carbon_lang_prefix(), __( 'Текст кнопки' ) )
                ->set_help_text( 'Текст на кнопке отправки формы' )
                ->set_default_value( 'Зв\'язатись з нами' )
                ->set_attribute( 'placeholder', 'Зв\'язатись з нами' )
                ->set_required( true ),
        // Заголовок контактов в футере
            Field::make( 'text', 'footer_contacts_title' . carbon_lang_prefix(), __( 'Заголовок контактов' ) )
                ->set_help_text( 'Заголовок секции контактов в футере' )
                ->set_default_value( 'контакти' )
                ->set_attribute( 'placeholder', 'контакти' )
                ->set_required( true ),
        // Заголовок меню в футере
            Field::make( 'text', 'footer_menu_title' . carbon_lang_prefix(), __( 'Заголовок меню' ) )
                ->set_help_text( 'Заголовок секции меню в футере' )
                ->set_default_value( 'меню' )
                ->set_attribute( 'placeholder', 'меню' )
                ->set_required( true ),
        ) );
}
