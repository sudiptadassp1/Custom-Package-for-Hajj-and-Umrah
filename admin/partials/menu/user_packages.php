<?php
// Register the admin menu only for users with the subscriber role
add_action('admin_menu', 'register_my_packages_menu');
function register_my_packages_menu(){
    // Get current user information
    $current_user = wp_get_current_user();
    
    // Check if the user has the 'subscriber' role (or adjust to your custom role)
    if ( empty($current_user->roles) || ! in_array( 'subscriber', (array)$current_user->roles ) ) {
        return; // Do not add the menu if the user is not a subscriber.
    }
    
    // Add the main menu page called "My Packages"
    add_menu_page(
       'My Packages',                      // Page title
       'My Packages',                      // Menu title
       'read',                             // Capability required (subscribers have 'read')
       'my-packages',                      // Menu slug
       'my_packages_page_callback',        // Callback function to display the page
       'dashicons-portfolio',              // Icon (you can change as needed)
       6                                   // Position
    );
}

// Main page: List all packages with Edit and Delete options
function my_packages_page_callback(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'save_for_later_db';

    // Handle deletion if requested
    if( isset($_GET['action']) && $_GET['action'] == 'delete' && !empty($_GET['id']) ){
         $id = intval($_GET['id']);
         $nonce = isset($_GET['nonce']) ? $_GET['nonce'] : '';
         if( ! wp_verify_nonce($nonce, 'delete_package_' . $id) ){
             echo '<div class="error"><p>Security check failed.</p></div>';
         } else {
             $deleted = $wpdb->delete($table_name, array('id' => $id), array('%d'));
             if($deleted){
                echo '<div class="updated"><p>Package deleted successfully.</p></div>';
             } else {
                echo '<div class="error"><p>Failed to delete package.</p></div>';
             }
         }
    }

    // Retrieve all packages from the DB
    $user_id = get_current_user_id();
    $packages = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d ORDER BY id DESC", $user_id));
    $edit_url = get_option('edit-url');

    echo '<div class="wrap">';
    echo '<h1>My Packages</h1>';
    if( $packages ){
         echo '<table class="wp-list-table widefat fixed striped">';
         echo '<thead>';
         echo '<tr>';
         echo '<th>ID</th>';
         echo '<th>Package Name</th>';
         echo '<th>User ID</th>';
         echo '<th>Actions</th>';
         echo '</tr>';
         echo '</thead>';
         echo '<tbody>';
         foreach( $packages as $package ){
             // Build Edit URL
             $edit_url = $edit_url.'?user='.$package->user_id.'&id=' . $package->id;
             // Build Delete URL with nonce for security
             $delete_url = admin_url('admin.php?page=my-packages&action=delete&id=' . $package->id . '&nonce=' . wp_create_nonce('delete_package_' . $package->id));
             
             echo '<tr>';
             echo '<td>' . esc_html($package->id) . '</td>';
             echo '<td>' . esc_html($package->package_name) . '</td>';
             echo '<td>' . esc_html($package->user_id) . '</td>';
             echo '<td>';
             echo '<a href="' . esc_url($edit_url) . '">Edit</a> | ';
             echo '<a href="' . esc_url($delete_url) . '" onclick="return confirm(\'Are you sure you want to delete this package?\')">Delete</a>';
             echo '</td>';
             echo '</tr>';
         }
         echo '</tbody>';
         echo '</table>';
    } else {
         echo '<p>No packages found.</p>';
    }
    echo '</div>';
}
