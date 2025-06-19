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
    $settingsdata = (json_decode(get_option('selected_settings'), true) !="")? json_decode(get_option('selected_settings'), true) : [];
    $settings_option = (json_decode(get_option('selected_options'), true) !="")? json_decode(get_option('selected_options'), true) : [];
    $transport_use_settings = (json_decode(get_option('transport_use_settings'), true) !="")? json_decode(get_option('transport_use_settings'), true) : [];

?>

<div class="package_settings">
    <h4 class="general_heading">General Settings:</h4>
    <hr/>
    <div class="input_field">
        <input type="checkbox" id="cphu_show_summary" name="package_settings" value="show_summary" <?php echo (array_key_exists('show_summary', $settingsdata) ? 'checked' : ''); ?>>
        <label for="cphu_show_summary">Do you want to see the summary?</label>
    </div>
    <div class="input_field">
        <input type="checkbox" id="cphu_save_for_later" name="package_settings" value="save_for_later" <?php echo (array_key_exists('save_for_later', $settingsdata) ? 'checked' : ''); ?>>
        <label for="cphu_save_for_later">Do you want to save for later</label>
    </div>
    <div class="transport_settings_wrap">
        <div class="edit-url-row">
            <div class="form-group">
                <label for="edit-url-input">Enter the url of custom package page to edit the saved package:</label>
                <input type="text" class="form-control" id="edit-url-input" value=<?php echo get_option('edit-url'); ?>>
            </div>
        </div>
    </div>


    <?php if (array_key_exists("transport", $settings_option)) {
        ?>
            <h4 class="transport_heading">Transport Settings:</h4>
            <hr />
            <div class="transport_settings_wrap">
                <div class="settings-row">
                    <div class="form-group">
                        <label for="settings-car-seater-option">Number of Car Seater (Provide only numbers with comma seperated):</label>
                        <input type="text" class="form-control" id="settings-car-seater-option" value=<?php echo get_option('transport_seater'); ?>>
                    </div>
                </div>
            </div>

            <h4 class="transport_heading">Select For Transportation Use:</h4>
            <hr/>
            <div class="transportation-use-wrap">
                <?php
                    $transportation_field_arr = [
                        "airport_pickup",
                        "airport_drop",
                        "inter_city",
                        "makka_ziara",
                        "madina_ziara",
                        "tayef_tour",
                        "jeddah_tour",
                    ];

                    foreach ($transportation_field_arr as $fields) {
                        ?>
                            <div class="input_field">
                                <input type="checkbox" id="cphu_<?php echo $fields ?>" name="trnsport_settings" value="<?php echo $fields; ?>" <?php echo (array_key_exists($fields, $transport_use_settings) ? 'checked' : ''); ?>>
                                <label for="cphu_<?php echo $fields; ?>">
                                    <?php
                                        echo ucwords(str_replace("_", " ", $fields));
                                    ?>
                                </label>
                            </div>
                        <?php
                    }
                ?>
            </div>
        <?php
    } ?>
    
    <button class="save_settings_settings">Save change</button>
    <span class="selected_settings notification_success"></span>
    <span class="selected_settings notification_error"></span>
</div>
