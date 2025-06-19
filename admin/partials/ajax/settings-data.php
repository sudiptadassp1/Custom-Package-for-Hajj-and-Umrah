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
      * This page is for setting panel AJAX function to data save in DB
      */

    function save_package_options() {
        // Verify nonce
        if (!isset($_POST['package_nonce']) || !wp_verify_nonce($_POST['package_nonce'], 'save_package_options')) {
            wp_send_json_error('Invalid nonce');
            return;
        }

        // Retrieve and sanitize the data
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $selected_data = !empty($_POST['data']) ? $_POST['data'] : '';

        // Save data to the options table
        update_option($name, json_encode($selected_data));

        // Return success response
        wp_send_json_success('Options saved successfully');
    }
    add_action('wp_ajax_save_package_options', 'save_package_options'); // For logged-in users
    add_action('wp_ajax_nopriv_save_package_options', 'save_package_options'); // For non-logged-in users


    // Save route data in DB
    add_action('wp_ajax_save_route_segments', 'save_route_segments');
    add_action('wp_ajax_nopriv_save_route_segments', 'save_route_segments'); // For non-logged-in users

    function save_route_segments() {
        if (!isset($_POST['routes']) || !is_array($_POST['routes'])) {
            wp_send_json_error(['message' => 'Invalid data received']);
        }

        // Prepare data for saving
        $routes = $_POST['routes'];
        // Save data to the options table
        update_option("route_settings_obj", json_encode($routes));

        wp_send_json_success(['message' => 'Routes saved successfully']);
    }


    // Update submitted package status in DB
    add_action('wp_ajax_save_submitted_package_status', 'save_submitted_package_status');
    add_action('wp_ajax_nopriv_save_submitted_package_status', 'save_submitted_package_status'); // For non-logged-in users

    function save_submitted_package_status() {
        if (!isset($_POST['data']) || !is_array($_POST['data'])) {
            wp_send_json_error(['message' => 'Invalid data received']);
        }
        

        global $wpdb;
        // Get and sanitize input data
        $status = sanitize_text_field($_POST['data']['status']);
        $package_id = intval($_POST['data']['package_id']);

        // Define the table name
        $table_name = $wpdb->prefix . 'submitted_custom_package';

        // Fetch the email of the package user
        $user_email = $wpdb->get_var($wpdb->prepare("SELECT cphu_email FROM $table_name WHERE id = %d", $package_id));

        if (!$user_email) {
            wp_send_json_error("User email not found.");
            exit;
        }

        // Perform the update query
        $updated = $wpdb->update(
            $table_name, 
            array('cphu_status' => $status), // Data to update
            array('id' => $package_id), // WHERE condition
            array('%s'), // Data format (string)
            array('%d')  // WHERE condition format (integer)
        );

        if ($updated !== false) {
            // Send email notification
            $subject = "Your Package Status Has Been Updated";
            $message = "Hello,\n\nYour package status has been updated to: $status.\n\nThank you!";
            $headers = array('Content-Type: text/plain; charset=UTF-8');

            // Send the email
            wp_mail($user_email, $subject, $message, $headers);

            wp_send_json_success("Status updated and email sent to $user_email.");
        } else {
            wp_send_json_error("Failed to update status.");
        }
    }

?>