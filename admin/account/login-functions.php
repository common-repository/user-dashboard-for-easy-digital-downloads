<?php

/**
 * Log-in the User
 *
 * This function accepts various parameters which are used for checking whether the user exists or not.
 *
 * @since 1.0.0
 *
 * @param int $user_id The ID of the user.
 * @param string $user_login The users username/email.
 * @param string $user_pass Password of the user.
 * @param boolean $user_remember Whether to remember the user credentials or not.
 *
 * @return void Return early if the user doesn't exist.
 * @author WebsiteGuider
 **/

if ( ! function_exists( 'ud_for_edd_custom_log_userin' ) ) {

	function ud_for_edd_custom_log_userin($user_id, $user_login, $user_pass, $user_remember = false ) {
	    if( ! absint( $user_id ) || $user_id < 1 ) {
	        return;
	    }
	    
	    wp_set_auth_cookie( $user_id, $user_remember );
	    wp_set_current_user( $user_id, $user_login );
	    do_action( 'wp_login', $user_login, get_userdata( $user_id ) );
	}
}

if ( ! function_exists('ud_for_edd_custom_error_set') ) {

	function ud_for_edd_custom_error_set( $id, $value ) {
		_deprecated_function( __FUNCTION__, '0.0.20', 'ud_for_edd_set_error' );
	    global $error_json;
	    
	    if( is_null($value) ) {
	        unset( $error_json );
	        return;
	    }
	    
	    $id = sanitize_key( $id );
	    
	    if( is_array( $value ) ) {
	        $error_json[ $id ] = wp_json_encode( $value );
	    } else {
	        $error_json[ $id ] = esc_attr( $value );
	    }
	    
	    return $error_json;
	}
}

if ( ! function_exists('ud_for_edd_custom_error_get') ) {

	function ud_for_edd_custom_error_get( $id ) {
		_deprecated_function( __FUNCTION__, '0.0.20', 'ud_for_edd_get_error' );

	    global $error_json;
	    
	    $maybe_decode_json = json_decode($error_json[ $id ]);
	    
	    if( ! is_null( $maybe_decode_json ) && ! is_array($maybe_decode_json) ) {
	        $maybe_decode_json = json_decode($error_json[ $id ], true);
	    } else {
	        $maybe_decode_json = FALSE;
	    }
	    
	    return $maybe_decode_json;
	    
	}
}

if ( ! function_exists('ud_for_edd_custom_get_errors') ) {
	function ud_for_edd_custom_get_errors() {
		_deprecated_function( __FUNCTION__, '0.0.20' );

	    return ud_for_edd_custom_error_get('custom-errors');
	}
}

if ( ! function_exists('ud_for_edd_custom_output_error') ) {
	function ud_for_edd_custom_output_error($id, $value) {
		_deprecated_function( __FUNCTION__, '0.0.20');

	    $errors = ud_for_edd_custom_get_errors();
	    if( ! $errors ) {
	        $errors = array();
	    }
	    
	    $errors[ $id ] = $value;
	    
	    ud_for_edd_custom_error_set('custom-errors', $errors);
	    
	}
}

if ( ! function_exists('ud_for_edd_custom_print_errors') ) {
	function ud_for_edd_custom_print_errors() {
		_deprecated_function( __FUNCTION__, '0.0.20', 'ud_for_edd_print_error' );

	    $errors = ud_for_edd_custom_get_errors();
	    
	    if( ! empty($errors) ) {
	        ?>
	        <div class="custom-error">
	        <?php
	        foreach( $errors as $error_id => $error ) {
	            echo '<p class="error_' . $error_id .'"><strong>Error:</strong> ' . $error . '</p>';
	        }
	        ?>
	        </div>
	        <?php
	    }
	}
}

/**
 * Generate the HTML markup of the form
 *
 * @since 1.0.0
 *
 * @param string $custom_redirect The URL where the user should be redirected after submitting the form.
 *
 * @return void Return early if the user is logged in.
 * @author WebsiteGuider
 **/

if ( ! function_exists('ud_for_edd_custom_html_login_form') ) {
	function ud_for_edd_custom_html_login_form( $custom_redirect ) {
	    if( ! is_user_logged_in() ) {
	        ?>
	        <body <?php body_class( 'ud_for_edd-custom-login' ); ?>>
	            <div class="ud_for_edd-container is-fluid">
	                <div class="ud_for_edd-column">
	                    <img class="ud_for_edd-logo-img" src="<?php echo ud_for_edd_get_logo_url() ?>">
	                    <form method="post" class="ud_for_edd-custom-login-form">
	                    <style type="text/css">
	            			.custom-error {
	            				margin-bottom: 10px;
	            				padding: 10px;
	                			background-color: #d64646;
	                			color: white;
	                			border-radius: 5px;
	            			}
	                        .custom-error p {
	                            margin: 0;
	                        }
	            		</style>
	                        <?php ud_for_edd_print_error() ?>
	                        <p>
	                            <label for="custom-user"><?php _e('Username', 'custom-login-register'); ?></label>
	                            <input type="text" name="custom_user" id="custom-user" placeholder="Type Username or Email" />
	                        </p>
	                        <p>
	                            <label for="custom-pass"><?php _e('Password', 'custom-login-register'); ?></label>
	                            <input type="password" name="custom_pass" id="custom-pass" placeholder="Type the password" />
	                        </p>
	                        <p>
	                        <label for="remember-me">
	                            <input type="checkbox" name="remember_me" id="remember-me"/>
	                            <?php _e('Remember Me', 'custom-login-register'); ?>
	                        </label>
	                        </p>
	                        <p>
	                            <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e('Lost Password', 'custom-login-register'); ?></a>
	                        </p>
	                        <p class="ud_for_edd-submit-login">
	                            <input type="hidden" name="custom_login_nonce" value="<?php echo wp_create_nonce('custom-login-nonce'); ?>" />
	                            <input type="hidden" name="custom_redirection" value="<?php echo esc_url( $custom_redirect ); ?>"/>
	                            <input type="submit" class="ud_for_edd-submit-custom-login" name="submit_custom_login" value="<?php _e('Login', 'custom-login-register'); ?>" />    
	                        </p>
	                    </form>
	                </div>
	            </div>
	        </body>
	        <?php
	    } else {
	        _e("You are logged in", 'custom-login-register');
	    }
	}
}

add_action( 'init', 'ud_for_edd_process_custom_login_form' );

/**
 * Process the Log-In form
 *
 * This callback function is called before any headers are sent. 
 * With this function you can validate the user details submitted by him using our log-in form.
 *
 * @since 1.0.0
 *
 * @return void
 * @author WebsiteGuider
 **/

if ( ! function_exists('ud_for_edd_process_custom_login_form') ) {
	function ud_for_edd_process_custom_login_form() {
	    // Validate the username or email field before submitting
	    if ( isset($_POST['custom_user'])) {
	        $custom_user =  trim( sanitize_text_field( $_POST['custom_user'] ) );
	    }
	    
	    // Validate password field before submitting
	    if ( isset($_POST['custom_pass']) ) {
	        $custom_pass = trim($_POST['custom_pass']);
	    }

	    if ( isset($_POST['remember_me']) ) {
	    	$sanitizedRemember = filter_var($_POST['remember_me'], FILTER_SANITIZE_NUMBER_INT );
	    }

	    if( wp_verify_nonce( (isset($_POST['custom_login_nonce']) ? $_POST['custom_login_nonce'] : ''), 'custom-login-nonce' ) ) {
	        $user_info = get_user_by( 'login', sanitize_user( $custom_user ) );
	        
	        if( ! $user_info ) {
	            $user_info = get_user_by( 'email', sanitize_email( $custom_user ) );
	        }
	        
	        if( $user_info ) {
	            $user_id = $user_info->ID;
	            if( wp_check_password( $custom_pass, $user_info->user_pass, $user_id ) ) {
	                if( isset($_POST['remember_me']) ) {
	                    $sanitizedRemember = 1;
	                } else {
	                    $sanitizedRemember = 0;
	                }
	                
	                ud_for_edd_custom_log_userin( $user_id, $custom_user, $custom_pass, $sanitizedRemember );
	                wp_redirect( $_POST['custom_redirection'] );
	                die;
	            } else {
	                ud_for_edd_set_error('wrong_password', 'The password you entered is incorrect.');
	            }
	        } else {
	            ud_for_edd_set_error('wrong_username', 'The username you entered is incorrect.');
	        }
	    }
	}
}
