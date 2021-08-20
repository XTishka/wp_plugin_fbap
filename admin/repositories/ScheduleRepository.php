<?php

namespace fbap\admin\repositories;

class ScheduleRepository {

	private $db_table;

	private $wpdb;

	public function __construct() {
		global $wpdb;
		global $table_prefix, $wpdb;

		$this->wpdb     = $wpdb;
		$this->db_table = $table_prefix . 'fbap_fb_schedule';

		add_action( 'admin_action_create_schedule', array( $this, 'insertSchedule' ) );
	}

	public function getAllSchedules() {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL ORDER BY `id` DESC " );

		return $result;
	}

	public function getAllAdsSchedulesWithTrashed($id) {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `ad_id` = $id " );

		return $result;
	}

	public function getScheduleByID( $id ) {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL AND `id` = $id" );

		return $result[0];
	}

	public function getSchedulesByAdID( $id ) {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL AND `ad_id` = $id" );

		return $result;
	}

	public function getLastSchedule() {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL ORDER BY `id` DESC LIMIT 1" );

		return $result[0];
	}

	public function getLastScheduleId() {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL ORDER BY `id` DESC LIMIT 1" );

		return $result[0]->id;
	}

	public function getLastSchedulePublicationDate() {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL ORDER BY `id` DESC LIMIT 1" );

		return $result[0]->publication_time;
	}

	public function getFilteredSchedulesByAdId( $id, $filter ) {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL AND `ad_id` = $id AND `status` = '$filter'" );

		return $result;
	}

	public function getTrashedSchedulesByAdId( $id, $filter ) {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NOT NULL AND `ad_id` = $id" );

		return $result;
	}

	public function insertSchedule( $post ) {
		$this->wpdb->insert(
			$this->db_table,
			[
				'ad_id'            => $post['ad_id'],
				'group_id'         => $post['group_id'],
				'publication_time' => $post['publication_time'],
				'status'           => 'waiting',
				'clicks'           => 0,
				'created_at'       => current_time( 'mysql' ),
				'updated_at'       => current_time( 'mysql' ),
				'deleted_at'       => null,
			]
		);
	}

	public function updateSchedule( $post ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'group_id'         => $post['group_id'],
				'publication_time' => $post['publication_time'],
				'updated_at'   => current_time( 'mysql' ),
			],
			[ 'id' => $post['publication_id'] ]
		);
	}

	public function updateScheduleClicks( $id, $clicks ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'clicks'         => $clicks,
			],
			[ 'id' => $id ]
		);
	}

	public function trashSchedule( $id ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'status' => 'trashed',
				'deleted_at' => current_time( 'mysql' )
			],
			[ 'id' => $id ]
		);
	}

	public function deleteSchedule( $id ) {
		$this->wpdb->delete( $this->db_table, [ 'id' => $id ] );
	}

	public function updateScheduleStatus( $id, $status ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'status'         => $status,
				'updated_at'   => current_time( 'mysql' ),
			],
			[ 'id' => $id ]
		);
	}
}