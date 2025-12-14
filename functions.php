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
        
        return '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" loading="lazy" decoding="async">';
    }
    
    // Обратная совместимость со старым способом через класс img
    if (isset($args->theme_location) && $args->theme_location == 'primary') {
        if (in_array('img', $item->classes)) {
            return '<img src="' . img_url('icons/surprise.png') . '" alt="surprise" loading="lazy" decoding="async">';
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
            
            $link_content = '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" loading="lazy" decoding="async">';
            $class_names = ' class="img"';
        } elseif (in_array('img', $item->classes)) {
            // Обратная совместимость со старым способом через класс img
            $link_content = '<img src="' . img_url('icons/surprise.png') . '" alt="surprise" loading="lazy" decoding="async">';
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

// Подключение экспорта/импорта Carbon Fields
if( file_exists(get_template_directory() . '/carbon-fields-export-import.php') ) {
    require_once get_template_directory() . '/carbon-fields-export-import.php';
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
            // Нужно различать group поля (один элемент) и repeater поля (несколько элементов)
            if ( is_array( $value ) && ! empty( $value ) && isset( $value[0] ) && is_array( $value[0] ) ) {
                // Проверяем, является ли массив числовым (индексированным числами) на верхнем уровне
                $top_level_keys = array_keys( $value );
                $is_numeric_array = ! empty( $top_level_keys ) && is_numeric( $top_level_keys[0] );
                
                // Если это числовой массив (repeater), возвращаем весь массив
                // Если это не числовой массив или массив с одним элементом, проверяем дальше
                if ( $is_numeric_array && count( $value ) > 1 ) {
                    // Это точно repeater с несколькими элементами, возвращаем весь массив
                    return $value;
                }
                
                // Если массив с одним элементом, проверяем, является ли это group полем
                if ( count( $value ) === 1 ) {
                    $first_item = $value[0];
                    $item_keys = array_keys( $first_item );
                    // Если ключи элементов - строки (не числа), это group поле
                    if ( ! empty( $item_keys ) && ! is_numeric( $item_keys[0] ) ) {
                        // Это complex поле с одним элементом (group), возвращаем первый элемент
                        return $first_item;
                    }
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
        
        // Получаем метаданные для srcset
        $image_meta = wp_get_attachment_metadata( $image_id );
        $srcset = '';
        $sizes = '';
        
        if ( $image_meta && isset( $image_meta['width'] ) && isset( $image_meta['height'] ) ) {
            $size_array = array( $image_meta['width'], $image_meta['height'] );
            $srcset = wp_calculate_image_srcset( $size_array, $url, $image_meta, $image_id );
            $sizes = wp_calculate_image_sizes( $size_array, $url, $image_meta, $image_id );
        }
        
        return array(
            'url' => $url,
            'alt' => $alt,
            'title' => $title,
            'id' => $image_id,
            'width' => isset( $image_meta['width'] ) ? $image_meta['width'] : '',
            'height' => isset( $image_meta['height'] ) ? $image_meta['height'] : '',
            'srcset' => $srcset,
            'sizes' => $sizes,
        );
    }
    
    return false;
}

/**
 * Вывести оптимизированный тег изображения
 * @param int|array $image_id ID изображения или массив данных изображения
 * @param string $size Размер изображения
 * @param array $args Дополнительные аргументы (loading, fetchpriority, class, etc.)
 * @return string HTML тег img
 */
function push_optimized_image( $image_id, $size = 'full', $args = array() ) {
    $defaults = array(
        'loading' => 'lazy',
        'fetchpriority' => 'auto',
        'class' => '',
        'sizes' => null,
        'srcset' => null,
        'decoding' => 'async',
    );
    
    $args = wp_parse_args( $args, $defaults );
    
    // Получаем данные изображения
    $image = is_array( $image_id ) ? $image_id : crb_get_image( $image_id, $size );
    
    if ( ! $image || ! isset( $image['url'] ) ) {
        return '';
    }
    
    $url = $image['url'];
    $alt = isset( $image['alt'] ) ? $image['alt'] : '';
    $width = isset( $image['width'] ) ? $image['width'] : '';
    $height = isset( $image['height'] ) ? $image['height'] : '';
    $srcset = $args['srcset'] ?: ( isset( $image['srcset'] ) ? $image['srcset'] : '' );
    $sizes = $args['sizes'] ?: ( isset( $image['sizes'] ) ? $image['sizes'] : '' );
    
    // Формируем атрибуты
    $attributes = array();
    $attributes[] = 'src="' . esc_url( $url ) . '"';
    
    if ( $alt ) {
        $attributes[] = 'alt="' . esc_attr( $alt ) . '"';
    }
    
    if ( $width ) {
        $attributes[] = 'width="' . esc_attr( $width ) . '"';
    }
    
    if ( $height ) {
        $attributes[] = 'height="' . esc_attr( $height ) . '"';
    }
    
    if ( $srcset ) {
        $attributes[] = 'srcset="' . esc_attr( $srcset ) . '"';
    }
    
    if ( $sizes ) {
        $attributes[] = 'sizes="' . esc_attr( $sizes ) . '"';
    }
    
    if ( $args['loading'] && $args['loading'] !== 'auto' ) {
        $attributes[] = 'loading="' . esc_attr( $args['loading'] ) . '"';
    }
    
    if ( $args['fetchpriority'] && $args['fetchpriority'] !== 'auto' ) {
        $attributes[] = 'fetchpriority="' . esc_attr( $args['fetchpriority'] ) . '"';
    }
    
    if ( $args['decoding'] ) {
        $attributes[] = 'decoding="' . esc_attr( $args['decoding'] ) . '"';
    }
    
    if ( $args['class'] ) {
        $attributes[] = 'class="' . esc_attr( $args['class'] ) . '"';
    }
    
    return '<img ' . implode( ' ', $attributes ) . '>';
}

/**
 * Добавить preload для критических изображений
 * @param string $url URL изображения
 * @param string $as Тип ресурса (image)
 */
function push_preload_image( $url, $as = 'image' ) {
    if ( ! $url ) {
        return;
    }
    
    echo '<link rel="preload" as="' . esc_attr( $as ) . '" href="' . esc_url( $url ) . '">' . "\n";
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

// Интеграция с Contact Form 7
// Функция для получения ID формы CF7
function push_get_cf7_form_id($form_type = 'pushstart') {
    // Сначала проверяем опцию
    $option_key = $form_type . '_cf7_form_id';
    $form_id = get_option($option_key, '');
    
    // Если ID установлен и числовой - возвращаем его
    if (!empty($form_id) && is_numeric($form_id)) {
        return intval($form_id);
    }
    
    // Если это хеш (не числовой), пытаемся найти форму по хешу
    if (!empty($form_id) && !is_numeric($form_id)) {
        $posts = get_posts(array(
            'post_type' => 'wpcf7_contact_form',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));
        
        foreach ($posts as $post) {
            $form = wpcf7_contact_form($post->ID);
            if ($form) {
                $shortcode = $form->shortcode();
                if (strpos($shortcode, $form_id) !== false) {
                    return $post->ID;
                }
            }
        }
    }
    
    // Если ID не найден, пытаемся найти форму по названию
    $form_name_map = array(
        'pushstart' => array('pushstart', 'push-start', 'push start'),
        'formfooter' => array('formfooter', 'form-footer', 'footer', 'form footer')
    );
    
    if (isset($form_name_map[$form_type])) {
        $posts = get_posts(array(
            'post_type' => 'wpcf7_contact_form',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));
        
        foreach ($posts as $post) {
            $title_lower = strtolower($post->post_title);
            foreach ($form_name_map[$form_type] as $search_name) {
                if (strpos($title_lower, strtolower($search_name)) !== false) {
                    return $post->ID;
                }
            }
        }
    }
    
    // Если ничего не найдено, возвращаем пустую строку
    return '';
}

// AJAX обработчик для отправки форм
function push_handle_cf7_form_submit() {
    // Проверка nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'push_form_submit')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }
    
    $form_id = isset($_POST['form_id']) ? intval($_POST['form_id']) : 0;
    
    if (empty($form_id) || !function_exists('wpcf7_contact_form')) {
        wp_send_json_error(array('message' => 'Форма не найдена'));
        return;
    }
    
    $contact_form = wpcf7_contact_form($form_id);
    if (!$contact_form) {
        wp_send_json_error(array('message' => 'Форма не найдена'));
        return;
    }
    
    // Подготовка данных для CF7
    $posted_data = array();
    if (isset($_POST['your-name'])) {
        $posted_data['your-name'] = sanitize_text_field($_POST['your-name']);
    }
    if (isset($_POST['your-phone'])) {
        $posted_data['your-phone'] = sanitize_text_field($_POST['your-phone']);
    }
    
    // Очищаем $_POST и устанавливаем необходимые поля для CF7
    $_POST = array();
    $_POST['_wpcf7'] = $form_id;
    $_POST['_wpcf7_version'] = defined('WPCF7_VERSION') ? WPCF7_VERSION : '';
    $_POST['_wpcf7_locale'] = get_locale();
    $_POST['_wpcf7_unit_tag'] = 'wpcf7-f' . $form_id . '-o1';
    
    // Добавляем данные формы в $_POST
    foreach ($posted_data as $key => $value) {
        $_POST[$key] = $value;
    }
    
    // Создаем submission - это важно для работы CFDB7
    // CFDB7 перехватывает данные через хук wpcf7_before_send_mail
    $submission = WPCF7_Submission::get_instance($contact_form);
    
    if ($submission) {
        // Получаем статус и результат
        $status = $submission->get_status();
        $invalid_fields = $submission->get_invalid_fields();
        $response = $submission->get_response();
        
        if ($status === 'mail_sent') {
            $message = $contact_form->message('mail_sent_ok');
            if (empty($message)) {
                $message = !empty($response) ? $response : 'Дякуємо! Ваше повідомлення відправлено.';
            }
            wp_send_json_success(array(
                'message' => $message,
                'status' => 'success'
            ));
        } else {
            $message = $contact_form->message('validation_error');
            if (empty($message)) {
                $message = !empty($response) ? $response : 'Помилка валідації. Перевірте правильність заповнення полів.';
            }
            
            wp_send_json_error(array(
                'message' => $message,
                'status' => 'validation_failed',
                'invalid_fields' => $invalid_fields
            ));
        }
    } else {
        wp_send_json_error(array('message' => 'Ошибка создания submission'));
    }
}
add_action('wp_ajax_push_cf7_submit', 'push_handle_cf7_form_submit');
add_action('wp_ajax_nopriv_push_cf7_submit', 'push_handle_cf7_form_submit');

// AJAX обработчик для получения контента модального окна кейса
function push_get_case_modal_content() {
    // Проверка nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'push_case_modal')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }
    
    $card_index = isset($_POST['card_index']) ? intval($_POST['card_index']) : -1;
    
    if ($card_index < 0) {
        wp_send_json_error(array('message' => 'Не указан индекс карточки'));
        return;
    }
    
    // Получаем карточки кейсов
    $cases_cards = get_field('cases_cards', 'option');
    
    if (!$cases_cards || !is_array($cases_cards) || !isset($cases_cards[$card_index])) {
        wp_send_json_error(array('message' => 'Карточка не найдена'));
        return;
    }
    
    $card = $cases_cards[$card_index];
    $modal_content = isset($card['modal_content']) && is_array($card['modal_content']) && !empty($card['modal_content']) 
        ? $card['modal_content'][0] 
        : null;
    
    if (!$modal_content) {
        wp_send_json_error(array('message' => 'Контент модального окна не найден'));
        return;
    }
    
    // Формируем HTML контента
    $html = '';
    
    // Заголовок
    if (isset($modal_content['header']) && is_array($modal_content['header']) && !empty($modal_content['header'])) {
        $header = $modal_content['header'][0];
        $html .= '<div class="cases-modal__header">';
        
        if (!empty($header['title_orange']) || !empty($header['title_black'])) {
            $html .= '<h2 class="cases-modal__title">';
            if (!empty($header['title_orange'])) {
                $html .= '<span class="cases-modal__title-orange">' . esc_html($header['title_orange']) . '</span>';
            }
            if (!empty($header['title_black'])) {
                $html .= '<span class="cases-modal__title-black">' . esc_html($header['title_black']) . '</span>';
            }
            $html .= '</h2>';
        }
        
        if (!empty($header['subtitle'])) {
            $html .= '<p class="cases-modal__subtitle">' . esc_html($header['subtitle']) . '</p>';
        }
        
        if (!empty($header['logo_label'])) {
            $html .= '<p class="cases-modal__sub">' . esc_html($header['logo_label']) . '</p>';
        }
        
        $html .= '</div>';
    }
    
    // Тело модального окна
    $html .= '<div class="cases-modal__body">';
    $html .= '<div class="cases-modal__content-left">';
    
    // Секции контента
    if (isset($modal_content['sections']) && is_array($modal_content['sections'])) {
        foreach ($modal_content['sections'] as $section) {
            if (empty($section['title']) && empty($section['content'])) {
                continue;
            }
            
            $html .= '<div class="cases-modal__section">';
            
            if (!empty($section['title'])) {
                $html .= '<h3 class="cases-modal__section-title">' . esc_html($section['title']) . '</h3>';
            }
            
            if (!empty($section['content'])) {
                // Проверяем, есть ли списки в контенте
                $content = wp_kses_post($section['content']);
                // Если контент содержит <ul> или <li>, используем его как есть и добавляем класс для списка
                if (strpos($content, '<ul') !== false || strpos($content, '<li') !== false) {
                    // Добавляем класс к списку, если его нет
                    $content = preg_replace('/<ul([^>]*)>/i', '<ul class="cases-modal__section-list"$1>', $content);
                    $html .= $content;
                } else {
                    $html .= '<p class="cases-modal__section-text">' . $content . '</p>';
                }
            }
            
            $html .= '</div>';
        }
    }
    
    $html .= '</div>'; // .cases-modal__content-left
    
    // Правая часть
    $html .= '<div class="cases-modal__content-right">';
    
    // Логотип
    if (!empty($modal_content['logo'])) {
        $logo_image = crb_get_image($modal_content['logo']);
        if ($logo_image && isset($logo_image['url'])) {
            $html .= '<div class="cases-modal__logo">';
            $html .= push_optimized_image($logo_image, 'full', array(
                'loading' => 'lazy',
                'fetchpriority' => 'auto'
            ));
            $html .= '</div>';
        }
    } else {
        $html .= '<div class="cases-modal__logo">';
        $html .= '<div class="cases-modal__image-placeholder">';
        $html .= '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
        $html .= '<path d="M4 16L8 12L12 16L20 8" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        $html .= '<path d="M20 8H16V12" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        $html .= '</svg>';
        $html .= '</div>';
        $html .= '</div>';
    }
    
    // Изображения
    if (!empty($modal_content['images']) && is_array($modal_content['images'])) {
        $html .= '<div class="cases-modal__images">';
        foreach ($modal_content['images'] as $image_item) {
            if (!empty($image_item['image'])) {
                $modal_image = crb_get_image($image_item['image']);
                if ($modal_image && isset($modal_image['url'])) {
                    $html .= '<div class="cases-modal__image-placeholder cases-modal__image-placeholder--small">';
                    $html .= push_optimized_image($modal_image, 'full', array(
                        'loading' => 'lazy',
                        'fetchpriority' => 'auto'
                    ));
                    $html .= '</div>';
                }
            }
        }
        $html .= '</div>';
    } else {
        // Placeholder изображения
        $html .= '<div class="cases-modal__images">';
        $html .= '<div class="cases-modal__image-placeholder cases-modal__image-placeholder--small">';
        $html .= '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
        $html .= '<path d="M4 16L8 12L12 16L20 8" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        $html .= '<path d="M20 8H16V12" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        $html .= '</svg>';
        $html .= '</div>';
        $html .= '<div class="cases-modal__image-placeholder cases-modal__image-placeholder--small">';
        $html .= '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
        $html .= '<path d="M4 16L8 12L12 16L20 8" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        $html .= '<path d="M20 8H16V12" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        $html .= '</svg>';
        $html .= '</div>';
        $html .= '</div>';
    }
    
    // Видео
    if (!empty($modal_content['video'])) {
        $video_url = wp_get_attachment_url($modal_content['video']);
        if ($video_url) {
            $html .= '<div class="cases-modal__video">';
            $html .= '<video controls>';
            $html .= '<source src="' . esc_url($video_url) . '" type="video/mp4">';
            $html .= '</video>';
            $html .= '</div>';
        }
    }
    
    $html .= '</div>'; // .cases-modal__content-right
    $html .= '</div>'; // .cases-modal__body
    
    wp_send_json_success(array(
        'html' => $html
    ));
}
add_action('wp_ajax_push_get_case_modal', 'push_get_case_modal_content');
add_action('wp_ajax_nopriv_push_get_case_modal', 'push_get_case_modal_content');

// Локализация скрипта для AJAX
function push_localize_scripts() {
    wp_localize_script('push-theme-script', 'pushAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('push_form_submit'),
        'caseModalNonce' => wp_create_nonce('push_case_modal')
    ));
}
add_action('wp_enqueue_scripts', 'push_localize_scripts', 20);

// Автоматическая оптимизация изображений в контенте
function push_optimize_content_images($content) {
    if (empty($content)) {
        return $content;
    }
    
    // Используем DOMDocument для парсинга HTML
    if (!class_exists('DOMDocument')) {
        return $content;
    }
    
    $dom = new DOMDocument();
    @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    
    $images = $dom->getElementsByTagName('img');
    
    foreach ($images as $img) {
        // Добавляем loading="lazy" если его нет
        if (!$img->hasAttribute('loading')) {
            $img->setAttribute('loading', 'lazy');
        }
        
        // Добавляем decoding="async" если его нет
        if (!$img->hasAttribute('decoding')) {
            $img->setAttribute('decoding', 'async');
        }
        
        // Добавляем width и height если их нет, но есть src
        if ($img->hasAttribute('src') && !$img->hasAttribute('width') && !$img->hasAttribute('height')) {
            $src = $img->getAttribute('src');
            // Пытаемся получить размеры из URL (для WordPress изображений)
            if (preg_match('/-(\d+)x(\d+)\./', $src, $matches)) {
                $img->setAttribute('width', $matches[1]);
                $img->setAttribute('height', $matches[2]);
            }
        }
        
        // Добавляем srcset если его нет, но есть src с WordPress URL
        if ($img->hasAttribute('src') && !$img->hasAttribute('srcset')) {
            $src = $img->getAttribute('src');
            // Проверяем, является ли это WordPress изображением
            if (preg_match('/wp-content\/uploads\/(\d{4}\/\d{2}\/.*)/', $src, $matches)) {
                // Пытаемся найти attachment ID из URL
                $attachment_id = attachment_url_to_postid($src);
                if ($attachment_id) {
                    $image_meta = wp_get_attachment_metadata($attachment_id);
                    if ($image_meta) {
                        $size_array = array($image_meta['width'], $image_meta['height']);
                        $srcset = wp_calculate_image_srcset($size_array, $src, $image_meta, $attachment_id);
                        $sizes = wp_calculate_image_sizes($size_array, $src, $image_meta, $attachment_id);
                        
                        if ($srcset) {
                            $img->setAttribute('srcset', $srcset);
                        }
                        if ($sizes) {
                            $img->setAttribute('sizes', $sizes);
                        }
                    }
                }
            }
        }
    }
    
    // Сохраняем обратно в HTML
    $content = $dom->saveHTML();
    
    return $content;
}
add_filter('the_content', 'push_optimize_content_images', 20);

// Включаем lazy loading для всех изображений WordPress по умолчанию
add_filter('wp_get_attachment_image_attributes', 'push_add_image_attributes', 10, 3);
function push_add_image_attributes($attr, $attachment, $size) {
    // Добавляем loading="lazy" если его нет
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    
    // Добавляем decoding="async" для асинхронного декодирования
    if (!isset($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }
    
    return $attr;
}

// Добавляем preload для критических изображений в head
function push_preload_critical_images() {
    // Получаем изображение hero push, если мы на главной странице
    if (push_is_front_page()) {
        $hero_push_image = get_field('hero_push_image', 'option');
        if ($hero_push_image) {
            $push_image = crb_get_image($hero_push_image);
            if ($push_image && isset($push_image['url'])) {
                push_preload_image($push_image['url']);
            }
        }
    }
}
add_action('wp_head', 'push_preload_critical_images', 1);
