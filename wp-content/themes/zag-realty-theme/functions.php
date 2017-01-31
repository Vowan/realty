<?php

//require_once get_template_directory() . '/wp_bootstrap_navwalker.php';




if (!function_exists('zaganich_realty_theme')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * @since Twenty Fifteen 1.0
     */
    function zaganich_realty_theme_setup() {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on twentyfifteen, use a find and replace
         * to change 'twentyfifteen' to the name of your theme in all the template files
         */
        //load_theme_textdomain( 'twentyfifteen', get_template_directory() . '/languages' );
        // Add default posts and comments RSS feed links to head.
        //add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        //add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support( 'post-thumbnails' );
               
       
        //
        //
        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'zaganich_realty_theme'),
            'top' => __('Top Menu', 'zaganich_realty_theme'),
            'social' => __('Social Links Menu', 'zaganich_realty_theme'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
        ));

        /*
         * Enable support for custom logo.
         *
         * @since Twenty Fifteen 1.5
         */
        add_theme_support('custom-logo', array(
            'height' => 248,
            'width' => 248,
            'flex-height' => true,
        ));
    }

endif; // zaganich_realty_theme_setup
add_action('after_setup_theme', 'zaganich_realty_theme_setup');

function zaganich_realty_theme_scripts() {

   
}

add_action('wp_enqueue_scripts', 'zaganich_realty_theme_scripts');

// adding loginout url to top menu

function add_nav_menu_items($items, $args) {

    $items .= '<li>' . wp_loginout($_SERVER['REQUEST_URI'], false) . '</li>';

    if (!is_user_logged_in()) {
        $items .= '<li>  <a href="' . esc_url(wp_registration_url()) . '">' . __('Register') . '</a> </li>';
    }


    return $items;
}

add_filter('wp_nav_menu_top_items', 'add_nav_menu_items', 10, 2);

/**
 * Registers a widget area.
 * 
 */
function zag_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'zag'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'zag'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Main frontend content aria', 'zag'),
        'id' => 'sidebar-2',
        'description' => __('Appears at the top of the  main content on', 'zag'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Loginout', 'zag'),
        'id' => 'sidebar-3',
        'description' => __('Appears at the top bar', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => __('Create_property_form', 'zag'),
        'id' => 'sidebar-4',
        'description' => __('Appears at user profile page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => __('All_user_properties', 'zag'),
        'id' => 'sidebar-5',
        'description' => __('Appears at user profile page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => __('All_town_properties', 'zag'),
        'id' => 'sidebar-6',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    
    register_sidebar(array(
        'name' => __('Sell new property widget area', 'zag'),
        'id' => 'sell',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    
    register_sidebar(array(
        'name' => __('Buy new property widget area', 'zag'),
        'id' => 'buy',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    
    register_sidebar(array(
        'name' => __('Project new property widget area', 'zag'),
        'id' => 'project',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    
     register_sidebar(array(
        'name' => __('rent_long new property widget area', 'zag'),
        'id' => 'rent_long',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
     
      register_sidebar(array(
        'name' => __('rent_rever new property widget area', 'zag'),
        'id' => 'rent_rever',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
      
      register_sidebar(array(
        'name' => __('rent_short new property widget area', 'zag'),
        'id' => 'rent_short',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
      
      register_sidebar(array(
        'name' => __('hostel new property widget area', 'zag'),
        'id' => 'hostel',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
      /************************************************************************/
       register_sidebar(array(
        'name' => __('Edit Sell new property widget area', 'zag'),
        'id' => 'edit_sell',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    
    register_sidebar(array(
        'name' => __('Edit Buy new property widget area', 'zag'),
        'id' => 'edit_buy',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    
    register_sidebar(array(
        'name' => __('Edit Project new property widget area', 'zag'),
        'id' => 'edit_project',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    
     register_sidebar(array(
        'name' => __('Edit rent_long new property widget area', 'zag'),
        'id' => 'edit_rent_long',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
     
      register_sidebar(array(
        'name' => __('Edit rent_rever new property widget area', 'zag'),
        'id' => 'edit_rent_rever',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
      
      register_sidebar(array(
        'name' => __('Edit rent_short new property widget area', 'zag'),
        'id' => 'edit_rent_short',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
      
      register_sidebar(array(
        'name' => __('Edit hostel new property widget area', 'zag'),
        'id' => 'edit_hostel',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
      
      /***********************************************************/
       register_sidebar(array(
        'name' => __('See sell new property widget area', 'zag'),
        'id' => 'see_sell',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    
    register_sidebar(array(
        'name' => __('See Buy new property widget area', 'zag'),
        'id' => 'see_buy',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    
    register_sidebar(array(
        'name' => __('See Project new property widget area', 'zag'),
        'id' => 'see_project',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    
     register_sidebar(array(
        'name' => __('See rent_long new property widget area', 'zag'),
        'id' => 'see_rent_long',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
     
      register_sidebar(array(
        'name' => __('See rent_rever new property widget area', 'zag'),
        'id' => 'see_rent_rever',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
      
      register_sidebar(array(
        'name' => __('See rent_short new property widget area', 'zag'),
        'id' => 'see_rent_short',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
      
      register_sidebar(array(
        'name' => __('See hostel new property widget area', 'zag'),
        'id' => 'see_hostel',
        'description' => __('Appears at town page', 'zag'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
}

add_action('widgets_init', 'zag_widgets_init');


function webp_upload_mimes( $existing_mimes ) {
	// add webp to the list of mime types
	$existing_mimes['webp'] = 'image/webp';

	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'mime_types', 'webp_upload_mimes' );



function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
