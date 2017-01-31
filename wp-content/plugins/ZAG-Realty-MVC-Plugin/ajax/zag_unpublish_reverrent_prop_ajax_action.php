<?php

function zag_unpublish_reverrent_prop_ajax_action(){

    global $current_user;

    $post_id = sanitize_text_field($_REQUEST['post_id']);


    $postarr = array(
        'post_type' => 'zag_property',
        'ID' => $post_id,
        'post_title' => $current_user->display_name . '_' . $current_user->ID . "_post_" . $post_id,
        'post_status' => 'private',
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
