<?php


add_action( 'admin_action_create_partner', 'createPartnerFormHandler' );
function createPartnerFormHandler($post) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'fbap_partners';
	$wpdb->insert(
		$table_name,
		[
			'display_name' => $post['display_name'],
			'url' => $post['url'],
			'api' => $post['api'],
			'partner_id' => $post['partner_id'],
			'program_id' => $post['program_id'],
			'link' => 'custom_link',
			'created_at' => current_time( 'mysql' ),
			'updated_at' => current_time( 'mysql' ),
			'soft_delete' => 0,
		]
	);
}


//add_action ('wp_loaded', 'partnerCreateRedirect');
//function partnerCreateRedirect() {
//	if ( $_POST['create_partner'] and $_POST['validated'] ) {
//		$redirect = 'http://example.com/redirect-example-url.html';
//		wp_redirect($redirect);
//		exit;
//	}
//}