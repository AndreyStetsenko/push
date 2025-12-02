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
