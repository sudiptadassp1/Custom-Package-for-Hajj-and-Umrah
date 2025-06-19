(function( $ ) {
	'use strict';
    $(document).ready(function () {
        // Update shortcode when the select value changes
        $('#Select-style-input').on('change', function () {
            const selectedValue = $(this).val(); // Get the selected option value
            const shortcodeField = $('#shortcode-display');

            if (selectedValue) {
                // Generate the shortcode
                const shortcode = `[custom_package template="${selectedValue}"]`;
                shortcodeField.val(shortcode); // Update the shortcode display

                //Preiew image
                $('.preview-style').empty().append(`<img src="/wp-content/plugins/custom-package-for-hajj-and-umrah/admin/images/preview-${selectedValue}.jpg">`);
            } else {
                // Clear the shortcode if no option is selected
                shortcodeField.val('[shortcode_placeholder]');
            }
        });

        $('#copy-shortcode-btn').on('click', function () {
            const shortcode = $('#shortcode-display').val();
            const tooltip = $('#tooltip');
    
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(shortcode).then(function () {
                    // Show the tooltip
                    tooltip.addClass('show');
    
                    // Hide the tooltip after 2 seconds
                    setTimeout(function () {
                        tooltip.removeClass('show');
                    }, 2000);
                }).catch(function (err) {
                    console.error('Error copying shortcode: ', err);
                });
            } else {
                // Fallback for unsupported Clipboard API
                const tempTextarea = $('<textarea>');
                $('body').append(tempTextarea);
                tempTextarea.val(shortcode).select();
                try {
                    document.execCommand('copy');
    
                    // Show the tooltip
                    tooltip.addClass('show');
    
                    // Hide the tooltip after 2 seconds
                    setTimeout(function () {
                        tooltip.removeClass('show');
                    }, 2000);
                } catch (err) {
                    console.error('Fallback copy failed: ', err);
                }
                tempTextarea.remove();
            }
        });
    });
      
    
})( jQuery );