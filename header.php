<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if (function_exists('wp_body_open')) wp_body_open(); ?>

<div id="page" class="site">
    <div class="header<?php echo !push_is_front_page() ? ' info' : ''; ?>">
        <div class="container">
            <div class="header__wrapp">
                <div class="header__logo">
                    <?php
                    // Пробуем получить логотип с префиксом языка
                    $logo_id = get_field( 'header_logo', 'option' );
                    // Если не найдено, пробуем без префикса (fallback)
                    if ( ! $logo_id ) {
                        $logo_id = carbon_get_theme_option( 'header_logo' );
                    }
                    if ( $logo_id ) {
                        $logo_url = '';
                        $logo_alt = 'Push';
                        
                        // Пробуем использовать функцию crb_get_image, если доступна
                        if ( function_exists( 'crb_get_image' ) ) {
                            $logo = crb_get_image( $logo_id, 'full' );
                            if ( $logo && isset( $logo['url'] ) ) {
                                $logo_url = $logo['url'];
                                $logo_alt = ! empty( $logo['alt'] ) ? $logo['alt'] : 'Push';
                            }
                        }
                        
                        // Если crb_get_image не сработала, используем прямой способ
                        if ( empty( $logo_url ) && is_numeric( $logo_id ) ) {
                            $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                            if ( $logo_url ) {
                                $logo_alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', true );
                                $logo_alt = ! empty( $logo_alt ) ? $logo_alt : 'Push';
                            }
                        }
                        
                        if ( $logo_url ) {
                            echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $logo_alt ) . '">';
                        } else {
                            echo '<span>Push</span>';
                        }
                    } else {
                        echo '<span>Push</span>';
                    }
                    ?>
                </div>
                <div class="header__navigation">
                    <div class="header__menu">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => '',
                            'items_wrap'     => '<ul>%3$s</ul>',
                            'fallback_cb'    => false,
                        ));
                        ?>
                    </div>

                    <div class="header__lang">
                        <?php
                        // Получаем текущий язык и список языков из Polylang
                        $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'uk';
                        
                        // Получаем все языки с параметром hide_if_empty => false, чтобы показывать все языки
                        $languages = function_exists('pll_the_languages') ? pll_the_languages(array(
                            'raw' => 1,
                            'hide_if_empty' => false,
                            'hide_if_no_translation' => false,
                            'force_home' => false
                        )) : array();
                        
                        // Маппинг кодов языков на названия
                        $lang_names = array(
                            'uk' => 'Укр',
                            'en' => 'Eng',
                            'ru' => 'Рус'
                        );
                        
                        // Получаем название текущего языка
                        $current_lang_name = isset($lang_names[$current_lang]) ? $lang_names[$current_lang] : 'Укр';
                        
                        // Если языки не получены, пробуем альтернативный способ
                        if (empty($languages) && function_exists('pll_languages_list')) {
                            $lang_slugs = pll_languages_list();
                            $languages = array();
                            foreach ($lang_slugs as $slug) {
                                $url = function_exists('pll_home_url') ? pll_home_url($slug) : home_url();
                                $languages[] = array(
                                    'slug' => $slug,
                                    'name' => isset($lang_names[$slug]) ? $lang_names[$slug] : $slug,
                                    'url' => $url,
                                    'current_lang' => $slug === $current_lang
                                );
                            }
                        }
                        ?>
                        <button class="header__lang-toggle" type="button" aria-expanded="false">
                            <span class="header__lang-current"><?php echo esc_html($current_lang_name); ?></span>
                            <div class="header__lang-icon">
                                <svg class="header__lang-chevron" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </button>
                        <ul class="header__lang-list">
                            <?php if (!empty($languages) && is_array($languages)): ?>
                                <?php foreach ($languages as $lang): ?>
                                    <?php 
                                    // Проверяем структуру данных языка
                                    $lang_code = isset($lang['slug']) ? $lang['slug'] : (isset($lang['code']) ? $lang['code'] : '');
                                    if (empty($lang_code)) {
                                        continue; // Пропускаем если нет кода языка
                                    }
                                    
                                    $lang_name = isset($lang_names[$lang_code]) ? $lang_names[$lang_code] : (isset($lang['name']) ? $lang['name'] : $lang_code);
                                    $is_current = $lang_code === $current_lang;
                                    
                                    // Получаем URL языка
                                    $lang_url = isset($lang['url']) ? $lang['url'] : '';
                                    if (empty($lang_url) && function_exists('pll_home_url')) {
                                        $lang_url = pll_home_url($lang_code);
                                    }
                                    if (empty($lang_url)) {
                                        $lang_url = home_url();
                                    }
                                    ?>
                                    <li class="header__lang-item<?php echo $is_current ? ' header__lang-item--active' : ''; ?>">
                                        <?php if ($is_current): ?>
                                            <button type="button" class="header__lang-option header__lang-option--active" data-lang="<?php echo esc_attr($lang_code); ?>" disabled><?php echo esc_html($lang_name); ?></button>
                                        <?php else: ?>
                                            <button type="button" class="header__lang-option" data-lang="<?php echo esc_attr($lang_code); ?>" data-lang-url="<?php echo esc_url($lang_url); ?>"><?php echo esc_html($lang_name); ?></button>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback если Polylang не активен или языки не получены -->
                                <?php 
                                // Пробуем получить языки через pll_languages_list
                                if (function_exists('pll_languages_list')) {
                                    $lang_slugs = pll_languages_list();
                                    if (!empty($lang_slugs)) {
                                        foreach ($lang_slugs as $slug) {
                                            $lang_name = isset($lang_names[$slug]) ? $lang_names[$slug] : $slug;
                                            $is_current = $slug === $current_lang;
                                            $lang_url = function_exists('pll_home_url') ? pll_home_url($slug) : home_url();
                                            ?>
                                            <li class="header__lang-item<?php echo $is_current ? ' header__lang-item--active' : ''; ?>">
                                                <?php if ($is_current): ?>
                                                    <button type="button" class="header__lang-option header__lang-option--active" data-lang="<?php echo esc_attr($slug); ?>" disabled><?php echo esc_html($lang_name); ?></button>
                                                <?php else: ?>
                                                    <button type="button" class="header__lang-option" data-lang="<?php echo esc_attr($slug); ?>" data-lang-url="<?php echo esc_url($lang_url); ?>"><?php echo esc_html($lang_name); ?></button>
                                                <?php endif; ?>
                                            </li>
                                            <?php
                                        }
                                    } else {
                                        // Если и это не сработало, показываем статический список
                                        ?>
                                        <li class="header__lang-item">
                                            <button type="button" class="header__lang-option" data-lang="uk">Укр</button>
                                        </li>
                                        <li class="header__lang-item">
                                            <button type="button" class="header__lang-option" data-lang="en">Eng</button>
                                        </li>
                                        <li class="header__lang-item">
                                            <button type="button" class="header__lang-option" data-lang="ru">Рус</button>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    // Fallback если Polylang не активен
                                    ?>
                                    <li class="header__lang-item">
                                        <button type="button" class="header__lang-option" data-lang="uk">Укр</button>
                                    </li>
                                    <li class="header__lang-item">
                                        <button type="button" class="header__lang-option" data-lang="en">Eng</button>
                                    </li>
                                    <li class="header__lang-item">
                                        <button type="button" class="header__lang-option" data-lang="ru">Рус</button>
                                    </li>
                                    <?php
                                }
                                ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <button class="header__burger" type="button" aria-label="Открыть меню">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <a href="#" class="header__contacts">
                        <span>Контакти</span>
                        <div class="header__contacts-icon-wrapp">
                            <svg class="header__contacts-icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Мобильное меню -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu__overlay"></div>
        <div class="mobile-menu__sidebar">
            <button class="mobile-menu__close" type="button" aria-label="Закрыть меню">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            
            <nav class="mobile-menu__nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => '',
                    'items_wrap'     => '<div class="mobile-menu__items">%3$s</div>',
                    'fallback_cb'    => false,
                    'link_before'    => '',
                    'link_after'     => '',
                    'walker'         => new Mobile_Menu_Walker(),
                ));
                ?>
            </nav>

            <a href="#" class="mobile-menu__contacts">
                <span>Контакти</span>
                <div class="mobile-menu__contacts-icon">
                    <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"/>
                    </svg>
                </div>
            </a>
        </div>
    </div>


