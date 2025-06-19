<?php
    function add_hotel_room($location, $saved_rooms = array()) {
        $total = 0;
        foreach (array('single','double','triple','quad','quint') as $room_type) {
            $total += isset($saved_rooms[$room_type]) ? intval($saved_rooms[$room_type]) : 0;
        }
        ?>
        <div class="d-grid gap-2 hotel_rooms_section">
            <label for="">Select Number of Rooms:</label>
            <div class="input-group mb-3 hotel-room-selector">
                <input type="text" disabled class="form-control hotel_no_of_rooms <?php echo $location; ?>" value="<?php echo $total; ?> Rooms" aria-label="Rooms">
                <button class="btn btn-outline-secondary hotel_rooms_popup_button" type="button">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </button>
            </div>
            <div class="hotel_rooms_wrap <?php echo $location; ?>" style="display: none;">
                <div class="hotel_rooms_message" style="display: none;"></div>
                    <?php foreach (array('single'=>'1 Adult', 'double'=>'2 Adults', 'triple'=>'3 Adults', 'quad'=>'4 Adults', 'quint'=>'5 Adults') as $room => $desc): ?>
                    <div class="row">
                        <div class="col">
                            <label for=""><?php echo ucfirst($room); ?> Room<br /><small><?php echo $desc; ?></small></label>
                        </div>
                        <div class="col hotel_counter_wrap hotel_<?php echo $room; ?>">
                            <div class="hotel_decrease" data-room="<?php echo $room; ?>">-</div>
                            <div class="hotel_counter"><?php echo $saved_rooms[$room] ?? 0; ?></div>
                            <div class="hotel_increase" data-room="<?php echo $room; ?>">+</div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row-button">
                    <div class="hotel_close_popup_button">Done</div>
                </div>
            </div>
        </div>
    <?php
    }
?>