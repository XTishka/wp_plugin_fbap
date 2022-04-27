<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.facebook.com/XTishka
 * @since      2.0.0
 *
 * @package    Fbap
 * @subpackage Fbap/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.0.0
 * @package    Fbap
 * @subpackage Fbap/includes
 * @author     Takhir Berdyiev <takhir.berdyiev@gmail.com>
 */
class Fbap {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      Fbap_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    2.0.0
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
	 * @since    2.0.0
	 */
	public function __construct() {
		if ( defined( 'FBAP_VERSION' ) ) {
			$this->version = FBAP_VERSION;
		} else {
			$this->version = '2.0.0';
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
	 * - Fbap_Loader. Orchestrates the hooks of the plugin.
	 * - Fbap_i18n. Defines internationalization functionality.
	 * - Fbap_Admin. Defines all hooks for the admin area.
	 * - Fbap_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    2.0.0
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
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fbap-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fbap-admin-posts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fbap-admin-taxonomy-partners.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-fbap-admin-taxonomy-groups.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-fbap-public.php';

		$this->loader = new Fbap_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Fbap_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Fbap_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Fbap_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Register FB Publications post type
		$publication_posts = new Publisher_Admin_Post( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action('init', $publication_posts, 'register_publications_post_type');
		$this->loader->add_action( 'admin_menu', $publication_posts, 'publications_admin_menu' );

		// Register and setup Partners taxonomy
		$taxonomy_partners = new Fbap_Admin_Taxonomy_Partners( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action('init', $taxonomy_partners, 'register_taxonomy');
		$this->loader->add_action( 'partners_add_form_fields', $taxonomy_partners, 'add_form_fields' );
		$this->loader->add_action( 'partners_edit_form_fields', $taxonomy_partners, 'edit_form_fields', 10, 2 );
		$this->loader->add_action( 'created_partners', $taxonomy_partners, 'save_custom_fields' );
		$this->loader->add_action( 'edited_partners', $taxonomy_partners, 'save_custom_fields' );
		$this->loader->add_action( 'manage_partners_custom_column', $taxonomy_partners, 'populate_custom_columns', 10, 3 );
		$this->loader->add_action( 'admin_footer', $taxonomy_partners, 'remove_default_fields' );
		$this->loader->add_filter( 'manage_edit-partners_columns', $taxonomy_partners, 'manage_taxonomy_columns' );

		// Register and setup Groups taxonomy
		$taxonomy_groups = new Fbap_Admin_Taxonomy_Groups( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action('init', $taxonomy_groups, 'register_taxonomy');
		$this->loader->add_action( 'groups_add_form_fields', $taxonomy_groups, 'add_form_fields' );
		$this->loader->add_action( 'groups_edit_form_fields', $taxonomy_groups, 'edit_form_fields', 10, 2 );
		$this->loader->add_action( 'created_groups', $taxonomy_groups, 'save_custom_fields' );
		$this->loader->add_action( 'edited_groups', $taxonomy_groups, 'save_custom_fields' );
		$this->loader->add_action( 'manage_groups_custom_column', $taxonomy_groups, 'populate_custom_columns', 10, 3 );
		$this->loader->add_action( 'admin_footer', $taxonomy_groups, 'remove_default_fields' );
		$this->loader->add_filter( 'manage_edit-groups_columns', $taxonomy_groups, 'manage_taxonomy_columns' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Fbap_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    2.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     2.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     2.0.0
	 * @return    Fbap_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     2.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
