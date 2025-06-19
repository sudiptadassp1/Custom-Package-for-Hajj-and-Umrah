<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://siliconorchard.com/
 * @since      1.0.0
 *
 * @package    Custom_Package_For_Hajj_And_Umrah
 * @subpackage Custom_Package_For_Hajj_And_Umrah/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Custom_Package_For_Hajj_And_Umrah
 * @subpackage Custom_Package_For_Hajj_And_Umrah/includes
 * @author     Silicon Orchard Ltd. <sudipta@siliconorchard.com>
 */
class Custom_Package_For_Hajj_And_Umrah_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'custom-package-for-hajj-and-umrah',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
