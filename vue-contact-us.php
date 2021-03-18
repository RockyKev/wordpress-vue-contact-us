<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Vue Contact Us
 *
 * @wordpress-plugin
 * Plugin Name:       Vue Contact Us
 * Plugin URI:        #
 * Description:       This creates a Vue App that generates data to PHP and sends a email.
 * Version:           1.0.0
 * Author:            Rocky Kev
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vue-contact-us
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}
/**

* Currently plugin version.
 */
define('VUE_CONTACT_US', '1.0.0');


/* Enter your code here */
include_once('vue-contact-us-settings-admin.php');


function vue_contact_us() {
    // get Vue libs
	wp_register_script('vue-app-vendors',  plugins_url('app/dist/js/chunk-vendors.js', __FILE__), array(), '1.0.0');
	wp_register_script('my-vue-app', plugins_url('app/dist/js/app.js', __FILE__), array('vue-app-vendors'), '1.0.0');

	// pass the scripts to WP
	wp_enqueue_script('vue-app-vendors');
	wp_enqueue_script('my-vue-app');
    wp_enqueue_style('my-vue-app',  plugins_url('app/dist/css/app.css', __FILE__),   array(),  '1.0.0');

	// pass plugin directory
	$wp_plugin_uri = plugin_dir_url( __FILE__ );

	wp_localize_script('my-vue-app', 'wpPluginUri', $wp_plugin_uri);

    return '<div id="app"></div>';
}

add_shortcode('contact-us-vue', 'vue_contact_us');
