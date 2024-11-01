<?php

add_action( 'ud_for_edd_dashboard_settings_endpoint', 'ud_for_edd_dashboard_settings_endpoint' );

if ( ! function_exists('ud_for_edd_dashboard_settings_endpoint') ) {
    function ud_for_edd_dashboard_settings_endpoint(){

        if ( ud_for_edd_is_endpoint_url('settings') ) {
            ud_for_edd_get_dashboard_template('settings');
        }
    }
}

add_action( 'ud_for_edd_dashboard_purchased-items_endpoint', 'ud_for_edd_dashboard_purchased_items_endpoint' );

if ( ! function_exists('ud_for_edd_dashboard_purchased_items_endpoint') ) {
    function ud_for_edd_dashboard_purchased_items_endpoint(){

        if ( ud_for_edd_is_endpoint_url('purchased-items') ) {
            ud_for_edd_get_dashboard_template('purchased-items');
        }
    }
}

add_action( 'ud_for_edd_dashboard_download-history_endpoint', 'ud_for_edd_dashboard_download_history_endpoint' );

if ( ! function_exists('ud_for_edd_dashboard_download_history_endpoint') ) {
    function ud_for_edd_dashboard_download_history_endpoint(){

        if ( ud_for_edd_is_endpoint_url('download-history') ) {
            edd_get_template_part('history', 'downloads');
        }
    }
}

add_action( 'ud_for_edd_dashboard_before_content', 'ud_for_edd_dashboard_navigation' );

if ( ! function_exists('ud_for_edd_dashboard_navigation') ) {
    function ud_for_edd_dashboard_navigation() {
        ud_for_edd_get_dashboard_template('navigation');
    }
}