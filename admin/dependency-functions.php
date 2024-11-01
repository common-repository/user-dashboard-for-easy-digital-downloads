<?php
// {====== Settings (options) Functions ======}

if ( ! function_exists( 'ud_for_edd_general_options' ) ) {
	function ud_for_edd_general_options() {
		return (array) get_option( 'ud_for_edd_general_options');
	}
}

if ( ! function_exists( 'ud_for_edd_redirection_options' ) ) {
	function ud_for_edd_redirection_options() {
		return (array) get_option( 'ud_for_edd_redirection_options');
	}
}

if ( ! function_exists( 'ud_for_edd_access_control_options' ) ) {
	function ud_for_edd_access_control_options() {
		return (array) get_option( 'ud_for_edd_access_control_options');
	}
}
if ( ! function_exists( 'ud_for_edd_email_options' ) ) {
	function ud_for_edd_email_options() {
		return (array) get_option( 'ud_for_edd_email_options');
	}
}

if ( ! function_exists( 'ud_for_edd_reset_options' ) ) {
	function ud_for_edd_reset_options() {
		return (array) get_option( 'ud_for_edd_reset_options');
	}
}


if ( ! function_exists('ud_for_edd_get_logo_url') ) {
	function ud_for_edd_get_logo_url() {
		$frontLogo = isset(ud_for_edd_general_options()['front_logo']) ? esc_url( ud_for_edd_general_options()['front_logo'] ) : '';
		return $frontLogo;
	}
}

// {====== Error Manager Functions ======}

if ( ! function_exists( 'ud_for_edd_set_error' ) ) {
	function ud_for_edd_set_error( $id, $value ) {
		global $udForEddErrorManager;
		$udForEddErrorManager->set_error( $id, $value );
	}
}

if ( ! function_exists( 'ud_for_edd_get_error' ) ) {
	function ud_for_edd_get_error( $id ) {
		global $udForEddErrorManager;
		$udForEddErrorManager->get_error( $id );
	}
}

if ( ! function_exists( 'ud_for_edd_print_error' ) ) {
	function ud_for_edd_print_error() {
		global $udForEddErrorManager;
		$udForEddErrorManager->print_error();
	}
}

