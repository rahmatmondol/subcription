<?php
// select box
add_shortcode( 'subcription_select_box', 'subcription_select_box' );
function subcription_select_box() {
    $subcription = get_user_subscriptions();
    $user = wp_get_current_user();
    $user_boxes = json_decode( get_user_meta( $user->ID, 'active_boxes', true ), true ) ?: array();
    ob_start();
    ?>
    <div class="select-box-container">
       
        <?php if($subcription): ?>
            <div class="box-container">
                    <h2 class="text-center mb-1"><?php esc_html_e( 'Package', 'subscription-Manager' ); ?>:<span><?php echo $subcription->product_name ?></span></h2>
                    <p class="text-center mb-1"><?php esc_html_e( 'Choose '.$subcription->limit.' box for your subscription', 'subscription-Manager' ); ?></p>
                    <input type="hidden" id="limit" value="<?php echo $subcription->limit ?>">
                    <input type="hidden" id="status" value="<?php echo $subcription->status ?>">
                <?php if($user_boxes): ?>
                    <div class="boxes row">
                        <?php foreach ( $subcription->boxes as $box_post ): ?>
                            <?php if ( in_array( $box_post->ID, $user_boxes ) ) : ?>
                                <div class="selected-box col-md-4 p-2 <?php echo $subcription->status !== 'cancelled' ? 'disabled' : '' ?>" data-id="<?php echo esc_attr( $box_post->ID ); ?>" data-name="<?php echo esc_attr( $box_post->post_title ); ?>">
                                    <a href="<?php echo esc_url( get_the_permalink( $box_post->ID ) ); ?>" target="_blank">
                                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $box_post->ID, 'full' ) ); ?>" alt="<?php echo esc_attr( $box_post->post_title ); ?>">
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="boxes row">
                        <?php foreach ( $subcription->boxes as $box_post ): ?>
                            <div class="box col-md-4 p-2 <?php echo $subcription->status == 'cancelled' ? 'disabled' : '' ?>" data-id="<?php echo esc_attr( $box_post->ID ); ?>" data-name="<?php echo esc_attr( $box_post->post_title ); ?>">
                                <img src="<?php echo esc_url( get_the_post_thumbnail_url( $box_post->ID, 'full' ) ); ?>" alt="<?php echo esc_attr( $box_post->post_title ); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="selected-boxes text-center mt-3">
                        <div class="" id="selected-boxes"></div>
                        <button class="btn disabled" id="active-selected-boxes"><?php esc_html_e( 'Active Selected Boxes', 'subscription-Manager' ); ?></button>
                    </div>
            <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="no-package">
                <h2 class="text-center"><?php esc_html_e( 'You dont have any subscription', 'subscription-Manager' ); ?></h2>
                <p class=""><?php esc_html_e( 'Please select a package', 'subscription-Manager' ); ?></p>
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'select-boxe' ) ); ?>"><?php esc_html_e( 'Select a package', 'subscription-Manager' ); ?></a>
            </div>
            
        <?php endif; ?>
        <!-- <pre>
            <?php print_r($user_boxes); ?>
        </pre> -->
    </div>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script>
        jQuery(document).ready(function ($) {

            const deactiveBoxes = () => {
                const status = '<?php echo $subcription->status ?>';
                const boxes = JSON.parse('<?php echo json_encode($user_boxes) ?>');
                if (status === 'cancelled' && boxes.length > 0) {
                    $.post('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                        action: 'deactive_selected_boxes'
                    })
                    .done(function (response) {
                        console.log(response);
                        location.reload();
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText);
                    });
                }
            }
            deactiveBoxes();

            $('.select-box-container .box').on('click', function () {
                var boxId = $(this).data('id');
                var limit = $('#limit').val();

                if ($('.select-box-container .box.active').length < limit || limit == 0) {
                    $(this).toggleClass('active');
                    if ($('.select-box-container .box.active').length == limit) {
                        $('.select-box-container .box:not(.active)').addClass('disabled');
                        $('#active-selected-boxes.disabled').removeClass('disabled');
                    } else {
                        $('.select-box-container .box.disabled').removeClass('disabled');
                        $('#active-selected-boxes').addClass('disabled');
                    }
                } else if ($('.select-box-container .box.active').length == limit && $(this).hasClass('active')) {
                    $(this).toggleClass('active');
                    $('#active-selected-boxes').addClass('disabled');
                    $('.select-box-container .box.disabled').removeClass('disabled');
                } else {
                    alert('Maximum number of boxes reached.');
                }
            });

            $('#active-selected-boxes').on('click', function () {
                var selectedBoxes = $('.select-box-container .box.active').map(function () {
                    return $(this).data('id');
                }).get()

                // ajax call
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'save_selected_boxes',
                        selected_boxes: selectedBoxes
                    },
                    success: function(response) {
                        if (response.success) {
                            // reload page
                            location.reload();
                        } else {
                            console.error('Error:', response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });

            });


            });

    </script>
<?php
    return ob_get_clean();
}    