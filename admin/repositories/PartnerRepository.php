<?php

namespace fbap\admin\repositories;

class PartnerRepository {

	private $db_table;

	private $wpdb;

	public function __construct() {
		global $wpdb;
		global $table_prefix, $wpdb;

		$this->wpdb     = $wpdb;
		$this->db_table = $table_prefix . 'fbap_partners';

		add_action( 'admin_action_create_partner', array( $this, 'insertPartner' ) );
	}

	public function getAllPartners() {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL ORDER BY `id` DESC " );

		return $result;
	}

	public function getPartnerByID( $id ) {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL AND `id` = $id" );

		return $result;
	}

	public function insertPartner( $post ) {
		$this->wpdb->insert(
			$this->db_table,
			[
				'display_name' => $post['display_name'],
				'url'          => $post['url'],
				'api'          => $post['api'],
				'partner_id'   => $post['partner_id'],
				'program_id'   => $post['program_id'],
				'link'         => 'custom_link',
				'created_at'   => current_time( 'mysql' ),
				'updated_at'   => current_time( 'mysql' ),
				'deleted_at'   => null,
			]
		);
	}

	public function updatePartner( $id, $post ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'display_name' => $post['display_name'],
				'url'          => $post['url'],
				'api'          => $post['api'],
				'partner_id'   => $post['partner_id'],
				'program_id'   => $post['program_id'],
				'link'         => 'custom_link',
				'updated_at'   => current_time( 'mysql' ),
			],
			[ 'id' => $id ]
		);
	}

	public function trashPartner( $id ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'deleted_at' => current_time( 'mysql' )
			],
			[ 'id' => $id ]
		);
	}

	public function deletePartner( $id ) {
		$this->wpdb->delete( $this->db_table, [ 'id' => $id ] );
	}
}