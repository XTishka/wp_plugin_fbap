<?php

class Publisher_Admin_Settings extends Fbap_Admin {

	private $plugin_name;

	public function __construct( $plugin_name, $version ) {
		parent::__construct( $plugin_name, $version );
		$this->plugin_name = $plugin_name;
	}

	public function add_menu() {
		add_submenu_page(
			'edit.php?post_type=fb-publications',
			'FB Publications settings',
			'Settings',
			'manage_options',
			'fb-publications-options',
			[
				$this,
				'form'
			],
			40
		);
	}

	public function register_options() {
		register_setting( 'fbap-settings-group', 'fbap_app_id' );
		register_setting( 'fbap-settings-group', 'fbap_app_secret' );
		register_setting( 'fbap-settings-group', 'fbap_app_token' );
	}

	public function form() { ?>
        <div class="wrap nosubsub">
            <h1 class="wp-heading-inline"><?php echo __('Settings', $this->plugin_name) ?></h1>

            <div id="col-container" class="wp-clearfix">
                <div id="col-left">
                    <div class="col-wrap">
                        <div class="form-wrap">
                            <h2><?php echo __('Facebook application settings', $this->plugin_name) ?></h2>
                            <form method="post" action="options.php" class="validate">
								<?php settings_fields( 'fbap-settings-group' ); ?>
								<?php do_settings_sections( 'fbap-settings-group' ); ?>

                                <div class="form-field form-required term-app-id-wrap">
                                    <label for="fbap_app_id"><?php echo __('Application ID', $this->plugin_name) ?></label>
                                    <input name="fbap_app_id" id="fbap_app_id" type="text"
                                           value="<?php echo esc_attr( get_option( 'fbap_app_id' ) ); ?>"
                                           size="40" aria-required="true">
                                    <p><?php echo __('Enter Facebook application ID', $this->plugin_name) ?></p>
                                </div>

                                <div class="form-field term-app-secret-wrap">
                                    <label for="fbap_app_secret"><?php echo __('Application secret', $this->plugin_name) ?></label>
                                    <input name="fbap_app_secret" id="fbap_app_secret" type="text"
                                           value="<?php echo esc_attr( get_option( 'fbap_app_secret' ) ); ?>" size="40">
                                    <p><?php echo __('Enter Facebook application secret', $this->plugin_name) ?></p>
                                </div>

                                <div class="form-field term-app-token-wrap">
                                    <label for="fbap_app_token"><?php echo __('Application token', $this->plugin_name) ?></label>
                                    <input name="fbap_app_token" id="fbap_app_token" type="text"
                                           value="<?php echo esc_attr( get_option( 'fbap_app_token' ) ); ?>" size="40">
                                    <p><?php echo __('Enter Facebook application token', $this->plugin_name) ?></p>
                                </div>

                                <p class="submit">
	                                <?php submit_button(); ?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div><!-- /col-left -->
            </div><!-- /col-container -->
        </div>
	<?php }
}
