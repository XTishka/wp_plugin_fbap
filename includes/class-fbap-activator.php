<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class FBAP_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		init_db_partners();
	}
}

// Initialize DB Tables
function init_db_partners() {

	// WP Globals
	global $table_prefix, $wpdb;

	// Customer Table
	$partnersTable = $table_prefix . 'fbap_partners';

	// Create Customer Table if not exist
	if ( $wpdb->get_var( "show tables like '$partnersTable'" ) != $partnersTable ) {

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $partnersTable (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  display_name varchar (255) NOT NULL,
		  url tinytext NOT NULL,
		  api varchar (255) NOT NULL,
		  partner_id varchar (255) NOT NULL,
		  program_id varchar (255) NOT NULL,
		  link tinytext NOT NULL,
		  created_at datetime NOT NULL,
		  updated_at datetime NOT NULL,
		  deleted_at datetime NULL,
		  soft_delete tinyint(1) DEFAULT 0 NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
	}

}
