<?php
// select box
add_shortcode( 'subcription_select_box', 'subcription_select_box' );
function subcription_select_box() {
    $subcription = get_user_subscriptions();
    ob_start();
    ?>
    <div class="select-box-container">
       
        <?php if($subcription): ?>
            <div class="box-container">
                <h2 class="text-center mb-1"><?php esc_html_e( 'Package', 'subscription' ); ?>:<span><?php echo $subcription->product_name ?></span></h2>
                <p class="text-center mb-1"><?php esc_html_e( 'Choose '.$subcription->limit.' box for your subscription', 'subscription' ); ?></p>
                <input type="hidden" id="limit" value="<?php echo $subcription->limit ?>">
                <input type="hidden" id="status" value="<?php echo $subcription->status ?>">
                <div class="boxes row">
                    <?php foreach ( $subcription->boxes as $box_post ): ?>
                        <div class="box col-md-4 p-2" data-id="<?php echo esc_attr( $box_post->ID ); ?>" data-name="<?php echo esc_attr( $box_post->post_title ); ?>">
                            <img src="<?php echo esc_url( get_the_post_thumbnail_url( $box_post->ID, 'full' ) ); ?>" alt="<?php echo esc_attr( $box_post->post_title ); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="selected-boxes text-center mt-3">
                    <div class="" id="selected-boxes"></div>
                    <button class="btn disabled" id="active-selected-boxes">Active Selected Boxes</button>
                </div>
            </div>
        <?php else : ?>
            <div class="no-package">
                <h2 class="text-center"><?php esc_html_e( 'You dont have any subscription', 'subscription' ); ?></h2>
                <p class=""><?php esc_html_e( 'Please select a package', 'subscription' ); ?></p>
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'select-boxe' ) ); ?>">Select Package</a>
            </div>
            
        <?php endif; ?>
        <pre>
            <?php print_r($subcription); ?>
        </pre>
    </div>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php
    return ob_get_clean();
}    