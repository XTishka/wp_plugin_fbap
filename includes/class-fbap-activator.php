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

	public static function activate() {
		init_db_partners();
		init_db_groups();
		init_db_ads();
	}
}

function init_db_partners() {
	global $table_prefix, $wpdb;
	$partnersTable = $table_prefix . 'fbap_partners';

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
		  logo_url tinytext NOT NULL,
		  created_at datetime NOT NULL,
		  updated_at datetime NOT NULL,
		  deleted_at datetime NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
	}

}

function init_db_groups() {
	global $table_prefix, $wpdb;
	$groupsTable = $table_prefix . 'fbap_groups';

	if ( $wpdb->get_var( "show tables like '$groupsTable'" ) != $groupsTable ) {

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $groupsTable (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  display_name varchar (255) NOT NULL,
		  url tinytext NOT NULL,
		  api varchar (255) NOT NULL,
		  created_at datetime NOT NULL,
		  updated_at datetime NOT NULL,
		  deleted_at datetime NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
	}

}

function init_db_ads() {
	global $table_prefix, $wpdb;
	$adsTable      = $table_prefix . 'fbap_ads';

	if ( $wpdb->get_var( "show tables like '$adsTable'" ) != $adsTable ) {

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $adsTable (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  title varchar (255) NOT NULL,
		  description text NOT NULL,
		  price varchar(255) NOT NULL,
		  partner_id mediumint(9) NOT NULL,
		  partner_name varchar (255) NOT NULL,
		  affiliate_link varchar (255) NOT NULL,
		  images json NOT NULL,
		  post_id int(9) NOT NULL,
		  post_url varchar (255) NOT NULL,
		  clicks int(9) NOT NULL,
		  
		  created_at datetime NOT NULL,
		  updated_at datetime NOT NULL,
		  deleted_at datetime NULL,

		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
	}
}

