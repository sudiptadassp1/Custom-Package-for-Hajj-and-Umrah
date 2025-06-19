(function($) {
    var flag = 0;
    function template(counter){
        const html = '<div class="segment-inner-wrap cost-'+counter+'">'
            +'<span class="delete-segment" data-segment="'+counter+'">X</span>'
            +'<div class="date-time-span">'
                +'<div class="time-field-wrap">'
                    +'<div class="input-group">'
                        +'<label>Enter From Date:</label>'
                        +'<input type="date" class="from-date-input from-date-'+counter+'" placeholder="Enter From Date"/>'
                    +'</div>'
                    +'<div class="input-group">'
                        +'<label>Enter To Date:</label>'
                        +'<input type="date" class="to-date-input to-date-'+counter+'" placeholder="Enter To Date"/>'
                    +'</div>'
                +'</div>'
                +'<div class="costing-wrap">'
                    +'<h5 class="costing-label">Cost Within Date Range:</h5><hr/>'
                    +'<div class="room-cost-wrap">'
                        +'<div class="room-type single room">'
                            +'<label for="">Single Bed:</label>'
                            +'<input type="number" class="room-cost single-room weekday" placeholder="Weekdays Cost">'
                            +'<input type="number" class="room-cost single-room weekend" placeholder="Weekend Cost">'
                        +'</div>'
                        +'<div class="room-type double room">'
                            +'<label for="">Double Bed:</label>'
                            +'<input type="number" class="room-cost double-room weekday" placeholder="Weekdays Cost">'
                            +'<input type="number" class="room-cost double-room weekend" placeholder="Weekend Cost">'
                        +'</div>'
                        +'<div class="room-type triple room">'
                            +'<label for="">Triple Bed:</label>'
                            +'<input type="number" class="room-cost triple-room weekday" placeholder="Weekdays Cost">'
                            +'<input type="number" class="room-cost triple-room weekend" placeholder="Weekend Cost">'
                        +'</div>'
                        +'<div class="room-type quad room">'
                            +'<label for="">Quad Bed:</label>'
                            +'<input type="number" class="room-cost quad-room weekday" placeholder="Weekdays Cost">'
                            +'<input type="number" class="room-cost quad-room weekend" placeholder="Weekend Cost">'
                        +'</div>'
                        +'<div class="room-type quint room">'
                            +'<label for="">Quint Bed:</label>'
                            +'<input type="number" class="room-cost quint-room weekday" placeholder="Weekdays Cost">'
                            +'<input type="number" class="room-cost quint-room weekend" placeholder="Weekend Cost">'
                        +'</div>'
                    +'</div>'
                    +'<div class="food-cost-wrap">'
                        +'<div class="food-type breakfast food">'
                            +'<label for="">Breakfast:</label>'
                            +'<input type="number" class="food-cost breakfast weekday" placeholder="Weekdays Cost">'
                            +'<input type="number" class="food-cost breakfast weekend" placeholder="Weekend Cost">'
                        +'</div>'
                        +'<div class="food-type half-board food">'
                            +'<label for="">Half Board:</label>'
                            +'<input type="number" class="food-cost half-board weekday" placeholder="Weekdays Cost">'
                            +'<input type="number" class="food-cost half-board weekend" placeholder="Weekend Cost">'
                        +'</div>'
                        +'<div class="food-type full-board food">'
                            +'<label for="">Full Board:</label>'
                            +'<input type="number" class="food-cost full-board weekday" placeholder="Weekdays Cost">'
                            +'<input type="number" class="food-cost full-board weekend" placeholder="Weekend Cost">'
                        +'</div>'
                    +'</div>'
                +'</div>'
            +'</div>'
        +'</div>';
        return html;
    }
    
    $(document).ready(function() {
        var flag = 0;
        $('.add-segment-btn').on('click', function(e){
            e.preventDefault();

            
            const existing_repeater = $('.hotel-segment-wrap .segment-inner-wrap').length;
            flag = existing_repeater + 1;
            $('.hotel-segment-wrap').append(template(flag));
            
        });

        // Delete particular cost segment
        $('.hotel-segment-wrap').on('click', '.delete-segment', function(){
            
            const segment_id = $(this).data('segment');
            $(this).parent().remove();
            const updated_repeater = $('.hotel-segment-wrap .segment-inner-wrap').length;
            for(i = segment_id; i<= updated_repeater; i++){
                $('.hotel-segment-wrap .segment-inner-wrap:nth-child('+i+')').removeClass('cost-'+(i+1)).addClass('cost-'+i);
            }
        });



        //Save hotel cost meta data

        $(".save-meta-data").on('click', function(e){
            e.preventDefault();
			 const iframeHtml = document.getElementById('map-location').value;
            
            // Create a temporary div to parse the iframe HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = iframeHtml;
            
            // Find the iframe element and get its src attribute
            const iframeSrc = tempDiv.querySelector('iframe') ? tempDiv.querySelector('iframe').getAttribute('src') : null;
			
     
            const no_of_repeater = $('.hotel-segment-wrap .segment-inner-wrap').length;
            const hotel_cost_obj = {};
            const hotel_basic_info = {
                "hotel_id": $('.hotel_id').val(),
                "road_name": $('#road-name').val(),
                "city_name": $('#city-name').val(),
                "distance": $('#distance-meter').val(),
                "map": iframeSrc,
            };

            for (var i = 0; i < no_of_repeater; i++){
                
                hotel_cost_obj[i] = {
                    'from_date': $('.segment-inner-wrap.cost-'+(i+1)+' .from-date-input').val(),
                    'to_date': $('.segment-inner-wrap.cost-'+(i+1)+' .to-date-input').val(),
                    'single-room': {
                        "weekday": $('.segment-inner-wrap.cost-'+(i+1)+' .single-room.weekday').val(),
                        "weekend": $('.segment-inner-wrap.cost-'+(i+1)+' .single-room.weekend').val(),
                    },
                    'double-room': {
                        "weekday": $('.segment-inner-wrap.cost-'+(i+1)+' .double-room.weekday').val(),
                        "weekend": $('.segment-inner-wrap.cost-'+(i+1)+' .double-room.weekend').val(),
                    },
                    'triple-room': {
                        "weekday": $('.segment-inner-wrap.cost-'+(i+1)+' .triple-room.weekday').val(),
                        "weekend": $('.segment-inner-wrap.cost-'+(i+1)+' .triple-room.weekend').val(),
                    },
                    'quad-room': {
                        "weekday": $('.segment-inner-wrap.cost-'+(i+1)+' .quad-room.weekday').val(),
                        "weekend": $('.segment-inner-wrap.cost-'+(i+1)+' .quad-room.weekend').val(),
                    },
                    'quint-room': {
                        "weekday": $('.segment-inner-wrap.cost-'+(i+1)+' .quint-room.weekday').val(),
                        "weekend": $('.segment-inner-wrap.cost-'+(i+1)+' .quint-room.weekend').val(),
                    },
                    'breakfast': {
                        "weekday": $('.segment-inner-wrap.cost-'+(i+1)+' .breakfast.weekday').val(),
                        "weekend": $('.segment-inner-wrap.cost-'+(i+1)+' .breakfast.weekend').val(),
                    },
                    'half-board': {
                        "weekday": $('.segment-inner-wrap.cost-'+(i+1)+' .half-board.weekday').val(),
                        "weekend": $('.segment-inner-wrap.cost-'+(i+1)+' .half-board.weekend').val(),
                    },
                    'full-board': {
                        "weekday": $('.segment-inner-wrap.cost-'+(i+1)+' .full-board.weekday').val(),
                        "weekend": $('.segment-inner-wrap.cost-'+(i+1)+' .full-board.weekend').val(),
                    },
                }
            }
            
            

            $.ajax({
                type : "post",
                url : adminAjax.ajaxurl,
                data : {
                    action: "save_hotel_meta_data", 
                    hotel_cost_obj : hotel_cost_obj,
                    hotel_basic_info: hotel_basic_info
                },
                success: function(response) {
                    $('#publishing-action #publish').click();
                },
                error: function(xhr) {
                    toastr.error('Some error occurred.');
                }
            })
            
        });
    });

    

})(jQuery);