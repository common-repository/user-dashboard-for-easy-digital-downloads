<?php
/**
 * @wordpress-plugin
 * Plugin Name:       User Dashboard for Easy Digital Downloads
 * Plugin URI:        https://websiteguider.com
 * Description:       This plugin lets Easy digital downloads users add a dashboard to frontend. The UI is simple.
 * Version:           0.20.10
 * Author:            WebsiteGuider
 * Author URI:        https://websiteguider.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ud_for_edd
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'USER_DASHBOARD_FOR_EDD_VERSION', '0.20.10' );

define('USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ));
define('USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_URI', plugin_dir_url( __FILE__ ));

spl_autoload_register('ud_for_edd_autoloader');

function ud_for_edd_autoloader( $className ) {
	// // Path of classes where they are located. They are inside {classes} folder
	$path = USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'classes/class-';
	$extension = '.php';

	// Check if the class has 'user_dashboard' text 
	if ( strpos($className, 'User_Dashboard_For_EDD') === false ) {
		return;
	}

	if( $className ) {
		$fileName = strtolower(str_replace(array( '\\', '_' ), array( '-', '-' ), $className));
	}

	$fileLocation = $path . $fileName . $extension;

	if ( file_exists( $fileLocation ) ) {
		include_once $fileLocation;
	}

	return null;

}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-user-dashboard-for-edd-activator.php
 */
if ( ! function_exists('ud_for_edd_activate') ) {
	function ud_for_edd_activate() {
		$activator = new User_Dashboard_For_EDD_Activator();
		$activator->activate();
	}
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-user-dashboard-for-edd-deactivator.php
 */
if ( ! function_exists('ud_for_edd_deactivate') ) {
	function ud_for_edd_deactivate() {
		User_Dashboard_For_EDD_Deactivator::deactivate();
	}
}

register_activation_hook( __FILE__, 'ud_for_edd_activate' );
register_deactivation_hook( __FILE__, 'ud_for_edd_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
if ( ! function_exists('ud_for_edd_run') ) {
	function ud_for_edd_run() {
		new User_Dashboard_For_EDD();
	}
}

ud_for_edd_run();

add_action( 'init', function() {
	if ( get_option( 'ud_for_edd_flush_rewrite_rules') ) {
		flush_rewrite_rules();
		delete_option( 'ud_for_edd_flush_rewrite_rules' );
	}
} );

require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/manager/globals.php';
require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/dependency-functions.php';
require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/dashboard/dashboard-functions.php';
require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/settings/admin-page-settings.php';
require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/settings/callback-functions.php';
require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/dashboard/class-user-dashboard-for-edd-template.php';
require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/manager/admin-actions.php';
require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/manager/ajax-actions.php';
require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/endpoints/endpoint-functions.php';
require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/endpoints/endpoint-actions.php';
require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/account/login-functions.php';
