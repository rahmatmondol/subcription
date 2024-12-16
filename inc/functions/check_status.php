<?php 
function display_single_post_id_in_header() {
    // Check if the current page is a single post of post type 'box'
    if ( is_single() && get_post_type() === 'box' ) {
        // Check if the user is logged in
        if ( ! is_user_logged_in() ) {
            // Display a permission error message and exit
            wp_die(
                __( 'You do not have permission to view this page.', 'subscription-Manager' ),
                __( 'Access Denied', 'subscription-Manager' ),
                array( 'response' => 403 )
            );
        }

        // Get the current user
        $user = wp_get_current_user();

        // Skip for administrators
        if ( in_array( 'administrator', (array) $user->roles, true ) ) {
            return;
        }

        // Fetch user subscription details
        $subscription = get_user_subscriptions(); // Assuming this function returns subscription details
        $user_boxes = json_decode( get_user_meta( $user->ID, 'active_boxes', true ), true ) ?: array();

        // Handle no subscription
        if ( ! $subscription ) {
            wp_die(
                __( 'You do not have an active subscription.', 'subscription-Manager' ),
                __( 'Access Denied', 'subscription-Manager' ),
                array( 'response' => 403 )
            );
        }

        // Handle cancelled subscription
        if ( $subscription->status === 'cancelled' ) {
            if($user_boxes){
                update_user_meta( $user->ID, 'active_boxes', $user_boxes );
            }
            wp_die(
                __( 'Your subscription has been cancelled.', 'subscription-Manager' ),
                __( 'Access Denied', 'subscription-Manager' ),
                array( 'response' => 403 )
            );
        }

        // Check if the current post ID is in the user's active boxes
        $post_id = get_the_ID();
        if ( ! in_array( $post_id, $user_boxes, true ) ) {
            wp_die(
                __( 'You do not have access to this box.', 'subscription-Manager' ),
                __( 'Access Denied', 'subscription-Manager' ),
                array( 'response' => 403 )
            );
            exit;
        }
    }
}

// Hook the function to the wp_head action
add_action( 'wp_head', 'display_single_post_id_in_header' );
