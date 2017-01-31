<?php

function zag_edit_reverrent_prop_ajax_action() {

    global $current_user;


    $address_data = array();
    $address_data_ru = array();
    $main_data = array();
    $user_info = array();

    $error_message = array();

    $request = $_REQUEST;




    $zag_domain = $request['zag_domain'] ? $request['zag_domain'] : "rus";

    $post_id = sanitize_text_field($request['post_id']);

    $address_data_ru = get_post_meta($post_id, "address_data_ru", true);

    $address_data_ru['latitude'] = sanitize_text_field($request['latitude']);
    $address_data_ru['longitude'] = sanitize_text_field($request['longitude']);

    $address_data = get_post_meta($post_id, "address_data", true);
    $address_data['latitude'] = sanitize_text_field($request['latitude']);
    $address_data['longitude'] = sanitize_text_field($request['longitude']);


    $main_data = get_post_meta($post_id, 'main_data', true);


    $main_data['cost_US'] = sanitize_text_field($request['cost_US']);
    $main_data['cost_GRN'] = sanitize_text_field($request['cost_GRN']);
    $main_data['comment'] = sanitize_text_field($request['comment']);
    $main_data['shot_title'] = sanitize_text_field($request['shot_title']);
    
    $main_data['time_period'] = sanitize_text_field($request['time_period']);
    $main_data['date_from'] = sanitize_text_field($request['date_from']);
    $main_data['date_to'] = sanitize_text_field($request['date_to']);


    $user_data = get_post_meta($post_id, "user_info", true);

    $user_info['user_first_name'] = sanitize_text_field($request['user_first_name']);
    $user_info['user_last_name'] = sanitize_text_field($request['user_last_name']);
    $user_info['user_tel'] = sanitize_text_field($request['user_tel']);
    $user_info['user_email'] = sanitize_text_field($request['user_email']);
    $user_info['user_agency'] = sanitize_text_field($request['user_agency']);



    update_post_meta($post_id, 'main_data', $main_data);

    update_post_meta($post_id, 'user_info', $user_info);

    update_post_meta($post_id, 'address_data_ru', $address_data_ru);
    update_post_meta($post_id, 'address_data', $address_data);

    $postarr = array(
        'post_type' => 'zag_property',
        'ID' => $post_id,
        'post_title' => $current_user->display_name . '_' . $current_user->ID . "_post_" . $post_id,
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
