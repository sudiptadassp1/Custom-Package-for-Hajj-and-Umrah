<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://https://siliconorchard.com/
 * @since      1.0.0
 *
 * @package    Custom_Package_For_Hajj_And_Umrah
 * @subpackage Custom_Package_For_Hajj_And_Umrah/includes
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
 * @since      1.0.0
 * @package    Custom_Package_For_Hajj_And_Umrah
 * @subpackage Custom_Package_For_Hajj_And_Umrah/includes
 * @author     Silicon Orchard Ltd. <sudipta@siliconorchard.com>
 */
class Custom_Package_For_Hajj_And_Umrah {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Custom_Package_For_Hajj_And_Umrah_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'CUSTOM_PACKAGE_FOR_HAJJ_AND_UMRAH_VERSION' ) ) {
			$this->version = CUSTOM_PACKAGE_FOR_HAJJ_AND_UMRAH_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'custom-package-for-hajj-and-umrah';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->create_hotel_post_type();
		$this->settings_panel_in_menu();
		$this->db_create();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Custom_Package_For_Hajj_And_Umrah_Loader. Orchestrates the hooks of the plugin.
	 * - Custom_Package_For_Hajj_And_Umrah_i18n. Defines internationalization functionality.
	 * - Custom_Package_For_Hajj_And_Umrah_Admin. Defines all hooks for the admin area.
	 * - Custom_Package_For_Hajj_And_Umrah_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-custom-package-for-hajj-and-umrah-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-custom-package-for-hajj-and-umrah-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-custom-package-for-hajj-and-umrah-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-custom-package-for-hajj-and-umrah-public.php';

		$this->loader = new Custom_Package_For_Hajj_And_Umrah_Loader();

		/**
		 * Create hotel
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/hotel-post-type.php';

		/**
		 * Settings panel in menu
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings-panel.php';	
		
		/**
		 * DB Creation
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/db-create.php';

		/**
		 * Save settings data via AJAX
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/ajax/settings-data.php';
		
		/**
		 * Save costing data via AJAX
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/ajax/save-cost-data.php';

		/**
		 * Save hotel meta data via AJAX
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/ajax/save-hotel-meta-data.php';

		/**
		 * Add hotel meta fields
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/meta_fields/basic-meta-fields.php';

		/**
		 * Define Shortcode function
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/shortcode.php';
		
		/**
		 * Frontend shortcode AJAX
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/ajax/shortcode-ajax.php';

		/**
		 * Frontend cost calculation AJAX
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/ajax/costing-ajax.php';

		/**
		 * Save submitted_packagein DB AJAX
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/ajax/save_submitted_package_in_db.php';


		/**
		 * Package page for user
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/menu/user_packages.php';

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Custom_Package_For_Hajj_And_Umrah_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Custom_Package_For_Hajj_And_Umrah_i18n();

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

		$plugin_admin = new Custom_Package_For_Hajj_And_Umrah_Admin( $this->get_plugin_name(), $this->get_version() );

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

		$plugin_public = new Custom_Package_For_Hajj_And_Umrah_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	private function create_hotel_post_type(){
		$hotel_class = new Hotel_Post_Type( $this->get_plugin_name(), $this->get_version());
	}

	private function settings_panel_in_menu(){
		new Settings_Panel($this->get_plugin_name(), $this->get_version());
	}
	
	private function db_create(){
		new DB_Create($this->get_plugin_name(), $this->get_version());
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
	 * @return    Custom_Package_For_Hajj_And_Umrah_Loader    Orchestrates the hooks of the plugin.
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
