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
      * This page is for save costing data in DB
      */

    function save_costing_data() {
        // Verify nonce
        if ( ! isset( $_POST['cost_nonce'] ) || ! wp_verify_nonce( $_POST['cost_nonce'], 'save_cost_data' ) ) {
            wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
            return;
        }

        // Retrieve and sanitize the data
        $cost_data_arr = !empty($_POST['data']) ? $_POST['data'] : [];

        // Save data to the options table
        update_option("cphu_costing_data", json_encode($cost_data_arr));

        // Return success response
        wp_send_json_success( array( 'message' => 'Cost saved successfully' ) );
    }
    add_action('wp_ajax_save_costing_data', 'save_costing_data'); // For logged-in users
    add_action('wp_ajax_nopriv_save_costing_data', 'save_costing_data'); // For non-logged-in users

?>