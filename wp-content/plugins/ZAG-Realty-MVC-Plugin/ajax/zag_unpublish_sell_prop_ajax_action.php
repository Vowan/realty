<?php

function zag_unpublish_sell_prop_ajax_action() {

    global $current_user;

    $post_id = sanitize_text_field($_REQUEST['post_id']);

    $current_post = get_post($post_id);

    if (!$current_post->post_author == $current_user->ID || 0 == $current_user->ID || !check_ajax_referer('edit_sell_nonce', 'coming_unpublish_sell_nonce', false)) {

        $error_message[] = 'У Вас нет прав  снять с публикации данный пост. Обратитесь к администратору';

        wp_send_json_success(array(
            'error' => $error_message,
        ));
        exit();
    }


    $postarr = array(
        'post_type' => 'zag_property',
        'ID' => $post_id,
        'post_title' => $current_user->display_name . '_' . $current_user->ID . "_post_" . $post_id,
        'post_status' => 'private',
    );

    $post_update = wp_insert_post($postarr);


    if (0 == $post_update || $post_update instanceof WP_Error) {

        $error_message[] = 'Статус объекта не изменен. Обратитесь к администратору';


        wp_send_json_success(array(
            'error' => $error_message,
        ));
        exit();
    }

    wp_send_json_success(array(
        'ok' => 'ok',
    ));
}
