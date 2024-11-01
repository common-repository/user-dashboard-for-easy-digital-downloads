<?php

if ( ! class_exists( 'User_Dashboard_For_EDD_Settings_Manager' ) ) {
	class User_Dashboard_For_EDD_Settings_Manager
	{
		public $general;
		public $redirection;
		public $email;

		public function  __construct()
		{
			add_action( 'admin_menu', array( $this, 'initialize_admin_page' ) );
			add_action( 'admin_init', array( $this, 'initialize_settings_fields_and_sections' ) );
		}

		public function initialize_admin_page()
		{
			add_menu_page( 
				__('User Dashboard EDD Settings', 'ud-for-edd'), 
				__('User Dashboard EDD', 'ud-for-edd'), 
				'manage_options',
				'ud-for-edd', 
				array($this, 'ud_for_edd_setup_menu_page'),
				'dashicons-layout'
			);

			add_submenu_page( 
				'ud-for-edd',
				__( 'Redirection Settings', 'ud-for-edd' ), 
				__( 'Redirection', 'ud-for-edd' ), 
				'manage_options', 
				'ud-for-edd-redirection', 
				array( $this, 'ud_for_edd_setup_redirection_page' ) 
			);			
			add_submenu_page( 
				'ud-for-edd',
				__( 'Access Control Settings', 'ud-for-edd' ), 
				__( 'Access Control', 'ud-for-edd' ), 
				'manage_options', 
				'ud-for-edd-access-control', 
				array( $this, 'ud_for_edd_setup_access_control_page' ) 
			);

			add_submenu_page( 
				'ud-for-edd', 
				__( 'Email Settings', 'ud-for-edd' ), 
				__( 'Email', 'ud-for-edd' ), 
				'manage_options', 
				'ud-for-edd-email', 
				array( $this, 'ud_for_edd_setup_email_page' ) 
			);

			add_submenu_page( 
				'ud-for-edd', 
				__( 'Reset Settings', 'ud-for-edd' ), 
				__( 'Reset', 'ud-for-edd' ), 
				'manage_options', 
				'ud-for-edd-reset', 
				array( $this, 'ud_for_edd_setup_reset_page' ) 
			);

		}

		public function initialize_settings_fields_and_sections()
		{

			register_setting( 
				'ud_for_edd_general', 
				'ud_for_edd_general_options' );

			add_settings_section( 
				'ud_for_edd_general_section', 
				'', 
				false, 
				'ud_for_edd_general' 
			);

			add_settings_field( 
				'ud_for_edd_general_page_selector', 
				__( 'Select A dashboard Page', 'ud-for-edd' ), 
				'ud_for_edd_page_selector_callback', 
				'ud_for_edd_general', 
				'ud_for_edd_general_section' 
			);

			// Settings field for logo
	    	add_settings_field( 'ud_for_edd_logo_selector', __( 'Choose your logo', 'ud_for_edd'), 'ud_for_edd_logo_callback', 'ud_for_edd_general', 'ud_for_edd_general_section' );

	    	add_settings_field( 'ud_for_edd_delete_data_uninstall', __( 'Delete settings and other data on uninstall', 'ud-for-edd' ), 'ud_for_edd_delete_data_uninstall_callback', 'ud_for_edd_general', 'ud_for_edd_general_section' );

			//  Redirection sections and fields
			register_setting( 
				'ud_for_edd_redirection', 
				'ud_for_edd_redirection_options' 
			);

			add_settings_section( 
				'ud_for_edd_redirection_section', 
				'', 
				false, 
				'ud_for_edd_redirection' 
			);

			add_settings_field( 
				'ud_for_edd_logout_link_redirect_field', 
				__( 'Logout URL Redirect', 'ud-for-edd' ), 
				'ud_for_edd_logout_link_redirect_field_callback', 
				'ud_for_edd_redirection', 
				'ud_for_edd_redirection_section' 
			);				
			add_settings_field( 
				'ud_for_edd_not_allowed_roles_redirect_field', 
				__( 'Redirect not allowed roles', 'ud-for-edd' ), 
				'ud_for_edd_not_allowed_roles_redirect_field_callback', 
				'ud_for_edd_redirection', 
				'ud_for_edd_redirection_section' 
			);			

			//  Access Control sections and fields
			register_setting( 
				'ud_for_edd_access_control', 
				'ud_for_edd_access_control_options' 
			);

			add_settings_section( 
				'ud_for_edd_access_control_section', 
				'', 
				false, 
				'ud_for_edd_access_control' 
			);

			add_settings_field( 
				'ud_for_edd_access_control_field', 
				__( 'Allowed Roles', 'ud-for-edd' ), 
				'ud_for_edd_access_control_field_callback', 
				'ud_for_edd_access_control', 
				'ud_for_edd_access_control_section' 
			);			

			add_settings_field( 
				'ud_for_edd_access_control_checkbox_field', 
				__( 'Redirect Users', 'ud-for-edd' ), 
				'ud_for_edd_access_control_checkbox_field_callback', 
				'ud_for_edd_access_control', 
				'ud_for_edd_access_control_section' 
			);

			//  Email sections and fields
			register_setting( 
				'ud_for_edd_email', 
				'ud_for_edd_email_options' 
			);

			add_settings_section( 
				'ud_for_edd_email_section', 
				'', 
				false, 
				'ud_for_edd_email' 
			);

			// add_settings_field( 
			// 	'ud_for_edd_email_page_selector', 
			// 	__( 'Select A dashboard Page', 'ud-for-edd' ), 
			// 	array( $this, 'callback_ud_for_edd_email_page_selector'), 
			// 	'ud_for_edd_email', 
			// 	'ud_for_edd_email_section' 
			// );

			//  Access Control sections and fields
			register_setting( 
				'ud_for_edd_reset', 
				'ud_for_edd_reset_options' 
			);

			add_settings_section( 
				'ud_for_edd_reset_section', 
				'', 
				false, 
				'ud_for_edd_reset' 
			);

			add_settings_field( 
				'ud_for_edd_reset_field', 
				__( 'Click to reset', 'ud-for-edd' ), 
				'ud_for_edd_reset_field_callback', 
				'ud_for_edd_reset', 
				'ud_for_edd_reset_section' 
			);			
		}

		public function ud_for_edd_setup_menu_page()
		{
			$this->settings_html_form_header();
			?>
			<div class="ud-for-edd-main">
				<div class="ud-for-edd-left">
					<div class="ud-for-edd-left-inner">
						<form action="options.php" method="POST">
							<?php
							settings_fields( 'ud_for_edd_general' );
					        do_settings_sections( 'ud_for_edd_general' );
					        submit_button('Save Settings');
					        ?>
				    	</form>
				    </div>
			    </div>
			    <div class="ud-for-edd-right">
			    	<div class="ud-for-edd-right-inner">
			    		<?php $this->settings_html_form_sidebar();  ?>
			    	</div>
			    </div>
			</div>
	        <?php
	        $this->settings_html_form_footer();
		}

		public function ud_for_edd_setup_redirection_page()
		{
			$this->settings_html_form_header();
			?>
			<div class="ud-for-edd-main">
				<div class="ud-for-edd-left">
					<div class="ud-for-edd-left-inner">
					<form action="options.php" method="POST">
						<?php
						settings_fields( 'ud_for_edd_redirection' );
				        do_settings_sections( 'ud_for_edd_redirection' );
				        submit_button('Save Settings');
				        ?>
			        </form>
			        </div>
			    </div>
			    <div class="ud-for-edd-right">
			    	<div class="ud-for-edd-right-inner">
			    		<?php $this->settings_html_form_sidebar();  ?>
			    	</div>
			    </div>
			</div> 
	        <?php
		}

		public function ud_for_edd_setup_access_control_page()
		{
			$this->settings_html_form_header();
			?>
			<div class="ud-for-edd-main">
				<div class="ud-for-edd-left">
					<div class="ud-for-edd-left-inner">
					<form action="options.php" method="POST">
						<?php
						settings_fields( 'ud_for_edd_access_control' );
				        do_settings_sections( 'ud_for_edd_access_control' );
				        submit_button('Save Settings');
				        ?>
			        </form>
			        </div>
			    </div>
			    <div class="ud-for-edd-right">
			    	<div class="ud-for-edd-right-inner">
			    		<?php $this->settings_html_form_sidebar();  ?>
			    	</div>
			    </div>
			</div> 
	        <?php
		}

		public function ud_for_edd_setup_email_page()
		{
			$this->settings_html_form_header();
			?>
			<div class="ud-for-edd-main">
				<div class="ud-for-edd-left">
					<div class="ud-for-edd-left-inner">
						<div class="ud-for-edd-coming-soon">
							<span class="dashicons dashicons-admin-appearance"></span>
							<p>Hey there, I am under construction. You will see settings in the coming releases. Thank you.</p>
						</div>
			        </div>
			    </div>
			    <div class="ud-for-edd-right">
			    	<div class="ud-for-edd-right-inner">
			    		<?php $this->settings_html_form_sidebar();  ?>
			    	</div>
			    </div>
			</div> 
	        <?php
		}

		public function ud_for_edd_setup_reset_page()
		{
			$this->settings_html_form_header();
			?>
			<div class="ud-for-edd-main">
				<div class="ud-for-edd-left">
					<div class="ud-for-edd-left-inner">
					<form method="POST" action="options.php">
					<?php
						settings_fields( 'ud_for_edd_reset' );
						do_settings_sections( 'ud_for_edd_reset' );
						echo wp_nonce_field('ud_nonce_reset_action', 'ud_nonce_reset');
					?>
					</form>
			        </div>
			    </div>
			    <div class="ud-for-edd-right">
			    	<div class="ud-for-edd-right-inner">
			    		<?php $this->settings_html_form_sidebar();  ?>
			    	</div>
			    </div>
			</div> 
	        <?php
		}

		public function settings_html_form_header()
		{
			?>
			<div class="ud-for-edd-settings <?php echo sanitize_html_class( isset($_GET['page'] ) ? $_GET['page'] : '' ); ?>">
				<div class="ud-for-edd-settings-header">
					<div class="ud-for-edd-settings-inner">
						<p class="ud-for-edd-logo"><span class="dashicons dashicons-layout"></span><span class="logo-text">User Dashboard EDD</span></p>
						<h2 class="ud-for-edd-page-title">
							<?php 
							if ( isset( $_GET['page'] ) && $_GET['page'] == 'ud-for-edd-redirection' ) {
								_e( 'Redirection Settings', 'ud-for-edd' );
							} else if ( isset( $_GET['page'] ) && $_GET['page'] == 'ud-for-edd-email' ) {
								_e( 'Email Settings', 'ud-for-edd' );
							} else if ( isset( $_GET['page'] ) && $_GET['page'] == 'ud-for-edd-access-control' ) {
								_e( 'Access Control Settings', 'ud-for-edd' );
							} else if ( isset( $_GET['page'] ) && $_GET['page'] == 'ud-for-edd-reset' ) {
								_e( 'Reset Settings', 'ud-for-edd' );
							} else {
								_e( 'General Settings', 'ud-for-edd' );
							}
							?>
						</h2>
						<div class="ud-plugin-info">
							<p class="ud-plugin-version">VERSION <sup><?php echo USER_DASHBOARD_FOR_EDD_VERSION ?></sup></p>
							<img src="<?php echo esc_url ( USER_DASHBOARD_FOR_EDD_PLUGIN_DIR_URI  . 'assets/websiteguider_logo.png' ); ?>">
						</div>
					</div>
				</div>
			<?php
		}		

		public function settings_html_form_footer()
		{
			?>
			</div>
			<?php
		}		

		public function settings_html_form_sidebar()
		{
			?>
			<div class="sidebar-item sidebar-item-1">
				<div class="sidebar-item-inner">
					<div class="ud-sidebar-header">
						<h3>WordPress Resources</h3>
					</div>
					<div class="ud-sidebar-content">
						<ul class="ud-side-content">
							<li class="ud-sc-1">
								<a target="blank" rel="nofollow" href="https://websiteguider.com/blog">WebsiteGuider's Blog</a>
							</li>
						</ul>
					</div>
				</div>
			</div>			
			<div class="sidebar-item sidebar-item-2">
				<div class="sidebar-item-inner">
					<div class="ud-sidebar-header">
						<h3>Tools We Recommend</h3>
					</div>
					<div class="ud-sidebar-content">
						<ul class="ud-side-content">
							<li class="ud-sc ud-sc-1">
								<span>Hosting:</span><a href="" class="button button-primary">Green Geeks</a>
							</li>
							<li class="ud-sc ud-sc-2">
								<span>CDN:</span><a href="#" class="button button-primary">Max CDN</a>
							</li>							
							<li class="ud-sc ud-sc-3">
								<span>Theme:</span><a href="#" class="button button-primary">Genesis Framework</a>
							</li>
							<li class="ud-sc ud-sc-4">
								<span>Security:</span><a href="#" class="button button-primary">Sucuri</a>
							</li>							
							<li class="ud-sc ud-sc-4">
								<span>Writing:</span><a href="#" class="button button-primary">Grammarly</a>
							</li>							
							<li class="ud-sc ud-sc-5">
								<span>SEO:</span><a href="#" class="button button-primary">SEMrush</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

