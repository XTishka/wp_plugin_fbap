<?php

namespace fbap\admin\repositories;

class GroupRepository {

	private $db_table;

	private $wpdb;

	public function __construct() {
		global $wpdb;
		global $table_prefix, $wpdb;

		$this->wpdb     = $wpdb;
		$this->db_table = $table_prefix . 'fbap_groups';

		add_action( 'admin_action_create_group', [ $this, 'insertGroup' ] );
	}

	public function getAllGroups() {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL ORDER BY `id` DESC " );

		return $result;
	}

	public function getGroupByID( $id ) {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL AND `id` = $id" );

		return $result;
	}

	public function insertGroup( $post ) {
		$this->wpdb->insert(
			$this->db_table,
			[
				'display_name' => $post['display_name'],
				'url'          => $post['url'],
				'api'          => $post['api'],
				'created_at'   => current_time( 'mysql' ),
				'updated_at'   => current_time( 'mysql' ),
				'deleted_at'   => null,
			]
		);
	}

	public function updateGroup( $id, $post ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'display_name' => $post['display_name'],
				'url'          => $post['url'],
				'api'          => $post['api'],
				'updated_at'   => current_time( 'mysql' ),
			],
			[ 'id' => $id ]
		);
	}

	public function trashGroup( $id ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'deleted_at' => current_time( 'mysql' )
			],
			[ 'id' => $id ]
		);
	}

	public function deleteGroup( $id ) {
		$this->wpdb->delete( $this->db_table, [ 'id' => $id ] );
	}
}