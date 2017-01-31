<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <!--[if lt IE 9]>
        <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/html5.js"></script>
        <![endif]-->
        <?php
        wp_head();
        global $current_town;
        global $prop_array;

        $current_town = 'Украина';
        $slug = 'ukraine';

        $prop_type = sanitize_text_field($_GET['prop_type']);



        $current_user = wp_get_current_user();

        $current_post = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());

        $address = get_post_meta($current_post->ID, "address_data", true);
        $prop_type = get_post_meta($current_post->ID, "property_type", true);


        $prop_array[] = array(
            'lat' => $address['latitude'],
            'lng' => $address['longitude'],
            'prop_type' => $prop_type,
            'markers' => array(
                'buy' => plugin_dir_url() . 'ZAG-Realty-MVC-Plugin/img/red.png',
                'sell' => plugin_dir_url() . 'ZAG-Realty-MVC-Plugin/img/darkblue.png',
                'project' => plugin_dir_url() . 'ZAG-Realty-MVC-Plugin/img/orange.png',
                'rent_long' => plugin_dir_url() . 'ZAG-Realty-MVC-Plugin/img/darkgreen.png',
                'rent_short' => plugin_dir_url() . 'ZAG-Realty-MVC-Plugin/img/lightgreen.png',
                'rent_rever' => plugin_dir_url() . 'ZAG-Realty-MVC-Plugin/img/yellow.png',
                'hostel' => plugin_dir_url() . 'ZAG-Realty-MVC-Plugin/img/perple.png',
            )
        );

        function single_qqq() {
            global $prop_array;
            wp_localize_script("single-google-map", 'single_map_object', $prop_array);
        }

        add_action('wp_print_footer_scripts', 'single_qqq', 1);
        ?>
    </head>

    <body <?php body_class(); ?> >

<?php
if ($current_post->post_name == 'zero') {
    get_sidebar('newProperty');
} elseif ($current_post->post_author == $current_user->ID && 0 != $current_user->ID) {

    get_sidebar('edit_post');
} else {
    get_sidebar('see_post');
}
?>
        
<div id="spinner" class="spinner" style="display:none;">
    <img id="img-spinner" src="<?= plugin_dir_url() . 'ZAG-Realty-MVC-Plugin/img/ajax-loader.gif'?>" alt="Loading"/>
</div>


