<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that classes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      0.10
 *
 * @package    User_Dashboard_For_Easy_Digital_Downloads
 * @subpackage User_Dashboard_For_Easy_Digital_Downloads/classes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    customerDash for Easy Digital Downloads
 * @subpackage customerdash-for-Easy-Digital-Downloads/classes
 * @author     Your Name <email@example.com>
 */
class User_Dashboard_For_EDD {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      user_dashboard_for_edd_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $user_dashboard_for_edd    The string used to uniquely identify this plugin.
	 */
	protected $user_dashboard_for_edd;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'USER_DASHBOARD_FOR_EDD_VERSION' ) ) {
			$this->version = USER_DASHBOARD_FOR_EDD_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->user_dashboard_for_edd = 'user-dashboard-for-edd';
		$this->load_front_scripts();
		$this->load_critical_functions();
		$this->load_dependencies();
		$adminScripts = new User_Dashboard_For_EDD_Admin( $this->user_dashboard_for_edd, $this->version );
		add_action( 'admin_enqueue_scripts', array($adminScripts, 'enqueue_styles') );
		add_action( 'admin_enqueue_scripts', array($adminScripts, 'enqueue_scripts') );
		$publicScripts = new User_Dashboard_For_EDD_Public( $this->user_dashboard_for_edd, $this->version );
		add_action( 'wp_enqueue_scripts', array($publicScripts, 'enqueue_styles'), 999 );
		add_action( 'wp_enqueue_scripts', array($publicScripts, 'enqueue_scripts'), 999 );
	}

	public function load_dependencies() {
		require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/class-user-dashboard-for-edd-admin.php';
		require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'public/class-user-dashboard-for-edd-public.php';
	}

	public function load_front_scripts() {
		add_action( 'wp_enqueue_scripts', array($this, 'load_scripts_for_front' ), 999 );
	}

	public function load_scripts_for_front() {
		wp_enqueue_style( 'font-css', 'https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap' );
	}


	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_user_dashboard_for_edd() {
		return $this->user_dashboard_for_edd;
	}
	public function load_critical_functions()
	{
		require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'admin/manager/critical-functions.php';
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    user_dashboard_for_edd_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
