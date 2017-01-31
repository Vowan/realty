<?php

if (!class_exists('ZAG_Basic')) {

    /**
     * The core plugin class.
     * 
     */
    class ZAG_Basic {
        /** Singleton ************************************************************ */

        /**
         * @var ZAG_Basic.
         * @since 1.0.0
         */
        private static $instance;
        private $ajax_actions;

        public static function instance() {

            if (!isset(self::$instance) && !( self::$instance instanceof WP_User_Manager )) {

                self::$instance = new ZAG_Basic;
            }

            return self::$instance;
        }

        public function __construct() {

            register_activation_hook(__FILE__, array($this, 'activate'));
            register_deactivation_hook(__FILE__, array($this, 'deactivate'));

            $this->includes();

            $this->ajax_actions = new Zag_Frontend_Ajax();



            $this->define_actions();
            $this->define_filters();
        }

        function includes() {

            // require_once( dirname(dirname(__FILE__)) . '/admin/zag-image-size.php' ); //defines loginout widget

            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_new_sell_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag-new-buy-prop-ajax-action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag-new-project-prop-ajax-action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_new_longrent_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_new_rentrever_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_new_shortrent_prop_ajax_action.php' ); //defines loginout widget

            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_edit_longrent_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_unpublish_longrent_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_trash_longrent_prop_ajax_action.php' ); //defines loginout widget

            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_edit_shortrent_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_unpublish_shortrent_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_trash_shortrent_prop_ajax_action.php' ); //defines loginout widget

            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_edit_reverrent_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_unpublish_reverrent_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_trash_reverrent_prop_ajax_action.php' ); //defines loginout widget

            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_edit_buy_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_unpublish_buy_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_trash_buy_prop_ajax_action.php' ); //defines loginout widget

            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_edit_sell_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_unpublish_sell_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_trash_sell_prop_ajax_action.php' ); //defines loginout widget


            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_edit_project_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_unpublish_project_prop_ajax_action.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/ajax/zag_trash_project_prop_ajax_action.php' ); //defines loginout widget



            require_once( dirname(dirname(__FILE__)) . '/languages/sublocality_ukr_rus.php' ); //defines loginout widget


            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-loginout-widget.php' ); //defines loginout widget

            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-creat-new-sell-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-creat-new-buy-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-creat-new-project-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-creat-new-rentlong-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-creat-new-rentrever-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-creat-new-rentshort-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-creat-new-hostel-property-widget.php' ); //defines loginout widget

            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-edit-sell-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-edit-buy-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-edit-project-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-edit-rentlong-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-edit-rentrever-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-edit-rentshort-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-edit-hostel-property-widget.php' ); //defines loginout widget

            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-see-sell-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-see-buy-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-see-project-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-see-rentlong-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-see-rentrever-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-see-rentshort-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-see-hostel-property-widget.php' ); //defines loginout widget


            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-edit-property-widget.php' ); //defines loginout widget
            require_once( dirname(dirname(__FILE__)) . '/views/widgets/zag-see-property-widget.php' ); //defines loginout widget

            require_once( dirname(__FILE__) . '/class-zag-frontend-ajax.php' ); //defines loginout widget
        }

        function register_widgets() {
            register_widget('My_Loginout_Widget');

            register_widget('Zag_Creat_New_Sell_Property_Widget');
            register_widget('Zag_Creat_New_Buy_Property_Widget');
            register_widget('Zag_Creat_New_Project_Property_Widget');
            register_widget('Zag_Creat_New_RentLong_Property_Widget');
            register_widget('Zag_Creat_New_Rent_Rever_Property_Widget');
            register_widget('Zag_Creat_New_Rent_Short_Property_Widget');
            register_widget('Zag_Creat_New_Hostel_Property_Widget');

            register_widget('Zag_Edit_Sell_Property_Widget');
            register_widget('Zag_Edit_Buy_Property_Widget');
            register_widget('Zag_Edit_Project_Property_Widget');
            register_widget('Zag_Edit_RentLong_Property_Widget');
            register_widget('Zag_Edit_Rent_Rever_Property_Widget');
            register_widget('Zag_Edit_Rent_Short_Property_Widget');
            register_widget('Zag_Edit_Hostel_Property_Widget');

            register_widget('Zag_See_Sell_Property_Widget');
            register_widget('Zag_See_Buy_Property_Widget');
            register_widget('Zag_See_Project_Property_Widget');
            register_widget('Zag_See_RentLong_Property_Widget');
            register_widget('Zag_See_Rent_Rever_Property_Widget');
            register_widget('Zag_See_Rent_Short_Property_Widget');
            register_widget('Zag_See_Hostel_Property_Widget');

            register_widget('Zag_Edit_Property_Widget');
            register_widget('Zag_See_Property_Widget');
            //register_widget('All_User_Properties');
            //register_widget('Frontend_Properties');
            //register_widget('Page_Properties');
        }

        public function enqueue_styles() {

            wp_enqueue_style('bootstrap', plugin_dir_url(dirname(__FILE__)) . 'bower_components/bootstrap/dist/css/bootstrap.css');

            wp_enqueue_style('styles', plugin_dir_url(dirname(__FILE__)) . 'css/styles.css');

            wp_enqueue_style('style', plugin_dir_url(dirname(__FILE__)) . 'css/style.css');

            wp_enqueue_style('popuo-box', plugin_dir_url(dirname(__FILE__)) . 'css/popuo-box.css');

            wp_enqueue_style('flexslider', plugin_dir_url(dirname(__FILE__)) . 'css/flexslider.css');

            wp_enqueue_style('main', plugin_dir_url(dirname(__FILE__)) . 'css/main.css');

            if ('rent_rever' == $_GET['prop_type']) {

                wp_enqueue_style('bootstrap-datapicker', plugin_dir_url(dirname(__FILE__)) . 'bower_components/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.css');
            }
        }

        public function enqueue_scripts() {

            wp_enqueue_script('bootstrap-script', plugin_dir_url(dirname(__FILE__)) . 'bower_components/bootstrap/dist/js/bootstrap.js', array('jquery'), null, true);

            wp_enqueue_script('jquery-validate', plugin_dir_url(dirname(__FILE__)) . 'js/jquery.validate.js', array(), null, true);

            wp_enqueue_script('jquery-validate-add-methods', plugin_dir_url(dirname(__FILE__)) . 'js/additional-methods.js', array(), null, true);


            wp_enqueue_script('plugin-script', plugin_dir_url(dirname(__FILE__)) . 'js/scripts.js', array(), null, true);

            wp_localize_script("plugin-script", 'ajax_object', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'ajax_nonce' => wp_create_nonce('ajax_nonce'),
                    )
            );



            wp_enqueue_script('responsiveslides', plugin_dir_url(dirname(__FILE__)) . 'js/responsiveslides.min.js', array(), null, true);

            wp_enqueue_script('easyResponsiveTabs', plugin_dir_url(dirname(__FILE__)) . 'js/easyResponsiveTabs.js', array(), null, true);

            wp_enqueue_script('jquery.magnific-popup', plugin_dir_url(dirname(__FILE__)) . 'js/jquery.magnific-popup.js', array(), null, true);

            if (is_page('kiev') || (is_single() && 'kiev' == $_GET['town'])) {
                $lat = 50.4501;
                $lng = 30.5234;
                $zoom = 11;
            } elseif (is_page('odessa') || (is_single() && 'odessa' == $_GET['town'])) {
                $lat = 46.482526;
                $lng = 30.7233095;
                $zoom = 11;
            } elseif (is_page('lviv') || (is_single() && 'lviv' == $_GET['town'])) {
                $lat = 49.839683;
                $lng = 24.029717;
                $zoom = 11;
            } else {
                $lat = 48.507933;
                $lng = 31.262317;
                $zoom = 6;
            }


            if (is_single('zero')) {

                wp_enqueue_script("newprop-google-map", plugin_dir_url(dirname(__FILE__)) . 'js/newprop-google-map.js', array(), $this->version, true);

                wp_localize_script("newprop-google-map", 'map_object', array(
                    'map_center' => array(
                        'lat' => $lat,
                        'lng' => $lng,
                    ),
                    'zoom' => $zoom,
                        )
                );

                if ('sell' == $_GET['prop_type']) {
                    wp_enqueue_script("new-sell-prop", plugin_dir_url(dirname(__FILE__)) . 'js/new-sell-prop.js', array(), $this->version, true);

                    wp_localize_script("new-sell-prop", 'ajax_new_sell', array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'new_sell_nonce' => wp_create_nonce('new_sell_nonce'),
                            )
                    );
                }


                if ('buy' == $_GET['prop_type']) {
                    wp_enqueue_script("new-buy-prop", plugin_dir_url(dirname(__FILE__)) . 'js/new-buy-prop.js', array(), $this->version, true);

                    wp_localize_script("new-buy-prop", 'ajax_new_buy', array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'new_buy_nonce' => wp_create_nonce('new_buy_nonce'),
                            )
                    );
                }

                if ('project' == $_GET['prop_type']) {
                    wp_enqueue_script("new-project-prop", plugin_dir_url(dirname(__FILE__)) . 'js/new-project-prop.js', array(), $this->version, true);

                    wp_localize_script("new-project-prop", 'ajax_new_project', array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'new_project_nonce' => wp_create_nonce('new_project_nonce'),
                            )
                    );
                }

                if ('rent_long' == $_GET['prop_type']) {
                    wp_enqueue_script("new-rentlong-prop", plugin_dir_url(dirname(__FILE__)) . 'js/new-rentlong-prop.js', array(), $this->version, true);

                    wp_localize_script("new-rentlong-prop", 'ajax_project', array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'ajax_nonce' => wp_create_nonce('ajax_nonce'),
                            )
                    );
                }

                if ('rent_rever' == $_GET['prop_type']) {

                    wp_enqueue_script('bootstrap-datapicker', plugin_dir_url(dirname(__FILE__)) . 'bower_components/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.js', array('jquery'), null, true);
                    wp_enqueue_script('bootstrap-datapicker-rus', plugin_dir_url(dirname(__FILE__)) . 'bower_components/bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.ru.min.js', array('jquery'), null, true);


                    wp_enqueue_script("new-rentrever-prop", plugin_dir_url(dirname(__FILE__)) . 'js/new-rentrever-prop.js', array(), $this->version, true);

                    wp_localize_script("new-rentrever-prop", 'ajax_project', array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'ajax_nonce' => wp_create_nonce('ajax_nonce'),
                            )
                    );
                }

                if ('rent_short' == $_GET['prop_type']) {

                    wp_enqueue_script("new-rentshort-prop", plugin_dir_url(dirname(__FILE__)) . 'js/new-rentshort-prop.js', array(), $this->version, true);

                    wp_localize_script("new-rentshort-prop", 'ajax_project', array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'ajax_nonce' => wp_create_nonce('ajax_nonce'),
                            )
                    );
                }
            } elseif (is_single()) {
                wp_enqueue_script("single-google-map", plugin_dir_url(dirname(__FILE__)) . 'js/single-google-map.js', array(), $this->version, true);

                wp_localize_script("single-google-map", 'map_object', array(
                    'map_center' => array(
                        'lat' => $lat,
                        'lng' => $lng,
                    ),
                    'zoom' => 16,
                        )
                );


                if (is_user_logged_in()) {

                    if ('rent_long' == sanitize_text_field($_GET['prop_type'])) {
                        wp_enqueue_script("edit-rentlong-prop", plugin_dir_url(dirname(__FILE__)) . 'js/edit-rentlong-prop.js', array(), $this->version, true);

                        wp_localize_script("edit-rentlong-prop", 'ajax_project', array(
                            'ajax_url' => admin_url('admin-ajax.php'),
                            'ajax_nonce' => wp_create_nonce('ajax_nonce'),
                                )
                        );
                    }

                    if ('rent_short' == sanitize_text_field($_GET['prop_type'])) {
                        wp_enqueue_script("edit-rentshort-prop", plugin_dir_url(dirname(__FILE__)) . 'js/edit-rentshort-prop.js', array(), $this->version, true);

                        wp_localize_script("edit-rentshort-prop", 'ajax_project', array(
                            'ajax_url' => admin_url('admin-ajax.php'),
                            'ajax_nonce' => wp_create_nonce('ajax_nonce'),
                                )
                        );
                    }

                    if ('rent_rever' == sanitize_text_field($_GET['prop_type'])) {

                        wp_enqueue_script('bootstrap-datapicker', plugin_dir_url(dirname(__FILE__)) . 'bower_components/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.js', array('jquery'), null, true);
                        wp_enqueue_script('bootstrap-datapicker-rus', plugin_dir_url(dirname(__FILE__)) . 'bower_components/bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.ru.min.js', array('jquery'), null, true);


                        wp_enqueue_script("edit-rentrever-prop", plugin_dir_url(dirname(__FILE__)) . 'js/edit-rentrever-prop.js', array(), $this->version, true);

                        wp_localize_script("edit-rentrever-prop", 'ajax_project', array(
                            'ajax_url' => admin_url('admin-ajax.php'),
                            'ajax_nonce' => wp_create_nonce('ajax_nonce'),
                                )
                        );
                    }

                    if ('buy' == sanitize_text_field($_GET['prop_type'])) {


                        wp_enqueue_script("edit-buy-prop", plugin_dir_url(dirname(__FILE__)) . 'js/edit-buy-prop.js', array(), $this->version, true);

                        wp_localize_script("edit-buy-prop", 'ajax_edit_buy', array(
                            'ajax_url' => admin_url('admin-ajax.php'),
                            'edit_buy_nonce' => wp_create_nonce('edit_buy_nonce'),
                                )
                        );
                    }

                    if ('sell' == sanitize_text_field($_GET['prop_type'])) {


                        wp_enqueue_script("edit-sell-prop", plugin_dir_url(dirname(__FILE__)) . 'js/edit-sell-prop.js', array(), $this->version, true);

                        wp_localize_script("edit-sell-prop", 'ajax_edit_sell', array(
                            'ajax_url' => admin_url('admin-ajax.php'),
                            'edit_sell_nonce' => wp_create_nonce('edit_sell_nonce'),
                                )
                        );
                    }
                    
                    if ('project' == sanitize_text_field($_GET['prop_type'])) {


                        wp_enqueue_script("edit-project-prop", plugin_dir_url(dirname(__FILE__)) . 'js/edit-project-prop.js', array(), $this->version, true);

                        wp_localize_script("edit-project-prop", 'ajax_edit_project', array(
                            'ajax_url' => admin_url('admin-ajax.php'),
                            'edit_project_nonce' => wp_create_nonce('edit_project_nonce'),
                                )
                        );
                    }
                }
            } else {

                wp_enqueue_script("ukrain-google-map", plugin_dir_url(dirname(__FILE__)) . 'js/ukrain-google-map.js', array(), $this->version, true);

                wp_localize_script("ukrain-google-map", 'map_object', array(
                    'map_center' => array(
                        'lat' => $lat,
                        'lng' => $lng,
                    ),
                    'zoom' => $zoom,
                    'markers' => array(
                        'buy' => plugin_dir_url(dirname(__FILE__)) . 'img/red.png',
                        'sell' => plugin_dir_url(dirname(__FILE__)) . 'img/darkblue.png',
                        'project' => plugin_dir_url(dirname(__FILE__)) . 'img/orange.png',
                        'rent_long' => plugin_dir_url(dirname(__FILE__)) . 'img/darkgreen.png',
                        'rent_short' => plugin_dir_url(dirname(__FILE__)) . 'img/lightgreen.png',
                        'rent_rever' => plugin_dir_url(dirname(__FILE__)) . 'img/yellow.png',
                        'hostel' => plugin_dir_url(dirname(__FILE__)) . 'img/perple.png',
                    )
                        )
                );
            }

            wp_enqueue_script('google-map', 'https://maps.googleapis.com/maps/api/js?key=	
AIzaSyDImhdEAxubprlL0piFqMerQ6WZAXN2Mu0&libraries=places&language=ru', array(), null, true);
        }

        public function define_actions() {



            add_action('init', array($this, 'create_taxonomies')); // custom taxonomy 'adress_level' for props address
            add_action('init', array($this, 'register_post_types')); // custom post type 'zag_property'

            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts')); // adding scripts
            add_action('wp_enqueue_scripts', array($this, 'enqueue_styles')); // adding styles

            add_action('widgets_init', array($this, 'register_widgets'));

            add_action('wp_ajax_nopriv_zag_registration', array($this->ajax_actions, 'zag_ajax_registration'));
            add_action('wp_ajax_zag_logout', array($this->ajax_actions, 'zag_ajax_logout'));
            add_action('wp_ajax_nopriv_zag_login', array($this->ajax_actions, 'zag_ajax_login'));
            add_action('wp_ajax_zag_new_property', array($this->ajax_actions, 'zag_new_property'));

            add_action('wp_ajax_zag_new_sell_prop_ajax_action', 'zag_new_sell_prop_ajax_action');
            add_action('wp_ajax_zag_new_buy_prop_ajax_action', 'zag_new_buy_prop_ajax_action');
            add_action('wp_ajax_zag_new_project_prop_ajax_action', 'zag_new_project_prop_ajax_action');
            add_action('wp_ajax_zag_new_longrent_prop_ajax_action', 'zag_new_longrent_prop_ajax_action');
            add_action('wp_ajax_zag_new_rentrever_prop_ajax_action', 'zag_new_rentrever_prop_ajax_action');
            add_action('wp_ajax_zag_new_shortrent_prop_ajax_action', 'zag_new_shortrent_prop_ajax_action');

            add_action('wp_ajax_zag_edit_longrent_prop_ajax_action', 'zag_edit_longrent_prop_ajax_action');
            add_action('wp_ajax_zag_unpublish_longrent_prop_ajax_action', 'zag_unpublish_longrent_prop_ajax_action');
            add_action('wp_ajax_zag_trash_longrent_prop_ajax_action', 'zag_trash_longrent_prop_ajax_action');

            add_action('wp_ajax_zag_edit_shortrent_prop_ajax_action', 'zag_edit_shortrent_prop_ajax_action');
            add_action('wp_ajax_zag_unpublish_shortrent_prop_ajax_action', 'zag_unpublish_shortrent_prop_ajax_action');
            add_action('wp_ajax_zag_trash_shortrent_prop_ajax_action', 'zag_trash_shortrent_prop_ajax_action');

            add_action('wp_ajax_zag_edit_reverrent_prop_ajax_action', 'zag_edit_reverrent_prop_ajax_action');
            add_action('wp_ajax_zag_unpublish_reverrent_prop_ajax_action', 'zag_unpublish_reverrent_prop_ajax_action');
            add_action('wp_ajax_zag_trash_reverrent_prop_ajax_action', 'zag_trash_reverrent_prop_ajax_action');

            add_action('wp_ajax_zag_edit_buy_prop_ajax_action', 'zag_edit_buy_prop_ajax_action');
            add_action('wp_ajax_zag_unpublish_buy_prop_ajax_action', 'zag_unpublish_buy_prop_ajax_action');
            add_action('wp_ajax_zag_trash_buy_prop_ajax_action', 'zag_trash_buy_prop_ajax_action');

            add_action('wp_ajax_zag_edit_sell_prop_ajax_action', 'zag_edit_sell_prop_ajax_action');
            add_action('wp_ajax_zag_unpublish_sell_prop_ajax_action', 'zag_unpublish_sell_prop_ajax_action');
            add_action('wp_ajax_zag_trash_sell_prop_ajax_action', 'zag_trash_sell_prop_ajax_action');

            add_action('wp_ajax_zag_edit_project_prop_ajax_action', 'zag_edit_project_prop_ajax_action');
            add_action('wp_ajax_zag_unpublish_project_prop_ajax_action', 'zag_unpublish_project_prop_ajax_action');
            add_action('wp_ajax_zag_trash_project_prop_ajax_action', 'zag_trash_project_prop_ajax_action');



            remove_action('wp_head', 'feed_links', 2);
            remove_action('wp_head', 'feed_links_extra', 3);
            remove_action('wp_head', 'rsd_link');
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
            remove_action('wp_head', 'locale_stylesheet');
            remove_action('wp_head', 'noindex', 1);
            remove_action('wp_head', 'print_emoji_detection_script', 7);


            remove_action('wp_head', 'wp_generator');
            remove_action('wp_head', 'rel_canonical');
            remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
            remove_action('wp_head', 'wp_site_icon', 99);
            remove_action('wp_head', 'wp_oembed_add_discovery_links', 99);
            remove_action('wp_head', 'wp_oembed_add_host_js', 99);

            remove_action('wp_print_styles', 'print_emoji_styles');



            remove_action('embed_footer', 'print_embed_sharing_dialog');
            remove_action('embed_footer', 'print_embed_scripts');
            remove_action('embed_footer', 'wp_print_footer_scripts', 20);

            remove_action('wp_head', 'wp_oembed_add_discovery_links');
            remove_action('wp_head', 'wp_oembed_add_host_js');
        }

        public function define_filters() {

            add_filter('upload_dir', array($this, 'zag_upload_dir_structure')); // for post photo
            add_filter('get_avatar', array($this, 'zag_user_avatar'), 99, 6);
            add_filter('intermediate_image_sizes_advanced', array($this, 'zag_prop_img_sizes'), 10, 2);
        }

        public function zag_prop_img_sizes($sizes, $metadata) {
            if (DOING_AJAX && ($_REQUEST['action'] == "zag_new_property") || $_REQUEST['action'] == "zag_new_project_prop_ajax_action") {


                unset($sizes['medium']);
                unset($sizes['large']);
                unset($sizes['medium-large']);
            }

            return $sizes;
        }

        public function zag_user_avatar() {
            $args = func_get_args();

            $photo = get_user_option("photo", $args[1]);

            $url = $photo['url'];

            $avatar = sprintf(
                    "<img alt='%s' src='%s' srcset='%s' class='%s' height='%d' width='%d' %s/>", esc_attr($args[5]['alt']), esc_url($url), esc_attr(" "), esc_attr(join(' ', $args[5]['class'])), (int) $args[5]['height'], (int) $args[5]['width'], $args[5]['extra_attr']
            );

            return $avatar;
        }

        public function zag_upload_dir_structure() {
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

            $subdir = "/" . $current_user->display_name . '_' . $current_user->ID;


            $dir .= $subdir;
            $url .= $subdir;

            return array(
                'path' => $dir,
                'url' => $url,
                'subdir' => $subdir,
                'basedir' => $basedir,
                'baseurl' => $baseurl,
                'error' => false,
            );
        }

        public function create_taxonomies() {
            // Add new taxonomy, make it hierarchical (like categories)
            $labels = array(
                'name' => _x('Adress_Levels', 'taxonomy general name', 'textdomain'),
                'singular_name' => _x('Adress_Level', 'taxonomy singular name', 'textdomain'),
                'search_items' => __('Search Adress_Levels', 'textdomain'),
                'all_items' => __('All Adress_Levels', 'textdomain'),
                'parent_item' => __('Parent Adress_Level', 'textdomain'),
                'parent_item_colon' => __('Parent Adress_Level:', 'textdomain'),
                'edit_item' => __('Edit Adress_Level', 'textdomain'),
                'update_item' => __('Update Adress_Level', 'textdomain'),
                'add_new_item' => __('Add New Adress_Level', 'textdomain'),
                'new_item_name' => __('New Adress_Level Name', 'textdomain'),
                'menu_name' => __('Adress_Level', 'textdomain'),
            );

            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'adress'),
            );

            register_taxonomy('adress_level', array('zag_property'), $args);
        }

        /*
         * 
         */

        public function activate() {

            // Flush rewrite rules so that users can access custom post types on the
            // front-end right away
            $this->create_taxonomies();
            $this->register_post_types();
            flush_rewrite_rules();
        }

        public function register_post_types() {
            register_post_type('zag_property', array(
                'labels' => array(
                    'name' => __('Properties'),
                    'singular_name' => __('Property')
                ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'properties'),
                    )
            );

            register_taxonomy_for_object_type('adress_level', 'zag_property');
        }

        public function deactivate() {
            
        }

    }

}

