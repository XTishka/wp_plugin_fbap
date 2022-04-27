<?php

class Fbap_Admin_Taxonomy_Groups extends Fbap_Admin {

	private $plugin_name;

	public function __construct( $plugin_name, $version ) {
		parent::__construct( $plugin_name, $version );
		$this->plugin_name = $plugin_name;
	}

	public function register_taxonomy() {
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

	public function populate_custom_columns( $string, $columns, $term_id ) {
		switch ( $columns ) {
			case 'members_qty':
				echo get_term_meta( $term_id, 'members_qty', true );
				break;
			case 'group_id':
				echo get_term_meta( $term_id, 'group_id', true );
				break;
		}
	}

	public function manage_taxonomy_columns( $columns ) {
		global $current_screen;

		if ( $current_screen->id == 'edit-groups' ) {
			$columns = array(
				'cb'          => $columns['cb'],
				'name'        => __( 'Group Name', $this->plugin_name ),
				'members_qty' => __( 'Members quantity', $this->plugin_name ),
				'group_id'    => __( 'Group ID', $this->plugin_name ),
				'posts'       => $columns['posts'],
			);
		}

		return $columns;
	}

	public function add_form_fields() { ?>
        <div class="form-field term-members-qty-wrap">
            <label for="members_qty">Members Qty</label>
            <input name="members_qty" id="members_qty" type="text" value="" size="40">
            <p>Enter group members quantity.</p>
        </div>

        <div class="form-field term-group-id-wrap">
            <label for="group_id">Facebook Group ID</label>
            <input name="group_id" id="group_id" type="text" value="" size="40">
            <p>Enter Facebook Group ID here.</p>
        </div>
	<?php }

	public function edit_form_fields( $term, $taxonomy ) {

		$apiInfo   = get_term_meta( $term->term_id, 'members_qty', true );
		$partnerID = get_term_meta( $term->term_id, 'group_id', true );
		?>
        <tr class="form-field form-required term-members_qty_info-wrap">
            <th scope="row"><label for="members_qty">Members Qty</label></th>
            <td>
                <input name="members_qty" id="members_qty" type="text" value="<?php _e( $apiInfo ); ?>" size="40"
                       aria-required="true">
                <p class="description">Enter API info code here.</p>
            </td>
        </tr>

        <tr class="form-field form-required term-group_id-wrap">
            <th scope="row"><label for="group_id">Facebook Group ID</label></th>
            <td>
                <input name="group_id" id="group_id" type="text" value="<?php _e( $partnerID ); ?>" size="40"
                       aria-required="true">
                <p class="description">Enter Partner ID here.</p>
            </td>
        </tr>
	<?php }

	public function save_custom_fields( $term_id ) {
		update_term_meta( $term_id, 'members_qty', sanitize_text_field( $_POST['members_qty'] ) );
		update_term_meta( $term_id, 'group_id', sanitize_text_field( $_POST['group_id'] ) );
	}

	public function remove_default_fields() {
		global $current_screen;

		if ( $current_screen->id == 'edit-groups' ) { ?>
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