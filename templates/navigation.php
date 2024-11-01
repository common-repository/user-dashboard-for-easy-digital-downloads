<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wp;
?>
<header>
	<div class="ud-navbar-fixed">
        <nav class="ud-navbar">
        	<ul class="ud-nav-wrapper menu">
        	<?php echo the_title('<h3>', '</h3>' );  ?>
            <i class="wg-list2 menu-open-icon"></i>
            <i class="wg-cross menu-close-icon"></i>
                <ul id="ud-nav-mobile" class="ud-right">
                    <li class="ud_for_edd-date"><?php echo date('F j, Y'); ?></li>
                    <li class="ud_for_edd-logout"><a href='<?php echo esc_url(wp_logout_url( ud_for_edd_logout_redirect() )) ?>'>Logout <i class='wg-exit'></i></a></li>
                    <li class="ud_for_edd-account-icon"><a href="<?php echo esc_url(ud_for_edd_dashboard_get_endpoint_url('settings')); ?>">Account <i class="wg-user20"></i></a></li>
                </ul>
        	</ul>
        </nav>
    </div>
    <ul class="ud-sidenav ud-sidenav-fixed">
        <img src="<?php echo ud_for_edd_get_logo_url(); ?>">
          <?php 
		foreach ( ud_for_edd_get_dashboard_items() as $key => $value ) {
            $current = isset( $wp->query_vars[$key] );
            if ( $key == 'dashboard' && ( isset($wp->query_vars['page']) || empty($wp->query_vars) ) ) {
                $current = true;
            }

            $class = '';

            if ( $current ) {
                $class .= ' class="is-active-item"';
            }

			echo '<li'. $class .'><a class="ud_for_edd-' . $key . '" href="'. esc_url( ud_for_edd_dashboard_get_endpoint_url($key) ) . '">'. esc_html( $value ) .'</a></li>';
		}
		?>
        <a class="ud-logout-link" href="<?php echo wp_logout_url(ud_for_edd_logout_redirect() ); ?>">LogOut <i class="wg-exit"></i></a>
    </ul>

</header>


