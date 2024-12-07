<?php
/*
Plugin Name: Subcription Manager
Plugin URI: 
Description: Subcription Manager Plugin
Version: 1.0
Author: Rahmat Mondol
Author URI: www.rahmatmondol.com
*/

// Add "Select Box" tab to the My Account menu
function add_user_details_tab( $menu_links ) {
    // Add the new tab before "Logout"
    $new_links = array( 'select-boxe' => __( 'Select Box', 'woocommerce' ) );

    // Insert the new tab in the menu
    $menu_links = array_slice( $menu_links, 0, count( $menu_links ) - 1, true ) 
                + $new_links 
                + array_slice( $menu_links, count( $menu_links ) - 1, null, true );

    return $menu_links;
}

add_filter( 'woocommerce_account_menu_items', 'add_user_details_tab', 99 );

// Register the endpoint for "Select Box"
function add_user_details_endpoint() {
    add_rewrite_endpoint( 'select-boxe', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'add_user_details_endpoint' );

// Content for the "Select Box" tab
function user_details_tab_content() {
    $user = wp_get_current_user();

    if ( ! $user->exists() ) {
        echo '<p>' . __( 'No Select Box found.', 'woocommerce' ) . '</p>';
        return;
    }

    ?>
    <h2><?php esc_html_e( 'Select Box', 'woocommerce' ); ?></h2>
    
    <?php
}

add_action( 'woocommerce_account_select-boxe_endpoint', 'user_details_tab_content' );
