<?php

if ( ! function_exists('ud_for_edd_endpoints') ) {
    function ud_for_edd_endpoints() {
        return new User_Dashboard_For_EDD_Endpoints();
    }
}

if ( ! function_exists('ud_for_edd_is_endpoint_url') ) {
    function ud_for_edd_is_endpoint_url( $endpoint = false ) {
        global $ud_for_edd_endpoints, $wp;
        $endpoints = $ud_for_edd_endpoints->get_query_vars();

        if ( false !== $endpoint ) {
          if ( ! isset( $endpoints[ $endpoint ] ) ) {
            return false;
          } else {
            $endpoint_var = $endpoints[ $endpoint ];
          }

          return isset( $wp->query_vars[ $endpoint_var ] );
        } else {
          foreach ( $endpoints as $key => $value ) {
            if ( isset( $wp->query_vars[ $key ] ) ) {
              return true;
            }
          }

          return false;
        }
    }
}

if ( ! function_exists('ud_for_edd_get_registered_endpoints') ) {
    function ud_for_edd_get_registered_endpoints() {
        return ud_for_edd_endpoints()->get_query_vars();
    }
}

if ( ! function_exists('ud_for_edd_get_dashboard_items') ) {
    function ud_for_edd_get_dashboard_items() {
        $endpoints = ud_for_edd_get_registered_endpoints();

        $menu_items = array(
            'dashboard'         => __( 'Dashboard', 'ud_for_edd' ),
            'purchased-items'   => __( 'Purchased Items', 'ud_for_edd' ),
            'download-history'  => __( 'Download History', 'ud_for_edd' ),
            'settings'          => __( 'Settings', 'ud_for_edd' ),
        );

        // Remove missing endpoints.
        foreach ( $endpoints as $endpoint_id => $endpoint ) {
            if ( empty( $endpoint ) ) {
                unset( $menu_items[ $endpoint_id ] );
            }
        }

        return apply_filters( 'customerdash_dashboard_menu_items', $menu_items, $endpoints );
    }
}

if ( ! function_exists('ud_for_edd_get_endpoint_url') ) {
    function ud_for_edd_get_endpoint_url($endpoint, $value = '', $permalink = '') {
        if ( ! $permalink ) {
            $permalink = get_permalink();
        }

        // Map endpoint to options.
        $query_vars = ud_for_edd_get_registered_endpoints();
        $endpoint   = ! empty( $query_vars[ $endpoint ] ) ? $query_vars[ $endpoint ] : $endpoint;

        if ( get_option( 'permalink_structure' ) ) {
            if ( strstr( $permalink, '?' ) ) {
                $query_string = '?' . wp_parse_url( $permalink, PHP_URL_QUERY );
                $permalink    = current( explode( '?', $permalink ) );
            } else {
                $query_string = '';
            }
            $url = trailingslashit( $permalink ) . trailingslashit( $endpoint );
        }

        return apply_filters( 'customerdash_get_endpoint_url', $url, $endpoint, $permalink );
    }
}

if ( ! function_exists('ud_for_edd_dashboard_get_endpoint_url') ) {
    function ud_for_edd_dashboard_get_endpoint_url( $endpoint ) {
        if ( 'dashboard' === $endpoint ) {
            return ud_for_edd_get_dashboard_url();
        }
        
        return ud_for_edd_get_endpoint_url( $endpoint, '', ud_for_edd_get_dashboard_url() );
    }
}
