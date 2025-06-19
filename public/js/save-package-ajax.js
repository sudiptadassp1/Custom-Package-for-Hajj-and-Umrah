(function( $ ) {
	'use strict';
    $(document).ready(function() {
        $('.view_summary .custom-btn').click(function() {
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

    
            if (!isValid) {
                $('#toaster-warning').fadeIn().delay(3000).fadeOut();
            } else {
                // AJAX request
                jQuery.ajax({
                    url: package_params.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'calculate_cost', // Include the action inside data
                        data: formData // Ensure formData is formatted correctly
                    },
                    success: function(response) {
                        $("#dataTable tbody").empty();
                        function addRow(category, description, cost) {
                            if(!description){
                                description = "N/A";
                            }
                            // Ensure numeric values and format to 2 decimal places
                            let adultCost = parseFloat(cost.adult) || 0;
                            let childrenCost = parseFloat(cost.children) || 0;
                            let infantCost = parseFloat(cost.infant) || 0;
                            let totalCost = parseFloat(cost.total) || 0;
                    
                            let row = `<tr>
                                <td>${category}</td>
                                <td>${description}</td>
                                <td>${adultCost.toFixed(2)}</td>
                                <td>${childrenCost.toFixed(2)}</td>
                                <td>${infantCost.toFixed(2)}</td>
                                <td>${totalCost.toFixed(2)}</td>
                            </tr>`;
                    
                            $("#dataTable tbody").append(row);
                    
                            // Update total values
                            totalAdult += adultCost;
                            totalChildren += childrenCost;
                            totalInfant += infantCost;
                            totalOverall += totalCost;
                        }
                    
                        // Initialize total counters
                        let totalAdult = 0, totalChildren = 0, totalInfant = 0, totalOverall = 0;
                    
                        // Check if received_data exists in response.data
                        if (response.data && response.data.received_data) {
                            $('#summary_object').removeAttr("data-obj").attr("data-obj", JSON.stringify(response.data.received_data));
                            // Loop through top-level items
                            $.each(response.data.received_data, function(key, value) {
                                if (key !== "hotel" && value?.cost) {
                                    addRow(value["Name: "], value.description, value.cost);
                                }
                            });
                    
                            // Handle Hotel Details separately
                            if (response.data.received_data.hotel) {
                                response.data.received_data.hotel.forEach((hotelItem) => {
                                    if (Array.isArray(hotelItem)) {
                                        hotelItem.forEach((nestedHotelItem) => {
                                            let category = nestedHotelItem["Name: "];
                                            let hotelData = nestedHotelItem["0"];
                                            $.each(hotelData, function(city, details) {
                                                addRow(category + " (" + city + ")", details.description, details.cost);
                                            });
                                        });
                                    } else {
                                        let category = hotelItem["Name: "];
                                        let hotelData = hotelItem["0"];
                                        $.each(hotelData, function(city, details) {
                                            addRow(category + " (" + city + ")", details.description, details.cost);
                                        });
                                    }
                                });
                            }
                    
                            // Append total row at the end
                            let totalRow = `<tr class="total-row">
                                <td colspan="2">Total (Per Person): </td>
                                <td>${totalAdult.toFixed(2)}</td>
                                <td>${totalChildren.toFixed(2)}</td>
                                <td>${totalInfant.toFixed(2)}</td>
                                <td>${totalOverall.toFixed(2)}</td>
                            </tr>`;
                            
                            $("#dataTable tbody").append(totalRow);
                            $('.summary-wrap').show();
                        } else {
                            console.log('No data received');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error Calculation cost:', error);
                    }
                });
            }
        });


        $(".request_package").click(function(){
            $('#packagePanel').show();
        });

        $("#packageForm button").on('click', function(e){
            e.preventDefault(); // Prevent page reload
    
            let retrievedData = JSON.parse($("#summary_object").attr("data-obj"));

           

            function extractData(originalData) {
                const result = {};
            
                // Process top-level properties
                $.each(originalData, function(key, value) {
                    if (key === 'hotel') return; // We'll process hotel separately
                    
                    if (value['Name: '] && value.description) {
                        result[value['Name: ']] = value.description;
                    }
                });
            
                // Process hotel array
                $.each(originalData.hotel, function(_, hotelItem) {
                    processHotelItem(hotelItem, result);
                });
            
                return result;
            }
            
            function processHotelItem(item, result) {
                if (Array.isArray(item)) {
                    $.each(item, function(_, subItem) {
                        processHotelItem(subItem, result);
                    });
                } else {
                    const name = item['Name: '];
                    const details = item[0];
                    
                    if (name && details) {
                        const hotelData = {};
                        
                        $.each(['makka', 'madina'], function(_, city) {
                            if (details[city] && details[city].description) {
                                hotelData[city] = details[city].description;
                            }
                        });
                        
                        if (!$.isEmptyObject(hotelData)) {
                            result[name] = hotelData;
                        }
                    }
                }
            }
            
            // Validation function
            function validateUserData(data) {
                let errors = [];

                // Validate Name (not empty)
                if (!data.name) {
                    errors.push("Name is required.");
                }

                // Validate Phone (only numbers, min 10 digits)
                let phonePattern = /^[0-9]{7,15}$/;// Modify range as per need
                if (!phonePattern.test(data.phone)) {
                    errors.push("Invalid phone number. Must contain only numbers and be at least 10 digits long.");
                }

                // Validate Email
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(data.email)) {
                    errors.push("Invalid email format.");
                }
                
                return errors;
            }

            const extractedData = extractData(retrievedData);

            let edit_id = 0; 

            if ($(".page_edit_mode")[0]){
                edit_id = parseInt($('.page_edit_mode').val());
            }
            
             // Collect form data
             let userData = {
                name: $("#name").val(),
                phone: $("#phone").val(),
                email: $("#email").val(),
                mode: edit_id,
                packageData: extractedData 
            };

            // Run validation
            let validationErrors = validateUserData(userData);
            if (validationErrors.length > 0) {
                alert("Validation or Missing Input");
            } else {
                 // Example AJAX request to send all data
                $.ajax({
                    url: package_params.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'save_submitted_package_db', // Include the action inside data
                        data: userData // Ensure formData is formatted correctly
                    },
                    success: function(response) {
                        $('#toaster-success').fadeIn().delay(3000).fadeOut();
                        setTimeout(function() {
                            window.location.href = '/';
                        }, 2000);
                    },
                    error: function() {
                        alert("Error submitting package request.");
                    }
                });
            }
        });

    });

})( jQuery );