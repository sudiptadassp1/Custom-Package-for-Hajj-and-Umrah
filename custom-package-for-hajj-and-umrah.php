<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://siliconorchard.com/
 * @since             1.0.0
 * @package           Custom_Package_For_Hajj_And_Umrah
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Package for Hajj and Umrah
 * Plugin URI:        https://https://siliconorchard.com/
 * Description:       This plugin is for any wordpress site to book and manage custom hajj and umrah packages. Admin can set the costing in the backend and the user can see the costing summary. Users also have a dashboard panel to monitor the packages.
 * Version:           1.0.0
 * Author:            Silicon Orchard Ltd.
 * Author URI:        https://https://siliconorchard.com//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-package-for-hajj-and-umrah
 * Domain Path:       /languages
 */

 // Include license validation and settings.
require_once plugin_dir_path( __FILE__ ) . 'includes/license-validation.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/license-settings.php';


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CUSTOM_PACKAGE_FOR_HAJJ_AND_UMRAH_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom-package-for-hajj-and-umrah-activator.php
 */
function activate_custom_package_for_hajj_and_umrah() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-package-for-hajj-and-umrah-activator.php';
	Custom_Package_For_Hajj_And_Umrah_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom-package-for-hajj-and-umrah-deactivator.php
 */
function deactivate_custom_package_for_hajj_and_umrah() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-package-for-hajj-and-umrah-deactivator.php';
	Custom_Package_For_Hajj_And_Umrah_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_custom_package_for_hajj_and_umrah' );
register_deactivation_hook( __FILE__, 'deactivate_custom_package_for_hajj_and_umrah' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custom-package-for-hajj-and-umrah.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_package_for_hajj_and_umrah() {

	$plugin = new Custom_Package_For_Hajj_And_Umrah();
	$plugin->run();

}
run_custom_package_for_hajj_and_umrah();
