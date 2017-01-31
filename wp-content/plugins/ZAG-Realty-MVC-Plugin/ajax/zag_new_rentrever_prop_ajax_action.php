<?php

function zag_new_rentrever_prop_ajax_action() {

    global $current_user;


    $address_data = array();
    $address_data_ru = array();
    $main_data = array();
    $user_info = array();

    $error_message = array();

    $request = $_REQUEST;




    $zag_domain = $request['zag_domain'] ? $request['zag_domain'] : "rus";

    $main_data['time_period'] = sanitize_text_field($request['time_period']);
    $main_data['date_from'] = sanitize_text_field($request['date_from']);
    $main_data['date_to'] = sanitize_text_field($request['date_to']);

    $main_data['cost_US'] = sanitize_text_field($request['cost_US']);
    $main_data['cost_GRN'] = sanitize_text_field($request['cost_GRN']);
    $main_data['totalSQ'] = sanitize_text_field($request['totalSQ']);
    $main_data['liveSQ'] = sanitize_text_field($request['liveSQ']);
    $main_data['rooms'] = sanitize_text_field($request['rooms']);
    $main_data['level'] = sanitize_text_field($request['level']);
    $main_data['comment'] = sanitize_text_field($request['comment']);
    $main_data['shot_title'] = sanitize_text_field($request['shot_title']);




    $request['map_autocomplete'] = $request['map_autocomplete'] ? sanitize_text_field($request['map_autocomplete']) : '';

    if ('' == $request['map_autocomplete']) {

        $error_message[] = 'Вы не выбрали адрес с помощью поля ввода над картой';

        wp_send_json_success(array(
            'error' => $error_message,
        ));
        exit();
    }

    $property_type = 'rent_rever';

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

    update_post_meta($post_id, 'main_data', $main_data);

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
