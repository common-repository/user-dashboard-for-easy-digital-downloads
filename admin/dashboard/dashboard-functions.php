<?php

add_action( 'ud_for_edd_dashboard', 'ud_for_edd_dashboard' );

if ( ! function_exists('ud_for_edd_dashboard') ) {
    function ud_for_edd_dashboard() {
    	if ( is_user_logged_in() && ud_for_edd_is_dashboard_page()  ) {
    		ud_for_edd_get_dashboard_template('dashboard');
    	}
    }
}

add_action( 'ud_for_edd_dashboard_content', 'ud_for_edd_dashboard_output_content' );

if ( ! function_exists('ud_for_edd_dashboard_output_content') ) {
    function ud_for_edd_dashboard_output_content() {
        if ( is_user_logged_in() && ud_for_edd_is_dashboard_page() && ! ud_for_edd_is_endpoint_url() ) {
            // Current logged in user details
            $user = wp_get_current_user();
            // Store Current logged in users 'Display Name'
            $userDisplayName = $user->display_name;
            ?>
            <main class="ud-main">
                <div class="ud-container">
                    <div class="ud-section user-welcome">
                    <?php
                        $userHeading = __( sprintf('<h2>Welcome Back, %1$s</h2>', $userDisplayName), 'ud_for_eddd');
                        echo $userHeading;
                    ?>
                        <p>Here is your dashboard, where you can manage all your downloads, purchase history, personal data and much more.</p>
                    </div>
                    <div class="ud-section purchased-items">
                    <h3><?php echo __( 'Purchased Items', 'ud_for_eddd' ) ?></h3>
                    <?php
                        ud_for_edd_get_dashboard_template('purchased-items'); 
                    ?>
                    </div>
                    <div class="ud-section download-history">
                        <h3><?php echo __( 'Your Downloads', 'ud_for_eddd' ) ?></h3>
                        <?php
                        ud_for_edd_get_dashboard_template('downloads-history');
                        ?>
                    </div>
                </div>
            </main>
            <?php
        }
    }
}

add_action( 'ud_for_edd_dashboard_after_navigation', 'ud_for_edd_dashboard_after_navigation_link' );

if ( ! function_exists('ud_for_edd_dashboard_after_navigation_link') ) {
    function ud_for_edd_dashboard_after_navigation_link() {
        $logoutURL = ud_for_edd_logout_redirect();
    	echo "<span class='ud_for_edd-logout-link'><a href='". esc_url( wp_logout_url( $logoutURL )) . "'>Logout <i class='wg-user21'></i></a></span>";
    }
}

add_action( 'ud_for_edd_dashboard_content', 'ud_for_edd_dashboard_content' );

if ( ! function_exists('ud_for_edd_dashboard_content') ) {
    function ud_for_edd_dashboard_content() {
        global $wp;
        if ( ! empty( $wp->query_vars ) ) {
            foreach ( $wp->query_vars as $key => $value ) {
                // Ignore pagename param.
                if ( 'pagename' === $key ) {
                    continue;
                }

                if ( has_action( 'ud_for_edd_dashboard_' . $key . '_endpoint' ) ) {
                    do_action( 'ud_for_edd_dashboard_' . $key . '_endpoint', $value );
                    return;
                }
            }
        }
    }
}

/**
 * Get dashboard page ID.
 *
 * Get the page ID of specific page which has been selected by user in settings.
 *
 * @return string $value Return page ID
 */
if ( ! function_exists('ud_for_edd_get_dashboard_page_id') ) {
    function ud_for_edd_get_dashboard_page_id() {
            return ( isset( ud_for_edd_general_options()['page_id'] ) ?  ud_for_edd_general_options()['page_id'] : '' );
    }
}

if ( ! function_exists('ud_for_edd_is_dashboard_page') ) {
    function ud_for_edd_is_dashboard_page() {
        $page_id = ud_for_edd_get_dashboard_page_id();

        if ( ! is_page( $page_id ) ) {
            return false;
        }
        return true;
    }
}

add_action( 'template_redirect', 'ud_for_edd_template_redirect' );

if ( ! function_exists('ud_for_edd_template_redirect') ) {
    function ud_for_edd_template_redirect() {
        global $wp_query;

        if ( ud_for_edd_is_endpoint_url()  && ! ud_for_edd_is_dashboard_page() ) {
            $wp_query->set_404();
            status_header( 404 );
            include( get_query_template( '404' ) );
            exit;
        }
    }
}

if ( ! function_exists('ud_for_edd_get_dashboard_url') ) {
    function ud_for_edd_get_dashboard_url() {
        return get_permalink( ud_for_edd_get_dashboard_page_id() );
    }
}

if ( ! function_exists('ud_for_edd_get_dashboard_template') ) {
    function ud_for_edd_get_dashboard_template( $location ) {
    	// Location where templates are kept
    	$base_file_location = USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'templates/';
    	// Complete path of file
    	$file = $base_file_location . $location . '.php';
    	// Check if file exists or not. If it exists, include it
    	if (file_exists($file)) {
    		include $file;
    	} else {
    		// Throw error if the template isn't found
    		wp_die( "File Not found: $file", 'Template File Not Found' );
    	}
    }
}

if ( ! function_exists('ud_for_edd_get_template') ) {
    function ud_for_edd_get_template( $fileName=''  ) {
        if ( file_exists( get_stylesheet_directory() . '/user-dashboard-for-edd/templates/' . $fileName . '.php' ) ) {
            require_once get_stylesheet_directory() . '/user-dashboard-for-edd/templates/' . $fileName . '.php';
            exit();
        } elseif ( file_exists( get_template_directory() . '/user-dashboard-for-edd/templates/' . $fileName . '.php' ) ) {
            require_once get_template_directory() . '/user-dashboard-for-edd/templates/' . $fileName . '.php';
            exit();
        } elseif ( file_exists( USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'templates/' . $fileName . '.php' ) ) {
            require_once USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_PATH . 'templates/' . $fileName . '.php';
            exit();
        } else {
            wp_die( "File Not found: $fileName", 'Template File Not Found' );  
        }
    }
}

add_filter( 'page_template', 'ud_for_edd_change_dashboard_page_template' );
function ud_for_edd_change_dashboard_page_template() {

    if ( is_page_template( 'dashboard-template.php' ) && ! is_page(ud_for_edd_get_dashboard_page_id()) ) {
        delete_post_meta( get_the_ID(), '_wp_page_template', 'dashboard-template.php' );
    }

    if ( ud_for_edd_is_dashboard_page() ) {
        update_post_meta( ud_for_edd_get_dashboard_page_id(), '_wp_page_template', 'dashboard-template.php' );
    }
}

function ud_for_edd_page_endpoint_title( $title ) {
    global $wp_query;

    if ( ! is_null( $wp_query ) && is_user_logged_in() && is_main_query() && is_page(ud_for_edd_get_dashboard_page_id()) ) {
        $endpoint       = ud_for_edd_endpoints()->get_queried_endpoint();
        $endpoint_title = ud_for_edd_endpoints()->get_endpoint_title( $endpoint );
        $title          = $endpoint_title ? $endpoint_title : $title;

    }

    return $title;
}

add_filter( 'the_title', 'ud_for_edd_page_endpoint_title' );

add_action( 'ud_for_edd_dashboard_before_navigation', 'ud_for_edd_dashboard_before_navigation_logo' );

function ud_for_edd_dashboard_before_navigation_logo() {
    $logo = apply_filters( 'ud_for_edd_dashboard_before_navigation_logo', '<img src="' . ud_for_edd_get_logo_url() . '">' );
    echo $logo;
}

function ud_for_edd_document_endpoint_title( $title ) {
    global $wp_query;

    $endpoint       = ud_for_edd_endpoints()->get_queried_endpoint();
    $sep = apply_filters( 'document_title_separator', ' - ' );
    $site_name = apply_filters( 'ud_for_edd_site_name_endpoint', get_bloginfo( 'name', 'display' ) );
    if ( ! is_null( $wp_query ) && ! is_admin() && is_main_query() && is_page(ud_for_edd_get_dashboard_page_id()) ) {
        $endpoint_title = ud_for_edd_endpoints()->get_endpoint_title( $endpoint ) . $sep . $site_name;
        $title          = $endpoint_title ? $endpoint_title : $title;

        remove_filter( 'pre_get_document_title', 'ud_for_edd_document_endpoint_title' );
    }

    if ( ud_for_edd_is_dashboard_page() && ! ud_for_edd_is_endpoint_url() ) {
        $title = get_the_title(ud_for_edd_get_dashboard_page_id()) . $sep . $site_name;
        remove_filter( 'pre_get_document_title', 'ud_for_edd_document_endpoint_title' );
    } else if (! is_null( $wp_query ) && ! is_admin() && is_main_query() && is_page(ud_for_edd_get_dashboard_page_id()) ) {
        $endpoint_title = ud_for_edd_endpoints()->get_endpoint_title( $endpoint ) . $sep . $site_name;
        $title          = $endpoint_title ? $endpoint_title : $title;

        remove_filter( 'pre_get_document_title', 'ud_for_edd_document_endpoint_title' );
    }

    return $title;
}

add_filter( 'pre_get_document_title', 'ud_for_edd_document_endpoint_title' );