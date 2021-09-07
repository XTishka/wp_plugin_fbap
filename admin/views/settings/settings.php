<?php

function fbpa_settings() { ?>
	<div class="wrap">
		<h1>Application Settings</h1>

		<?php fbap_tabs_menu('settings') ?>

		<div class="clear"></div>

		<form method="post" action="options.php">
			<?php settings_fields( 'fbap-settings-group' ); ?>
			<?php do_settings_sections( 'fbap-settings-group' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						Enter application ID
					</th>
					<td>
						<input class="w-50p" type="text" name="fbap_app_id" value="<?php echo esc_attr( get_option('fbap_app_id') ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Enter application secret
					</th>
					<td>
						<input class="w-50p" type="text" name="fbap_app_secret" value="<?php echo esc_attr( get_option('fbap_app_secret') ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						Enter application token
					</th>
					<td>
						<input class="w-50p" type="text" name="fbap_app_token" value="<?php echo esc_attr( get_option('fbap_app_token') ); ?>" />
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>

		</form>
	</div>
<?php }