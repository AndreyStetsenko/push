<?php
/**
 * Push Theme Functions
 */

// Подключение стилей и скриптов
function push_theme_enqueue_scripts() {
    // Версия для кеширования (можно использовать время изменения файла)
    $theme_version = wp_get_theme()->get('Version');
    $css_version = file_exists(get_template_directory() . '/assets/css/main.min.css') 
        ? filemtime(get_template_directory() . '/assets/css/main.min.css') 
        : $theme_version;
    $js_version = file_exists(get_template_directory() . '/assets/js/main.min.js') 
        ? filemtime(get_template_directory() . '/assets/js/main.min.js') 
        : $theme_version;
    
    // Подключение основного стиля темы (обязательный для WordPress)
    wp_enqueue_style('push-theme-style', get_stylesheet_uri(), array(), $theme_version);
    
    // Подключение скомпилированных стилей
    // Используем минифицированную версию для продакшена
    if (defined('WP_DEBUG') && WP_DEBUG) {
        // Для разработки - обычная версия с source maps
        wp_enqueue_style('push-theme-main', get_template_directory_uri() . '/assets/css/main.css', array('push-theme-style'), $css_version);
    } else {
        // Для продакшена - минифицированная версия
        wp_enqueue_style('push-theme-main', get_template_directory_uri() . '/assets/css/main.min.css', array('push-theme-style'), $css_version);
    }
    
    // Подключение скомпилированных скриптов
    // Используем минифицированную версию для продакшена
    if (defined('WP_DEBUG') && WP_DEBUG) {
        // Для разработки - обычная версия с source maps
        wp_enqueue_script('push-theme-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $js_version, true);
    } else {
        // Для продакшена - минифицированная версия
        wp_enqueue_script('push-theme-script', get_template_directory_uri() . '/assets/js/main.min.js', array('jquery'), $js_version, true);
    }
}
add_action('wp_enqueue_scripts', 'push_theme_enqueue_scripts');

// Поддержка основных функций WordPress
function push_theme_setup() {
    // Поддержка заголовка документа
    add_theme_support('title-tag');
    
    // Поддержка миниатюр записей
    add_theme_support('post-thumbnails');
    
    // Поддержка меню
    register_nav_menus(array(
        'primary' => 'Основное меню',
        'footer' => 'Меню в подвале',
    ));
    
    // Поддержка логотипа
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Поддержка HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'push_theme_setup');

// Вспомогательная функция для короткого подключения изображений
function img_url($path) {
    return get_template_directory_uri() . '/assets/images/' . ltrim($path, '/');
}

/**
 * Проверяет, является ли текущая страница главной, учитывая префиксы языков Polylang
 * @return bool true если это главная страница (с учетом языковых префиксов)
 */
function push_is_front_page() {
    // Стандартная проверка WordPress
    if (is_front_page()) {
        return true;
    }
    
    // Если Polylang активен, проверяем через него
    if (function_exists('pll_current_language')) {
        // Получаем текущий URL без домена
        $current_url = $_SERVER['REQUEST_URI'] ?? '';
        $current_url = trim($current_url, '/');
        
        // Получаем текущий язык
        $current_lang = pll_current_language();
        
        // Если URL состоит только из префикса языка (например: /ru/, /en/)
        // или пустой (главная страница), то это главная страница
        if (empty($current_url) || $current_url === $current_lang) {
            return true;
        }
        
        // Проверяем, является ли это главной страницей для текущего языка
        if (function_exists('pll_home_url')) {
            $home_url = pll_home_url($current_lang);
            $current_full_url = home_url($_SERVER['REQUEST_URI'] ?? '');
            
            // Нормализуем URL (убираем trailing slash)
            $home_url = untrailingslashit($home_url);
            $current_full_url = untrailingslashit($current_full_url);
            
            if ($home_url === $current_full_url) {
                return true;
            }
        }
        
        // Проверяем через is_home() и is_page() с ID главной страницы
        if (is_home() && !is_paged()) {
            return true;
        }
        
        // Если установлена статическая главная страница, проверяем её ID
        $page_on_front = get_option('page_on_front');
        if ($page_on_front && is_page($page_on_front)) {
            return true;
        }
    }
    
    return false;
}

// Кастомный Walker для мобильного меню
class Mobile_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="mobile-menu__item' . ($item->current ? ' mobile-menu__item--active' : '') . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= '<a' . $id . $class_names . ' href="' . esc_attr($item->url) . '">';
        $output .= apply_filters('the_title', $item->title, $item->ID);
        $output .= '</a>';
    }
    
    function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= '';
    }
}

// Фильтр для добавления классов к элементам десктопного меню
function push_nav_menu_css_class($classes, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location == 'primary') {
        // Если у пункта меню есть CSS класс 'img', добавляем его
        if (in_array('img', $item->classes)) {
            $classes[] = 'img';
        }
        
        // Если передан параметр add_li_class, добавляем его ко всем элементам
        if (isset($args->add_li_class) && !empty($args->add_li_class)) {
            $add_classes = is_array($args->add_li_class) ? $args->add_li_class : array($args->add_li_class);
            $classes = array_merge($classes, $add_classes);
        }
        
        // Добавляем кастомные классы из админки
        $custom_classes = get_post_meta($item->ID, '_menu_item_custom_classes', true);
        if (!empty($custom_classes)) {
            $custom_classes_array = array_filter(array_map('trim', explode(' ', $custom_classes)));
            $classes = array_merge($classes, $custom_classes_array);
        }
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'push_nav_menu_css_class', 10, 3);

// Добавление кастомных полей в настройки пункта меню
function push_add_menu_image_field($item_id, $item) {
    $menu_image = get_post_meta($item_id, '_menu_item_image', true);
    $menu_image_alt = get_post_meta($item_id, '_menu_item_image_alt', true);
    $menu_custom_classes = get_post_meta($item_id, '_menu_item_custom_classes', true);
    ?>
    <p class="field-image description description-wide">
        <label for="edit-menu-item-image-<?php echo esc_attr($item_id); ?>">
            <?php _e('Изображение вместо текста'); ?><br />
            <input type="text" id="edit-menu-item-image-<?php echo esc_attr($item_id); ?>" 
                   class="widefat code edit-menu-item-image" 
                   name="menu-item-image[<?php echo esc_attr($item_id); ?>]" 
                   value="<?php echo esc_attr($menu_image); ?>" 
                   placeholder="URL изображения или путь от /assets/images/"/>
        </label>
    </p>
    <p class="field-image-alt description description-wide">
        <label for="edit-menu-item-image-alt-<?php echo esc_attr($item_id); ?>">
            <?php _e('Alt текст для изображения'); ?><br />
            <input type="text" id="edit-menu-item-image-alt-<?php echo esc_attr($item_id); ?>" 
                   class="widefat edit-menu-item-image-alt" 
                   name="menu-item-image-alt[<?php echo esc_attr($item_id); ?>]" 
                   value="<?php echo esc_attr($menu_image_alt); ?>"/>
        </label>
    </p>
    <p class="field-custom-classes description description-wide">
        <label for="edit-menu-item-custom-classes-<?php echo esc_attr($item_id); ?>">
            <?php _e('Дополнительные CSS классы тега li'); ?><br />
            <input type="text" id="edit-menu-item-custom-classes-<?php echo esc_attr($item_id); ?>" 
                   class="widefat edit-menu-item-custom-classes" 
                   name="menu-item-custom-classes[<?php echo esc_attr($item_id); ?>]" 
                   value="<?php echo esc_attr($menu_custom_classes); ?>"
                   placeholder="class1 class2 class3"/>
            <span class="description"><?php _e('Укажите дополнительные CSS классы через пробел'); ?></span>
        </label>
    </p>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'push_add_menu_image_field', 10, 2);

// Сохранение кастомных полей меню
function push_save_menu_image_field($menu_id, $menu_item_db_id) {
    if (isset($_POST['menu-item-image'][$menu_item_db_id])) {
        $image_url = sanitize_text_field($_POST['menu-item-image'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_menu_item_image', $image_url);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_image');
    }
    
    if (isset($_POST['menu-item-image-alt'][$menu_item_db_id])) {
        $image_alt = sanitize_text_field($_POST['menu-item-image-alt'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_menu_item_image_alt', $image_alt);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_image_alt');
    }
    
    if (isset($_POST['menu-item-custom-classes'][$menu_item_db_id])) {
        $custom_classes = sanitize_text_field($_POST['menu-item-custom-classes'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_menu_item_custom_classes', $custom_classes);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_custom_classes');
    }
}
add_action('wp_update_nav_menu_item', 'push_save_menu_image_field', 10, 2);

// Фильтр для вывода содержимого ссылки с изображением
function push_nav_menu_item_title($title, $item, $args, $depth) {
    $menu_image = get_post_meta($item->ID, '_menu_item_image', true);
    
    if (!empty($menu_image)) {
        $image_alt = get_post_meta($item->ID, '_menu_item_image_alt', true);
        if (empty($image_alt)) {
            $image_alt = $item->title;
        }
        
        // Если путь начинается с / или не содержит http, считаем его относительным
        if (!preg_match('/^https?:\/\//', $menu_image)) {
            // Если путь начинается с /assets/images/, используем img_url
            if (strpos($menu_image, '/assets/images/') === 0) {
                $image_url = img_url(str_replace('/assets/images/', '', $menu_image));
            } else {
                // Иначе считаем, что это путь от корня темы
                $image_url = get_template_directory_uri() . '/' . ltrim($menu_image, '/');
            }
        } else {
            $image_url = $menu_image;
        }
        
        return '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
    }
    
    // Обратная совместимость со старым способом через класс img
    if (isset($args->theme_location) && $args->theme_location == 'primary') {
        if (in_array('img', $item->classes)) {
            return '<img src="' . img_url('icons/surprise.png') . '" alt="surprise">';
        }
    }
    
    return $title;
}
add_filter('nav_menu_item_title', 'push_nav_menu_item_title', 10, 4);

// Кастомный Walker для меню в футере (разделение на два списка)
class Footer_Menu_Walker extends Walker_Nav_Menu {
    private $item_count = 0;
    
    function start_lvl(&$output, $depth = 0, $args = array()) {
        // Не добавляем вложенные списки
    }
    
    function end_lvl(&$output, $depth = 0, $args = array()) {
        // Не закрываем вложенные списки
    }
    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $this->item_count++;
        
        // Если это 5-й элемент, закрываем первый список и открываем второй
        if ($this->item_count == 5) {
            $output .= '</ul><ul>';
        }
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        // Проверяем, есть ли изображение в кастомных полях
        $menu_image = get_post_meta($item->ID, '_menu_item_image', true);
        $link_content = apply_filters('the_title', $item->title, $item->ID);
        
        if (!empty($menu_image)) {
            $image_alt = get_post_meta($item->ID, '_menu_item_image_alt', true);
            if (empty($image_alt)) {
                $image_alt = $item->title;
            }
            
            // Если путь начинается с / или не содержит http, считаем его относительным
            if (!preg_match('/^https?:\/\//', $menu_image)) {
                // Если путь начинается с /assets/images/, используем img_url
                if (strpos($menu_image, '/assets/images/') === 0) {
                    $image_url = img_url(str_replace('/assets/images/', '', $menu_image));
                } else {
                    // Иначе считаем, что это путь от корня темы
                    $image_url = get_template_directory_uri() . '/' . ltrim($menu_image, '/');
                }
            } else {
                $image_url = $menu_image;
            }
            
            $link_content = '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
            $class_names = ' class="img"';
        } elseif (in_array('img', $item->classes)) {
            // Обратная совместимость со старым способом через класс img
            $link_content = '<img src="' . img_url('icons/surprise.png') . '" alt="surprise">';
            $class_names = ' class="img"';
        }
        
        $output .= '<li' . $id . $class_names . '>';
        $output .= '<a href="' . esc_attr($item->url) . '">' . $link_content . '</a>';
    }
    
    function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= '</li>';
    }
}

// Инициализация Carbon Fields
add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    // Проверяем наличие Carbon Fields
    if ( file_exists( get_template_directory() . '/vendor/autoload.php' ) ) {
        require_once get_template_directory() . '/vendor/autoload.php';
    } elseif ( file_exists( ABSPATH . 'vendor/autoload.php' ) ) {
        require_once ABSPATH . 'vendor/autoload.php';
    }
    
    \Carbon_Fields\Carbon_Fields::boot();
}

// Подключение Carbon Fields полей
if( file_exists(get_template_directory() . '/acf-fields.php') ) {
    require_once get_template_directory() . '/acf-fields.php';
}

// Вспомогательные функции для работы с Carbon Fields (совместимость с ACF)
if ( ! function_exists( 'carbon_lang_prefix' ) ) {
    /**
     * Функция для добавления префикса мультиязычности к именам полей
     * @return string Префикс языка (например: '_ru', '_en') или пустая строка
     */
    function carbon_lang_prefix() {
        $prefix = '';
        // Проверяем наличие константы ICL_LANGUAGE_CODE (WPML)
        if ( ! defined( 'ICL_LANGUAGE_CODE' ) ) {
            // Если WPML не активен, пробуем получить язык через Polylang
            if ( function_exists( 'pll_current_language' ) ) {
                $current_lang = pll_current_language();
                if ( ! empty( $current_lang ) ) {
                    $prefix = '_' . $current_lang;
                }
            }
            return $prefix;
        }
        $prefix = '_' . ICL_LANGUAGE_CODE;
        return $prefix;
    }
}

if ( ! function_exists( 'get_field' ) ) {
    /**
     * Получить значение поля из Carbon Fields (совместимость с ACF)
     * Автоматически добавляет префикс языка для мультиязычности
     * @param string $field_name Имя поля
     * @param string|int $post_id ID поста или 'option' для опций темы
     * @return mixed Значение поля
     */
    function get_field( $field_name, $post_id = null ) {
        if ( $post_id === 'option' || $post_id === null ) {
            // Добавляем префикс языка к имени поля
            $field_name_with_prefix = $field_name . carbon_lang_prefix();
            $value = carbon_get_theme_option( $field_name_with_prefix );
            
            // Для complex полей Carbon Fields возвращает массив массивов
            // Если это массив с одним элементом-массивом, возвращаем первый элемент
            // Это нужно для совместимости с ACF group полями
            if ( is_array( $value ) && ! empty( $value ) && isset( $value[0] ) && is_array( $value[0] ) ) {
                $first_item = $value[0];
                // Проверяем, что это не числовой массив (не repeater)
                $keys = array_keys( $first_item );
                if ( ! empty( $keys ) && ! is_numeric( $keys[0] ) ) {
                    // Это complex поле с одним элементом (group), возвращаем первый элемент
                    return $first_item;
                }
            }
            
            return $value;
        }
        
        return carbon_get_post_meta( $post_id, $field_name );
    }
}

/**
 * Получить URL изображения из Carbon Fields
 * Carbon Fields возвращает ID изображения, эта функция преобразует его в URL
 * @param int|string $image_id ID изображения или массив (для совместимости с ACF)
 * @param string $size Размер изображения
 * @return string|false URL изображения или false
 */
function crb_get_image_url( $image_id, $size = 'full' ) {
    if ( is_array( $image_id ) && isset( $image_id['url'] ) ) {
        // Совместимость с ACF форматом
        return $image_id['url'];
    }
    
    if ( is_numeric( $image_id ) ) {
        return wp_get_attachment_image_url( $image_id, $size );
    }
    
    return false;
}

/**
 * Получить массив данных изображения из Carbon Fields (совместимость с ACF)
 * @param int|string $image_id ID изображения или массив (для совместимости с ACF)
 * @param string $size Размер изображения
 * @return array|false Массив с url, alt, title или false
 */
function crb_get_image( $image_id, $size = 'full' ) {
    if ( is_array( $image_id ) && isset( $image_id['url'] ) ) {
        // Уже в формате ACF
        return $image_id;
    }
    
    if ( is_numeric( $image_id ) ) {
        $url = wp_get_attachment_image_url( $image_id, $size );
        $alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        $title = get_the_title( $image_id );
        
        return array(
            'url' => $url,
            'alt' => $alt,
            'title' => $title,
            'id' => $image_id,
        );
    }
    
    return false;
}

// Кастомный Walker для нижних ссылок в футере
class Footer_Privacy_Walker extends Walker_Nav_Menu {
    private $item_count = 0;
    
    function start_lvl(&$output, $depth = 0, $args = array()) {
        // Не добавляем вложенные списки
    }
    
    function end_lvl(&$output, $depth = 0, $args = array()) {
        // Не закрываем вложенные списки
    }
    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $this->item_count++;
        
        // Первый элемент в col-1, второй в col-2
        $col_class = ($this->item_count == 1) ? 'col-1' : 'col-2';
        
        $output .= '<div class="' . $col_class . '">';
        $output .= '<a href="' . esc_attr($item->url) . '" class="footer__privacy">';
        $output .= apply_filters('the_title', $item->title, $item->ID);
        $output .= '</a>';
        $output .= '</div>';
    }
    
    function end_el(&$output, $item, $depth = 0, $args = array()) {
        // Закрытие уже в start_el
    }
}
