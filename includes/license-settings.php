<?php
// File: includes/license-settings.php

/**
 * Adds a new settings page for entering the license key.
 */
function custom_package_add_license_menu() {
    add_options_page(
        'Custom Package License Settings',
        'Custom Hajj and Umrah License',
        'manage_options',
        'custom-package-license-settings',
        'custom_package_render_license_settings_page'
    );
}
add_action( 'admin_menu', 'custom_package_add_license_menu' );

/**
 * Renders the license settings page.
 */
function custom_package_render_license_settings_page() {
    // Save the license key if the form was submitted.
    if ( isset( $_POST['custom_package_license_key'] ) ) {
        check_admin_referer( 'custom_package_save_license', 'custom_package_nonce' );
        update_option( 'custom_package_license_key', sanitize_text_field( $_POST['custom_package_license_key'] ) );
        echo '<div class="updated"><p>License key updated.</p></div>';
        
    }
    
    $license_key = get_option( 'custom_package_license_key', '' );
    ?>
    <div class="wrap">
        <h1>Custom Package License Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field( 'custom_package_save_license', 'custom_package_nonce' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">License Key</th>
                    <td>
                        <input type="text" name="custom_package_license_key" value="<?php echo esc_attr( $license_key ); ?>" class="regular-text" required>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
            <span><b>N:B: After save the key please reload the page.</b></span>
        </form>
    </div>
    <?php
}
