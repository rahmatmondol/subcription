<?php
/*
Plugin Name: Subcription Manager
Plugin URI: 
Description: Subcription Manager Plugin
Version: 1.0
Author: Rahmat Mondol
Author URI: www.rahmatmondol.com
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

include( __DIR__ . '/inc/shortcodes/subcription_select_box.php' );
include( __DIR__ . '/inc/functions/get_subcription_info.php' );
include( __DIR__ . '/inc/functions/wc_account_functions.php' );





