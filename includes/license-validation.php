<?php
// File: includes/license-validation.php

/**
 * Checks the plugin license.
 * This function runs on admin_init and adds a notice if the license is missing or invalid.
 */
function custom_package_check_license() {
    $license_key = get_option( 'custom_package_license_key', '' );

    // If no license is provided, show a warning notice.
    if ( empty( $license_key ) ) {
        add_action( 'admin_notices', 'custom_package_license_missing_notice' );
        return;
    }

    // Validate the license via your license server.
    if ( ! custom_package_validate_license( $license_key ) ) {
        add_action( 'admin_notices', 'custom_package_license_invalid_notice' );
    }
}

/**
 * Calls the remote licensing server to validate the license key.
 *
 * @param string $license_key
 * @return bool True if valid, false otherwise.
 */
function custom_package_validate_license( $license_key ) {
    // Replace with your actual license server endpoint.
    $license_server_url = 'https://sol.trydemo.dev/wp-json/license/v1/validate';
    
    $args = array(
        'timeout' => 15,
        'body'    => array(
            'license_key' => $license_key,
            'domain'      => $_SERVER['HTTP_HOST'],
        ),
    );

    $response = wp_remote_post( $license_server_url, $args );

    if ( is_wp_error( $response ) ) {
        return false;
    }

    if ( wp_remote_retrieve_response_code( $response ) != 200 ) {
        return false;
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    return isset( $data['status'] ) && $data['status'] === 'success';
}

/**
 * Admin notice when the license key is missing.
 */
function custom_package_license_missing_notice() {
    echo '<div class="notice notice-warning">
        <p>Your plugin license key is missing. Please enter a valid license key in the <a href="' . admin_url( 'options-general.php?page=custom-package-license-settings' ) . '">license settings</a>.</p>
    </div>';
}

/**
 * Admin notice when the license key is invalid.
 */
function custom_package_license_invalid_notice() {
    echo '<div class="notice notice-error">
        <p>Your plugin license key is invalid. Please update your license key in the <a href="' . admin_url( 'options-general.php?page=custom-package-license-settings' ) . '">license settings</a>.</p>
    </div>';
}

// Hook the license check to admin_init so it runs on every admin page.
add_action( 'admin_init', 'custom_package_check_license' );
