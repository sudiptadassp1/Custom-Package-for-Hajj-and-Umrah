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
      * This page is for hotel meta data save in DB through AJAX function
      */

    function save_hotel_meta_data() {

        // Retrieve and sanitize the data
        $hotel_cost_obj = !empty($_REQUEST['hotel_cost_obj']) ? $_REQUEST['hotel_cost_obj'] : '';
        $hotel_basic_info = !empty($_REQUEST['hotel_basic_info']) ? $_REQUEST['hotel_basic_info'] : '';

        // Save data to the options table
        update_post_meta( $hotel_basic_info['hotel_id'], 'hotel_road_name', $hotel_basic_info["road_name"] );
        update_post_meta( $hotel_basic_info['hotel_id'], 'hotel_city_name', $hotel_basic_info["city_name"] );
        update_post_meta( $hotel_basic_info['hotel_id'], 'hotel_distance', $hotel_basic_info["distance"] );
        update_post_meta( $hotel_basic_info['hotel_id'], 'hotel_map', $hotel_basic_info["map"] );
        update_post_meta( $hotel_basic_info['hotel_id'], 'hotel_costing_object', $hotel_cost_obj );

        // Return success response
        wp_send_json_success('Meta data saved successfully');
    }
    add_action('wp_ajax_save_hotel_meta_data', 'save_hotel_meta_data'); // For logged-in users
    add_action('wp_ajax_nopriv_save_hotel_meta_data', 'save_hotel_meta_data'); // For non-logged-in users

?>