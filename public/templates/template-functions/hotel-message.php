<?php
    function get_hotel_message($location, $saved_value = ''){
        ?>
        <label class="fw-bold">Message:</label>
        <input type="text" class="hotel_message_input <?php echo $location; ?>" placeholder="Any Request?" value="<?php echo esc_attr($saved_value); ?>">
        <?php
    }
?>