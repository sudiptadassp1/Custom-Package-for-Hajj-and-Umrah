<?php
    class Settings_Panel {

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
            add_action('admin_menu', [$this, 'custom_dashboard_menu']);
            // Hook to remove the default first submenu
            add_action('admin_menu', [$this, 'remove_default_submenu'], 99);
        }

        public function custom_dashboard_menu(){
            // Get the saved license key from the database.
            $license_key = get_option( 'custom_package_license_key', '' );

            // Validate the license key. (This function will be defined in our license validation file.)
            if ( empty( $license_key ) || ! custom_package_validate_license( $license_key ) ) {
                // If no license or invalid license, do not add the main admin menu.
                return;
            }
            // Add Parent Menu
            add_menu_page(
                'Dashboard',                      // Page Title
                'Custom Package',                    // Menu Title
                'manage_options', 
                'custom-package',             // Menu Slug
                [$this,'custom_package_settings_page'],   // Callback Function for Parent Page
                'dashicons-archive',          // Icon
                6                             // Position
            );

            // Add Submenu - Settings
            add_submenu_page(
                'custom-package',             // Parent Slug
                'Settings',                   // Page Title
                'Settings',                   // Menu Title
                'manage_options',             // Capability
                'custom-package-settings',    // Submenu Slug
                [$this,'custom_package_settings_page']// Callback Function for Submenu Page
            );

            // Add Submenu - Settings
            add_submenu_page(
                'custom-package',             // Parent Slug
                'Cost input',                   // Page Title
                'Cost input',                   // Menu Title
                'manage_options',             // Capability
                'custom-package-cost-input',    // Submenu Slug
                [$this,'custom_package_cost_input_page']// Callback Function for Submenu Page
            );

            // Add Submenu - Submitted Packages
            add_submenu_page(
                'custom-package',             // Parent Slug
                'Submitted Packages',         // Page Title
                'Submitted Packages',         // Menu Title
                'manage_options',             // Capability
                'custom-package-submitted',   // Submenu Slug
                [$this,'custom_package_submitted_page']// Callback Function for Submenu Page
            );
        }

        /**
         * Remove the default submenu that WordPress adds for the parent menu
         */
        public function remove_default_submenu() {
            global $submenu;
            // Remove the first submenu (which duplicates the parent menu)
            if (isset($submenu['custom-package'])) {
                unset($submenu['custom-package'][0]);
            }
        }

        // Callback for Settings Submenu
        public function custom_package_settings_page() {
            require_once plugin_dir_path( __FILE__ ) . 'partials/menu/menu-settings.php';
            Menu_Settings::settings_page();
        }
        
        // Callback for Settings Submenu
        public function custom_package_cost_input_page() {
            require_once plugin_dir_path( __FILE__ ) . 'partials/menu/cost_input.php';
        }

        // Callback for Submitted Packages Submenu
        public function custom_package_submitted_page() {
            require_once plugin_dir_path( __FILE__ ) . 'partials/menu/submited-package.php';
        }
    }
?>