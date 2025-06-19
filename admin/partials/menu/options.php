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
      * This page is for settings panel options 
      */

    $optiondata = (json_decode(get_option('selected_options'), true) !="")? json_decode(get_option('selected_options'), true) : [];
?>
<div class="package_option">
    <div class="input_field">
        <input type="checkbox" id="cphu_travellers" name="package_option" value="travellers" <?php echo (array_key_exists('travellers', $optiondata) ? 'checked' : ''); ?>>
        <label for="cphu_travellers">Travellers</label><br />
    </div>
    <div class="input_field">
        <input type="checkbox" id="cphu_flight" name="package_option" value="flight" <?php echo (array_key_exists('flight', $optiondata) ? 'checked' : ''); ?>>
        <label for="cphu_flight">Flight type</label><br />
    </div>
    <div class="input_field">
        <input type="checkbox" id="cphu_air_ticket" name="package_option" value="air_ticket" <?php echo (array_key_exists('air_ticket', $optiondata) ? 'checked' : ''); ?>>
        <label for="cphu_air_ticket">Air ticket</label><br />
    </div>
    <div class="input_field">
        <input type="checkbox" id="cphu_airlines" name="package_option" value="air_airlines" <?php echo (array_key_exists('air_airlines', $optiondata) ? 'checked' : ''); ?>>
        <label for="cphu_airlines">Preferred airlines</label><br />
    </div>
    <div class="input_field">
        <input type="checkbox" id="cphu_route" name="package_option" value="air_route" <?php echo (array_key_exists('air_route', $optiondata) ? 'checked' : ''); ?>>
        <label for="cphu_route">Route</label><br />
    </div>
    <div class="input_field">
        <input type="checkbox" id="cphu_visa_service" name="package_option" value="visa_service" <?php echo (array_key_exists('visa_service', $optiondata) ? 'checked' : ''); ?>>
        <label for="cphu_visa_service">Visa service</label><br />
    </div>
    <div class="input_field">
        <input type="checkbox" id="cphu_transport" name="package_option" value="transport" <?php echo (array_key_exists('transport', $optiondata) ? 'checked' : ''); ?>>
        <label for="cphu_transport">Tranport</label><br />
    </div>
    <div class="input_field">
        <input type="checkbox" id="cphu_guide" name="package_option" value="guide" <?php echo (array_key_exists('guide', $optiondata) ? 'checked' : ''); ?>>
        <label for="cphu_guide">Guide</label><br />
    </div>

    <br />
    <strong>Hotel Options:</strong>
    <hr/>

    <div class="input_field">
        <input type="checkbox" id="cphu_hotel_map" name="package_option" value="hotel_map" <?php echo (array_key_exists('hotel_map', $optiondata) ? 'checked' : ''); ?>>
        <label for="cphu_hotel_map">Location map</label><br />
    </div>
    <div class="input_field">
        <input type="checkbox" id="cphu_hotel_message" name="package_option" value="hotel_message" <?php echo (array_key_exists('hotel_message', $optiondata) ? 'checked' : ''); ?>>
        <label for="cphu_hotel_message">Request message</label><br />
    </div>

    <br />
    <button class="save_settings_option">Save change</button> 
    <span class="selected_options notification_success"></span>
    <span class="selected_options notification_error"></span>
</div>