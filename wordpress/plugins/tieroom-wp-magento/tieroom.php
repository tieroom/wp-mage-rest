<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Tieroom_WP_Magento
 * @author    Mattias Hising <mattias@ridgestreet.se>
 * @license   GPL-2.0+
 * @link      http://tieroom.com/tieroom-wp-magento
 * @copyright 2014 Mattias Hising, 80 Ridge Street AB and Tieroom AB
 *
 * @wordpress-plugin
 * Plugin Name:       Tieroom WP Magento Integration Plugin
 * Plugin URI:        http://tieroom.com/tieroom-wp-magento
 * Description:       A plugin enabling integration between Magento and Wordpress via the awesome WP JSON API
 * Version:           1.0.0
 * Author:            Mattias Hising
 * Author URI:        mattias@ridgestreet.se
 * Text Domain:       tieroom-wp-magento
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/tieroom/wp-magento
 * WordPress-Plugin-Boilerplate: v2.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-name.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/Tieroom.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Plugin_Name with the name of the class defined in
 *   `class-plugin-name.php`
 */
register_activation_hook( __FILE__, array( 'Tieroom_WP_Magento', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Tieroom_WP_Magento', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Plugin_Name with the name of the class defined in
 *   `class-plugin-name.php`
 */
add_action( 'plugins_loaded', array( 'Tieroom_WP_Magento', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-plugin-name-admin.php` with the name of the plugin's admin file
 * - replace Plugin_Name_Admin with the name of the class defined in
 *   `class-plugin-name-admin.php`
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/TieroomAdmin.php' );
	add_action( 'plugins_loaded', array( 'Tieroom_WP_Magento_Admin', 'get_instance' ) );

}
