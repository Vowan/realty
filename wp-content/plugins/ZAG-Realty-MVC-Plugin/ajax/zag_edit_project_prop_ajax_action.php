<?php

function zag_edit_project_prop_ajax_action() {

    global $current_user;


    $address_data = array();
    $address_data_ru = array();
    $main_data = array();
    $user_info = array();

    $error_message = array();

    $request = $_REQUEST;

    $zag_domain = $request['zag_domain'] ? $request['zag_domain'] : "rus";

    $post_id = sanitize_text_field($request['post_id']);

    $current_post = get_post($post_id);

    if (!$current_post->post_author == $current_user->ID || 0 == $current_user->ID || !check_ajax_referer('edit_project_nonce', 'coming_edit_project_nonce', false)) {

        $error_message[] = 'У Вас нет прав  редактировать данный пост. Обратитесь к администратору';

        wp_send_json_success(array(
            'error' => $error_message,
        ));
        exit();
    }



    $main_data = get_post_meta($post_id, 'main_data', true);
    $main_data['shot_title'] = sanitize_text_field($request['shot_title']);

    $address_data_ru = get_post_meta($post_id, "address_data_ru", true);

    $address_data_ru['latitude'] = sanitize_text_field($request['latitude']);
    $address_data_ru['longitude'] = sanitize_text_field($request['longitude']);

    $address_data = get_post_meta($post_id, "address_data", true);
    $address_data['latitude'] = sanitize_text_field($request['latitude']);
    $address_data['longitude'] = sanitize_text_field($request['longitude']);



    $project_data = get_post_meta($current_post->ID, 'project_data', true);


    if ($request['one-room-priceUS']) {
        foreach ($request['one-room-priceUS'] as $key => $value) {
            $project_data['one-room-file'][$key]['priceUS'] = sanitize_text_field($value);
        }
    }

    if ($request['one-room-priceGRN']) {
        foreach ($request['one-room-priceGRN'] as $key => $value) {
            $project_data['one-room-file'][$key]['priceGRN'] = sanitize_text_field($value);
        }
    }

    if ($request['one-room-totalSQ']) {
        foreach ($request['one-room-totalSQ'] as $key => $value) {
            $project_data['one-room-file'][$key]['totalSQ'] = sanitize_text_field($value);
        }
    }

    if ($request['one-room-liveSQ']) {
        foreach ($request['one-room-liveSQ'] as $key => $value) {
            $project_data['one-room-file'][$key]['liveSQ'] = sanitize_text_field($value);
        }
    }

    if ($request['one-room-comment']) {
        foreach ($request['one-room-comment'] as $key => $value) {
            $project_data['one-room-file'][$key]['comment'] = sanitize_text_field($value);
        }
    }


    if ($request['two-room-priceUS']) {
        foreach ($request['two-room-priceUS'] as $key => $value) {
            $project_data['two-room-file'][$key]['priceUS'] = sanitize_text_field($value);
        }
    }

    if ($request['two-room-priceGRN']) {
        foreach ($request['two-room-priceGRN'] as $key => $value) {
            $project_data['two-room-file'][$key]['priceGRN'] = sanitize_text_field($value);
        }
    }

    if ($request['two-room-totalSQ']) {
        foreach ($request['two-room-totalSQ'] as $key => $value) {
            $project_data['two-room-file'][$key]['totalSQ'] = sanitize_text_field($value);
        }
    }

    if ($request['two-room-liveSQ']) {
        foreach ($request['two-room-liveSQ'] as $key => $value) {
            $project_data['two-room-file'][$key]['liveSQ'] = sanitize_text_field($value);
        }
    }

    if ($request['two-room-comment']) {
        foreach ($request['two-room-comment'] as $key => $value) {
            $project_data['two-room-file'][$key]['comment'] = sanitize_text_field($value);
        }
    }


    if ($request['three-room-priceUS']) {
        foreach ($request['one-room-priceUS'] as $key => $value) {
            $project_data['one-room-file'][$key]['priceUS'] = sanitize_text_field($value);
        }
    }

    if ($request['three-room-priceGRN']) {
        foreach ($request['three-room-priceGRN'] as $key => $value) {
            $project_data['three-room-file'][$key]['priceGRN'] = sanitize_text_field($value);
        }
    }

    if ($request['three-room-totalSQ']) {
        foreach ($request['three-room-totalSQ'] as $key => $value) {
            $project_data['three-room-file'][$key]['totalSQ'] = sanitize_text_field($value);
        }
    }

    if ($request['three-room-liveSQ']) {
        foreach ($request['three-room-liveSQ'] as $key => $value) {
            $project_data['three-room-file'][$key]['liveSQ'] = sanitize_text_field($value);
        }
    }

    if ($request['three-room-comment']) {
        foreach ($request['three-room-comment'] as $key => $value) {
            $project_data['three-room-file'][$key]['comment'] = sanitize_text_field($value);
        }
    }

    if ($request['fore-room-priceUS']) {
        foreach ($request['fore-room-priceUS'] as $key => $value) {
            $project_data['fore-room-file'][$key]['priceUS'] = sanitize_text_field($value);
        }
    }

    if ($request['fore-room-priceGRN']) {
        foreach ($request['fore-room-priceGRN'] as $key => $value) {
            $project_data['fore-room-file'][$key]['priceGRN'] = sanitize_text_field($value);
        }
    }

    if ($request['fore-room-totalSQ']) {
        foreach ($request['fore-room-totalSQ'] as $key => $value) {
            $project_data['fore-room-file'][$key]['totalSQ'] = sanitize_text_field($value);
        }
    }

    if ($request['fore-room-liveSQ']) {
        foreach ($request['fore-room-liveSQ'] as $key => $value) {
            $project_data['fore-room-file'][$key]['liveSQ'] = sanitize_text_field($value);
        }
    }

    if ($request['fore-room-comment']) {
        foreach ($request['fore-room-comment'] as $key => $value) {
            $project_data['fore-room-file'][$key]['comment'] = sanitize_text_field($value);
        }
    }

    if ($request['pent-room-priceUS']) {
        foreach ($request['pent-room-priceUS'] as $key => $value) {
            $project_data['pent-room-file'][$key]['priceUS'] = sanitize_text_field($value);
        }
    }

    if ($request['pent-room-priceGRN']) {
        foreach ($request['pent-room-priceGRN'] as $key => $value) {
            $project_data['pent-room-file'][$key]['priceGRN'] = sanitize_text_field($value);
        }
    }

    if ($request['pent-room-totalSQ']) {
        foreach ($request['pent-room-totalSQ'] as $key => $value) {
            $project_data['pent-room-file'][$key]['totalSQ'] = sanitize_text_field($value);
        }
    }

    if ($request['pent-room-liveSQ']) {
        foreach ($request['pent-room-liveSQ'] as $key => $value) {
            $project_data['pent-room-file'][$key]['liveSQ'] = sanitize_text_field($value);
        }
    }

    if ($request['pent-room-comment']) {
        foreach ($request['pent-room-comment'] as $key => $value) {
            $project_data['pent-room-file'][$key]['comment'] = sanitize_text_field($value);
        }
    }





    $user_data = get_post_meta($post_id, "user_info", true);

    $user_info['user_first_name'] = sanitize_text_field($request['user_first_name']);
    $user_info['user_last_name'] = sanitize_text_field($request['user_last_name']);
    $user_info['user_tel'] = sanitize_text_field($request['user_tel']);
    $user_info['user_email'] = sanitize_text_field($request['user_email']);
    $user_info['user_agency'] = sanitize_text_field($request['user_agency']);





    update_post_meta($post_id, 'user_info', $user_info);
    update_post_meta($post_id, 'main_data', $main_data);
    update_post_meta($post_id, 'project_data', $project_data);
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

        $error_message[] = 'Объект не создан. Обратитесь к администратору';


        wp_send_json_success(array(
            'error' => $error_message,
        ));
        exit();
    }

    wp_send_json_success(array(
        'ok' => 'ok',
    ));
}
