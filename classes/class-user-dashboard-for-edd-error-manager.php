<?php

/**
 * The class is primarily used for Error Management
 *
 * @package user-dashboard-for-easy-digital-downloads/classes
 * @author WebsiteGuider
 **/

if ( ! class_exists( 'User_Dashboard_For_EDD_Error_Manager' ) ) {
	class User_Dashboard_For_EDD_Error_Manager
	{
		/**
		 * Stores the errors
		 *
		 * @var array Stores errors as key/value pairs
		 **/
		public $error = array();

		/**
		 * Set the error variable. Inserts the data into the variable $this->error
		 *
		 * @return array
		 * @author WebsiteGuider
		 **/
		public function set_error( $key, $value )
		{
			if ( isset( $key ) ) {
			    if( is_null( $value ) ) {
	        		unset( $this->error );
	        		return;
	    		}
				$sanitizedKey = sanitize_key( $key );

				$this->error[ $sanitizedKey ] = wp_json_encode( $value );

				return $this->error;
			}
		}

		/**
		 * Returns the error having specific key.
		 *
		 * @param $id Key for returning a specific error
		 * @return array 
		 * @author WebsiteGuider
		 **/
		public function get_error( $id )
		{

			if ( ! is_null( $id ) && array_key_exists($id, $this->error) ) {
				return $this->error[ $id ];
			}

			return false;
		}

		/**
		 * Prints the errors to the frontend.
		 *
		 * @return void
		 * @author WebsiteGuider
		 **/
		public function print_error()
		{
			if ( ! empty( $this->error ) ) {
				foreach ($this->error as $key => $value) {
					$decodeJson = json_decode( $value );
					?>
					<div class="ud-error custom-error">
						<p class="ud-error-<?php echo $key; ?>">
							<?php echo __( $decodeJson, 'ud-for-edd' ); ?>
						</p>
					</div>
					<?php
				}
			}
		}
	}
}