<?php
    // Hook for logged-in users
    add_action('wp_ajax_save_submitted_package_db', 'save_submitted_package_db_callback');

    // Hook for non-logged-in users (if needed)
    add_action('wp_ajax_nopriv_save_submitted_package_db', 'save_submitted_package_db_callback');

    function save_submitted_package_db_callback(){
        ob_clean(); // Clear any previous output

        if (!isset($_POST['data'])) {
            wp_send_json_error(['message' => 'Missing data parameter']);
        }
    
        $data = ($_POST['data']);
    
        // Sanitize and validate input data.
        $full_name = sanitize_text_field($data['name']);
        $mobile = sanitize_text_field($data['phone']);
        $email = sanitize_email($data['email']);
        $mode = isset($data['mode']) ? (int)$data['mode'] : 0;
        $object = isset($data['packageData']) ? json_encode($data['packageData']) : '';

        // Ensure the JSON is valid
        if (json_last_error() !== JSON_ERROR_NONE) {
            wp_send_json_error(['message' => 'Invalid JSON data']);
        }

        // Optional: Trim the data if it's too large
        if (strlen($object) > 10000) { // Limit to 10,000 characters (adjust as needed)
            $object = substr($object, 0, 10000); // Truncate to 10,000 characters
        }

        // Insert into the database
        global $wpdb;
        $table_name = $wpdb->prefix . "submitted_custom_package";

        // Insert query
        $insert_result = $wpdb->insert(
            $table_name, // Table name
            array(
                'cphu_full_name' => $full_name,
                'cphu_mobile' => $mobile,
                'cphu_email' => $email,
                'cphu_object' => $object, // Store the JSON string here
                'cphu_status' => "requested"
            ),
            array(
                '%s', // %s for string fields
                '%s', // %s for string fields
                '%s', // %s for string fields (email)
                '%s'  // %s for string fields (JSON)
            )
        );

        // Check for errors and return response
        if ($insert_result) {
            if($mode != 0){
                $save_for_later_table_name = $wpdb->prefix . 'save_for_later_db';

                // Delete the row where 'id' equals $id_to_delete.
                $deleted = $wpdb->delete( 
                    $save_for_later_table_name, 
                    array( 'id' => $mode ),  // WHERE clause
                    array( '%d' )                    // Data format for the WHERE clause
                );

                if ( false === $deleted ) {
                    // There was an error during deletion.
                    wp_die( 'Error deleting the record.' );
                }
            }
            wp_send_json_success(['message' => 'Package submitted successfully']);
        } else {
            wp_send_json_error([
                'message' => 'Failed to save the package',
                'error' => $wpdb->last_error // Show the specific MySQL error message
            ]);
        }

        die();
    }


    function removeEmptyValues(array $data): array {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Recursively process nested arrays
                $data[$key] = removeEmptyValues($value);
                // If the sub-array becomes empty, remove it
                if (empty($data[$key])) {
                    unset($data[$key]);
                }
            } else {
                // Remove the key if value is empty or is a default placeholder
                if (trim($value) === '' || $value === '— Select —') {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }


    // Hook for logged-in users
    add_action('wp_ajax_save_save_for_later_db', 'save_save_for_later_db_callback');

    // Hook for non-logged-in users (if needed)
    add_action('wp_ajax_nopriv_save_save_for_later_db', 'save_save_for_later_db_callback');

    function save_save_for_later_db_callback(){
        ob_clean(); // Clear any previous output

        // Check if user is logged in
        if( ! is_user_logged_in() ) {
            wp_send_json_error( array(
                'message'  => 'User not logged in. Please log in to continue.',
                'redirect' => wp_login_url()
            ) );
            exit;
        }
        
        $user_id = get_current_user_id();

        // Check for required POST parameters.
        if( !isset($_POST['data']) || !isset($_POST['packageName']) ) {
            wp_send_json_error( array('message' => 'Missing parameters') );
            exit;
        }
        
        // Sanitize package name
        $packageName = sanitize_text_field( $_POST['packageName'] );
        $data = $_POST['data'];
        
        // Remove any empty values (assuming you have defined removeEmptyValues() elsewhere)
        $filteredData = removeEmptyValues($data);
        
        // Encode the filtered data as JSON (you can change this if you prefer serialized data)
        $package_data_object = wp_json_encode( $filteredData );
        
        global $wpdb;
        $table_name = $wpdb->prefix . "save_for_later_db";
        
        // Check if a record already exists for this user_id and package name
        $existing_id = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT id FROM $table_name WHERE user_id = %d AND package_name = %s",
                $user_id,
                $packageName
            )
        );
        
        if( $existing_id ) {
            // Record exists, so update it
            $result = $wpdb->update(
                $table_name,
                array( 'package_data_object' => $package_data_object ),
                array( 'id' => $existing_id ),
                array( '%s' ),
                array( '%d' )
            );
            
            if( false === $result ) {
                wp_send_json_error( array('message' => 'Failed to update package data.') );
            } else {
                wp_send_json_success( array('message' => 'Package data updated successfully.') );
            }
        } else {
            // No record exists, so insert a new record
            $result = $wpdb->insert(
                $table_name,
                array(
                    'package_name'         => $packageName,
                    'user_id'              => $user_id,
                    'package_data_object'  => $package_data_object
                ),
                array( '%s', '%d', '%s' )
            );
            
            if( false === $result ) {
                wp_send_json_error( array('message' => 'Failed to save package data.') );
            } else {
                wp_send_json_success( array('message' => 'Package data saved successfully.') );
            }
        }
        exit;
        die();
    }

?>