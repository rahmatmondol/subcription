<?php
// Add "Select Box" tab to the My Account menu
function add_user_details_tab( $menu_links ) {
    // Insert the new tab in the menu
    $menu_links = array_merge( array( 'select-box' => __( 'Boxar', 'subscription-Manager' ) ), $menu_links );

    return $menu_links;
}

add_filter( 'woocommerce_account_menu_items', 'add_user_details_tab', 99 );



// Register the endpoint for "Select Box"
function add_user_details_endpoint() {
    add_rewrite_endpoint( 'select-box', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'add_user_details_endpoint' );

// Content for the "Select Box" tab
function user_details_tab_content() {
    //show short code
    echo do_shortcode('[subcription_select_box]');
}

add_action( 'woocommerce_account_select-box_endpoint', 'user_details_tab_content' );