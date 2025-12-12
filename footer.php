    <div id="scrolline" class="scrolline">
        <div class="scrolline__track">
            <div class="scrolline__wrapp">
                <div class="item">
                    <span>push</span>

                    <div class="item__icon">
                        <img src="<?= img_url('scrolline/btnp.png'); ?>" alt="">
                    </div>
                </div>

                <div class="item">
                    <span>push</span>

                    <div class="item__icon">
                        <img src="<?= img_url('scrolline/btnp.png'); ?>" alt="">
                    </div>
                </div>

                <div class="item">
                    <span>push</span>

                    <div class="item__icon">
                        <img src="<?= img_url('scrolline/btnp.png'); ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="scrolline__wrapp" aria-hidden="true">
                <div class="item">
                    <span>push</span>

                    <div class="item__icon">
                        <img src="<?= img_url('scrolline/btnp.png'); ?>" alt="">
                    </div>
                </div>

                <div class="item">
                    <span>push</span>

                    <div class="item__icon">
                        <img src="<?= img_url('scrolline/btnp.png'); ?>" alt="">
                    </div>
                </div>

                <div class="item">
                    <span>push</span>

                    <div class="item__icon">
                        <img src="<?= img_url('scrolline/btnp.png'); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Получаем данные из Carbon Fields для Footer Form секции
    $footer_form_title_group = get_field('footer_form_title_group', 'option');
    $footer_form_title_first = $footer_form_title_group && isset($footer_form_title_group['first']) ? $footer_form_title_group['first'] : 'Push-старт';
    $footer_form_title_second = $footer_form_title_group && isset($footer_form_title_group['second']) ? $footer_form_title_group['second'] : 'для твого бренду';
    ?>

    <div id="formfooter" class="formfooter">
        <div class="container">
            <div class="row">
                <div class="col-1">
                    <div class="formfooter__title">
                        <span class="formfooter__title-first"><?php echo esc_html($footer_form_title_first); ?></span>
                        <span class="formfooter__title-second"><?php echo esc_html($footer_form_title_second); ?></span>
                    </div>
                </div>
                <div class="col-2-3-4-5">
                    <div class="formfooter__form">
                        <?php 
                        $formfooter_form_id = push_get_cf7_form_id('formfooter');
                        // Если ID не найден, можно установить напрямую здесь:
                        // $formfooter_form_id = 124; // Замените на реальный ID формы
                        ?>
                        <form class="formfooter-form" data-form-id="<?php echo esc_attr($formfooter_form_id); ?>" method="post" novalidate>
                            <div class="wrapp">
                                <input type="text" name="your-name" placeholder="Ваше Ім'я" required>
                                <input type="tel" name="your-phone" placeholder="Номер телефону" required>
                                <button type="submit" class="formfooter__button">
                                    <span>Зв'язатись з нами</span>
                                    <div class="icon-wrap">
                                        <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"></path>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="wpcf7-response-output" aria-hidden="true"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer id="footer" class="footer">
        <div class="container">
            <div class="row">
                <div class="col-1">
                    <div class="footer__nav">
                        <span class="title">контакти</span>
                        <div class="menu">
                            <ul>
                                <li><a href="https://t.me/push_admin_1">
                                    <div class="icon">
                                        <svg width="100%" height="100%" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
                                            <g clip-path="url(#clip0_16_1239)">
                                            <path d="M18.3764 1.77727L0.657316 8.64547C-0.0557314 8.96531 -0.296903 9.60582 0.484972 9.95344L5.03068 11.4055L16.0216 4.57777C16.6217 4.14914 17.2361 4.26344 16.7074 4.73496L7.26771 13.3262L6.97118 16.962C7.24583 17.5233 7.74872 17.5259 8.0695 17.2469L10.6811 14.763L15.154 18.1297C16.1929 18.7479 16.7581 18.3489 16.9817 17.2158L19.9154 3.25215C20.2201 1.85742 19.7006 1.24289 18.3764 1.77727Z" fill="#FA6000"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_16_1239">
                                            <rect width="20" height="20" fill="white"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <span>tg: @push_admin_1</span>
                                </a></li>
                                <li><a href="mailto:push.smm.ua@gmail.com">
                                    <div class="icon">
                                        <svg width="100%" height="100%" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
                                            <path d="M15.2696 18.7496C14.5071 18.7496 13.436 18.4739 11.8321 17.5778C9.88171 16.484 8.37312 15.4742 6.43327 13.5395C4.56296 11.6703 3.6528 10.4602 2.37898 8.14222C0.939914 5.52503 1.18523 4.15315 1.45945 3.56683C1.78601 2.86604 2.26804 2.4469 2.89109 2.03089C3.24497 1.79903 3.61947 1.60027 4.00984 1.43714C4.0489 1.42034 4.08523 1.40433 4.11765 1.38987C4.31101 1.30276 4.60398 1.17112 4.97507 1.31175C5.22273 1.40472 5.44382 1.59495 5.78991 1.93675C6.49968 2.63675 7.4696 4.19573 7.82741 4.96136C8.06765 5.47737 8.22663 5.818 8.22702 6.20003C8.22702 6.64729 8.00202 6.99222 7.72898 7.36448C7.6778 7.4344 7.62702 7.5012 7.5778 7.56604C7.28054 7.95667 7.2153 8.06956 7.25827 8.27112C7.34538 8.6762 7.99499 9.88206 9.06257 10.9473C10.1301 12.0125 11.3012 12.6211 11.7079 12.7078C11.918 12.7528 12.0333 12.6848 12.4364 12.377C12.4942 12.3328 12.5536 12.2871 12.6157 12.2414C13.0321 11.9317 13.361 11.7125 13.7977 11.7125H13.8001C14.1801 11.7125 14.5055 11.8774 15.0446 12.1492C15.7477 12.5039 17.3536 13.4614 18.0579 14.1719C18.4005 14.5172 18.5915 14.7375 18.6848 14.9848C18.8255 15.3571 18.693 15.6489 18.6067 15.8442C18.5923 15.8766 18.5762 15.9121 18.5594 15.9516C18.395 16.3413 18.1951 16.715 17.9622 17.068C17.5469 17.6891 17.1262 18.17 16.4239 18.4969C16.0632 18.6675 15.6685 18.7539 15.2696 18.7496Z" fill="#FA6000"/>
                                        </svg>
                                    </div>
                                    <span>push.smm.ua@gmail.com</span>
                                </a></li>
                                <li><a href="tel:+380936056564">
                                    <div class="icon">
                                        <svg width="100%" height="100%" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
                                            <path d="M16.6641 3.33594H3.33073C2.41406 3.33594 1.6724 4.08594 1.6724 5.0026L1.66406 15.0026C1.66406 15.9193 2.41406 16.6693 3.33073 16.6693H16.6641C17.5807 16.6693 18.3307 15.9193 18.3307 15.0026V5.0026C18.3307 4.08594 17.5807 3.33594 16.6641 3.33594ZM16.3307 6.8776L10.4391 10.5609C10.1724 10.7276 9.82239 10.7276 9.55573 10.5609L3.66406 6.8776C3.5805 6.8307 3.50733 6.76732 3.44897 6.69132C3.39061 6.61531 3.34828 6.52825 3.32454 6.43541C3.3008 6.34257 3.29615 6.24588 3.31086 6.15119C3.32557 6.0565 3.35934 5.96578 3.41013 5.88452C3.46092 5.80326 3.52767 5.73315 3.60633 5.67843C3.685 5.62372 3.77395 5.58553 3.86781 5.56619C3.96166 5.54684 4.05846 5.54674 4.15236 5.56589C4.24625 5.58505 4.33528 5.62305 4.41406 5.6776L9.99739 9.16927L15.5807 5.6776C15.6595 5.62305 15.7485 5.58505 15.8424 5.56589C15.9363 5.54674 16.0331 5.54684 16.127 5.56619C16.2208 5.58553 16.3098 5.62372 16.3885 5.67843C16.4671 5.73315 16.5339 5.80326 16.5847 5.88452C16.6354 5.96578 16.6692 6.0565 16.6839 6.15119C16.6986 6.24588 16.694 6.34257 16.6702 6.43541C16.6465 6.52825 16.6042 6.61531 16.5458 6.69132C16.4875 6.76732 16.4143 6.8307 16.3307 6.8776Z" fill="#FA6000"/>
                                        </svg>
                                    </div>
                                    <span>+38 (093) 605-65-64</span>
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="footer__nav">
                        <span class="title">меню</span>
                        <div class="menu">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'primary',
                                'container'      => false,
                                'menu_class'     => '',
                                'items_wrap'     => '<ul>%3$s</ul>',
                                'fallback_cb'    => false,
                                'walker'         => new Footer_Menu_Walker(),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php
                if (has_nav_menu('footer')) {
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => '',
                        'items_wrap'     => '%3$s',
                        'fallback_cb'    => false,
                        'walker'         => new Footer_Privacy_Walker(),
                    ));
                } else {
                    echo '<div class="col-1"><a href="#" class="footer__privacy">Політика конфіденційності</a></div>';
                    echo '<div class="col-2"><a href="#" class="footer__privacy">Умови використання сайту</a></div>';
                }
                ?>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

