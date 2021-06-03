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








add_action('admin_menu', 'my_plugin_create_menu');

function my_plugin_create_menu() {

	//create new top-level menu
	add_menu_page( 'My Plugin',
		'myCust Form',
		'administrator',
		'insert-my-plugin_bro',
		'my_plugin_settings_page',
		'dashicons-translation',
		'60'
	);

	//call register settings function
	add_action( 'admin_init', 'register_my_plugin_settings' );
}


function register_my_plugin_settings() {
	//register our settings
	register_setting( 'my-plugin-settings-group', 'display_name' );
}

function my_plugin_settings_page() {
?>
<div class="wrap">
	<h1>My Plugin Settings</h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'my-plugin-settings-group' ); ?>
		<?php do_settings_sections( 'my-plugin-settings-group' ); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Enter a name to display</th>
				<td><input type="text" name="display_name" value="<?php echo esc_attr( get_option('display_name') ); ?>" /></td>
			</tr>
		</table>

		<?php submit_button(); ?>

	</form>
</div>

<?php }

// ---------------------

//Add admin page to the menu
add_action( 'admin_menu', 'add_admin_page');
function add_admin_page() {
	// add top level menu page
	add_menu_page(
		'My Plugin Settings', //Page Title
		'My Plugin', //Menu Title
		'manage_options', //Capability
		'my-plugin', //Page slug
		'admin_page_html' //Callback to print html
	);
}

//Admin page html callback
//Print out html for admin page
function admin_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	//Get the active tab from the $_GET param
	$default_tab = null;
	$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

	?>
    <!-- Our admin page content should all be inside .wrap -->
    <div class="wrap">
        <!-- Print the page title -->
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <!-- Here are our tabs -->
        <nav class="nav-tab-wrapper">
            <a href="?page=my-plugin" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Default Tab</a>
            <a href="?page=my-plugin&tab=settings" class="nav-tab <?php if($tab==='settings'):?>nav-tab-active<?php endif; ?>">Settings</a>
            <a href="?page=my-plugin&tab=tools" class="nav-tab <?php if($tab==='tools'):?>nav-tab-active<?php endif; ?>">Tools</a>
        </nav>

        <div class="tab-content">
			<?php switch($tab) :
				case 'settings':
					echo 'Settings'; //Put your HTML here
					break;
				case 'tools':
					echo 'Tools';
					break;
				default:
					echo 'Default tab';
					break;
			endswitch; ?>
        </div>
    </div>
	<?php
}