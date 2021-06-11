<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */


/**
 * The core plugin class.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class FBAP {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      FBAP_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'fbap';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fbap-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-fbap-i18n.php';

		/**
         * Composer
         */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/vendor/autoload.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fbap-admin.php';

		/**
		 * File upload
		 */
		require_once( ABSPATH . 'wp-admin/includes/file.php' );

		/**
		 * Admin menu and pages
		 */
		// Controllers
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/controllers/AdController.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/controllers/PartnerController.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/controllers/GroupController.php';

		// Repositories
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/repositories/PartnerRepository.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/repositories/GroupRepository.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/repositories/AdRepository.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/repositories/ScheduleRepository.php';

		// Services
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/services/AdService.php';

		// Validators
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/validators/PartnerValidator.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/validators/GroupValidator.php';

		// Tab pages
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/layouts/main.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/layouts/tabs.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/ads/index.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/ads/create.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/ads/update.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/partners/index.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/partners/create.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/partners/update.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/partners/delete.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/groups/index.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/groups/create.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/groups/update.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/groups/delete.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-fbap-public.php';

		$this->loader = new FBAP_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Plugin_Name_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new FBAP_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'init', $plugin_admin, 'create_post_type' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_fbap_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_fbap_settings' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new FBAP_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    FBAP_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}


