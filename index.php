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

        $subcription = get_user_subscriptions();

        ?>
    <h2><?php esc_html_e( 'Select Box', 'woocommerce' ); ?></h2>
    
        <pre>
            <?php print_r($subcription); ?>
        </pre>



    <?php
}

add_action( 'woocommerce_account_select-boxe_endpoint', 'user_details_tab_content' );


 // get user subcription details
function get_user_subscriptions( ) {
    $user = wp_get_current_user();

    $args = array(
        'customer' => $user->Id,
        'post_status' => 'any', // Optional: can filter by order status (e.g., 'completed', 'processing')
        'posts_per_page' => -1, // Retrieve all orders
    );
    
    $orders = wc_get_orders( $args );

        $wps_subscriptions_data[] = array();
        foreach ( $orders as $order ) {
            $order_id = $order->get_id();
            $subcription_id = $order->get_meta('wps_subscription_id');

            if ($subcription_id ) {
                $parent_order_id   = wps_sfw_get_meta_data( $subcription_id, 'wps_parent_order', true );
                $wps_subscription_status   = wps_sfw_get_meta_data( $subcription_id, 'wps_subscription_status', true );
                $product_name   = wps_sfw_get_meta_data( $subcription_id, 'product_name', true );
                $wps_recurring_total   = wps_sfw_get_meta_data( $subcription_id, 'wps_recurring_total', true );
        
                $wps_wsp_number   = wps_sfw_get_meta_data( $subcription_id, 'wps_sfw_subscription_number', true );
                $wps_wsp_interval   = wps_sfw_get_meta_data( $subcription_id, 'wps_sfw_subscription_interval', true );
        
                $wps_next_payment_date   = wps_sfw_get_meta_data( $subcription_id, 'wps_next_payment_date', true );
                $wps_susbcription_end   = wps_sfw_get_meta_data( $subcription_id, 'wps_susbcription_end', true );
        
                $wps_customer_id   = wps_sfw_get_meta_data( $subcription_id, 'wps_customer_id', true );
                $user = get_user_by( 'id', $wps_customer_id );
        
                $user_nicename = isset( $user->user_nicename ) ? $user->user_nicename : '';
                $wps_subscriptions_data= (object) [
                    'subscription_id'           => $subcription_id,
                    'parent_order_id'           => $parent_order_id,
                    'status'                    => $wps_subscription_status,
                    'product_name'              => $product_name,
                    'recurring_amount'          => $wps_recurring_total,
                    'wps_wsp_per_number'        => $wps_wsp_number,
                    'wps_wsp_interval'          => $wps_wsp_interval,
                    'user_name'                 => $user_nicename,
                    'next_payment_date'         => wps_sfw_get_the_wordpress_date_format( $wps_next_payment_date ),
                    'subscriptions_expiry_date' => wps_sfw_get_the_wordpress_date_format( $wps_susbcription_end ),
                ];

                return $wps_subscriptions_data;
            }else{
                return false;
            }
        }
}