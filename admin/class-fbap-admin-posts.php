<?php

class Publisher_Admin_Post extends Fbap_Admin {

	private $plugin_name;

	public function __construct( $plugin_name, $version ) {
		parent::__construct( $plugin_name, $version );
		$this->plugin_name = $plugin_name;
	}

	public function register_publications_post_type() {
		$labels = [
			'name'               => _x( 'Publications', 'Post Type General Name', $this->plugin_name ),
			'singular_name'      => _x( 'Publication', 'Post Type Singular Name', $this->plugin_name ),
			'menu_name'          => __( 'FB Publications', $this->plugin_name ),
			'parent_item_colon'  => __( 'Parent Publication', $this->plugin_name ),
			'all_items'          => __( 'All Publications', $this->plugin_name ),
			'view_item'          => __( 'View Publication', $this->plugin_name ),
			'add_new_item'       => __( 'Add New Publication', $this->plugin_name ),
			'add_new'            => __( 'Add New Publication', $this->plugin_name ),
			'edit_item'          => __( 'Edit Publication', $this->plugin_name ),
			'update_item'        => __( 'Update Publication', $this->plugin_name ),
			'search_items'       => __( 'Search Publication', $this->plugin_name ),
			'not_found'          => __( 'Not Found', $this->plugin_name ),
			'not_found_in_trash' => __( 'Not found in Trash', $this->plugin_name ),
		];

		$args = [
			'label'               => __( 'fb-publications', $this->plugin_name ),
			'description'         => __( 'FB publications', $this->plugin_name ),
			'labels'              => $labels,
			'supports'            => [
				'title',
				'editor',
				'custom-fields',
			],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 31,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-facebook',
		];

		register_post_type( 'fb-publications', $args );
	}

	public function register_facebook_groups_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Groups', 'taxonomy general name' ),
			'singular_name'              => _x( 'Group', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Groups' ),
			'popular_items'              => __( 'Popular Groups' ),
			'all_items'                  => __( 'All Groups' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Group' ),
			'update_item'                => __( 'Update Group' ),
			'add_new_item'               => __( 'Add New Group' ),
			'new_item_name'              => __( 'New Group Name' ),
			'separate_items_with_commas' => __( 'Separate groups with commas' ),
			'add_or_remove_items'        => __( 'Add or remove group' ),
			'choose_from_most_used'      => __( 'Choose from the most used groups' ),
			'menu_name'                  => __( 'Groups' ),
			'show_in_rest'               => true,
		);

		register_taxonomy( 'groups', 'fb-publications', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'fb-groups' ),
		) );
	}
}