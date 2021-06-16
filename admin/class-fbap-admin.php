<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    FBAP
 * @subpackage FBAP/admin
 * @author     Takhir Berdyiev <takhir.berdyiev@gmail.com>
 */
class FBAP_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/fbap-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/fbap-admin.js', array( 'jquery' ), $this->version, true );
	}

	public function create_post_type() {
		$labels = [
			'name'               => _x( 'Ads', 'Post Type General Name', 'fbap' ),
			'singular_name'      => _x( 'Ad', 'Post Type Singular Name', 'fbap' ),
			'menu_name'          => __( 'FB Ads', 'fbap' ),
			'parent_item_colon'  => __( 'Parent Ad', 'fbap' ),
			'all_items'          => __( 'All Ads', 'fbap' ),
			'view_item'          => __( 'View Ad', 'fbap' ),
			'add_new_item'       => __( 'Add New Ad', 'fbap' ),
			'add_new'            => __( 'Add New', 'fbap' ),
			'edit_item'          => __( 'Edit Ad', 'fbap' ),
			'update_item'        => __( 'Update Ad', 'fbap' ),
			'search_items'       => __( 'Search Ad', 'fbap' ),
			'not_found'          => __( 'Not Found', 'fbap' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'fbap' ),
		];

		// Set other options for Custom Post Type
		$args = [
			'label'               => __( 'ads', 'fbap' ),
			'description'         => __( 'Affiliate posts', 'fbap' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor
			'supports'            => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
			],
			// You can associate this CPT with a taxonomy or custom taxonomy.
//			'taxonomies'          => ['category'],
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 25,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,

		];

		// Registering your Custom Post Type
		register_post_type( 'affiliate-ads', $args );
	}

	public function register_fbap_settings() {
		register_setting( 'fbap-settings-group', 'parse_link' );
	}

	public function register_fbap_menu() {
		add_menu_page(
			'Affiliate ads',
			'FB Publisher',
			'manage_options',
			'fbap',
			'fbap_routing',
			'dashicons-facebook',
			30
		);
	}
}
