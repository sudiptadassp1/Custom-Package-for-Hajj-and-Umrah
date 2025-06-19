(function( $ ) {
	'use strict';

    $(document).ready(function($) {

        $('.save_for_later button.custom-btn').on('click', function(){
            $('.panel.save-forlater-wrapper').show();
        })

        $('.save-forlater-submit').on('click', function(){
            let isValid = true;
            let formData = {};

    
            // Check Travellers
            if($('.travelars_section').length){
                if ($('.travelars_wrap .adult .counter').text() === "0") {
                    isValid = false;
                } else {
                    formData.travellers = { 
                        adult : parseInt($('.travelars_wrap .adult .counter').text()),
                        children : parseInt($('.travelars_wrap .children .counter').text()),
                        infant : parseInt($('.travelars_wrap .infant .counter').text())

                    };
                }
            }
    
            // Check Flight Type
            if($('#flight_ticket_class').length){
                if ($('#flight_ticket_class').val() === "") {
                    isValid = false;

                } else {
                    formData.flightType = $('#flight_ticket_class').val();
                }
            }
    
            // Check Air Ticket Type
            if($('.air-ticket-type').length){
                if ($('input[name="air_ticket_type"]:checked').length === 0) {
                    isValid = false;

                } else {
                    formData.airTicketType = $('input[name="air_ticket_type"]:checked').val();
                }
            }
    
            // Check Airlines
            if($('#airlines-name').length){
                if ($('#airlines-name').val() === "") {
                    isValid = false;

                } else {
                    formData.airlines = $('#airlines-name').val();
                }
            }
    
            // Check Route
            if($('#air-route').length){
                if ($('#air-route').val() === "-- Select --") {
                    isValid = false;
                } else {
                    formData.route = $('#air-route').val();
                }
            }
    
            // Check Visa Service
            if($('.visa-service-wrap').length){
                if ($('input[name="visa-service"]:checked').length === 0) {
                    isValid = false;
                } else {
                    formData.visaService = $('input[name="visa-service"]:checked').val();
                }
            }
    
            // Check Guide
            if($('.guide-wrap').length){
                if ($('input[name="tour-guide"]:checked').length === 0) {
                    isValid = false;
                } else {
                    // Initialize guide array if not already defined
                    if (!formData.guide) formData.guide = [];

                    $('input[name="tour-guide"]:checked').each(function() {
                        formData.guide.push($(this).val());
                    });
                }
            }
    
            // Check Transport
            if($('.transport-wrap').length){
                if ($('.transport-wrap input[type="checkbox"]:checked').length === 0) {
                    isValid = false;
                } else {
                    formData.transport = [];
                    $('.transport-wrap input[type="checkbox"]:checked').each(function() {
                        let value = $(this).val();
                        if (/_\d+$/.test(value)) {  // Match values ending with _ followed by digits
                            formData.transport.push(value);
                        }
                        
                    });
                }
            }

            //Check Hotel type
            if($('.hotel-type-wrap').length){
                let makkaHotelType = $("#makka-Select-style-input").val();  // Select using ID only
                let madinaHotelType = $("#madina-Select-style-input").val(); // Select using ID only
            
                if (makkaHotelType && makkaHotelType !== "0" && madinaHotelType && madinaHotelType !== "0") {
                    formData.hoteltaxonomy = {
                        makka: makkaHotelType,
                        madina: madinaHotelType
                    };
                } else {
                    isValid = false;
                }
            }
            
            //Check Hotel name
            if ($('.hotel-name-wrap').length) {
                let makkaHotel = $("#makka-hotel-name-select").val();  // Select using ID only
                let madinaHotel = $("#madina-hotel-name-select").val(); // Select using ID only
            
                if (makkaHotel && makkaHotel !== "0" && madinaHotel && madinaHotel !== "0") {
                    formData.hotelId = {
                        makka: makkaHotel,
                        madina: madinaHotel
                    };

                } else {
                    isValid = false;
                }
            }

    
            // Check Hotel Fields (Makka and Madina)
            if($('.hotel-date-range-wrap').length){
                if (($('.makka-hotel .stay-from').val() === 0) && ($('.makka-hotel .stay-to').val() === 0) && ($('.madina-hotel .stay-from').val() === 0) && ($('.madina-hotel .stay-to').val() === 0)) {
                    isValid = false;
                } else {
                    formData.hotelStay = {
                        makka: {
                            from: $('.makka-hotel .stay-from').val(),
                            to: $('.makka-hotel .stay-to').val()
                        },
                        madina: {
                            from: $('.madina-hotel .stay-from').val(),
                            to: $('.madina-hotel .stay-to').val()
                        }
                    };
                }
            }
    
            // Function to trim the last digit
            function trimLastDigit(value) {
                let numStr = value.trim(); // Remove spaces
                if (numStr.length > 1) {
                    return parseInt(numStr.slice(0, -1), 10) || 0; // Remove last digit and convert to integer
                }
                return 0; // If it's a single digit, return 0
            }


            // Check Rooms
            if ($('.hotel_no_of_rooms').length) {
                if (($('.hotel_no_of_rooms.makka').val() === "0 Rooms") && ($('.hotel_no_of_rooms.madina').val() === "0 Rooms")) {
                    isValid = false;
                } else {
                    // Ensure formData.rooms is initialized
                    formData.rooms = {
                        makka: {
                            single: $('.hotel_rooms_wrap.makka .hotel_single .hotel_counter').text(),
                            double: $('.hotel_rooms_wrap.makka .hotel_double .hotel_counter').text(),
                            triple: $('.hotel_rooms_wrap.makka .hotel_triple .hotel_counter').text(),
                            quad: $('.hotel_rooms_wrap.makka .hotel_quad .hotel_counter').text(),
                            quint: $('.hotel_rooms_wrap.makka .hotel_quint .hotel_counter').text(),
                        },
                        madina: {
                            single: $('.hotel_rooms_wrap.madina .hotel_single .hotel_counter').text(),
                            double: $('.hotel_rooms_wrap.madina .hotel_double .hotel_counter').text(),
                            triple: $('.hotel_rooms_wrap.madina .hotel_triple .hotel_counter').text(),
                            quad: $('.hotel_rooms_wrap.madina .hotel_quad .hotel_counter').text(),
                            quint: $('.hotel_rooms_wrap.madina .hotel_quint .hotel_counter').text(),
                        }
                    };

                }
            }
    
            // Check Food
            if($('.food-section').length){
                let checkedMealPlans = {};
        
                $(".food-section").each(function() {
                    let sectionId = $(this).attr("id").replace("-food", "");
                    let yesRadio = $(`#food-yes-${sectionId}`);
                    
                    if (yesRadio.prop("checked")) {
                        let checkedIds = $(this).find(".food-options input[type='checkbox']:checked").map(function() {
                            return this.id;
                        }).get();
                        
                        if (checkedIds.length > 0) {
                            checkedMealPlans[sectionId] = checkedIds;
                        }
                    }
                });
                formData.food = checkedMealPlans;
            }

    
            // Check Message
            if($('.hotel_message_input').length){
                if ($('.hotel_message_input').val() != "") {
                    formData.message = {
                        makka: $('.hotel_message_input.makka').val(),
                        madina: $('.hotel_message_input.madina').val(),
                    }
                }
            }

            console.log(formData);
            


            if($('#save-forlater-name').val() != ""){
                $.ajax({
                    url: save_later_params.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'save_save_for_later_db', // Include the action inside data
                        packageName: $('#save-forlater-name').val(),
                        data: formData // Ensure formData is formatted correctly
                    },
                    success: function(response) {
                        if(response.success === false){
                            if(response.data.message === "User not logged in. Please log in to continue."){
                                location.href = response.data.redirect;
                            }
                        }else{
                            $('#toaster-success').fadeIn().delay(3000).fadeOut();
                            setTimeout(function() {
                                window.location.href = '/';
                            }, 2000);
                        }
                        
                    },
                    error: function() {
                        alert("Error submitting package request.");
                    }
                });
            }else{
                alert("Please provide name");
            }
        })
    });
})( jQuery );



