jQuery(document).ready(function ($) {
    // Function to toggle ACF group visibility.
    function toggleACFGroup() {
        if ($('#_wps_sfw_product').is(':checked')) {
            $('#acf-group_675b4923e73f4').show(); // Show the ACF group.
        } else {
            $('#acf-group_675b4923e73f4').hide(); // Hide the ACF group.
        }
    }

    // Initial check on page load.
    toggleACFGroup();

    console.log('hello');

    // Listen for changes on the checkbox.
    $('#_wps_sfw_product').on('change', function () {
        toggleACFGroup();
    });
});
