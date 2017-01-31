<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class-zag-frontend-ajax
 *
 * @author vova
 */
class Zag_Frontend_Ajax {

    public function zag_map_post() {

        $post_on_map_id = $_REQUEST["post_id"];
        $post_on_map_id = sanitize_text_field($post_on_map_id);

        $post_on_map_id = intval($post_on_map_id);

        if (!$post_on_map_id) {

            wp_send_json_error(array(
                'error' => 'Отредактировать пост невозможно, обратитесь к администратору'
            ));
            exit();
        }

        $post = get_post($post_on_map_id, OBJECT, 'display');

        if ($post->post_type == 'zag_property') {
            $attachments = get_posts(array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'post_parent' => $post->ID,
                'exclude' => get_post_thumbnail_id()
            ));

            if ($attachments) {
                foreach ($attachments as $attachment) {
//$class = "post-attachment mime-" . sanitize_title($attachment->post_mime_type);
                    $link = wp_get_attachment_image_src($attachment->ID, $size = 'img-prop-size', $icon = false);
// echo '<li class="' . $class . ' data-design-thumbnail">' . $thumbimg . '</li>';
                }
            }
        }


        if (!$post) {
            wp_send_json_error(array(
                'error' => 'Отредактировать пост невозможно, обратитесь к администратору'
            ));
            exit();
        }

        wp_send_json_success(array(
            'update' => 'ok',
        ));
        exit();
    }

    public function zag_post_edit() {

        $post_to_edit_id = $_REQUEST["post_to_edit"];
        $post_to_edit_id = sanitize_text_field($post_to_edit_id);

        $post_to_edit_id = intval($post_to_edit_id);

        if (!$post_to_edit_id) {

            wp_send_json_error(array(
                'error' => 'Отредактировать пост невозможно, обратитесь к администратору'
            ));
            exit();
        }

        $post = get_post($post_to_edit_id, OBJECT, 'display');


        if (!$post) {
            wp_send_json_error(array(
                'error' => 'Отредактировать пост невозможно, обратитесь к администратору'
            ));
            exit();
        }

        $rooms = get_post_meta($post->ID, "rooms_data", true);
        $address = get_post_meta($post->ID, "address_data", true);
        $main = get_post_meta($post->ID, "main_prop_features", true);

        wp_send_json_success(array(
            'rooms' => $rooms,
            'address' => $address,
            'main' => $main,
        ));
        exit();
    }

    public function zag_post_unpublish() {
        $post_to_unpublish_id = $_REQUEST["post_to_unpublish"];
        $post_to_unpublish_id = sanitize_text_field($post_to_unpublish_id);

        $post_to_unpublish_id = intval($post_to_unpublish_id);

        if (!$post_to_unpublish_id) {

            wp_send_json_error(array(
                'error' => 'Убрать пост невозможно, обратитесь к администратору'
            ));
            exit();
        }

        $post = get_post($post_to_unpublish_id, OBJECT, 'edit');


        if (!$post) {
            wp_send_json_error(array(
                'error' => 'Убрать пост невозможно, обратитесь к администратору'
            ));
            exit();
        }

        $postarr = array(
            'post_type' => 'zag_property',
            'ID' => $post->ID,
            'post_status' => 'draft'
        );

        $post_update = wp_insert_post($postarr);

        if (!$post_update || $post_update instanceof WP_Error) {
            wp_send_json_error(array(
                'error' => 'Убрать пост невозможно, обратитесь к администратору'
            ));
            exit();
        }

        wp_send_json_success(array(
            'update' => 'ok',
            'id' => $post_update
        ));
        exit();
    }

    public function zag_post_publish() {

        $post_to_publish_id = $_REQUEST["post_to_publish"];
        $post_to_publish_id = sanitize_text_field($post_to_publish_id);

        $post_to_publish_id = intval($post_to_publish_id);

        if (!$post_to_publish_id) {

            wp_send_json_error(array(
                'error' => 'Публикация нвозможна, обратитесь к администратору'
            ));
            exit();
        }

        $post = get_post($post_to_publish_id, OBJECT, 'edit');


        if (!$post) {
            wp_send_json_error(array(
                'error' => 'Публикация нвозможна, обратитесь к администратору'
            ));
            exit();
        }

        $postarr = array(
            'post_type' => 'zag_property',
            'ID' => $post->ID,
            'post_status' => 'publish'
        );

        $post_update = wp_insert_post($postarr);

        if (!$post_update || $post_update instanceof WP_Error) {
            wp_send_json_error(array(
                'error' => 'Публикация не состоялась, обратитесь к администратору'
            ));
            exit();
        }

        wp_send_json_success(array(
            'update' => 'ok',
            'id' => $post_update
        ));
        exit();
    }

    public function zag_new_property() {

        $address_data = array();
        $error_message = array();

        $request = $_REQUEST;
        $file = $_FILES;

        $zag_domain = $request['zag_domain'] ? $request['zag_domain'] : "rus";


        $request['map_autocomplete'] = $request['map_autocomplete'] ? sanitize_text_field($request['map_autocomplete']) : '';

        if ('' == $request['map_autocomplete']) {

            $error_message[] = 'Вы не выбрали адрес с помощью поля ввода над картой';

            wp_send_json_success(array(
                'error' => $error_message,
            ));
            exit();
        }

        $map_autocomplete = explode(",", $request['map_autocomplete']);




        $user_info['user_first_name'] = $request['user_first_name'] ? sanitize_text_field($request['user_first_name']) : "";

        $user_info['user_last_name'] = $request['user_last_name'] ? sanitize_text_field($request['user_last_name']) : "";

        $user_info['user_tel'] = $request['user_tel'] ? sanitize_text_field($request['user_tel']) : "";


        $user_info['user_email'] = $request['user_email'] ? sanitize_text_field($request['user_email']) : "";

        $user_info['user_agency'] = $request['user_agency'] ? sanitize_text_field($request['user_agency']) : "";


        /*         * *******************************************checking incoming data *************************************** */



        $address_data['street_number'] = $request['street_number'] ? $request['street_number'] : "";

        if ('' == $request['street_number']) {

            $error_message[] = 'Ваш  адрес не содержит номера дома - уточните его с помощью поля '
                    . 'автозаполнения на верху карты';

            wp_send_json_success(array(
                'error' => $error_message,
            ));
            exit();
        }





        $address_data['street_number'] = sanitize_text_field($address_data['street_number']);

        $address_data['route'] = $request['route'] ? $request['route'] : "";
        $address_data['route'] = sanitize_text_field($address_data['route']);


        $address_data['locality'] = $request['locality'] ? $request['locality'] : "";
        $address_data['locality'] = sanitize_text_field($address_data['locality']);


        $address_data['sublocality_level_1'] = $request['sublocality_level_1'] ? $request['sublocality_level_1'] : "";
        $address_data['sublocality_level_1'] = sanitize_text_field($address_data['sublocality_level_1']);

        $address_data['country'] = $request['country'] ? $request['country'] : "";
        $address_data['country'] = sanitize_text_field($address_data['country']);

        $address_data['administrative_area_level_1'] = $request['administrative_area_level_1'] ? $request['administrative_area_level_1'] : "";
        $address_data['administrative_area_level_1'] = sanitize_text_field($address_data['administrative_area_level_1']);


        $address_data['latitude'] = $request['latitude'] ? $request['latitude'] : "";
        $address_data['latitude'] = sanitize_text_field($address_data['latitude']);

        $address_data['longitude'] = $request['longitude'] ? $request['longitude'] : "";

        $address_data['longitude'] = sanitize_text_field($address_data['longitude']);

        if ("" == $address_data['street_number'] && preg_match("/^(\d+-?.?)/i", $address_data['route'], $output_array)) {

            $address_data['street_number'] = $output_array[0];

            $address_data['route'] = trim(preg_replace("/^(\d+-?.?)/i", '', $address_data['route']));
        }

        if ('' == $address_data['route'] || '' == $address_data['locality']) {

            wp_send_json_success(array(
                'error' => ($error_message[] = 'Вы должны выбрать с помощью карты корректный адрес Вашей недвижимости')
            ));
            exit();
        }

        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Є', 'Ї', 'Ж', 'З', 'И', 'І', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'є', 'ї', 'ж', 'з', 'и', 'і', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ', "'");
        $lat = array('a', 'b', 'v', 'g', 'd', 'e', 'e', 'yi', 'gh', 'z', 'i', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e', 'е', 'yi', 'gh', 'z', 'i', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', ' ', '');


        if (!$term_country = term_exists($address_data['country'], 'adress_level')) {
            $term_country = wp_insert_term($address_data['country'], 'adress_level', $args = array(
                'slug' => str_replace($rus, $lat, $address_data['country']),
                'description' => 'country',
            ));

            update_term_meta($term_country['term_id'], 'rus', sanitize_text_field($map_autocomplete[4]));
        }


        if (!$term_region = term_exists($address_data['administrative_area_level_1'], 'adress_level')) {
            $term_region = wp_insert_term($address_data['administrative_area_level_1'], 'adress_level', $args = array(
                'parent' => $term_country['term_id'],
                'slug' => str_replace($rus, $lat, $address_data['administrative_area_level_1']),
                'description' => 'administrative_area_level_1',
            ));

            update_term_meta($term_region['term_id'], 'rus', sanitize_text_field($map_autocomplete[3]));
        }


        if (!$term_locality = term_exists($address_data['locality'], 'adress_level')) {
            $term_locality = wp_insert_term($address_data['locality'], 'adress_level', $args = array(
                'parent' => $term_region['term_id'],
                'slug' => str_replace($rus, $lat, $address_data['locality']),
                'description' => 'locality',
            ));

            update_term_meta($term_locality['term_id'], 'rus', sanitize_text_field($map_autocomplete[2]));
        }

        if (!$term_district = term_exists($address_data['sublocality_level_1'], 'adress_level')) {
            $term_district = wp_insert_term($address_data['sublocality_level_1'], 'adress_level', $args = array(
                'parent' => $term_locality['term_id'],
                'slug' => str_replace($rus, $lat, $address_data['sublocality_level_1']),
                'description' => 'sublocality_level_1',
            ));

            update_term_meta($term_district['term_id'], 'rus', zag_district_locale($address_data['sublocality_level_1']));
        }


        if (!$term_street = term_exists($address_data['route'], 'adress_level')) {
            $term_street = wp_insert_term($address_data['route'], 'adress_level', $args = array(
                'parent' => $term_district['term_id'],
                'slug' => str_replace($rus, $lat, $address_data['route']),
                'description' => 'route',
            ));

            update_term_meta($term_street['term_id'], 'rus', sanitize_text_field($map_autocomplete[0]));
        }


        $main_prop_features['property_price'] = $request['property_price'] ? $request['property_price'] : "";
        $main_prop_features['property_price'] = sanitize_text_field($main_prop_features['property_price'])*1000;

        $main_prop_features['property_price_gry'] = $request['property_price_gry'] ? $request['property_price_gry'] : "";
        $main_prop_features['property_price_gry'] = sanitize_text_field($main_prop_features['property_price_gry'])*1000;


        $main_prop_features['property_roomN'] = $request['property_roomN'] ? $request['property_roomN'] : "";
        $main_prop_features['property_roomN'] = sanitize_text_field($main_prop_features['property_roomN']);

        $main_prop_features['total_sq'] = $request['total_sq'] ? $request['total_sq'] : "";
        $main_prop_features['total_sq'] = sanitize_text_field($main_prop_features['total_sq']);

        $main_prop_features['life_sq'] = $request['life_sq'] ? $request['life_sq'] : "";
        $main_prop_features['life_sq'] = sanitize_text_field($main_prop_features['life_sq']);

        $main_prop_features['house_level'] = $request['house_level'] ? $request['house_level'] : "";
        $main_prop_features['house_level'] = sanitize_text_field($main_prop_features['house_level']);

        $main_prop_features['comment'] = $request['comment'] ? $request['comment'] : "";
        $main_prop_features['comment'] = sanitize_text_field($main_prop_features['comment']);


        $main_prop_features['shot_title'] = $request['shot_title'] ? $request['shot_title'] : "";
        $main_prop_features['shot_title'] = sanitize_text_field($main_prop_features['shot_title']);
        
        
        $property_type = $request['type'] ? $request['type'] : "";
        $property_type  = sanitize_text_field($property_type );
        
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
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );



        foreach ($_FILES["file"]["error"] as $key => $error) {

            if (is_array($error)) {

                foreach ($error as $photo_number => $photo) {
                    if ($photo == UPLOAD_ERR_OK) {
                        $tmp_name = $_FILES["file"]["tmp_name"][$key][$photo_number];
// basename() может спасти от атак на файловую систему;
// может понадобиться дополнительная проверка/очистка имени файла

                        $size = round($_FILES['file']['size'][$key][$photo_number] / 1024);

                        if ($size < 1) {
                            $error_message[] = 'File' . $_FILES["file"]["name"][$key][$photo_number] . ' is too small for this site';
                        }

                        if ($size > 10000) {
                            $error_message[] = 'File ' . $_FILES["file"]["name"][$key][$photo_number] . 'is too big for this site';
                        }

                        $name = basename($_FILES["file"]["name"][$key][$photo_number]);


                        $filetype = wp_check_filetype($name);

                        $image_exts = array('jpg', 'jpeg', 'jpe', 'gif', 'png');


                        if (!in_array($filetype[ext], $image_exts)) {
                            $error_message[] = 'File' . $_FILES["file"]["name"][$key][$photo_number] . ' doesnt have proper extention ';
                        }
                    } else {
                        $error_message[$_FILES["file"]["name"][$key][$photo_number]] = $phpFileUploadErrors[$_FILES['file']['error'][$key][$photo_number]];
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





        /*         * ******************** insert new property post  and get its id from db ************************ */
        $postarr = array(
            'post_type' => 'zag_property',
        );

        $post_id = wp_insert_post($postarr);

        $address_tags = array(
            $term_country['term_id'],
            $term_region['term_id'],
            $term_locality['term_id'],
            $term_district['term_id'],
            $term_street['term_id']
        );

        wp_set_post_terms($post_id, $address_tags, 'adress_level');


        /*         * ******************* create custom upload folder and save property photos ********************** */
        global $current_user;

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


        $basedir = $dir;

        $baseurl = $url;

        $subdir = "/" . $current_user->display_name . '_' . $current_user->ID . "/" . $post_id;


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



        
        
        


        /*         * **************************************handle_upload files********************************************* */

        $gallery_data = array();
        $rooms_data = array();

        $upload_success = true;

        foreach ($_FILES["file"]["name"] as $key => $name) {

            if (is_array($name)) {

                foreach ($name as $photo_number => $photo) {

                    $tmp_name = $_FILES["file"]["tmp_name"][$key][$photo_number];

// basename() может спасти от атак на файловую систему;
// может понадобиться дополнительная проверка/очистка имени файла
                    $name = basename($_FILES["file"]["name"][$key][$photo_number]);

                    $name = sanitize_text_field($name);
                    $room = sanitize_text_field($_REQUEST['select'][$key]);
                    $room_sq = sanitize_text_field($_REQUEST['room_sq'][$key]);

                    $name = $room . '-' . $name;

                    $new_file = $dir . "/" . $name;
                    $new_file_url = $url . "/" . $name;
                    $gallery_data[] = $new_file_url;

                    $move_new_file = @ move_uploaded_file($tmp_name, $new_file);


                    if (!$move_new_file)
                        $upload_success = false;

// Set correct file permissions.
                    $stat = stat(dirname($new_file));
                    $perms = $stat['mode'] & 0000666;
                    @ chmod($new_file, $perms);



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

                    add_post_meta($attach_id, 'room', $room);
                    add_post_meta($attach_id, 'room_sq', $room_sq);


                    $rooms_data[$room][] = $attach_id;
                }
            }
        }
        /*         * ********************************************************************************************************* */
        /*
          if ($upload_success) {
          $rooms_data = array();


          foreach ($request["id"] as $key => $data) {

          $rooms_data[$key] = $data;

          if (is_array($data)) {
          foreach ($data as $k => $v) {
          if ('room_photo' == $k)
          $array = explode("\\", $v);
          }

          if (is_array($array))
          $last_element = array_pop($array);
          else
          $last_element = '';

          if ('' != $last_element)
          $rooms_data[$key]['room_photo'] = $url . "/" . $last_element;
          else {
          $rooms_data[$key]['room_photo'] = '';
          }
          }
          }
          }
         * 
         */
        /*         * ******************************************************************************************* */

       if ($property_type)
            update_post_meta($post_id, 'property_type', $property_type);
        else
            delete_post_meta($post_id, 'property_type');
        
        if ($rooms_data)
            update_post_meta($post_id, 'rooms_data', $rooms_data);
        else
            delete_post_meta($post_id, 'rooms_data');



        if ($address_data)
            update_post_meta($post_id, 'address_data', $address_data);
        else
            delete_post_meta($post_id, 'address_data');


        if ($main_prop_features)
            update_post_meta($post_id, 'main_prop_features', $main_prop_features);
        else
            delete_post_meta($post_id, 'main_prop_features');

        if ($user_info)
            update_post_meta($post_id, 'user_info', $user_info);
        else
            delete_post_meta($post_id, 'user_info');

        
         /*         * ******************** set post title ************************ */
        $postarr = array(
            'post_type' => 'zag_property',
            'post_title' => $current_user->display_name . '_' . $current_user->ID . "_post_" . $post_id,
            'ID' => $post_id,
            'post_status' => 'publish',
        );

        $post_update = wp_insert_post($postarr);

        $profile = get_page_by_title($request['current_page']);

        $profile_link = get_permalink($profile);


        /*         * *********************************************************************************************** */

        wp_send_json_success(array(
            'link' => $profile_link
        ));
    }

    public function zag_distr_autocomplete() {

        $term = $_REQUEST['term'];
        $town = $_REQUEST['town'];

        if ('' == $town || !isset($town)) {
            wp_send_json_success(array(
                'responce_term' => 'you must enter a town name first'
            ));
        }

        $town_town = get_term_by('name', $town, 'category');



        $terms = get_terms(array(
            'taxonomy' => "category",
            'hide_empty' => false,
            'parent' => $town_town->term_id,
            'name__like' => $term,
        ));

        $names = array();
        foreach ($terms as $term_found) {

            $names[] = $term_found->name;
        }


        wp_send_json_success(array(
            'responce_term' => $names
        ));
    }

    public function zag_street_autocomplete() {

        $term = $_REQUEST['term'];
        $distr = $_REQUEST['distr'];

        if ('' == $distr || !isset($distr)) {
            wp_send_json_success(array(
                'responce_term' => 'you must enter a town name first'
            ));
        }

        $distr_town = get_term_by('name', $distr, 'category');



        $terms = get_terms(array(
            'taxonomy' => "category",
            'hide_empty' => false,
            'parent' => $distr_town->term_id,
            'name__like' => $term,
        ));

        $names = array();
        foreach ($terms as $term_found) {

            $names[] = $term_found->name;
        }


        wp_send_json_success(array(
            'responce_term' => $names
        ));
    }

    public function zag_town_autocomplete() {




        $term = $_REQUEST['term'];

        $terms = get_terms(array(
            'taxonomy' => "category",
            'hide_empty' => false,
            'parent' => 10,
            'name__like' => $term,
        ));


        $names = array();
        foreach ($terms as $term_found) {

            $names[] = $term_found->name;
        }


        wp_send_json_success(array(
            'responce_term' => $names
        ));
    }
    
    /*********************************************************************************************************/

    public function zag_ajax_logout() {

        wp_logout();

        wp_set_current_user(0);



        wp_send_json_success(array(
            'link' => get_home_url(),
        ));
    }
    
    /*************************************Login********************************************************/

    public function zag_ajax_login() {




        if (check_ajax_referer('ajax_nonce', 'my_nonce', false)) {
// Nonce is checked, get the POST data and sign user on
            $info = array();
            $info['user_login'] = sanitize_user($_POST['user_login']);
            $info['user_password'] = sanitize_user($_POST['user_password']);
            $info['remember'] = true;

            // $cur_town = sanitize_text_field($_POST['cur_town']);





            $user_signon = wp_signon($info, false);





            if (is_wp_error($user_signon)) {
                wp_send_json_success(array(
                    "errors" => "Логин или пароль неверные",
                ));
            } else {

                wp_set_current_user($user_signon->ID);

                wp_set_auth_cookie($user_signon->ID);

                //$logout_nonce = wp_create_nonce('login-nonce');



                wp_send_json_success(array(
                ));
            }
        } else {
            wp_send_json_success(array(
                "errors" => "Что-то пошло не так. Обратитесь к администратору ",
            ));
        }
    }

    public function zag_ajax_registration() {

        $errors = array();

        if (check_ajax_referer('ajax_nonce', 'my_nonce', false)) {

            $user_login = isset($_POST['user_login']) ? sanitize_user($_POST['user_login'], true) : '';
            $user_pass1 = isset($_POST['user_password1']) ? sanitize_user($_POST['user_password1']) : '';
            $user_pass2 = isset($_POST['user_password2']) ? sanitize_user($_POST['user_password2']) : '';

            $user_first_name = isset($_POST['user_first_name']) ? sanitize_user($_POST['user_first_name']) : '';

            $user_last_name = isset($_POST['user_last_name']) ? sanitize_user($_POST['user_last_name']) : '';

            $user_tel = isset($_POST['user_tel']) ? sanitize_user($_POST['user_tel']) : '';

            $user_agency = isset($_POST['user_agency']) ? sanitize_user($_POST['user_agency']) : '';


            $user_email = isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : '';

            if ('' == $user_pass1 || '' == $user_pass2) {
                $errors[] = "Одно из полей для пароля не заполнено";
            }


            if ($user_pass1 != $user_pass2) {
                $errors[] = "Повторный ввод пароля не верный";
            }

            if ('' == $user_first_name) {
                $errors[] = "Укажите Ваше имя";
            }

            if ('' == $user_tel) {
                $errors[] = "Укажите Ваш телефон";
            }

            $user_email = apply_filters('user_registration_email', $user_email);

// Check the username
            if ('' == $user_login) {
                $errors[] = "Необходимо ввести Ваш логин";
            } elseif (!validate_username($user_login)) {
                $errors[] = "Логин содержит недопустимые символы";
                $user_login = '';
            } elseif (username_exists($user_login)) {
                $errors[] = "Этот логин уже существует. Введите другое слово";
            } else {
                /** This filter is documented in wp-includes/user.php */
                $illegal_user_logins = array_map('strtolower', (array) apply_filters('illegal_user_logins', array()));
                if (in_array(strtolower($user_login), $illegal_user_logins)) {
                    $errors[] = "Использование этого слова в качестве логина на нашем сайте запрещено";
                }
            }


// Check the email address
            if ('' == $user_email) {
                $errors[] = "Необходимо ввести Ваш email";
            } elseif (!is_email($user_email)) {
                $errors[] = "Ваш email введен не корректно";
                $user_email = '';
            } elseif (email_exists($user_email)) {
                $errors[] = "Этот email уже существует. Введите другой email";
            }


            $user_photo = isset($_FILES['thumbnail']) ? $_FILES['thumbnail'] : '';


//   $file = $this->zag_handle_upload($user_photo, $overrides, $time);
// A successful upload will pass this test. It makes no sense to override this one.
            if (isset($user_photo['error']) && $user_photo['error'] > 0) {
                $errors[] = "Ошибка при загрузке файла";
            }

            if (!empty($errors)) {
                wp_send_json_success(array(
                    "errors" => $errors,
                ));
            }

            $test_file_size = $user_photo['size'];
// A non-empty file will pass this test.
            if (!( $test_file_size > 0 )) {
                $errors[] = "Файл с фото имеет слишком маленький размер";
            }


// A properly uploaded file will pass this test. There should be no reason to override this one.
            $test_uploaded_file = @is_uploaded_file($user_photo['tmp_name']);
            if (!$test_uploaded_file) {
                $errors[] = "Файл не загрузился";
            }


// A correct MIME type will pass this test. Override $mimes or use the upload_mimes filter.

            $wp_filetype = wp_check_filetype_and_ext($user_photo['tmp_name'], $user_photo['name']);
            $ext = empty($wp_filetype['ext']) ? '' : $wp_filetype['ext'];
            $type = empty($wp_filetype['type']) ? '' : $wp_filetype['type'];
            $proper_filename = empty($wp_filetype['proper_filename']) ? '' : $wp_filetype['proper_filename'];

// Check to see if wp_check_filetype_and_ext() determined the filename was incorrect
            if ($proper_filename) {
                $user_photo['name'] = $proper_filename;
            }
            if ((!$type || !$ext ) && !current_user_can('unfiltered_upload')) {
                $errors[] = "Загрузка этого файла не разрешена по требованиям безопасности";
            }
            if (!$type) {
                $type = $user_photo['type'];
            }




            if (!empty($errors)) {
                wp_send_json_success(array(
                    "errors" => $errors,
                ));
            }


            $user_id = wp_create_user($user_login, $user_pass1, $user_email);

            if (!$user_id || is_wp_error($user_id)) {
                $errors[] = "Не можем Вас зарегистрировать. Обратитесь к администратору - " . get_option('admin_email');
            }

            if (!empty($errors)) {
                wp_send_json_success(array(
                    "errors" => $errors,
                ));
            }

//  update_user_option($user_id, 'default_password_nag', true, true); //Set up the Password change nag.






            $user = wp_set_current_user($user_id);

            $user->add_cap('edit_posts');

            wp_set_auth_cookie($user_id);



            /*
             * A writable uploads dir will pass this test. Again, there's no point
             * overriding this one.
             */
            $time = current_time('mysql');

            if (!($uploads = wp_upload_dir($time) )) {
                $errors[] = "Директория загрузки заблокирована. Обратитесь к администратору - " . get_option('admin_email');
            }


            $filename = wp_unique_filename($uploads['path'], $user_photo['name']);

// Move the file to the uploads dir.
            $new_file = $uploads['path'] . "/avatar-" . $filename;


            $move_new_file = @ move_uploaded_file($user_photo['tmp_name'], $new_file);

            if (false === $move_new_file) {
                $errors[] = "Файл фотографии не записался. Обратитесь к администратору - " . get_option('admin_email');
            }


// Set correct file permissions.
            $stat = stat(dirname($new_file));
            $perms = $stat['mode'] & 0000666;
            @ chmod($new_file, $perms);

// Compute the URL.
            $url = $uploads['url'] . "/avatar-" . $filename;




            update_user_meta($user_id, "photo", $url);

            update_user_meta($user_id, "user_first_name", $user_first_name);
            update_user_meta($user_id, "user_last_name", $user_last_name);
            update_user_meta($user_id, "user_tel", $user_tel);
            update_user_meta($user_id, "user_email", $user_email);
            update_user_meta($user_id, "user_agency", $user_email);

            $profile = get_page_by_title("Profile");

            $profile_link = get_permalink($profile);

            wp_send_json_success(array(
                "profile_link" => $profile_link,
            ));
        }
    }

}
