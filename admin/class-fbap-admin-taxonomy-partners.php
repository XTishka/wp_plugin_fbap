<?php

class Fbap_Admin_Taxonomy_Partners extends Fbap_Admin {

	private $plugin_name;

	public function __construct( $plugin_name, $version ) {
		parent::__construct( $plugin_name, $version );
		$this->plugin_name = $plugin_name;
	}

	public function register_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Partners', 'taxonomy general name' ),
			'singular_name'              => _x( 'Partner', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Partners' ),
			'popular_items'              => __( 'Popular Partners' ),
			'all_items'                  => __( 'All Partners' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Partner' ),
			'update_item'                => __( 'Update Partner' ),
			'add_new_item'               => __( 'Add New Partner' ),
			'new_item_name'              => __( 'New Partner Name' ),
			'separate_items_with_commas' => __( 'Separate patners with commas' ),
			'add_or_remove_items'        => __( 'Add or remove partner' ),
			'choose_from_most_used'      => __( 'Choose from the most used partners' ),
			'menu_name'                  => __( 'Partners' ),
			'show_in_rest'               => true,
		);

		register_taxonomy( 'partners', 'fb-publications', array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'fb-partners' ),
		) );
	}

	public function populate_custom_columns( $string, $columns, $term_id ) {
		switch ( $columns ) {
			case 'api_info':
				echo get_term_meta( $term_id, 'api_info', true );
				break;
			case 'partner_id':
				echo get_term_meta( $term_id, 'partner_id', true );
				break;
			case 'program_id':
				echo get_term_meta( $term_id, 'program_id', true );
				break;
		}
	}

	public function manage_taxonomy_columns( $columns ) {
		global $current_screen;

		if ( $current_screen->id == 'edit-partners' ) {
			$columns = array(
				'cb'         => $columns['cb'],
				'name'       => __( 'Name', $this->plugin_name ),
				'api_info'   => __( 'API Info', $this->plugin_name ),
				'partner_id' => __( 'Partner ID', $this->plugin_name ),
				'program_id' => __( 'Program ID', $this->plugin_name ),
				'posts'      => $columns['posts'],
			);
		}

		return $columns;
	}

	public function add_form_fields() { ?>
        <div class="form-field term-api-wrap">
            <label for="api_info">API Info</label>
            <input name="api_info" id="api_info" type="text" value="" size="40">
            <p>Enter API info code here.</p>
        </div>

        <div class="form-field term-api-wrap">
            <label for="partner_id">Partner ID</label>
            <input name="partner_id" id="partner_id" type="text" value="" size="40">
            <p>Enter Partner ID here.</p>
        </div>

        <div class="form-field term-api-wrap">
            <label for="program_id">Program ID</label>
            <input name="program_id" id="program_id" type="text" value="" size="40">
            <p>Enter Program ID here.</p>
        </div>
	<?php }

	public function edit_form_fields( $term, $taxonomy ) {

		$apiInfo   = get_term_meta( $term->term_id, 'api_info', true );
		$partnerID = get_term_meta( $term->term_id, 'partner_id', true );
		$programID = get_term_meta( $term->term_id, 'program_id', true );
		?>
        <tr class="form-field form-required term-api_info-wrap">
            <th scope="row"><label for="api_info">API Info</label></th>
            <td>
                <input name="api_info" id="api_info" type="text" value="<?php _e( $apiInfo ); ?>" size="40"
                       aria-required="true">
                <p class="description">Enter API info code here.</p>
            </td>
        </tr>

        <tr class="form-field form-required term-partner_id-wrap">
            <th scope="row"><label for="partner_id">Partner ID</label></th>
            <td>
                <input name="partner_id" id="partner_id" type="text" value="<?php _e( $partnerID ); ?>" size="40"
                       aria-required="true">
                <p class="description">Enter Partner ID here.</p>
            </td>
        </tr>

        <tr class="form-field form-required term-program_id-wrap">
            <th scope="row"><label for="program_id">Program ID</label></th>
            <td>
                <input name="program_id" id="program_id" type="text" value="<?php _e( $programID ); ?>" size="40"
                       aria-required="true">
                <p class="description">Enter Program ID here.</p>
            </td>
        </tr>
	<?php }

	public function save_custom_fields( $term_id ) {
		update_term_meta( $term_id, 'api_info', sanitize_text_field( $_POST['api_info'] ) );
		update_term_meta( $term_id, 'partner_id', sanitize_text_field( $_POST['partner_id'] ) );
		update_term_meta( $term_id, 'program_id', sanitize_text_field( $_POST['program_id'] ) );
	}

	public function remove_default_fields() {
		global $current_screen;

		if ( $current_screen->id == 'edit-partners' ) { ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    $('#tag-description').parent().remove();
                    $('#tag-slug').parent().remove();
                    $('#term-slug-wrap').parent().remove();
                    $('#term-description-wrap').parent().remove();
                });
            </script>
		<?php }
	}
}