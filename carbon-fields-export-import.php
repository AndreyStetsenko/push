<?php
/**
 * Экспорт/Импорт данных Carbon Fields
 */

// Добавляем страницу в меню админки
add_action( 'admin_menu', 'crb_add_export_import_page', 100 );
function crb_add_export_import_page() {
    // Проверяем, что Carbon Fields активен
    if ( ! class_exists( 'Carbon_Fields\Carbon_Fields' ) ) {
        return;
    }
    
    // Пытаемся найти любую страницу Carbon Fields для использования как родительскую
    global $submenu;
    $parent_slug = null;
    
    // Ищем первую страницу Carbon Fields
    if ( isset( $submenu ) ) {
        foreach ( $submenu as $menu_slug => $items ) {
            if ( is_array( $items ) ) {
                foreach ( $items as $item ) {
                    if ( isset( $item[2] ) && strpos( $item[2], 'crb_carbon_fields_container_' ) === 0 ) {
                        $parent_slug = $item[2];
                        break 2;
                    }
                }
            }
        }
    }
    
    // Если не нашли, создаем как отдельную страницу в меню настроек
    if ( $parent_slug ) {
        add_submenu_page(
            $parent_slug,
            'Экспорт/Импорт Carbon Fields',
            'Экспорт/Импорт',
            'manage_options',
            'crb-export-import',
            'crb_export_import_page'
        );
    } else {
        add_options_page(
            'Экспорт/Импорт Carbon Fields',
            'Carbon Fields Export/Import',
            'manage_options',
            'crb-export-import',
            'crb_export_import_page'
        );
    }
}

// Обработка экспорта
add_action( 'admin_init', 'crb_handle_export' );
function crb_handle_export() {
    if ( ! isset( $_GET['crb_export'] ) || ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    check_admin_referer( 'crb_export' );
    
    // Получаем все опции темы (Carbon Fields хранит данные в опциях)
    global $wpdb;
    
    $export_data = array(
        'version' => '1.0',
        'date' => current_time( 'mysql' ),
        'theme_options' => array(),
    );
    
    // Получаем все опции Carbon Fields
    // Carbon Fields использует формат: _field_name или _field_name|... для complex полей
    // Сначала получаем все опции, которые содержат | (это точно Carbon Fields complex поля)
    $options_with_pipe = $wpdb->get_results(
        "SELECT option_name, option_value FROM {$wpdb->options} 
         WHERE option_name LIKE '_%|%'
         ORDER BY option_name",
        ARRAY_A
    );
    
    // Получаем простые поля Carbon Fields по известным префиксам из конфигурации
    // Известные префиксы полей (могут иметь префикс языка _ru, _en и т.д.)
    $field_prefixes = array(
        'hero_', 'services_', 'whyus_', 'pushstart_', 'cases_', 
        'actors_', 'collab_', 'bonus_', 'faq_'
    );
    
    $simple_fields = array();
    foreach ( $field_prefixes as $prefix ) {
        $prefix_with_underscore = '_' . $prefix;
        $prefix_results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT option_name, option_value FROM {$wpdb->options} 
                 WHERE option_name LIKE %s
                 AND option_name NOT LIKE %s
                 ORDER BY option_name",
                $prefix_with_underscore . '%',
                $prefix_with_underscore . '%|%'
            ),
            ARRAY_A
        );
        $simple_fields = array_merge( $simple_fields, $prefix_results );
    }
    
    // Объединяем complex поля и простые поля
    $options = array_merge( $options_with_pipe, $simple_fields );
    
    foreach ( $options as $option ) {
        $export_data['theme_options'][ $option['option_name'] ] = maybe_unserialize( $option['option_value'] );
    }
    
    // Получаем данные из postmeta для постов, страниц и других типов записей
    // Carbon Fields использует ключи с префиксом _ и разделителем | для complex полей
    $postmeta = $wpdb->get_results(
        "SELECT post_id, meta_key, meta_value FROM {$wpdb->postmeta} 
         WHERE (meta_key LIKE '_%|%' OR meta_key REGEXP '^_[a-zA-Z0-9_]+$')
         AND meta_key NOT LIKE '_wp_%'
         AND meta_key NOT LIKE '_edit_%'
         AND meta_key NOT LIKE '_thumbnail_id'
         ORDER BY post_id, meta_key",
        ARRAY_A
    );
    
    $export_data['post_meta'] = array();
    foreach ( $postmeta as $meta ) {
        if ( ! isset( $export_data['post_meta'][ $meta['post_id'] ] ) ) {
            $export_data['post_meta'][ $meta['post_id'] ] = array();
        }
        $export_data['post_meta'][ $meta['post_id'] ][ $meta['meta_key'] ] = maybe_unserialize( $meta['meta_value'] );
    }
    
    // Получаем данные из termmeta для терминов таксономий
    $termmeta = $wpdb->get_results(
        "SELECT term_id, meta_key, meta_value FROM {$wpdb->termmeta} 
         WHERE (meta_key LIKE '_%|%' OR meta_key REGEXP '^_[a-zA-Z0-9_]+$')
         ORDER BY term_id, meta_key",
        ARRAY_A
    );
    
    $export_data['term_meta'] = array();
    foreach ( $termmeta as $meta ) {
        if ( ! isset( $export_data['term_meta'][ $meta['term_id'] ] ) ) {
            $export_data['term_meta'][ $meta['term_id'] ] = array();
        }
        $export_data['term_meta'][ $meta['term_id'] ][ $meta['meta_key'] ] = maybe_unserialize( $meta['meta_value'] );
    }
    
    // Получаем данные из usermeta для пользователей
    $usermeta = $wpdb->get_results(
        "SELECT user_id, meta_key, meta_value FROM {$wpdb->usermeta} 
         WHERE (meta_key LIKE '_%|%' OR meta_key REGEXP '^_[a-zA-Z0-9_]+$')
         AND meta_key NOT LIKE '_wp_%'
         AND meta_key NOT LIKE 'wp_%'
         ORDER BY user_id, meta_key",
        ARRAY_A
    );
    
    $export_data['user_meta'] = array();
    foreach ( $usermeta as $meta ) {
        if ( ! isset( $export_data['user_meta'][ $meta['user_id'] ] ) ) {
            $export_data['user_meta'][ $meta['user_id'] ] = array();
        }
        $export_data['user_meta'][ $meta['user_id'] ][ $meta['meta_key'] ] = maybe_unserialize( $meta['meta_value'] );
    }
    
    // Отправляем файл для скачивания
    $filename = 'carbon-fields-export-' . date( 'Y-m-d-H-i-s' ) . '.json';
    
    header( 'Content-Type: application/json; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
    header( 'Pragma: no-cache' );
    header( 'Expires: 0' );
    
    echo wp_json_encode( $export_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
    exit;
}

// Обработка импорта
add_action( 'admin_init', 'crb_handle_import' );
function crb_handle_import() {
    if ( ! isset( $_POST['crb_import'] ) || ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    check_admin_referer( 'crb_import' );
    
    if ( ! isset( $_FILES['crb_import_file'] ) || $_FILES['crb_import_file']['error'] !== UPLOAD_ERR_OK ) {
        wp_die( 'Ошибка загрузки файла.' );
    }
    
    $file = $_FILES['crb_import_file']['tmp_name'];
    $content = file_get_contents( $file );
    $data = json_decode( $content, true );
    
    if ( ! $data || ! isset( $data['theme_options'] ) ) {
        wp_die( 'Неверный формат файла экспорта.' );
    }
    
    global $wpdb;
    $imported = 0;
    $errors = array();
    
    // Импортируем опции темы
    if ( isset( $data['theme_options'] ) && is_array( $data['theme_options'] ) ) {
        foreach ( $data['theme_options'] as $option_name => $option_value ) {
            $serialized = maybe_serialize( $option_value );
            $result = update_option( $option_name, $option_value );
            if ( $result !== false ) {
                $imported++;
            } else {
                $errors[] = 'Ошибка импорта опции: ' . $option_name;
            }
        }
    }
    
    // Импортируем postmeta
    if ( isset( $data['post_meta'] ) && is_array( $data['post_meta'] ) ) {
        foreach ( $data['post_meta'] as $post_id => $meta_data ) {
            // Проверяем существование поста
            if ( ! get_post( $post_id ) ) {
                $errors[] = 'Пост с ID ' . $post_id . ' не найден, пропущен';
                continue;
            }
            
            foreach ( $meta_data as $meta_key => $meta_value ) {
                $result = update_post_meta( $post_id, $meta_key, $meta_value );
                if ( $result !== false ) {
                    $imported++;
                } else {
                    $errors[] = 'Ошибка импорта postmeta: ' . $meta_key . ' для поста ' . $post_id;
                }
            }
        }
    }
    
    // Импортируем termmeta
    if ( isset( $data['term_meta'] ) && is_array( $data['term_meta'] ) ) {
        foreach ( $data['term_meta'] as $term_id => $meta_data ) {
            // Проверяем существование термина
            if ( ! term_exists( $term_id ) ) {
                $errors[] = 'Термин с ID ' . $term_id . ' не найден, пропущен';
                continue;
            }
            
            foreach ( $meta_data as $meta_key => $meta_value ) {
                $result = update_term_meta( $term_id, $meta_key, $meta_value );
                if ( $result !== false ) {
                    $imported++;
                } else {
                    $errors[] = 'Ошибка импорта termmeta: ' . $meta_key . ' для термина ' . $term_id;
                }
            }
        }
    }
    
    // Импортируем usermeta
    if ( isset( $data['user_meta'] ) && is_array( $data['user_meta'] ) ) {
        foreach ( $data['user_meta'] as $user_id => $meta_data ) {
            // Проверяем существование пользователя
            if ( ! get_userdata( $user_id ) ) {
                $errors[] = 'Пользователь с ID ' . $user_id . ' не найден, пропущен';
                continue;
            }
            
            foreach ( $meta_data as $meta_key => $meta_value ) {
                $result = update_user_meta( $user_id, $meta_key, $meta_value );
                if ( $result !== false ) {
                    $imported++;
                } else {
                    $errors[] = 'Ошибка импорта usermeta: ' . $meta_key . ' для пользователя ' . $user_id;
                }
            }
        }
    }
    
    // Сохраняем результат в транзиенте для отображения
    $message = sprintf( 'Импортировано записей: %d', $imported );
    if ( ! empty( $errors ) ) {
        $message .= '<br>Ошибки: ' . implode( '<br>', array_slice( $errors, 0, 10 ) );
        if ( count( $errors ) > 10 ) {
            $message .= '<br>... и ещё ' . ( count( $errors ) - 10 ) . ' ошибок';
        }
    }
    
    set_transient( 'crb_import_result', $message, 30 );
    
    // Определяем правильный URL для редиректа
    // Пробуем оба варианта URL
    $redirect_url = admin_url( 'admin.php?page=crb-export-import' );
    
    wp_safe_redirect( $redirect_url );
    exit;
}

// Страница экспорта/импорта
function crb_export_import_page() {
    $import_result = get_transient( 'crb_import_result' );
    if ( $import_result ) {
        delete_transient( 'crb_import_result' );
    }
    ?>
    <div class="wrap">
        <h1>Экспорт/Импорт данных Carbon Fields</h1>
        
        <?php if ( $import_result ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo wp_kses_post( $import_result ); ?></p>
            </div>
        <?php endif; ?>
        
        <div class="card" style="max-width: 800px;">
            <h2>Экспорт данных</h2>
            <p>Экспортировать все данные Carbon Fields (опции темы, метаданные постов, терминов и пользователей) в JSON файл.</p>
            <p>
                <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=crb-export-import&crb_export=1' ), 'crb_export' ) ); ?>" 
                   class="button button-primary">
                    Экспортировать данные
                </a>
            </p>
        </div>
        
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2>Импорт данных</h2>
            <p>Импортировать данные Carbon Fields из JSON файла. <strong>Внимание:</strong> существующие данные будут перезаписаны!</p>
            <form method="post" enctype="multipart/form-data">
                <?php wp_nonce_field( 'crb_import' ); ?>
                <p>
                    <input type="file" name="crb_import_file" accept=".json" required>
                </p>
                <p>
                    <input type="submit" name="crb_import" class="button button-primary" value="Импортировать данные">
                </p>
            </form>
        </div>
        
        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2>Информация</h2>
            <ul>
                <li>Экспорт включает все данные Carbon Fields: опции темы, метаданные постов, терминов и пользователей</li>
                <li>Импорт перезапишет существующие данные соответствующими значениями из файла</li>
                <li>Файл экспорта имеет формат JSON с кодировкой UTF-8</li>
                <li>При импорте проверяется существование постов, терминов и пользователей</li>
            </ul>
        </div>
    </div>
    <?php
}

