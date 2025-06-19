<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://https://siliconorchard.com/
 * @since      1.0.0
 *
 * @package    Custom_Package_For_Hajj_And_Umrah
 * @subpackage Custom_Package_For_Hajj_And_Umrah/includes
 */


$settings_option = (json_decode(get_option('selected_options'), true) !="")? json_decode(get_option('selected_options'), true) : [];
$transport_use_settings = (json_decode(get_option('transport_use_settings'), true) !="")? json_decode(get_option('transport_use_settings'), true) : [];
$transport_seater = $transport_seater = str_replace('"', '', (get_option('transport_seater') !="")? get_option('transport_seater') : "");
$costing_value = (json_decode(get_option('cphu_costing_data'), true) !="")? json_decode(get_option('cphu_costing_data'), true) : [];

if ($transport_seater !== "") {
    $seater_array = array_map('intval', array_map('trim', explode(',', $transport_seater)));
} else {
    $seater_array = []; // Return an empty array if the value is empty
}
?>

<div class="wrap">
    <h1>Cost Input Page</h1>
    <p>Provide cost input for custom package</p>
    <hr/>

    <div class="cost-input-container">
        <?php if (array_key_exists("visa_service", $settings_option)) { 
            $passengenger_type = [
                "adult",
                "children",
                "infant",
            ];
        ?>
            <div class="visa-service cost-wrapper">
                <h4 class="cost-sub-heading">Visa Service:</h4>
                <hr />
                <?php
                    foreach ($passengenger_type as $passenger) {
                        ?>
                            <div class="cphu-row">
                                <div class="form-group">
                                    <label for="cphu-visa-cost-<?php echo $passenger; ?>">Visa Service Cost (<?php echo ucfirst($passenger); ?>):</label>
                                    <input type="number" class="form-control" id="cphu-visa-cost-<?php echo $passenger; ?>" value="<?php echo (isset($costing_value["cphu-visa-cost-".$passenger]))? $costing_value["cphu-visa-cost-".$passenger]:""; ?>">
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        <?php } ?>

        <?php if (array_key_exists("air_ticket", $settings_option)) { 
            $flight_type = [
                "direct-flight",
                "transit-flight",
                "budget-flight",
            ];
            $passengenger_type = [
                "adult",
                "children",
                "infant",
            ];
        ?>
            <div class="air-ticket cost-wrapper">
                <h4 class="cost-sub-heading">Air Ticket:</h4>
                <hr />
                <?php
                    foreach ($flight_type as $flight) {
                        foreach($passengenger_type as $passenger){
                            ?>
                                <div class="cphu-row">
                                    <div class="form-group">
                                        <label for="cphu-<?php echo $flight."-".$passenger; ?>">Price for <?php echo ucwords(str_replace("-", " ", $flight)) . " (" . ucwords($passenger) . ")"; ?>:</label>
                                        <input type="number" class="form-control" id="cphu-<?php echo $flight."-".$passenger; ?>" value="<?php echo (isset($costing_value["cphu-".$flight."-".$passenger]))? $costing_value["cphu-".$flight."-".$passenger] : ""; ?>">
                                    </div>
                                </div>
                            <?php
                        }
                    }
                ?>
                
            </div>
        <?php } ?>

        <?php if (array_key_exists("transport", $settings_option) && !empty($transport_use_settings)) { ?>
            <div class="transport cost-wrapper">
                <h4 class="cost-sub-heading">Transport:</h4>
                <hr />

                <?php
                    if(!empty($transport_use_settings) && !empty($seater_array)){
                        $suttle_service = [
                            "jeddah_makkah" => "Jeddah Airport - Makkah Hotel",
                            "madina_madina" => "Madina Airport - Madina Hotel",
                            "jeddah_madina" => "Jeddah Airport - Madina Hotel",
                            "madina_makkah" => "Madina Airport - Makkah Hotel",
                        ];

                        $time_span = [
                            'half_day' => "Half Day",
                            'day_long' => "Day Long",
                        ];
                         foreach ($transport_use_settings as $key => $value) {
                            // print_r($key);
                            if(($key === "airport_pickup") || ($key === "airport_drop")){
                                foreach ($suttle_service as $suttle_key => $suttle_value) {
                                    foreach ($seater_array as $seat) {
                                        ?>
                                            <div class="cphu-row">
                                                <div class="form-group">
                                                    <label for="cphu_transport_<?php echo $key."_".$suttle_key."_".$seat."_seater"; ?>">
                                                        <?php 
                                                            echo ucwords(str_replace("_", " ", $key)) . " ( " . $suttle_value. " ) ". ucfirst($seat). " Seater Cost:";
                                                        ?>
                                                    </label>
                                                    <input type="number" class="form-control cphu_transport_<?php echo $key."_".$suttle_key."_".$seat."_seater"; ?>" id="cphu_transport_<?php echo $key."_".$suttle_key."_".$seat."_seater"; ?>" value="<?php echo (isset($costing_value["cphu_transport_".$key."_".$suttle_key."_".$seat."_seater"]))? $costing_value["cphu_transport_".$key."_".$suttle_key."_".$seat."_seater"]:""; ?>">
                                                </div>
                                            </div>
                                        <?php
                                    }
                                }
                            }else if(($key === "tayef_tour") || ($key === "jeddah_tour")){
                                foreach ($time_span as $time_key => $time_value) {
                                    foreach ($seater_array as $seat) {
                                        ?>
                                            <div class="cphu-row">
                                                <div class="form-group">
                                                    <label for="cphu_transport_<?php echo $key."_".$time_key."_".$seat."_seater"; ?>">
                                                        <?php 
                                                            echo ucwords(str_replace("_", " ", $key)) . " ( " . $time_value. " ) ". ucfirst($seat). " Seater Cost:";
                                                        ?>
                                                    </label>
                                                    <input type="number" class="form-control cphu_transport_<?php echo $key."_".$time_key."_".$seat."_seater"; ?>" id="cphu_transport_<?php echo $key."_".$time_key."_".$seat."_seater"; ?>" value="<?php echo (isset($costing_value["cphu_transport_".$key."_".$time_key."_".$seat."_seater"]))? $costing_value["cphu_transport_".$key."_".$time_key."_".$seat."_seater"]:""; ?>">
                                                </div>
                                            </div>
                                        <?php
                                    }
                                }
                            }else{
                                foreach ($seater_array as $seat) {
                                ?>
                                    <div class="cphu-row">
                                        <div class="form-group">
                                            <label for="cphu_transport_<?php echo $key."_".$seat."_seater"; ?>"><?php echo ucwords(str_replace('_', ' ', $key . "_" . $seat . "_seater")) . " Cost:"; ?></label>
                                            <input type="number" class="form-control cphu_transport_<?php echo $key."_".$seat."_seater"; ?>" id="cphu_transport_<?php echo $key."_".$seat."_seater"; ?>" value="<?php echo (isset($costing_value["cphu_transport_".$key."_".$seat."_seater"]))? $costing_value["cphu_transport_".$key."_".$seat."_seater"]:""; ?>">
                                        </div>
                                    </div>
                                <?php
                                }
                                
                            }
                        }
                    }
                ?>
            </div>
        <?php } ?>

        <?php if (array_key_exists("guide", $settings_option)) { 
            $guide = ["umrah", "makka-ziara", "madina-ziara"];
        ?>
            <div class="guide cost-wrapper">
                <h4 class="cost-sub-heading">Guide Costing:</h4>
                <hr />
                <?php
                    foreach ($guide as $value) {
                        ?>
                            <div class="cphu-row">
                                <div class="form-group">
                                    <label for="cphu-<?php echo $value; ?>-guide"><?php echo ucwords(str_replace('-', ' ', $value)) . " Cost:" ?></label>
                                    <input type="number" class="form-control" id="cphu-<?php echo $value; ?>-guide" value="<?php echo (isset($costing_value["cphu-".$value."-guide"]))? $costing_value["cphu-".$value."-guide"]:""; ?>">
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        <?php } ?>

        <?php if (array_key_exists("air_route", $settings_option)) { 
            $route_obj = (json_decode(get_option('route_settings_obj'), true) !="")? json_decode(get_option('route_settings_obj'), true) : [];
        ?>
            <div class="guide cost-wrapper">
                <h4 class="cost-sub-heading">Route Costing:</h4>
                <hr />
                <?php
                    foreach ($route_obj as $route) {
                        ?>
                            <div class="cphu-row">
                                <div class="form-group">
                                    <label for="cphu-route-<?php echo strtolower($route['destination_from_location'])."-".strtolower($route['destination_from_airport'])."-".strtolower($route['return_from_airport'])."-".strtolower($route['return_from_location']); ?>">Cost For ( <?php echo $route['destination_from_location']." - ".$route['destination_from_airport']." ) to ( ".$route['return_from_airport']." - ".$route['return_from_location']." ) Route"; ?></label>
                                    <input type="number" class="form-control" id="cphu-route-<?php echo strtolower($route['destination_from_location'])."-".strtolower($route['destination_from_airport'])."-".strtolower($route['return_from_airport'])."-".strtolower($route['return_from_location']); ?>" value="<?php echo (isset($costing_value["cphu-route-".strtolower($route['destination_from_location'])."-".strtolower($route['destination_from_airport'])."-".strtolower($route['return_from_airport'])."-".strtolower($route['return_from_location'])]))? $costing_value["cphu-route-".strtolower($route['destination_from_location'])."-".strtolower($route['destination_from_airport'])."-".strtolower($route['return_from_airport'])."-".strtolower($route['return_from_location'])]:""; ?>">
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        <?php } ?>

        <button class="save_costing_data">Save change</button>
        <span class="costing_data notification_success"></span>
        <span class="costing_data notification_error"></span>
    </div>


</div>