<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/XTishka/wp_plugin_fbap
 * @since             1.0.0
 * @package           FBAP
 *
 * @wordpress-plugin
 * Plugin Name:       Facebook affiliate links publisher
 * Plugin URI:        https://github.com/XTishka/wp_plugin_fbap
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Takhir Berdyiev
 * Author URI:        https://xtf.com.ua/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fbap
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_fbap() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fbap-activator.php';
	Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_fbap() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fbap-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fbap' );
register_deactivation_hook( __FILE__, 'deactivate_fbap' );

/**
 * The core plugin class that is used to define internationalization,
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fbap.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fbap() {

	$plugin = new FBAP();
	$plugin->run();

}
run_fbap();


add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu(){
    add_menu_page(
        'Crowler',
        'FB publisher',
        'manage_options',
        'fbap-crawler',
        'crowler_init'
    );
}


function crowler_init(){
    echo "<h1>Crowler init!</h1>";
}

add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
    add_submenu_page(
        'fbap-crawler',
        'Дополнительная страница инструментов',
        'Название инструмента',
        'manage_options',
        'my-custom-submenu-page',
        'my_custom_submenu_page_callback'
    );
}

function my_custom_submenu_page_callback() {
    // контент страницы
    echo '<div class="wrap">';
    echo '<h2>'. get_admin_page_title() .'</h2>';
    echo '</div>';

}