(function( $ ) {
	'use strict';
    $(document).ready(function() {
        // Event delegation for dynamically added elements
        $(document).on('click', '.hotel_rooms_popup_button', function() {
            $(this).closest('.hotel_rooms_section').find('.hotel_rooms_wrap').toggle();
        });

        // Initialize the data attributes for each room type based on the displayed counter values
        $(document).ready(function(){
            $('.hotel_rooms_section').each(function(){
            const $section = $(this);
            // For each room type, read the counter text and set the data attribute
            ['single','double','triple','quad','quint'].forEach(function(roomType){
                const count = parseInt($section.find(`.hotel_counter_wrap.hotel_${roomType} .hotel_counter`).text()) || 0;
                updateHotelRoomCount($section, roomType, count);
            });
            updateHotelTotalRooms($section);
            });
        });
        
        $(document).on('click', '.hotel_close_popup_button', function() {
            const $roomsSection = $(this).closest('.hotel_rooms_section');
            const $messageContainer = $roomsSection.find('.hotel_rooms_message');
        
            // Hide any existing message
            $messageContainer.hide();
        
            // Validate rooms: if capacity is insufficient, show message and do not close popup
            if (!validateHotelRooms($roomsSection)) {
                $messageContainer
                .text('The number of rooms selected cannot accommodate all adults. Please select more rooms.')
                .show();
                return;
            }
        
            // If validation passes, close the popup
            $roomsSection.find('.hotel_rooms_wrap').hide();
        });
        
        $(document).on('click', '.hotel_increase, .hotel_decrease', function() {
            const $counter = $(this).siblings('.hotel_counter');
            const roomType = $(this).data('room');
            const $roomsSection = $(this).closest('.hotel_rooms_section');
            let count = parseInt($counter.text());
        
            if ($(this).hasClass('hotel_increase')) {
                count++;
            } else if (count > 0) {
                count--;
            }
        
            $counter.text(count);
            updateHotelRoomCount($roomsSection, roomType, count);
            updateHotelTotalRooms($roomsSection);
        });
        
        // Update the parent's data attribute for a given room type
        function updateHotelRoomCount($roomsSection, roomType, count) {
            switch (roomType) {
                case 'single':
                    $roomsSection.attr('data-hotelSingleRoomCount', count);
                    break;
                case 'double':
                    $roomsSection.attr('data-hotelDoubleRoomCount', count);
                    break;
                case 'triple':
                    $roomsSection.attr('data-hotelTripleRoomCount', count);
                    break;
                case 'quad':
                    $roomsSection.attr('data-hotelQuadRoomCount', count);
                    break;
                case 'quint':
                    $roomsSection.attr('data-hotelQuintRoomCount', count);
                    break;
            }
        }
        
        // Update the total number of rooms displayed in the disabled input
        function updateHotelTotalRooms($roomsSection) {
            const singleRoomCount = parseInt($roomsSection.attr('data-hotelSingleRoomCount')) || 0;
            const doubleRoomCount = parseInt($roomsSection.attr('data-hotelDoubleRoomCount')) || 0;
            const tripleRoomCount = parseInt($roomsSection.attr('data-hotelTripleRoomCount')) || 0;
            const quadRoomCount = parseInt($roomsSection.attr('data-hotelQuadRoomCount')) || 0;
            const quintRoomCount = parseInt($roomsSection.attr('data-hotelQuintRoomCount')) || 0;
        
            const totalRooms = singleRoomCount + doubleRoomCount + tripleRoomCount + quadRoomCount + quintRoomCount;
            $roomsSection.find('.hotel_no_of_rooms').val(`${totalRooms} Rooms`);
        }
        
        // Validate that the total capacity of selected rooms is at least the number of adults
        function validateHotelRooms($roomsSection) {
            const adultCount = parseInt($('.travelars_section .adult .counter').text()) || 0;
            const singleRoomCount = parseInt($roomsSection.attr('data-hotelSingleRoomCount')) || 0;
            const doubleRoomCount = parseInt($roomsSection.attr('data-hotelDoubleRoomCount')) || 0;
            const tripleRoomCount = parseInt($roomsSection.attr('data-hotelTripleRoomCount')) || 0;
            const quadRoomCount = parseInt($roomsSection.attr('data-hotelQuadRoomCount')) || 0;
            const quintRoomCount = parseInt($roomsSection.attr('data-hotelQuintRoomCount')) || 0;
        
            // Calculate the overall capacity based on room types
            const totalRoomsCapacity =
                (singleRoomCount * 1) +
                (doubleRoomCount * 2) +
                (tripleRoomCount * 3) +
                (quadRoomCount * 4) +
                (quintRoomCount * 5);
        
            return totalRoomsCapacity >= adultCount;
        }
  

    });

})( jQuery );
