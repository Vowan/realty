<?php

function zag_trash_sell_prop_ajax_action() {

    global $current_user;

    $post_id = sanitize_text_field($_REQUEST['post_id']);

    $current_post = get_post($post_id);

    if (!$current_post->post_author == $current_user->ID || 0 == $current_user->ID || !check_ajax_referer('edit_sell_nonce', 'coming_delete_sell_nonce', false)) {

        $error_message[] = 'У Вас нет прав  удалить данный пост. Обратитесь к администратору';

        wp_send_json_success(array(
            'error' => $error_message,
        ));
        exit();
    }


    $attachments = get_posts(array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_parent' => $current_post->ID,
    ));



    foreach ($attachments as $key => $attach) {

        $file = get_attached_file($attach->ID);

        $dir_name = dirname($file);

        wp_delete_attachment($attach->ID);

        $iterator = new \FilesystemIterator($dir_name);

        if (!$iterator->valid() && is_dir($dir_name)) {
            rmdir($dir_name);
            
            
        }

        // $photo_files[] = wp_get_attachment_url($attach->ID);
        // $room[] = get_post_meta($attach->ID, 'room', true);
        // $roomSQ[] = get_post_meta($attach->ID, 'roomSQ', true);
    }

    $dir_meta = get_post_meta($current_post->ID, "file_directory", true);

    if ($dir_meta && is_dir($dir_meta)) {
        $iterator = new \FilesystemIterator($dir_meta);

        if (!$iterator->valid() && is_dir($dir_meta)) {
            rmdir($dir_meta);
        }
    }

    $postarr = array(
        'post_type' => 'zag_property',
        'ID' => $post_id,
        'post_title' => $current_user->display_name . '_' . $current_user->ID . "_post_" . $post_id,
        'post_status' => 'trash',
    );

    $post_update = wp_insert_post($postarr);


    if (0 == $post_update || $post_update instanceof WP_Error) {

        $error_message[] = 'Объект не удален. Обратитесь к администратору';


        wp_send_json_success(array(
            'error' => $error_message,
        ));
        exit();
    }

    wp_send_json_success(array(
        'ok' => 'ok',
    ));
}
