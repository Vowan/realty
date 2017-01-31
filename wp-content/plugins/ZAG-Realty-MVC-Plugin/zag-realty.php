<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       Zag Realty 
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Main plugin for Real Estate Site
 * Version:           1.0.0
 * Author:            V.Zaganich
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

define( 'ZAG_NAME',                 'ZAG MVC Plugin' );
define( 'ZAG_REQUIRED_PHP_VERSION', '5.3' );                          // because of get_called_class()
define( 'ZAG_REQUIRED_WP_VERSION',  '3.1' );                          // because of esc_textarea()

/**
 * Checks if the system requirements are met
 *
 * @return bool True if system requirements are met, false if not
 */
function zag_requirements_met() {
	global $wp_version;
	//require_once( ABSPATH . '/wp-admin/includes/plugin.php' );		// to get is_plugin_active() early

	if ( version_compare( PHP_VERSION, ZAG_REQUIRED_PHP_VERSION, '<' ) ) {
		return false;
	}

	if ( version_compare( $wp_version, ZAG_REQUIRED_WP_VERSION, '<' ) ) {
		return false;
	}

	/*
	if ( ! is_plugin_active( 'plugin-directory/plugin-file.php' ) ) {
		return false;
	}
	*/

	return true;
}

/**
 * Prints an error that the system requirements weren't met.
 */
function zag_requirements_error() {
	global $wp_version;

	require_once( dirname( __FILE__ ) . '/views/zag-requirements-error.php' ); //defines admin notice message
}

/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise older PHP installations could crash when trying to parse it.
 */
if ( zag_requirements_met() ) {
    
    require_once( __DIR__ . '/classes/ZAG_Basic.php' );
    
    if ( class_exists( 'ZAG_Basic' ) ) {
		$GLOBALS['zag_plug'] = ZAG_Basic::instance();
		
		
	}
    
}else {
	add_action( 'admin_notices', 'zag_requirements_error' );
}