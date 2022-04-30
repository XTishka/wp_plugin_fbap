<?php

class Publisher_Admin_Post extends Fbap_Admin {

	private string $plugin_name;

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

	public function add_meta_box() {
		add_meta_box(
			'fbap_parser',
			__( 'Step 1: Parse URL', $this->plugin_name ),
			array( $this, 'parser_meta_box_callback' ),
			'fb-publications',
			'advanced',
			'high'
		);
	}

	public function place_meta_box() {
		global $post, $wp_meta_boxes;
		do_meta_boxes( get_current_screen(), 'advanced', $post );
		unset( $wp_meta_boxes['fb-publications']['advanced'] );
	}

	public function remove_meta_box_duplicate() {
		global $post, $wp_meta_boxes;
		unset( $wp_meta_boxes['fb-publications']['advanced'] );
	}

	public function parser_meta_box_callback( $post, $meta ) {
		global $current_screen; ?>

        <div class="output"></div>

        <div class="form-wrap">
            <div>

                <div class="form-field form-required term-parse-url-wrap">
                    <label for="parse_url"><?php echo __( 'Insert page URL for parsing here:', $this->plugin_name ) ?></label>
                    <input name="parse_url" id="parse_url" type="text"
                           value="" size="40" aria-required="true">
                </div>

                <p class="submit">
                    <button type="button" class="button button-primary submit-step-1">Parse data</button>
                </p>
            </div>
        </div>

	<?php }
}