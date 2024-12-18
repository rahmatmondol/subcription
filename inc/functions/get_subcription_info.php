<?php
// Get user subscription details
function get_user_subscriptions() {
    // Get the current user
    $user = wp_get_current_user();

    // Ensure user is logged in
    if ( ! $user || empty( $user->ID ) ) {
        return false;
    }

    // Fetch WooCommerce orders for the user
    $args = array(
        'customer_id'    => $user->ID,  // Filter orders by customer ID
        'post_status'    => 'any',     // Optional: retrieve orders with any status
        'posts_per_page' => -1,        // Retrieve all orders
    );

    $orders = wc_get_orders( $args );

    // Return false if no orders are found
    if ( empty( $orders ) ) {
        return false;
    }


//     	return $orders;

    // Loop through orders to retrieve subscription data
    foreach ( $orders as $order ) {
        $order_id = $order->get_id();

        $have_subscription = $order->get_meta( 'wps_sfw_order_has_subscription' );
		
         // Skip if the order is not a subscription
        if (  !$have_subscription ) {
            continue;
        }
		
        // Retrieve subscription ID from the order meta
        $subscription_id = $order->get_meta( 'wps_subscription_id' );
		
		
        // Retrieve subscription meta data
        $subscription_status = wps_sfw_get_meta_data( $subscription_id, 'wps_subscription_status', true );
        $product_id          = wps_sfw_get_meta_data( $subscription_id, 'product_id', true );
        $parent_order_id     = wps_sfw_get_meta_data( $subscription_id, 'wps_parent_order', true );
        $product_name        = wps_sfw_get_meta_data( $subscription_id, 'product_name', true );
        $recurring_total     = wps_sfw_get_meta_data( $subscription_id, 'wps_recurring_total', true );
        $wps_number          = wps_sfw_get_meta_data( $subscription_id, 'wps_sfw_subscription_number', true );
        $wps_interval        = wps_sfw_get_meta_data( $subscription_id, 'wps_sfw_subscription_interval', true );
        $next_payment_date   = wps_sfw_get_meta_data( $subscription_id, 'wps_next_payment_date', true );
        $subscription_end    = wps_sfw_get_meta_data( $subscription_id, 'wps_susbcription_end', true );
        $customer_id         = wps_sfw_get_meta_data( $subscription_id, 'wps_customer_id', true );

        // Retrieve additional fields (ACF or custom fields)
        $limit = get_field( 'limit', $product_id );
        $boxes = get_field( 'boxes', $product_id );
        $blogs = get_field( 'blogs', $product_id );

        // Retrieve customer user data
        $customer = get_user_by( 'id', $customer_id );
        $user_nicename = $customer ? $customer->user_nicename : '';

        // Format subscription data
        $subscription_data = (object) [
            'subscription_id'           => $subscription_id,
            'product_id'                => $product_id,
            'limit'                     => $limit,
            'parent_order_id'           => $parent_order_id,
            'status'                    => $subscription_status,
            'product_name'              => $product_name,
            'recurring_amount'          => $recurring_total,
            'wps_subscription_number'   => $wps_number,
            'wps_subscription_interval' => $wps_interval,
            'user_name'                 => $user_nicename,
            'next_payment_date'         => wps_sfw_get_the_wordpress_date_format( $next_payment_date ),
            'subscription_expiry_date'  => wps_sfw_get_the_wordpress_date_format( $subscription_end ),
            'boxes'                     => $boxes,
            'blogs'                     => $blogs,
        ];

        // Return subscription data (returning first active subscription)
        return $subscription_data;
    }

    // Return false if no subscriptions found in orders
    return false;
}
?>
