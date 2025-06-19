<?php
    function add_food_section($section_id, $saved_food = array()) {
        ?>
        <div class="food-section" id="<?php echo esc_attr($section_id); ?>-food">
            <label class="fw-bold">Do you want food?</label>
            <div class="d-flex align-items-center gap-3 mt-2">
                <div class="form-check">
                    <input class="form-check-input food-radio" type="radio" name="food-option-<?php echo esc_attr($section_id); ?>" id="food-yes-<?php echo esc_attr($section_id); ?>" <?php echo !empty($saved_food) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="food-yes-<?php echo esc_attr($section_id); ?>">Yes</label>
                    <div class="food-options mt-2" style="display: <?php echo !empty($saved_food) ? 'block' : 'none'; ?>;">
                        <label class="fw-bold">Select Meal Plan:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="breakfast-<?php echo esc_attr($section_id); ?>" value="breakfast-<?php echo esc_attr($section_id); ?>" <?php echo (in_array("breakfast-".$section_id, $saved_food)) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="breakfast-<?php echo esc_attr($section_id); ?>">Breakfast</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="half-board-<?php echo esc_attr($section_id); ?>" value="half-board-<?php echo esc_attr($section_id); ?>" <?php echo (in_array("half-board-".$section_id, $saved_food)) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="half-board-<?php echo esc_attr($section_id); ?>">Half Board</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="full-board-<?php echo esc_attr($section_id); ?>" value="full-board-<?php echo esc_attr($section_id); ?>" <?php echo (in_array("full-board-".$section_id, $saved_food)) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="full-board-<?php echo esc_attr($section_id); ?>">Full Board</label>
                        </div>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input food-radio" type="radio" name="food-option-<?php echo esc_attr($section_id); ?>" id="food-no-<?php echo esc_attr($section_id); ?>" <?php echo empty($saved_food) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="food-no-<?php echo esc_attr($section_id); ?>">No</label>
                </div>
            </div>        
        </div>
        <?php
    }  
?>