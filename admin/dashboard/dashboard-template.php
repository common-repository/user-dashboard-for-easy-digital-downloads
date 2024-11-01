<?php
/*
 * Template Name: Customer Dashboard
 * Template Post Type: page
 */
if ( is_user_logged_in() && ! ud_for_edd_allowed_roles() ) {
	if ( ! empty( ud_for_edd_access_control_options()['redirect_checkbox'] ) ) {
		$redirect = ud_for_edd_redirection_options()['not_allowed_role_redirect'];
		wp_redirect( $redirect );
		exit();
	} else {
		wp_die('You are not allowed to view this page. Sorry for any inconvenience. Please contact administrator.', 'Not allowed');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head() ?>
</head>
<?php
if ( ! is_user_logged_in() ) {
	wp_redirect( ud_for_edd_get_dashboard_template('form-login'));
} else {

	do_action( 'ud_for_edd_before_dashboard' );

	do_action( 'ud_for_edd_dashboard' );

	do_action( 'ud_for_edd_after_dashboard' );

?>
</html>
<?php
}