<?php 
// Function to display the current post ID in the header
function display_single_post_id_in_header() {
    // Check if the user is logged in
    if ( is_user_logged_in() ) {
        if ( is_single() && get_post_type() === 'box') {
            $subcription = get_user_subscriptions();
            $user = wp_get_current_user();
            $user_boxes = json_decode( get_user_meta( $user->ID, 'active_boxes', true ), true ) ?: array();

            if(!$subcription){
                wp_redirect( get_permalink( wc_get_page_id( 'myaccount' ) ) . 'select-boxe' );
                exit;
            }elseif($subcription->status === 'cancelled'){
                wp_redirect( get_permalink( wc_get_page_id( 'myaccount' ) ) . 'select-boxe' );
                delete_user_meta( $user->ID, 'active_boxes' );
                exit;
            }

            // Check if the current post ID is in the user's boxes
            $post_id = get_the_ID();
            if (!in_array($post_id, $user_boxes)) {
                // redirect to my account page
                wp_safe_redirect( get_permalink( wc_get_page_id( 'myaccount' ) ) . 'select-boxe' );
                exit;
            }
        }
    }else{
        wp_redirect( wp_login_url() );
    }

}

// Hook the function to the wp_head action
add_action('wp_head', 'display_single_post_id_in_header');