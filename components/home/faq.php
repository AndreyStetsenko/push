<?php
// Получаем данные из ACF полей для FAQ секции
$faq_title = get_field('faq_title', 'option') ?: '';
$faq_folders = get_field('faq_folders', 'option');
?>
<div id="faq" class="faq">
    <div class="container">
        <span class="faq__title"><?php echo esc_html($faq_title); ?></span>
    </div>

    <div class="faq__folders">
        <?php if ($faq_folders && is_array($faq_folders) && !empty($faq_folders)): ?>
            <?php foreach ($faq_folders as $folder): ?>
                <?php 
                $folder_type = $folder['folder_type'] ?? 'questions';
                $folder_color = $folder['color'] ?? 'black';
                $folder_number = $folder['number'] ?? 1;
                $folder_tab_title = $folder['tab_title'] ?? '';
                $folder_image_type = $folder['image_type'] ?? 'single';
                $folder_image = $folder['image'] ?? null;
                $folder_socials = $folder['socials'] ?? null;
                $folder_items = $folder['items'] ?? null;
                $folder_contacts = $folder['contacts_group'] ?? null;
                ?>
                <div class="folder folder--<?php echo esc_attr($folder_color); ?> folder--<?php echo esc_attr($folder_number); ?>">
                    <div class="folder__tab">
                        <span class="title"><?php echo esc_html($folder_tab_title); ?></span>
                    </div>
                    <div class="folder__content">
                        <?php if ($folder_type === 'contacts'): ?>
                            <!-- Папка с контактами -->
                            <div class="container">
                                <div class="folder__content--wrapp">
                                    <div class="contacts">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-1-2">
                                                    <div class="contacts__info">
                                                        <h3 class="contacts__title"><?php echo esc_html($folder_contacts['title'] ?? 'контакти'); ?></h3>
                                                        <p class="contacts__description"><?php echo esc_html($folder_contacts['description'] ?? ''); ?></p>

                                                        <?php if (!empty($folder_contacts['action_buttons']) && is_array($folder_contacts['action_buttons'])): ?>
                                                            <div class="contacts__actions">
                                                                <?php foreach ($folder_contacts['action_buttons'] as $button): ?>
                                                                    <button class="contacts__button">
                                                                        <span><?php echo esc_html($button['text'] ?? ''); ?></span>
                                                                        <div class="contacts__button-icon-wrapp">
                                                                            <svg class="contacts__button-icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="white" stroke-width="1.5"></path>
                                                                            </svg>
                                                                        </div>
                                                                    </button>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-3"></div>
                                                <div class="col-4-5">
                                                    <?php if (!empty($folder_contacts['contacts_list']) && is_array($folder_contacts['contacts_list'])): ?>
                                                        <div class="contacts__contacts">
                                                            <?php foreach ($folder_contacts['contacts_list'] as $contact): ?>
                                                                <button class="contacts__button">
                                                                    <div class="info">
                                                                        <span class="name"><?php echo esc_html($contact['name'] ?? ''); ?></span>
                                                                        <span class="sub"><?php echo esc_html($contact['value'] ?? ''); ?></span>
                                                                    </div>
                                                                    <div class="contacts__button-icon-wrapp">
                                                                        <?php 
                                                                        // SVG иконки для разных типов контактов
                                                                        $contact_name = strtolower($contact['name'] ?? '');
                                                                        if ($contact_name === 'telegram'): ?>
                                                                            <svg class="contacts__button-icon" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <g clip-path="url(#clip0_16_1286)">
                                                                                <path d="M33.8292 3.26628L1.21006 15.91C-0.102596 16.4988 -0.546572 17.6779 0.892789 18.3179L9.26101 20.991L29.4943 8.42176C30.5991 7.63269 31.7301 7.8431 30.7569 8.71113L13.3792 24.5268L12.8333 31.2199C13.3389 32.2533 14.2647 32.2582 14.8552 31.7445L19.663 27.1718L27.8971 33.3695C29.8096 34.5076 30.8502 33.7732 31.2617 31.6873L36.6625 5.98141C37.2233 3.41384 36.267 2.28254 33.8292 3.26628Z" fill="white"/>
                                                                                </g>
                                                                                <defs>
                                                                                <clipPath id="clip0_16_1286">
                                                                                <rect width="36.8182" height="36.8182" fill="white"/>
                                                                                </clipPath>
                                                                                </defs>
                                                                            </svg>
                                                                        <?php elseif ($contact_name === 'email'): ?>
                                                                            <svg class="contacts__button-icon" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M32.5 4H4.5C2.575 4 1.0175 5.575 1.0175 7.5L1 28.5C1 30.425 2.575 32 4.5 32H32.5C34.425 32 36 30.425 36 28.5V7.5C36 5.575 34.425 4 32.5 4ZM31.8 11.4375L19.4275 19.1725C18.8675 19.5225 18.1325 19.5225 17.5725 19.1725L5.2 11.4375C5.02452 11.339 4.87086 11.2059 4.74831 11.0463C4.62575 10.8867 4.53686 10.7039 4.48701 10.5089C4.43716 10.3139 4.42738 10.1109 4.45827 9.91204C4.48917 9.71319 4.56009 9.52267 4.66674 9.35203C4.7734 9.18138 4.91357 9.03415 5.07877 8.91924C5.24397 8.80434 5.43077 8.72414 5.62787 8.68352C5.82496 8.6429 6.02825 8.64269 6.22542 8.68291C6.4226 8.72313 6.60956 8.80293 6.775 8.9175L18.5 16.25L30.225 8.9175C30.3904 8.80293 30.5774 8.72313 30.7746 8.68291C30.9718 8.64269 31.175 8.6429 31.3721 8.68352C31.5692 8.72414 31.756 8.80434 31.9212 8.91924C32.0864 9.03415 32.2266 9.18138 32.3333 9.35203C32.4399 9.52267 32.5108 9.71319 32.5417 9.91204C32.5726 10.1109 32.5628 10.3139 32.513 10.5089C32.4631 10.7039 32.3743 10.8867 32.2517 11.0463C32.1291 11.2059 31.9755 11.339 31.8 11.4375Z" fill="white"/>
                                                                            </svg>
                                                                        <?php elseif (in_array($contact_name, ['телефон', 'phone', 'tel'])): ?>
                                                                            <svg class="contacts__button-icon" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M28.1518 34.558C26.7465 34.558 24.7724 34.0497 21.8162 32.3981C18.2215 30.3823 15.441 28.5212 11.8657 24.9552C8.41857 21.5103 6.74107 19.2798 4.3933 15.0076C1.74099 10.1839 2.19312 7.65545 2.69853 6.57479C3.30041 5.28319 4.18883 4.51068 5.33716 3.74393C5.9894 3.31659 6.67964 2.95026 7.39911 2.6496C7.47111 2.61864 7.53806 2.58912 7.59782 2.56248C7.9542 2.40193 8.49416 2.15931 9.17812 2.41849C9.63457 2.58984 10.0421 2.94046 10.6799 3.57042C11.9881 4.86058 13.7758 7.73392 14.4352 9.14503C14.878 10.0961 15.171 10.7239 15.1717 11.428C15.1717 12.2524 14.7571 12.8881 14.2538 13.5742C14.1595 13.7031 14.0659 13.8262 13.9752 13.9457C13.4273 14.6656 13.3071 14.8737 13.3863 15.2452C13.5468 15.9918 14.7441 18.2143 16.7117 20.1776C18.6794 22.1409 20.8378 23.2626 21.5873 23.4225C21.9746 23.5053 22.187 23.38 22.93 22.8127C23.0365 22.7313 23.146 22.6471 23.2604 22.5628C24.0279 21.9919 24.6341 21.588 25.439 21.588H25.4433C26.1439 21.588 26.7436 21.8918 27.7371 22.3929C29.033 23.0466 31.9928 24.8113 33.2909 26.1209C33.9223 26.7573 34.2743 27.1633 34.4464 27.6191C34.7056 28.3052 34.4615 28.843 34.3024 29.203C34.2758 29.2627 34.2462 29.3283 34.2153 29.401C33.9122 30.1192 33.5437 30.8079 33.1145 31.4586C32.3492 32.6033 31.5738 33.4896 30.2793 34.0922C29.6146 34.4067 28.8871 34.5659 28.1518 34.558Z" fill="white"/>
                                                                            </svg>
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
                            </div>
                        <?php else: ?>
                            <!-- Обычная папка с вопросами -->
                            <div class="folder__content--image">
                                <?php if ($folder_image_type === 'multiple' && $folder_socials && is_array($folder_socials) && !empty($folder_socials)): ?>
                                    <div class="socials">
                                        <?php foreach ($folder_socials as $social): ?>
                                            <?php if ($social['image'] && isset($social['image']['url'])): ?>
                                                <img src="<?php echo esc_url($social['image']['url']); ?>" alt="<?php echo esc_attr($social['image']['alt'] ?? ''); ?>">
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php elseif ($folder_image && isset($folder_image['url'])): ?>
                                    <img src="<?php echo esc_url($folder_image['url']); ?>" alt="<?php echo esc_attr($folder_image['alt'] ?? ''); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="folder__content--wrapp">
                                    <?php if ($folder_items && is_array($folder_items) && !empty($folder_items)): ?>
                                        <?php foreach ($folder_items as $item): ?>
                                            <a href="<?php echo esc_url($item['link'] ?? '#'); ?>" class="item">
                                                <span><?php echo esc_html($item['text'] ?? ''); ?></span>
                                                <div class="item__icon">
                                                    <svg class="icon" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M10.5303 0.75V10.75M10.5303 0.75H0.530273M10.5303 0.75L0.530273 10.75" stroke="#FA6000" stroke-width="1.5"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>