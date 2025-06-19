<?php
    function get_hotel_name($location, $saved_value = '') {
        $hotel_name = '';
        if ($saved_value) {
            $hotel_name = get_the_title($saved_value);
            if (!$hotel_name) {
                $hotel_name = $saved_value;
            }
        }
        ?>
        <div class="form-group">
            <label for="<?php echo $location; ?>-hotel-name-select" class="form-label">Select Hotel Name:</label>
            <select name="hotel-name-select" id="<?php echo $location; ?>-hotel-name-select" class="form-select">
                <option value="<?php echo $saved_value; ?>"><?php echo ($saved_value ? esc_html($hotel_name) : '-- Select Hotel Type First --'); ?></option>
            </select>
        </div>
        <?php
    }
?>