<?php

/**
 * Fired during plugin activation
 *
 * @since      0.10
 *
 * @package    User_Dashboard_For_Easy_Digital_Downloads
 * @subpackage User_Dashboard_For_Easy_Digital_Downloads/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    User_Dashboard_For_Easy_Digital_Downloads
 * @subpackage User_Dashboard_For_Easy_Digital_Downloads/includes
 * @author     WebsiteGuider <support@websiteguider.com>
 */
class User_Dashboard_For_EDD_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {
		if ( ! class_exists( 'Easy_Digital_Downloads' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( 'You can not activate this' );
		} else {
			if ( ! get_option( 'ud_for_edd_flush_rewrite_rules') ) {
				add_option( 'ud_for_edd_flush_rewrite_rules', true );
			}
		}
	}

	public function flush_rewrite_rules() 
	{
		if ( get_option( 'ud_for_edd_flush_rewrite_rules') ) {
			flush_rewrite_rules();

			delete_option( 'ud_for_edd_flush_rewrite_rules' );
		}
	}

}
