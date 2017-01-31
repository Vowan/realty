<?php

function zag_new_shortrent_prop_ajax_action() {


    global $current_user;


    $address_data = array();
    $address_data_ru = array();
    $main_data = array();
    $user_info = array();

    $error_message = array();

    $request = $_REQUEST;

    $files = $_FILES;


    $zag_domain = $request['zag_domain'] ? $request['zag_domain'] : "rus";


    $main_data['cost_US'] = sanitize_text_field($request['cost_US']);
    $main_data['cost_GRN'] = sanitize_text_field($request['cost_GRN']);
    $main_data['totalSQ'] = sanitize_text_field($request['totalSQ']);
    $main_data['liveSQ'] = sanitize_text_field($request['liveSQ']);
    $main_data['rooms'] = sanitize_text_field($request['rooms']);
    $main_data['level'] = sanitize_text_field($request['level']);



    $request['map_autocomplete'] = $request['map_autocomplete'] ? sanitize_text_field($request['map_autocomplete']) : '';

    if ('' == $request['map_autocomplete']) {

        $error_message[] = 'Вы не выбрали адрес с помощью поля ввода над картой';

        wp_send_json_success(array(
            'error' => $error_message,
        ));
        exit();
    }

    $property_type = 'rent_short';

    $map_autocomplete = explode(",", sanitize_text_field($request['map_autocomplete']));


    $address_data['street_number'] = sanitize_text_field($request['street_number']);
    $address_data_ru['street_number'] = '' != $address_data['street_number'] ? sanitize_text_field($map_autocomplete[1]) : '';


    $address_data['route'] = sanitize_text_field($request['route']);
    $address_data_ru['route'] = $map_autocomplete[0];

    $address_data['sublocality_level_1'] = sanitize_text_field($request['sublocality_level_1']);
    $address_data_ru['sublocality_level_1'] = sublocality_translate($address_data['sublocality_level_1']);

    $address_data['locality'] = sanitize_text_field($request['locality']);
    $address_data_ru['locality'] = '' != $address_data['street_number'] ? sanitize_text_field($map_autocomplete[2]) : sanitize_text_field($map_autocomplete[1]);


    $address_data['administrative_area_level_1'] = sanitize_text_field($request['administrative_area_level_1']);
    $address_data_ru['administrative_area_level_1'] = '' != $address_data['street_number'] ? sanitize_text_field($map_autocomplete[3]) : sanitize_text_field($map_autocomplete[2]);

    $address_data['country'] = sanitize_text_field($request['country']);
    $address_data_ru['country'] = '' != $address_data['street_number'] ? sanitize_text_field($map_autocomplete[4]) : sanitize_text_field($map_autocomplete[3]);


    $address_data['latitude'] = sanitize_text_field($request['latitude']);
    $address_data['longitude'] = sanitize_text_field($request['longitude']);



    /*
     * $_FILES['userfile']['name']
     * $_FILES['userfile']['type']
     * $_FILES['userfile']['size']
     * $_FILES['userfile']['tmp_name']
     * $_FILES['userfile']['error']
     *      UPLOAD_ERR_OK
     *      UPLOAD_ERR_INI_SIZE
     *      UPLOAD_ERR_PARTIAL
     *      UPLOAD_ERR_NO_FILE
     *      UPLOAD_ERR_NO_TMP_DIR
     *      UPLOAD_ERR_CANT_WRITE
     *      UPLOAD_ERR_EXTENSION
     */

    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'превышает максимально допустимый размер, установленный на сервере  in php.ini',
        2 => 'превышает максимально добустимый размер  MAX_FILE_SIZE ',
        3 => ' загружен только частично',
        4 => 'загружен не был',
        6 => 'временная директория не доступна',
        7 => 'не записан на диск',
        8 => 'загрузка остановлена',
    );


    foreach ($files['file'] as $key => $values) {

        if ('error' == $key) {

            foreach ($values as $number => $array) {
                foreach ($array as $item => $photo) {
                    if ($photo == UPLOAD_ERR_OK) {

                        $file_name = $files['file']['name'][$number][$item];
                        $file_tmp = $files['file']['tmp_name'][$number][$item];

                        $file_size = round($files['file']['size'][$number][$item] / 1024);

                        if ($file_size < 1) {
                            $error_message[] = 'Размер файла -' . $file_name . ' слишком маленький';
                        }

                        if ($file_size > 10000) {
                            $error_message[] = 'Размер файла -' . $file_name . 'слишком большой';
                        }

                        $filetype = wp_check_filetype($file_name);

                        $image_exts = array('jpg', 'jpeg', 'jpe', 'gif', 'png');


                        if (!in_array($filetype[ext], $image_exts)) {
                            $error_message[] = 'Файл ' . $file_name . '  не имеет допустимого для фото расширения';
                        }
                    } else {
                        $error_message[] = 'Файл ' . $files['file']['name'][$number][$item] . ' ' . $phpFileUploadErrors[$errors];
                    }
                }
            }
        }
    }



    if (!empty($error_message)) {
        wp_send_json_success(array(
            'error' => $error_message,
        ));
        exit();
    }

    $postarr = array(
        'post_type' => 'zag_property',
    );

    $post_id = wp_insert_post($postarr);

    if (0 == $post_id || $post_id instanceof WP_Error) {

        wp_send_json_success(array(
            'error' => 'Объект не создан. Обратитесь к администратору',
        ));
        exit();
    }

    /*     * ******************* create custom upload folder and save property photos ********************** */


    $siteurl = get_option('siteurl');
    $upload_path = trim(get_option('upload_path'));

    if (empty($upload_path) || 'wp-content/uploads' == $upload_path) {
        $dir = WP_CONTENT_DIR . '/uploads';
    } elseif (0 !== strpos($upload_path, ABSPATH)) {
// $dir is absolute, $upload_path is (maybe) relative to ABSPATH
        $dir = path_join(ABSPATH, $upload_path);
    } else {
        $dir = $upload_path;
    }

    if (!$url = get_option('upload_url_path')) {
        if (empty($upload_path) || ( 'wp-content/uploads' == $upload_path ) || ( $upload_path == $dir ))
            $url = WP_CONTENT_URL . '/uploads';
        else
            $url = trailingslashit($siteurl) . $upload_path;
    }


    $subdir = "/" . $current_user->display_name . '_' . $current_user->ID . "/" . $property_type . '_' . $post_id;


    $dir .= $subdir;
    $url .= $subdir;

    wp_mkdir_p($dir);

    if (!wp_is_writable($dir)) {

        wp_delete_post($post_id, true);

        $error_message[] = 'Ваши фото не соханены на сервере. Обратитесь к администратору.';


        wp_send_json_success(array(
            'error' => $error_message,
        ));
        exit();
    }


    /*     * **************************************handle_upload files********************************************* */


    foreach ($files['file'] as $key => $values) {

        if ('name' == $key) {

            foreach ($values as $number => $array) {
                foreach ($array as $item => $photo) {

                    $file_tmp = $files['file']['tmp_name'][$number][$item];

                    // basename() может спасти от атак на файловую систему;
// может понадобиться дополнительная проверка/очистка имени файла
                    $name = basename($file_name);

                    $name = sanitize_text_field($name);

                    $name = $room . '-' . $name;

                    $new_file = $dir . "/" . $name;
                    $new_file_url = $url . "/" . $name;

                    $img_editor = wp_get_image_editor($file_tmp);

                    $img_size = $img_editor->get_size();


                    if ($img_size['width'] > 300 || $img_size['height'] > 300) {

                        $img_editor->resize(300, 300);
                    }

                    $img_editor->save($new_file);




                    // Check the type of file. We'll use this as the 'post_mime_type'.
                    $filetype = wp_check_filetype(basename($name), null);

// Prepare an array of post data for the attachment.
                    $attachment = array(
                        'guid' => $url . '/' . basename($name),
                        'post_mime_type' => $filetype['type'],
                        'post_title' => preg_replace('/\.[^.]+$/', '', basename($name)),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );

// Insert the attachment.$new_file
                    $attach_id = wp_insert_attachment($attachment, $new_file, $post_id);

// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );

// Generate the metadata for the attachment, and update the database record.
                    $attach_data = wp_generate_attachment_metadata($attach_id, $new_file);
                    wp_update_attachment_metadata($attach_id, $attach_data);

                    //add_post_meta($attach_id, 'room', $room);
                    //add_post_meta($attach_id, 'room_sq', $room_sq);
                    // $rooms_data[$room][] = $attach_id;
                }
            }
        }
    }

    $user_info['user_first_name'] = sanitize_text_field($request['user_first_name']);
    $user_info['user_last_name'] = sanitize_text_field($request['user_last_name']);
    $user_info['user_tel'] = sanitize_text_field($request['user_tel']);
    $user_info['user_email'] = sanitize_text_field($request['user_email']);
    $user_info['user_agency'] = sanitize_text_field($request['user_agency']);


    update_post_meta($post_id, 'property_type', $property_type);

    update_post_meta($post_id, 'street_number', $address_data['street_number']);

    update_post_meta($post_id, 'uk_route', $address_data['route']);
    update_post_meta($post_id, 'rus_route', $address_data_ru['route']);

    update_post_meta($post_id, 'uk_sublocality', $address_data['sublocality_level_1']);
    update_post_meta($post_id, 'rus_sublocality', $address_data_ru['sublocality_level_1']);

    update_post_meta($post_id, 'uk_locality', $address_data['locality']);
    update_post_meta($post_id, 'rus_locality', $address_data_ru['locality']);

    update_post_meta($post_id, 'uk_administrative', $address_data['administrative_area_level_1']);
    update_post_meta($post_id, 'rus_administrative', $address_data_ru['administrative_area_level_1']);

    update_post_meta($post_id, 'uk_country', $address_data['country']);
    update_post_meta($post_id, 'rus_country', $address_data_ru['country']);

    update_post_meta($post_id, 'address_data', $address_data);
    update_post_meta($post_id, 'address_data_ru', $address_data_ru);

    update_post_meta($post_id, ' $main_data', $main_data);

    update_post_meta($post_id, 'user_info', $user_info);


    $postarr = array(
        'post_type' => 'zag_property',
        'post_title' => $current_user->display_name . '_' . $current_user->ID . "_post_" . $post_id,
        'ID' => $post_id,
        'post_status' => 'publish',
    );

    $post_update = wp_insert_post($postarr);


    if (0 == $post_update || $post_update instanceof WP_Error) {

        wp_send_json_success(array(
            'error' => 'Объект не создан. Обратитесь к администратору',
        ));
        exit();
    }

    wp_send_json_success(array(
        'ok' => 'ok',
    ));
}
