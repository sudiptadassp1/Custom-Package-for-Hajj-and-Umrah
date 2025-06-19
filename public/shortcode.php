<?php
    function custom_package_shortcode($atts) {
        // Parse the shortcode attributes and set defaults
        $atts = shortcode_atts(
            array(
                'template' => 'default_style', // Default template if none is provided
            ),
            $atts,
            'custom_package'
        );
    
        // Get the template attribute value
        $template = sanitize_text_field($atts['template']);

        $output = '';

        if ($template === "style_1") {
            $file_path = plugin_dir_path(dirname(__FILE__)) . 'public/templates/style_1.php';
            if (file_exists($file_path)) {
                $output .= include $file_path; // Append the returned content
            } else {
                $output .= '<p>Error: Template not found.</p>';
            }
        }

        return $output;
        
    }
    
    // Register the shortcode
    add_shortcode('custom_package', 'custom_package_shortcode');    
?>