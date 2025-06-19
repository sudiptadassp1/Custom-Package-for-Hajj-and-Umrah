<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://siliconorchard.com/
 * @since      1.0.0
 *
 * @package    Custom_Package_For_Hajj_And_Umrah
 * @subpackage Custom_Package_For_Hajj_And_Umrah/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Custom_Package_For_Hajj_And_Umrah
 * @subpackage Custom_Package_For_Hajj_And_Umrah/admin
 * @author     Silicon Orchard Ltd. <sudipta@siliconorchard.com>
 */
class Custom_Package_For_Hajj_And_Umrah_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_Package_For_Hajj_And_Umrah_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Package_For_Hajj_And_Umrah_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-package-for-hajj-and-umrah-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_Package_For_Hajj_And_Umrah_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Package_For_Hajj_And_Umrah_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if (wp_script_is('jquery', 'registered')) {
			wp_deregister_script('jquery');
		}
	
		// Register jQuery from a CDN
		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', [], '3.7.1', true);

		// Enqueue jQuery if not already enqueued
		if (!wp_script_is('jquery', 'enqueued')) {
			wp_enqueue_script('jquery');
		}


		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-package-for-hajj-and-umrah-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'adminAjax', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ), 
			'nonce' => wp_create_nonce("save_package_options")
		));

		wp_enqueue_script( 'hotel-costing-js', plugin_dir_url( __FILE__ ) . 'js/hotel-costing.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'settings-repeater-js', plugin_dir_url( __FILE__ ) . 'js/settings-repeater.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'save-costing-data', plugin_dir_url( __FILE__ ) . 'js/save-costing-data.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'save-costing-data', 'saveCostAjax', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ), 
			'nonce' => wp_create_nonce("save_cost_data")
		));
		wp_enqueue_script( 'display-js', plugin_dir_url( __FILE__ ) . 'js/display.js', array( 'jquery' ), $this->version, false );

	}

}
