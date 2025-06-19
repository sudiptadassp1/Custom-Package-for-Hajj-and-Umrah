document.addEventListener("DOMContentLoaded", function () {
    let hotelContainer = document.getElementById("hotel-container");

    // Use event delegation for distance sliders
    hotelContainer.addEventListener("input", function (event) {
        if (event.target.matches("[id$='-distance-slider']")) {
            let location = event.target.id.replace("-distance-slider", "");
            let distanceValue = document.getElementById(location + "-distance-value");
            if (distanceValue) {
                distanceValue.textContent = event.target.value + " Meter";
            }
        }
    });

    hotelContainer.addEventListener("change", function (event) {
        if (event.target.matches("[id$='-distance-slider']")) {
            let location = event.target.id.replace("-distance-slider", "");
            let hotelTypeSelect = document.getElementById(location + "-Select-style-input");
            let hotelTypeId = hotelTypeSelect ? hotelTypeSelect.value : null;
            fetchHotelNames(hotelTypeId, location);
        }

        if (event.target.matches("[id$='-Select-style-input']")) {
            let location = event.target.id.replace("-Select-style-input", "");
            fetchHotelNames(event.target.value, location);
        }
    });
});


function fetchHotelNames(hotelTypeId, location) {
    // Get the selected distance value
    const distanceSlider = document.getElementById(location + "-distance-slider");
    const distance = distanceSlider ? distanceSlider.value : 0;

    // Validate input
    if (!hotelTypeId || hotelTypeId === "-- Select --") {
        hotelTypeId = null; // Omit hotel type if not selected
    }

    // Get the hotel name select element
    const hotelNameSelect = document.getElementById(location + "-hotel-name-select");
    if (!hotelNameSelect) return;

    // Add a temporary loading option
    hotelNameSelect.innerHTML = '<option value="" disabled>Loading...</option>';

    // Prepare data for AJAX request
    const data = {
        action: 'fetch_hotel_names',
        location: location,
    };

    // Add hotel type to data if selected
    if (hotelTypeId) {
        data.hotel_type_id = hotelTypeId;
    }

    // Add distance to data if applicable
    if (distance > 0) {
        data.distance = distance;
    }

    // AJAX request
    jQuery.ajax({
        url: ajax_params.ajax_url,
        type: 'POST',
        data: data,
        success: function(response) {
            // Update the hotel name select options
            hotelNameSelect.innerHTML = response?.data || '<option value="" disabled>No hotels found</option>';
        },
        error: function(xhr, status, error) {
            console.log('Error fetching hotel names:', error);
            // Show an error message in the select input
            hotelNameSelect.innerHTML = '<option value="" disabled>Error loading hotels</option>';
        }
    });
}