<?php

namespace fbap\admin\repositories;

class AdRepository {

	private $db_table;

	private $wpdb;

	public $partnersLogo;

	public function __construct() {
		global $wpdb;
		global $table_prefix, $wpdb;

		$this->wpdb     = $wpdb;
		$this->db_table = $table_prefix . 'fbap_ads';

		add_action( 'admin_action_create_group', [ $this, 'insertGroup' ] );
	}

	public function getAllAds() {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL ORDER BY `id` DESC " );

		return $result;
	}

	public function getAdByID( $id ) {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL AND `id` = $id" );

		return $result[0];
	}

	public function getAdByPostId( $post_id ) {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `post_id` = $post_id" );

		return $result[0];
	}

	public function getLastAd() {
		$result = $this->wpdb->get_results( "SELECT * FROM $this->db_table WHERE `deleted_at` IS NULL ORDER BY `id` DESC LIMIT 1" );

		return $result[0];
	}

	public function insertAd( $post ) {
		return $this->wpdb->insert(
			$this->db_table,
			[
				'title'                 => $post['fbap_post_title'],
				'description'           => $post['fbap_post_description'],
				'price'                 => $post['fbap_post_price'],
				'partner_id'            => $post['affiliate_partner_id'],
				'partner_name'          => $post['affiliate_partner_name'],
				'affiliate_link'        => $post['affiliate_link'],
				'partners_special_link' => $post['partners_special_link'],
				'images'                => json_encode( $post['images'] ),
				'post_id'               => $post['post_id'],
				'post_url'              => $post['post_url'],
				'clicks'                => 0,
				'created_at'            => current_time( 'mysql' ),
				'updated_at'            => current_time( 'mysql' ),
				'deleted_at'            => null,
			]
		);
	}

	public function updateAd( $id, $post ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'title'       => $post['fbap_post_title'],
				'description' => $post['fbap_post_description'],
				'price'       => $post['fbap_post_price'],
				'updated_at'  => current_time( 'mysql' ),
			],
			[ 'id' => $id ]
		);
	}

	public function updateAdClicks( $id, $clicks ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'clicks'       => $clicks,
			],
			[ 'id' => $id ]
		);
	}

	public function trashAd( $id ) {
		$this->wpdb->update(
			$this->db_table,
			[
				'deleted_at' => current_time( 'mysql' )
			],
			[ 'id' => $id ]
		);
	}

	public function deleteAd( $id ) {
		$this->wpdb->delete( $this->db_table, [ 'id' => $id ] );
	}
}