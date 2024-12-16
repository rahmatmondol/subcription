<?php
/*
Plugin Name: Subscription Manager
Plugin URI: 
Description: This plugin is for Subscription Boxes management system
Version: 1.2 
Author: Leadcom
Author URI: http://leadcom.io
*/

// add stylesheets
function subcription_manager_assets() {
    wp_enqueue_style( 'subcription-manager-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
    // Enqueue Bootstrap CSS
    // wp_enqueue_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );

    // Enqueue jQuery
    wp_enqueue_script( 'jquery' );
    
    // Enqueue Bootstrap JS
    wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true );
    
    // custom js
    wp_enqueue_script( 'subcription-manager-js', plugins_url( 'assets/js/script.js', __FILE__ ), array( 'jquery' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'subcription_manager_assets' );

// Check if Subscriptions for WooCommerce is active
if ( in_array( 'subscriptions-for-woocommerce/subscriptions-for-woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // Include necessary files
    include( __DIR__ . '/inc/acf.php' );
    include( __DIR__ . '/inc/shortcodes/subcription_select_box.php' );
    include( __DIR__ . '/inc/functions/get_subcription_info.php' );
    include( __DIR__ . '/inc/functions/wc_account_functions.php' );
    include( __DIR__ . '/inc/functions/check_status.php' );
    include( __DIR__ . '/inc/ajax/save_selected_boxes.php' );
} else {
    // Add admin notice to prompt activation of Subscriptions for WooCommerce
    add_action( 'admin_notices', 'wps_sfw_activation_failure_admin_notice' );
    add_action( 'network_admin_notices', 'wps_sfw_activation_failure_admin_notice' );
}

/**
 * Display an admin notice for WooCommerce Subscriptions activation
 */
function wps_sfw_activation_failure_admin_notice() {
    // Ensure this message is only shown to users with admin privileges
    if ( current_user_can( 'activate_plugins' ) ) {
        echo '<div class="notice notice-error is-dismissible">';
        echo '<p><strong>Subscriptions for WooCommerce is not active.</strong> Please activate it to use this plugin.</p>';
        echo '</div>';
    }
}

