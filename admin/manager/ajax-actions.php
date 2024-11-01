<?php

add_action('wp_ajax_ud_reset_settings', 'ajax_ud_reset_settings');

if ( ! function_exists( 'ajax_ud_reset_settings' ) ) {
    function ajax_ud_reset_settings() {
        if ( ! is_user_logged_in() ) {
            return;
        }
        if ( wp_verify_nonce($_POST['ud_nonce_reset'], 'ud_nonce_reset_action') && $_POST['reset_settings'] == 'true' ) {
            delete_post_meta( ud_for_edd_get_dashboard_page_id(), '_wp_page_template', 'dashboard-template.php' );
            delete_option( 'ud_for_edd_general_options' );
            delete_option( 'ud_for_edd_redirection_options' );
            delete_option( 'ud_for_edd_access_control_options' );
            delete_option( 'ud_for_edd_email_options' );
            // Make sure to delete checkbox once the user hits `Reset Settngs` button.
            delete_option('ud_for_edd_reset_options');

            wp_send_json( array('resetStatus' => 'true' ) );
        } else {
            wp_send_json( array('resetStatus' => 'false') );
        }
    }
}