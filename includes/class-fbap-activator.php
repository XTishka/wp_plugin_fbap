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
		init_db_fb_schedule();
		insertDefaultPartners();
		insertDefaultGroups();
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
		  partners_special_link varchar (255) NOT NULL,
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

function init_db_fb_schedule() {
	global $table_prefix, $wpdb;
	$adsTable      = $table_prefix . 'fbap_fb_schedule';

	if ( $wpdb->get_var( "show tables like '$adsTable'" ) != $adsTable ) {

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $adsTable (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  ad_id int(9) NOT NULL,
		  group_id int(9) NOT NULL,
		  publication_time datetime NOT NULL,
		  clicks int(9) NOT NULL,
		  status varchar(255) NOT NULL,
		  created_at datetime NOT NULL,
		  updated_at datetime NOT NULL,
		  deleted_at datetime NULL,

		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
	}
}

function insertDefaultPartners() {
	global $table_prefix, $wpdb;
	$partnersTable = $table_prefix . 'fbap_partners';

	$wpdb->insert(
		$partnersTable,
		[
			'display_name' => 'Tradetracker.net',
			'url'          => 'https://tradetracker.com',
			'api'          => 'ieekf##1131239ikdkekkd',
			'partner_id'   => '353513',
			'program_id'   => '17613',
			'link'         => 'https://tc.tradetracker.net/?c=[program_id]&m=12&a=[partner_id]&r=Ferieboligsiden&u=[relative_uri]',
			'logo_url'     => 'https://www.tradetracker.com/assets/tt-circles.png',
			'created_at'   => current_time( 'mysql' ),
			'updated_at'   => current_time( 'mysql' ),
			'deleted_at'   => null,
		],
	);

	$wpdb->insert(
		$partnersTable,
		[
			'display_name' => 'Luksushuse.dk',
			'url'          => 'https://www.luksushuse.dk/',
			'api'          => 'ieekf##1131239ikdkekkd',
			'link'         => 'utm_source=ferieboligsiden&utm_medium=affili ate&utm_campaign=partner',
			'logo_url'     => 'https://www.luksushuse.dk/sites/default/themes/luksushuse/logo-da.png',
			'created_at'   => current_time( 'mysql' ),
			'updated_at'   => current_time( 'mysql' ),
			'deleted_at'   => null,
		]
	);
}

function insertDefaultGroups() {
	global $table_prefix, $wpdb;
	$groupsTable = $table_prefix . 'fbap_groups';

	$wpdb->insert(
		$groupsTable,
		[
			'display_name' => 'Poolhuse/Sommerhusudlejning Danmark',
			'url'          => 'https://www.facebook.com/groups/228972564238976',
			'api'          => '',
			'created_at'   => current_time( 'mysql' ),
			'updated_at'   => current_time( 'mysql' ),
			'deleted_at'   => null,
		]
	);

	$wpdb->insert(
		$groupsTable,
		[
			'display_name' => 'Sommerhusudlejning',
			'url'          => 'https://www.facebook.com/groups/106307152771323',
			'api'          => '',
			'created_at'   => current_time( 'mysql' ),
			'updated_at'   => current_time( 'mysql' ),
			'deleted_at'   => null,
		]
	);
}

