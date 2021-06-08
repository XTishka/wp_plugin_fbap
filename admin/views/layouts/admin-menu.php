<?php

add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu(){
	add_menu_page(
		'Affiliate ads',
		'FB Publisher',
		'manage_options',
		'fbap',
		'fbap_routing',
		'dashicons-facebook',
		30
	);
	add_action( 'admin_init', 'register_fbap_settings' );
}

add_action('admin_menu', 'register_my_custom_submenu_page');



function register_my_custom_submenu_page() {
	add_submenu_page(
		'fbap-crawler',
		'Дополнительная страница инструментов',
		'Reports',
		'manage_options',
		'my-custom-submenu-page',
		'my_custom_submenu_page_callback'
	);
}

function my_custom_submenu_page_callback() {
	// контент страницы
	echo '<div class="wrap">';
	echo '<h2>'. get_admin_page_title() .'</h2>';
	echo '</div>';

}

function register_fbap_settings() {
	register_setting( 'fbap-settings-group', 'parse_link' );
}