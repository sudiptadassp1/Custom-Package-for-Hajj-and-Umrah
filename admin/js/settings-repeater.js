(function( $ ) {
	'use strict';
    $(document).ready(function () {
        // Function to append a new route segment
        $('.add_route_segment').on('click', function () {
            // Define the route_segment HTML
            const routeSegmentHTML = `
                <div class="route_segment">
                    <div class="form-group">
                        <label for="destination-from-location">Destination From Location:</label>
                        <input type="text" placeholder="From Location" name="destination_from_location[]" class="form-control destination-from-location" id="destination-from-location" value="">
                    </div>
                    <div class="form-group">
                        <label for="destination-from-airport">Destination From Airport:</label>
                        <select name="destination_from_airport[]" id="destination-from-airport">
                            <option value="Jeddah">Jeddah</option>
                            <option value="Madina">Madina</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <h4 class="segment-divider">To</h4>
                    </div>
                    <div class="form-group">
                        <label for="return-from-airport">Return From Airport:</label>
                        <select name="return_from_airport[]" id="return-from-airport">
                            <option value="Jeddah">Jeddah</option>
                            <option value="Madina">Madina</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="return-from-location">Return From Location:</label>
                        <input type="text" name="return_from_location[]" placeholder="Return Location" class="form-control return-from-location" id="return-from-location" value="">
                    </div>
                    <div class="form-group">
                        <button class="settings_remove_route">
                            <span class="icon">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                                    <path d="M3 6h18v2H3V6zm3 4h12v10a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V10zm2 2v8h8v-8H8zm4-8a3 3 0 0 1 3 3H9a3 3 0 0 1 3-3zm-1 3h2v2h-2V7z"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            `;
    
            // Append the new route segment to the route_wrap
            $('.route_wrap').append(routeSegmentHTML);
    
            // Attach the event listener to the newly added "Remove Route" button
            addRemoveButtonListeners();
        });
    
        // Function to handle removing a route segment
        function addRemoveButtonListeners() {
            $('.settings_remove_route').off('click').on('click', function () {
                $(this).closest('.route_segment').remove();
            });
        }
    
        // Initialize remove button listeners for existing route segments
        addRemoveButtonListeners();


        // Save route data
        $('.save_settings_repeater').on('click', function () {
            // Gather all route segment data
            const routes = [];
    
            $('.route_segment').each(function () {
                const route = {
                    destination_from_location: $(this).find('[name="destination_from_location[]"]').val(),
                    destination_from_airport: $(this).find('[name="destination_from_airport[]"]').val(),
                    return_from_airport: $(this).find('[name="return_from_airport[]"]').val(),
                    return_from_location: $(this).find('[name="return_from_location[]"]').val(),
                };
                routes.push(route);
            });

            
    
            // Send data to the WordPress AJAX handler
            $.ajax({
                url: ajaxurl, // WordPress's AJAX URL
                type: 'POST',
                data: {
                    action: 'save_route_segments',
                    routes: routes, // Send route data
                },
                success: function (response) {
                    if (response.success) {
						$(".selected_repeater.notification_success").empty().append('Data saved successfully');
						location.reload();
                    } else {
						$(".selected_repeater.notification_error").empty().append('Failed to save options');
                    }
                },
                error: function () {
                    alert('Error saving routes.');
                },
            });
        });
    });
    
})( jQuery );