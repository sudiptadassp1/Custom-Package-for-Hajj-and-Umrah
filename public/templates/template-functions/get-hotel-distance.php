<?php
    function get_hotel_distance($location){
        ?>
            <div class="distance-wrap">
                <label for="<?php echo $location; ?>-distance-slider">Distance (in km): <span id="<?php echo $location; ?>-distance-value">0 Meter</span></label>
                <input type="range" id="<?php echo $location; ?>-distance-slider" name="<?php echo $location; ?>-distance-slider" step="10" min="0" max="100" value="0">
                
            </div>
        <?php
    }
?>