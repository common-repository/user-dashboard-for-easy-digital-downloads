<?php

if ( ! class_exists('User_Dashboard_For_EDD_Endpoints') ) {
	/**
	 * 
	 */
	class User_Dashboard_For_EDD_Endpoints
	{
		public $query_vars;
		
		function __construct()
		{
			add_action( 'init', array($this, 'add_endpoints') );

			if ( !is_admin() ) {
				add_filter( 'query_vars', array( $this, 'add_query_vars' ) );
			}
			$this->init_query_vars();
		}

		public function init_query_vars()
		{
			$this->query_vars = array(
				'purchased-items' => 'purchased-items', 
				'download-history' => 'download-history',
				'settings' => 'settings'
			);
		}

		public function get_endpoint_title( $endpoint ) {
			global $wp;

			switch ( $endpoint ) {
				case 'purchased-items':
					$title = __( 'Purchased Items', 'ud_for_edd' );
					break;
				case 'download-history':
					$title = __( 'Download History', 'ud_for_edd' );
					break;
				case 'settings':
					$title = __( 'Settings', 'ud_for_edd' );
					break;
				default:
					$title = '';
					break;
			}

			return apply_filters( 'customerdash_endpoint_' . $endpoint . '_title', $title, $endpoint );
		}

		public function add_endpoints()
		{
			foreach ($this->get_query_vars() as $key => $value ) {
				add_rewrite_endpoint( $value, EP_PAGES );
			}
			
		}

		public function add_query_vars($vars)
		{

			foreach ($this->get_query_vars() as $key => $value) {
				$vars[] = $value;
			}

			return $vars;
	
		}

		public function get_query_vars()
		{
			return apply_filters( 'ud_for_edd_dashboard_get_query_vars', $this->query_vars );
		}

		public function get_queried_endpoint()
		{
			global $wp;

			foreach ( $this->get_query_vars() as $key => $value ) {
				if ( isset( $wp->query_vars[ $key ] ) ) {
					return $key;
				}
			}
			return '';
		}
	}
}

new User_Dashboard_For_EDD_Endpoints();

