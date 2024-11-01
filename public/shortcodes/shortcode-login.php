<?php


/**
 * Shortcode for showing Sign In form.
 *
 * Use [user_dashboard_for_edd_login] shortcode in page, post, or widget to display the log-in form.
 *
 * @since 1.0.0
 *
 * @param array $atts The list of attributes passed when calling the shortcode.
 *
 * @return Return the login form using output buffering.
 * @author WebsiteGuider
 **/

if ( ! function_exists('ud_for_edd_dashboard_shortcode') ) {
	function ud_for_edd_shortcode_custom_login( $atts ) {
		if( isset($atts['redirect']) ) {
			$custom_redirect = $atts['redirect']; }

			if( empty($atts['redirect']) ) $custom_redirect = home_url();

	    	// Start Output buffering
			ob_start();
	    	// Output the HTML form here
			custom_html_login_form( $custom_redirect );
	    	// End Output buffering by returning it
			return ob_get_clean();
	}
}
add_shortcode( 'user_dashboard_for_edd_login', 'shortcode_custom_login' );