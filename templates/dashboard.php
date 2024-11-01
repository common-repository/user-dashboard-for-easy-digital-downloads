<?php
// If the user isn't logged in call exit().
if ( ! is_user_logged_in() || ! defined( 'ABSPATH' ) ) {
	exit();
}

global $wp;

if ( ! empty( $wp->query_vars ) ) {
	foreach ( $wp->query_vars as $key => $value ) {
		if ( $value == 'dashboard') {
			$class = 'dashboard';
		} else {
			$class = $key;
		}
	}
}
?>

<body <?php body_class("ud-dashboard-body key-ud-{$class}") ?>>
	<?php 
	do_action( 'ud_for_edd_dashboard_before_content' );

	do_action( 'ud_for_edd_dashboard_content' );

	do_action( 'ud_for_edd_dashboard_after_content' );
	?>
</body>
