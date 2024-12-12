<?php
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
            $product_id   = wps_sfw_get_meta_data( $subcription_id, 'product_id', true );
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

            $limit = get_field('limit', $product_id);
            $boxes = get_field('boxes', $product_id);
    
            $user_nicename = isset( $user->user_nicename ) ? $user->user_nicename : '';
            $wps_subscriptions_data= (object) [
                'subscription_id'           => $subcription_id,
                'product_id'                => $product_id,
                'limit'                     => $limit,
                'parent_order_id'           => $parent_order_id,
                'status'                    => $wps_subscription_status,
                'product_name'              => $product_name,
                'recurring_amount'          => $wps_recurring_total,
                'wps_wsp_per_number'        => $wps_wsp_number,
                'wps_wsp_interval'          => $wps_wsp_interval,
                'user_name'                 => $user_nicename,
                'next_payment_date'         => wps_sfw_get_the_wordpress_date_format( $wps_next_payment_date ),
                'subscriptions_expiry_date' => wps_sfw_get_the_wordpress_date_format( $wps_susbcription_end ),
                'boxes'                     => $boxes,
            ];

            return $wps_subscriptions_data;
        }else{
            return false;
        }
    }
}