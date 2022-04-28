<?php

class Publisher_Admin_Dashboard extends Fbap_Admin {

	private $plugin_name;

	public function __construct( $plugin_name, $version ) {
		parent::__construct( $plugin_name, $version );
		$this->plugin_name = $plugin_name;
	}

    public function add_menu() {
	    add_submenu_page(
		    'edit.php?post_type=fb-publications',
		    'Dashboard',
		    'Dashboard',
		    'manage_options',
		    'fb-publications-dashboard',
		    [
			    $this,
			    'dashboard'
		    ],
		    0
	    );
    }

	public function dashboard() {
		echo '<h1>';
		echo __( 'Dashboard', $this->plugin_name );
		echo '</h1>';
	}
}
