<?php

if ( ! function_exists('ud_for_edd_page_selector_callback') ) {
	function ud_for_edd_page_selector_callback() {
	    wp_dropdown_pages( array( 'name' => 'ud_for_edd_general_options[page_id]', 'selected' => ud_for_edd_get_dashboard_page_id() ) );
	                        
	}
}

if ( ! function_exists('ud_for_edd_logo_callback') ) {
	function ud_for_edd_logo_callback() {
		?>
		<input id="upload_image" type="text" size="36" name="ud_for_edd_general_options[front_logo]" value="<?php echo esc_url( ud_for_edd_get_logo_url() ); ?> " placeholder="Enter URL" />
		<input id="ud_for_edd_upload_logo_button" class="button" type="button" value="Upload Image" />
		<div class="ud-for-edd-preview-logo">
			<span>Preview: </span>
			<?php
			if ( ! empty( ud_for_edd_get_logo_url() ) ) {
				echo '<img src="' . ud_for_edd_get_logo_url(). '">';
			} else {
				echo "<span>No Image Selected</span>";
			}
			?>
		</div>
		<!-- <span class="ud-for-edd-tooltip"></span>
		<p class="ud-for-edd-tooltip-text">Hello</p> -->
		<?php                    
	}
}

if ( ! function_exists( 'ud_for_edd_logout_link_redirect_field_callback' ) ) {
	function ud_for_edd_logout_link_redirect_field_callback() {
		$redirectLogoutLink = ( ! empty( ud_for_edd_redirection_options()['logout_link_redirect']) ) ? ud_for_edd_redirection_options()['logout_link_redirect'] : '';
		?>
		<input class="widefat" type="url" name="ud_for_edd_redirection_options[logout_link_redirect]" value="<?php echo esc_url( $redirectLogoutLink ); ?>" placeholder="Enter URL">
		<p class="ud-input-details"><?php  _e( 'Please enter the link where you want the user to redirect after logout.', 'ud-for-edd' ); ?></p>
		<?php
	}
}

if ( ! function_exists( 'ud_for_edd_not_allowed_roles_redirect_field_callback' ) ) {
	function ud_for_edd_not_allowed_roles_redirect_field_callback() {
		$redirectRoleLink = ( ! empty( ud_for_edd_redirection_options()['not_allowed_role_redirect']) ) ? ud_for_edd_redirection_options()['not_allowed_role_redirect'] : '';
		?>
		<input class="widefat" type="url" name="ud_for_edd_redirection_options[not_allowed_role_redirect]" value="<?php echo esc_url( $redirectRoleLink ); ?>" placeholder="Enter URL">
		<p class="ud-input-details"><?php  _e( 'Please enter the link where you want the user to redirect if his role isn\'t allowed to see the dashboard page.', 'ud-for-edd' ); ?></p>
		<?php
	}
}

if ( ! function_exists( 'ud_for_edd_delete_data_uninstall_callback' ) ) {
	function ud_for_edd_delete_data_uninstall_callback() {
		$checked = isset(ud_for_edd_general_options()['data_delete_uninstall']) ? 1 : 0;
		?>
		<input type="checkbox" name="ud_for_edd_general_options[data_delete_uninstall]" <?php echo checked( 1, $checked, false ); ?> value="1">
		<p><?php _e( 'Select the checkbox, if you want to delete all data on uninstall.', 'ud-for-edd' ); ?></p>
		<?php
	}
}

if ( ! function_exists( 'ud_for_edd_access_control_field_callback' ) ) {
	function ud_for_edd_access_control_field_callback() {
		global $wp_roles;
		$roles = $wp_roles->roles;
		$allowedRoles = ! empty( ud_for_edd_access_control_options()["allowed_roles"] ) ? ud_for_edd_access_control_options()["allowed_roles"] : ''; 

		foreach ( $roles as $role ) {
			$roleName = $role['name'];
			$output = sprintf('<input type="checkbox" id="ue_roles_checkbox" name="ud_for_edd_access_control_options[allowed_roles][]" value="%1$s" %2$s><label for="ue_roles_checkbox">%1$s</label><br>', 
				$roleName,
				checked( in_array($roleName, (array) $allowedRoles), 1, false )
			);
			echo $output;
		}
	}
}

if ( ! function_exists( 'ud_for_edd_access_control_checkbox_field_callback' ) ) {
	function ud_for_edd_access_control_checkbox_field_callback() {
		$selected = ! empty(ud_for_edd_access_control_options()['redirect_checkbox']) ? true : false; 
		?>
		<input type="checkbox" name="ud_for_edd_access_control_options[redirect_checkbox]" <?php echo checked( $selected, true, false );  ?>>
		<p class="ud-input-details">Check the box if you want to redirect user if his role isn't in allowed roles list</p>
		<?php
	}
}

if ( ! function_exists( 'ud_for_edd_reset_field_callback' ) ) {
	function ud_for_edd_reset_field_callback() {
		printf('<input type="%1$s" value="%2$s" name="%3$s" class="%3$s"><div class="ud-ajax-message"><p>Click above button.</p></div>', 'button', 'Reset Settings', 'ud_reset_submit button button-primary');
	}
}
