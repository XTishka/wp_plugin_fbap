<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.facebook.com/XTishka
 * @since      2.0.0
 *
 * @package    Fbap
 * @subpackage Fbap/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      2.0.0
 * @package    Fbap
 * @subpackage Fbap/includes
 * @author     Takhir Berdyiev <takhir.berdyiev@gmail.com>
 */
class Fbap_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'fbap',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
