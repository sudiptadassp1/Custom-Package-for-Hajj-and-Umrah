<?php
    // Hook for logged-in users
    add_action('wp_ajax_fetch_hotel_names', 'fetch_hotel_names_callback');

    // Hook for non-logged-in users (if needed)
    add_action('wp_ajax_nopriv_fetch_hotel_names', 'fetch_hotel_names_callback');

    function fetch_hotel_names_callback(){
        ob_clean(); // Clear any previous output

        // Sanitize inputs
        $hotel_type_id = isset($_POST['hotel_type_id']) ? intval($_POST['hotel_type_id']) : null;
        $location = sanitize_text_field($_POST['location']);
        $distance = isset($_POST['distance']) ? intval($_POST['distance']) : 0;

        // Validate location (required)
        if (!$location) {
            echo '<option value="" disabled>Invalid request</option>';
            wp_die();
        }

        // Base query arguments
        $args = array(
            'post_type' => 'hotel', // Replace with your custom post type
            'posts_per_page' => -1, // Retrieve all matching posts
        );

        // Add tax query if hotel type is provided
        if ($hotel_type_id) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $location . '_hotel_type',
                    'field'    => 'term_id',
                    'terms'    => $hotel_type_id,
                ),
            );
        }

        // Add meta query if distance is provided and greater than 0
        if ($distance > 0) {
            $args['meta_query'] = array(
                array(
                    'key'     => 'hotel_distance', // Replace with your distance meta key
                    'value'   => $distance,
                    'compare' => '<=', // Filter hotels with distance less than or equal to the selected value
                    'type'    => 'NUMERIC'
                )
            );
        }

        // print_r($args);

        $hotels = new WP_Query($args);

        // Check if there are posts
        if ($hotels->have_posts()) {
            $options = '<option selected value="0">-- Select Hotel --</option>';
            while ($hotels->have_posts()) {
                $hotels->the_post();
                $hotel_id = get_the_ID();
                $title    = get_the_title();
                // Retrieve the map URL. Using 'true' returns a single value.
                $map_url  = get_post_meta($hotel_id, 'hotel_map', true);
                
                // Add the map URL as a data attribute
                $options .= '<option value="' . $hotel_id . '" data-map-url="' . esc_attr($map_url) . '">' . esc_html($title) . '</option>';
            }
            wp_send_json_success($options); // Send success response with options
        } else {
            wp_send_json_error('No hotels found.');
        }
        

        wp_die(); // Required to terminate the AJAX request properly
    }
?>