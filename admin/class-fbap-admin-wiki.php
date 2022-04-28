<?php

class Publisher_Admin_Wiki extends Fbap_Admin {

	private $plugin_name;

	public function __construct( $plugin_name, $version ) {
		parent::__construct( $plugin_name, $version );
		$this->plugin_name = $plugin_name;
	}

    public function add_menu() {
	    add_submenu_page(
		    'edit.php?post_type=fb-publications',
		    'FB Publications Wiki',
		    'Wiki',
		    'manage_options',
		    'fb-publications-wiki',
		    [
			    $this,
			    'wiki'
		    ],
		    50
	    );
    }

	public function wiki() {
		echo '<h1>';
		echo __( 'Wiki', $this->plugin_name );
		echo '</h1>';
	}
}
