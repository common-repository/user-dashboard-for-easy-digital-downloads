<?php

if ( ! function_exists( 'ud_for_edd_delete_deprecated_options' ) ) {
	function ud_for_edd_delete_deprecated_options() {
		$generalOption = get_option( 'ud_for_edd_general_option');
		$redirectionOptions = get_option( 'ud_for_edd_redirection_option');
		$optionsFirst = get_option( 'ud_for_edd_options');

		if ( isset( $generalOption ) ) {
			add_option( 'ud_for_edd_general_options', get_option( 'ud_for_edd_general_option'));
			delete_option( 'ud_for_edd_general_option' );
		} 

		if ( isset( $redirectionOptions ) ) {
			add_option( 'ud_for_edd_redirection_options', get_option( 'ud_for_edd_redirection_option') );
			delete_option( 'ud_for_edd_redirection_option' );
		}

		if ( isset( $optionsFirst ) ) {
			update_option( 'ud_for_edd_general_options', get_option( 'ud_for_edd_options') );
			delete_option( 'ud_for_edd_options' );
		}
	}	
}

if ( ! function_exists( 'ud_for_edd_logout_redirect' ) ) {
	function ud_for_edd_logout_redirect() {
		$redirectLink = '';
		$logoutOption = isset( ud_for_edd_redirection_options()['logout_link_redirect'] ) ? ud_for_edd_redirection_options()['logout_link_redirect'] : null;
		if (  ! $logoutOption == null ) {
			$redirectLink = apply_filters( 'filter_ud_for_edd_logout_redirect', $logoutOption);
		}

		return $redirectLink;
	}
}

if ( function_exists( 'ud_for_edd_admin_settings_coming_soon' ) ) {
	function ud_for_edd_admin_settings_coming_soon() {
	?>
	<div class="ud-for-edd-coming-soon">
		<span class="dashicons dashicons-admin-appearance"></span>
		<p>Hey there, I am being constructed. You will see settings in the coming releases. Thank you.</p>
	</div>
	<?php
	}
}

if ( ! function_exists( 'ud_for_edd_allowed_roles' ) ) {
	function ud_for_edd_allowed_roles() {
		$currentUser = wp_get_current_user();
		$currentUserRole = $currentUser->roles;

		$optionNotSelected = empty( ud_for_edd_access_control_options()['allowed_roles']) ? true : false;

		if ( $optionNotSelected ) {
			return true;
		}

		$allowedUserRoles = isset( ud_for_edd_access_control_options()['allowed_roles']) ? ud_for_edd_access_control_options()['allowed_roles'] : '';

		foreach ( (array) $allowedUserRoles as $role) {
			$role = strtolower($role);

			if ( in_array($role, $currentUserRole) ) {
				return true;
			} else {
				return false;
			}
		}


	}
}