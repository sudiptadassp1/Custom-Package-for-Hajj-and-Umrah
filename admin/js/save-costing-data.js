(function( $ ) {
	'use strict';
    $(document).ready(function () {
        // Save route data
        $('.save_costing_data').on('click', function () {
            let input_field_costs = {};
            $('.cost-input-container .cphu-row input').each(function() {
                const id = $(this).attr('id'); // Get the ID of the input
                const value = $(this).val(); // Get the current value
                if(value != ""){
                    input_field_costs[id] = value; // Store the value in an object
                }
                
            });
            
            // Send data to the WordPress AJAX handler
            $.ajax({
                url: saveCostAjax.ajaxurl, // WordPress's AJAX URL
                type: 'POST',
                data: {
                    action: 'save_costing_data',
                    data: input_field_costs,
                    cost_nonce: saveCostAjax.nonce // Sending the nonce
                },
                success: function (response) {
                    if (response.success) {
						$(".costing_data.notification_success").empty().append('Data saved successfully');
						location.reload();
                    } else {
						$(".costing_data.notification_error").empty().append('Failed to save options');
                    }
                },
                error: function () {
                    alert('Error saving data.');
                },
            });
        });
    });
    
})( jQuery );