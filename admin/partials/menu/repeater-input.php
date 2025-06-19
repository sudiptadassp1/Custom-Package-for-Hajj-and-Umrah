<?php
    /**
     * The file that defines the core plugin class
     *
     * A class definition that includes attributes and functions used across both the
     * public-facing side of the site and the admin area.
     *
     * @link       https://https://siliconorchard.com/
     * @since      1.0.0
     *
     * @package    Custom_Package_For_Hajj_And_Umrah
     * @subpackage Custom_Package_For_Hajj_And_Umrah/includes
     */

     /**
      * This page is for repeater input options 
      */

?>

<div class="package_repeater_input">
    <div class="repeater_input_wrap">
        <div class="repeater_segment route">
            <h4 class="repeater_segment_heading">Route:</h4>
            <hr />
            <div class="route_wrap">
                <?php 
                    $route_obj = (json_decode(get_option('route_settings_obj'), true) !="")? json_decode(get_option('route_settings_obj'), true) : [];
                    foreach ($route_obj as $route) {
                        ?>
                            <div class="route_segment">
                                <div class="form-group">
                                    <label for="destination-from-location">Destination From Location:</label>
                                    <input type="text" placeholder="From Location" name="destination_from_location[]" class="form-control destination-from-location" id="destination-from-location" value="<?php echo $route['destination_from_location']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="destination-from-airport">Destination From Airport:</label>
                                    <select name="destination_from_airport[]" id="destination-from-airport">
                                        <option value="Jeddah" <?php echo ($route['destination_from_airport'] == 'Jeddah') ? 'selected' : ''; ?>>Jeddah</option>
                                        <option value="Madina" <?php echo ($route['destination_from_airport'] == 'Madina') ? 'selected' : ''; ?>>Madina</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <h4 class="segment-divider">To</h4>
                                </div>
                                <div class="form-group">
                                    <label for="return-from-airport">Return From Airport:</label>
                                    <select name="return_from_airport[]" id="return-from-airport">
                                        <option value="Jeddah" <?php echo ($route['return_from_airport'] == 'Jeddah') ? 'selected' : ''; ?>>Jeddah</option>
                                        <option value="Madina" <?php echo ($route['return_from_airport'] == 'Madina') ? 'selected' : ''; ?>>Madina</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="return-from-location">Return From Location:</label>
                                    <input type="text" name="return_from_location[]" placeholder="Return Location" class="form-control return-from-location" id="return-from-location" value="<?php echo $route['return_from_location']; ?>">
                                </div>
                                <div class="form-group">
                                    <button class="settings_remove_route">
                                        <span class="icon">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                                                <path d="M3 6h18v2H3V6zm3 4h12v10a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V10zm2 2v8h8v-8H8zm4-8a3 3 0 0 1 3 3H9a3 3 0 0 1 3-3zm-1 3h2v2h-2V7z"/>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
            <button class="add_route_segment">+ Add Route</button>
        </div>
    </div>

    <button class="save_settings_repeater">Save change</button>
    <span class="selected_repeater notification_success"></span>
    <span class="selected_repeater notification_error"></span>
</div>
