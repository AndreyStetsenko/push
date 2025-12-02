<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <div class="header<?php echo !is_front_page() ? ' info' : ''; ?>">
        <div class="container">
            <div class="header__wrapp">
                <div class="header__logo">
                    <span>Push</span>
                </div>
                <div class="header__navigation">
                    <div class="header__menu">
                        <ul>
                            <li><a href="<?= home_url(); ?>">Головна</a></li>
                            <li><a href="#">Послуги</a></li>
                            <li><a href="#">Чому ми</a></li>
                            <li><a href="#">Кейси</a></li>
                            <li><a href="#">Актори</a></li>
                            <li><a href="#">Етапи співпраці</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li class="img"><a href="#">
                                <img src="<?= img_url('icons/surprise.png'); ?>" alt="surprise">
                            </a></li>
                        </ul>
                    </div>

                    <div class="header__lang">
                        <button class="header__lang-toggle" type="button" aria-expanded="false">
                            <span class="header__lang-current">Укр</span>
                            <div class="header__lang-icon">
                                <svg class="header__lang-chevron" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </button>
                        <ul class="header__lang-list">
                            <li class="header__lang-item">
                                <button type="button" class="header__lang-option" data-lang="uk">Укр</button>
                            </li>
                            <li class="header__lang-item">
                                <button type="button" class="header__lang-option" data-lang="en">Eng</button>
                            </li>
                            <li class="header__lang-item">
                                <button type="button" class="header__lang-option" data-lang="ru">Рус</button>
                            </li>
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
                <a href="#" class="mobile-menu__item mobile-menu__item--active">Головна</a>
                <a href="#" class="mobile-menu__item">Послуги</a>
                <a href="#" class="mobile-menu__item">Чому ми?</a>
                <a href="#" class="mobile-menu__item">Кейси</a>
                <a href="#" class="mobile-menu__item">Актори</a>
                <a href="#" class="mobile-menu__item">Етапи співпраці</a>
                <a href="#" class="mobile-menu__item">FAQ</a>
                
                <div class="mobile-menu__gift">
                    <img src="<?= img_url('icons/surprise.png'); ?>" alt="gift">
                </div>
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


