<?php
// active selected boxes ajax
add_action( 'wp_ajax_save_selected_boxes', 'save_selected_boxes' );
add_action( 'wp_ajax_nopriv_save_selected_boxes', 'save_selected_boxes' );

function save_selected_boxes() {
    if ( empty( $_POST['selected_boxes'] ) ) {
        wp_send_json_error( 'No boxes selected.' );
    }

    $user = wp_get_current_user();
    $selected_boxes = isset( $_POST['selected_boxes'] ) ? $_POST['selected_boxes'] : array();

    if ( ! update_user_meta( $user->ID, 'active_boxes', json_encode( $selected_boxes ) ) ) {
        wp_send_json_error( 'Failed to save boxes.' );
    }

    wp_send_json_success( 'Boxes saved successfully.' );
}

// deactive selected boxes ajax
add_action( 'wp_ajax_deactive_selected_boxes', 'deactive_selected_boxes' );
add_action( 'wp_ajax_nopriv_deactive_selected_boxes', 'deactive_selected_boxes' );

function deactive_selected_boxes() {
    $user = wp_get_current_user();
    
    if ( delete_user_meta( $user->ID, 'active_boxes' ) ) {
        wp_send_json_success( 'Boxes deactivated successfully.' );
    } else {
        wp_send_json_error( 'Failed to deactivate boxes.' );
    }
}
