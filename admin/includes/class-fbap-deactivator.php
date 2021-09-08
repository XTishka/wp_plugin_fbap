<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		drop_plugin_tables('fbap_ads');
		drop_plugin_tables('fbap_partners');
		drop_plugin_tables('fbap_groups');
	}
}

function drop_plugin_tables($table) {
	global $wpdb;
	global $table_prefix, $wpdb;
	echo $table_prefix.$table;
	$wpdb->query( "DROP TABLE IF EXISTS $table_prefix.$table" );
}

