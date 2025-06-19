<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://siliconorchard.com/
 * @since      1.0.0
 *
 * @package    Custom_Package_For_Hajj_And_Umrah
 * @subpackage Custom_Package_For_Hajj_And_Umrah/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Custom_Package_For_Hajj_And_Umrah
 * @subpackage Custom_Package_For_Hajj_And_Umrah/public
 * @author     Silicon Orchard Ltd. <sudipta@siliconorchard.com>
 */
class Custom_Package_For_Hajj_And_Umrah_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-package-for-hajj-and-umrah-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( "font-awesone", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css", array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script('frontend-ajax', plugin_dir_url( __FILE__ ) . '/js/frontend-ajax.js', array('jquery'), null, true);
		wp_localize_script('frontend-ajax', 'ajax_params', array(
			'ajax_url' => admin_url('admin-ajax.php')
		));

		wp_enqueue_script('save-package-ajax', plugin_dir_url( __FILE__ ) . '/js/save-package-ajax.js', array('jquery'), null, true);
		wp_localize_script('save-package-ajax', 'package_params', array(
			'ajax_url' => admin_url('admin-ajax.php')
		));

		wp_enqueue_script('save-for-later-ajax', plugin_dir_url( __FILE__ ) . '/js/save-for-later.js', array('jquery'), null, true);
		wp_localize_script('save-for-later-ajax', 'save_later_params', array(
			'ajax_url' => admin_url('admin-ajax.php')
		));
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-package-for-hajj-and-umrah-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "custom-package-frontend", plugin_dir_url( __FILE__ ) . 'js/custom-package-frontend.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "custom-package-room-type", plugin_dir_url( __FILE__ ) . 'js/custom-package-room-type.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "edit-mode", plugin_dir_url( __FILE__ ) . 'js/edit-mode.js', array( 'jquery' ), $this->version, false );
		

	}

}
