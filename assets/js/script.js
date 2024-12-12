jQuery(document).ready(function ($) {

    var status = $('#status').val();
    if (!status == 'cancelled') {
        $('.select-box-container .box:not(.active)').addClass('disabled');
        $('#active-selected-boxes').addClass('disabled');
    }

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
        }).get().join(',');
        $('#selected-boxes').html(selectedBoxes);
    });


});
