<?php
    /**
     * Rquire Template Functions
     */

    $requre_file = [
        'get-hotel-type',
        'get-hotel-name',
        'get-hotel-distance',
        'hotel-room',
        'hotel-food',
        'hotel-message',
    ];

    foreach($requre_file as $file){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'templates/template-functions/'.$file.'.php';
    }

    $settings_option = (json_decode(get_option('selected_options'), true) !="")? json_decode(get_option('selected_options'), true) : [];
    $settings_settings = (json_decode(get_option('selected_settings'), true) !="")? json_decode(get_option('selected_settings'), true) : [];
    $transport_use_settings = (json_decode(get_option('transport_use_settings'), true) !="")? json_decode(get_option('transport_use_settings'), true) : []; 

   // === FETCH SAVED PACKAGE DATA (Edit Mode) ===
    global $wpdb;
    $saved_data_arr = array();
    $package_data   = array();

    if ( isset($_GET['user']) && isset($_GET['id']) ) {
        $user_id   = intval($_GET['user']);
        $record_id = intval($_GET['id']);
        $table     = $wpdb->prefix . "save_for_later_db";

        // Use a prepared statement for security.
        $saved_data_arr = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table WHERE user_id = %d AND id = %d", $user_id, $record_id),
            ARRAY_A
        );
        if ( ! $saved_data_arr ) {
            $saved_data_arr = array();
        } else {
            // Decode the package_data_object JSON into an associative array.
            $package_data = json_decode($saved_data_arr['package_data_object'], true);
        }
    }

    $hotelStayhidden = $package_data['hotelStay'] ?? []; 
    if(!empty($package_data)){
        echo '<input type="hidden" class="page_edit_mode" value="'.$record_id.'"> ';
    }


    ob_start(); // Start output buffering
    ?>
        <div class="custom-package-wrap style_1">
            <input type="hidden" class="transport_hidden" value='<?php echo json_encode($package_data['transport'] ?? []); ?>'> 
            <input type="hidden" name="hotelStayHidden" id="hotelStayHidden" value='<?php echo htmlspecialchars(json_encode($hotelStayhidden), ENT_QUOTES, 'UTF-8'); ?>'>
            
            <div id="toaster-warning" class="toaster">
                Please fill all the required fields.
            </div>
            <div id="toaster-success" class="toaster">
                Package submitted successfully.
            </div>
            <h3 class="custom-package-title">Create Your Own Custom Package</h3>
            <div class="field-wrapper">
                <!-- Travellers -->
                <?php if (array_key_exists("travellers", $settings_option)) {
                    ?>
                        <div class="d-grid gap-2 travelars_section">
                            <label for="">Select Number of Travellers:</label>
                            <div class="input-group mb-3">
                                <?php
                                    $adults = $package_data['travellers']['adult'] ?? 0;
                                    $children = $package_data['travellers']['children'] ?? 0;
                                    $infants = $package_data['travellers']['infant'] ?? 0;
                                ?>
                                <input type="text" disabled class="form-control no_of_travelers" value="<?php echo $adults + $children + $infants . " Travellers"; ?>" aria-label="Travellers" aria-describedby="travelars_popup_button">
                                <button class="btn btn-outline-secondary" type="button" id="travelars_popup_button">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="travelars_wrap">
                                <div class="row">
                                    <div class="col">
                                        <label for="">Adult<br />
                                            <small>12+ Years</small>
                                        </label>
                                    </div>
                                    <div class="col counter_wrap adult">
                                        <div class="decrease" data-room="">-</div>
                                        <div class="counter"><?php echo $package_data['travellers']['adult'] ?? 0; ?></div>
                                        <div class="increase" data-room="">+</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="">Children<br />
                                            <small>3 - 11 Years</small>
                                        </label>
                                    </div>
                                    <div class="col counter_wrap children">
                                        <div class="decrease" data-room="">-</div>
                                        <div class="counter"><?php echo $package_data['travellers']['children'] ?? 0; ?></div>
                                        <div class="increase" data-room="">+</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="">Infants<br />
                                            <small>0 - 2 Years</small>
                                        </label>
                                    </div>
                                    <div class="col counter_wrap infant">
                                        <div class="decrease" data-room="">-</div>
                                        <div class="counter"><?php echo $package_data['travellers']['infant'] ?? 0; ?></div>
                                        <div class="increase" data-room="">+</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="close_popup_button">Done</div>
                                </div>
                            </div>
                        </div>

                    <?php
                }?>

                <!-- Flight -->
                <?php if (array_key_exists("flight", $settings_option)) {?>
                    <label for="flight_ticket_class">Select Flight Type:</label>
                    <div class="flight-wrap">
                        <select class="form-select form-control" id="flight_ticket_class" aria-label="Flight Ticket Class">
                        <option value="Economy" <?php selected( $package_data['flightType'] ?? '', "Economy" ); ?>>Economy</option>
                        <option value="Business" <?php selected( $package_data['flightType'] ?? '', "Business" ); ?>>Business</option>
                        </select>
                    </div>
                <?php } ?>

                <!-- Air Ticket Type -->
                <?php if (array_key_exists("air_ticket", $settings_option)) {?>
                    <div class="air-ticket-type">
                        <label for="direct_flight">Air Ticket Type:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="air_ticket_type" id="direct_flight" value="Direct Flight" <?php checked( $package_data['airTicketType'] ?? '', 'Direct Flight' ); ?>>
                            <label class="form-check-label" for="direct_flight">
                                Direct Flight
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="air_ticket_type" id="transit_flight" <?php checked( $package_data['airTicketType'] ?? '', 'Transit Flight' ); ?> value="Transit Flight">
                            <label class="form-check-label" for="transit_flight">
                                Transit Flight
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="air_ticket_type" id="budget_flight" value="Budget Flight" <?php checked( $package_data['airTicketType'] ?? '', 'Budget Flight' ); ?>>
                            <label class="form-check-label" for="budget_flight">
                                Budget Fight
                            </label>
                        </div>
                    </div>
                <?php } ?>  
                
                <!-- Airlines -->
                <?php if (array_key_exists("air_airlines", $settings_option)) {?>
                    <div class="airlines-wrap">
                        <div class="form-floating mb-3">
                            <label for="airlines-name">Preferred Airlines (E.g. Biman,FlyNas)</label>
                            <input type="text" class="form-control" id="airlines-name" placeholder="Airlines name" value="<?php echo isset($package_data['airlines']) ? esc_attr($package_data['airlines']) : ''; ?>">
                        </div>
                    </div>
                <?php } ?> 

                <!-- Route -->
                <?php if (array_key_exists("air_route", $settings_option)) {
                    $route_obj = (json_decode(get_option('route_settings_obj'), true) !="")? json_decode(get_option('route_settings_obj'), true) : [];
                ?>
                    
                    <div class="route-wrap">
                        <label for="air-route">Route:</label>
                        <select class="form-select form-control" id="air-route" aria-label="Air Route">
                            <option>-- Select --</option>
                            <?php
                                foreach ($route_obj as $key => $value) {
                                    $option_value = $value['destination_from_location'] . "-" . $value['destination_from_airport'] . "-" . $value['return_from_airport'] . "-" . $value['return_from_location'];
                                    ?>
                                    <option value="<?php echo esc_attr($option_value); ?>" <?php selected( $package_data['route'] ?? '', $option_value ); ?>>
                                        <?php echo esc_html($value['destination_from_location'] . " - " . $value['destination_from_airport'] . " to " . $value['return_from_airport'] . " - " . $value['return_from_location']); ?>
                                    </option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                <?php } ?>

                <!-- Visa service -->
                <?php if (array_key_exists("visa_service", $settings_option)) {?>
                    <div class="visa-service-wrap">
                        <label for="visa-service-yes">Visa Service:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visa-service" id="visa-service-yes" value="yes" <?php checked($package_data['visaService'] ?? '', 'yes'); ?>>
                            <label class="form-check-label" for="visa-service-yes">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visa-service" id="visa-service-no" value="no" <?php checked($package_data['visaService'] ?? '', 'no'); ?>>
                            <label class="form-check-label" for="visa-service-no">
                                No
                            </label>
                        </div>
                    </div>
                <?php } ?>
                
                <!-- Guide -->
                <?php if (array_key_exists("guide", $settings_option)) {?>
                    <div class="guide-wrap">
                        <label for="guide-umrah">Guide:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tour-guide" id="guide-umrah" value="umrah" <?php echo (in_array("umrah", $package_data['guide'] ?? array())) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="guide-umrah">
                                Guide for Umrah
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tour-guide" id="guide-makka-ziara" value="makka_ziara" <?php echo (in_array("makka_ziara", $package_data['guide'] ?? array())) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="guide-makka-ziara">
                                Guide for Makka Ziara
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tour-guide" id="guide-madina-ziara" value="madina_ziara" <?php echo (in_array("madina_ziara", $package_data['guide'] ?? array())) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="guide-madina-ziara">
                                Guide for Madina Ziara
                            </label>
                        </div>
                    </div>
                <?php } ?>

                <!-- Transport -->
                <?php if (array_key_exists("transport", $settings_option) && !empty($transport_use_settings)) : ?>
                    <div class="transport-wrap">
                        <label for="">Transport:</label>
                        <div class="transport-field-wrap">
                            <div class="form-check-wrapper">
                            <?php

                            // Transport seater option
                            $transport_seater = str_replace('"', '', (get_option('transport_seater') != "") ? get_option('transport_seater') : "");
                            if ($transport_seater !== "") {
                                $seater_array = array_map('intval', array_map('trim', explode(',', $transport_seater)));
                            } else {
                                $seater_array = array();
                            }

                            if(!empty($transport_use_settings)){
                                foreach ($transport_use_settings as $key => $transport_use) {
                                    // Determine if the parent checkbox should be checked.
                                    $transportValues = $package_data['transport'] ?? array();
                                    $checkedParent = in_array($key, $transportValues) ||
                                        ( !empty($transportValues) && count(preg_grep("/^" . preg_quote($key, '/') . "_/", $transportValues)) > 0 );
                                    ?>
                                    <div class="form-check level-0 parent-wrapper" data-level="0">
                                        <input class="form-check-input" type="checkbox" name="<?php echo esc_attr($key); ?>" id="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>" <?php echo ($checkedParent ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="<?php echo esc_attr($key); ?>">
                                            <?php 
                                            $key_string = explode("_", $key);
                                            echo ucwords($key_string[0] . " " . ($key_string[1] ?? ''));
                                            ?>
                                        </label>
                                        <?php
                                        // For keys that include "airport", use a specific nested structure.
                                        if(strpos($key, "airport") !== false){
                                            $suttle_service = array(
                                                "jeddah_makkah" => "Jeddah Airport - Makkah Hotel",
                                                "madina_madina" => "Madina Airport - Madina Hotel",
                                                "jeddah_madina" => "Jeddah Airport - Madina Hotel",
                                                "madina_makkah" => "Madina Airport - Makkah Hotel",
                                            );
                                            echo '<div class="'. esc_attr($key) .' sub_wrapper">';
                                            foreach($suttle_service as $survice_key => $service){
                                                $sub_val = $key . "_" . $survice_key;
                                                ?>
                                                <div class="form-check level-1 parent-wrapper" data-level="1">
                                                    <input class="form-check-input" type="checkbox" name="<?php echo esc_attr($key."_".$survice_key); ?>" id="<?php echo esc_attr($key."_".$survice_key); ?>" value="<?php echo esc_attr($sub_val); ?>" <?php echo (in_array($sub_val, $transportValues)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="<?php echo esc_attr($key."_".$survice_key); ?>"><?php echo esc_html($service); ?></label>
                                                    <?php
                                                    echo '<div class="'. esc_attr($key."_".$survice_key) .' sub_wrapper seater">';
                                                    foreach($seater_array as $seat_number){
                                                        $sub_sub_val = $key . "_" . $survice_key . "_" . $seat_number;
                                                        ?>
                                                        <div class="form-check level-2 child-wrapper" data-level="2">
                                                            <input class="form-check-input" type="checkbox" name="<?php echo esc_attr($key."_".$survice_key."_".$seat_number); ?>" id="<?php echo esc_attr($key."_".$survice_key."_".$seat_number); ?>" value="<?php echo esc_attr($sub_sub_val); ?>" <?php echo (in_array($sub_sub_val, $transportValues)) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="<?php echo esc_attr($key."_".$survice_key."_".$seat_number); ?>"><?php echo $seat_number." Seater"; ?></label>
                                                        </div>
                                                        <?php
                                                    }
                                                    echo '</div>';
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            echo '</div>';
                                        }
                                        // For keys that include "tour", use a different nested structure.
                                        else if(strpos($key, "tour") !== false) {
                                            $time_span = array(
                                                'half_day' => "Half Day",
                                                'day_long' => "Day Long",
                                            );
                                            echo '<div class="'. esc_attr($key) .' sub_wrapper">';
                                            foreach($time_span as $time_key => $time){
                                                $sub_val = $key . "_" . $time_key;
                                                ?>
                                                <div class="form-check level-1 parent-wrapper" data-level="1">
                                                    <input class="form-check-input" type="checkbox" name="<?php echo esc_attr($key."_".$time_key); ?>" id="<?php echo esc_attr($key."_".$time_key); ?>" value="<?php echo esc_attr($sub_val); ?>" <?php echo (in_array($sub_val, $transportValues)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="<?php echo esc_attr($key."_".$time_key); ?>"><?php echo esc_html($time); ?></label>
                                                    <?php
                                                    echo '<div class="'. esc_attr($key."_".$time_key) .' sub_wrapper seater">';
                                                    foreach($seater_array as $seat_number){
                                                        $sub_sub_val = $key . "_" . $time_key . "_" . $seat_number;
                                                        ?>
                                                        <div class="form-check level-2 child-wrapper" data-level="2">
                                                            <input class="form-check-input" type="checkbox" name="<?php echo esc_attr($key."_".$time_key."_".$seat_number); ?>" id="<?php echo esc_attr($key."_".$time_key."_".$seat_number); ?>" value="<?php echo esc_attr($sub_sub_val); ?>" <?php echo (in_array($sub_sub_val, $transportValues)) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="<?php echo esc_attr($key."_".$time_key."_".$seat_number); ?>"><?php echo $seat_number." Seater"; ?></label>
                                                        </div>
                                                        <?php
                                                    }
                                                    echo '</div>';
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            echo '</div>';
                                        }
                                        // For other keys, output a simple nested checkbox set.
                                        else {
                                            echo '<div class="'. esc_attr($key) .' sub_wrapper seater">';
                                            foreach($seater_array as $seat_number){
                                                $sub_val = $key . "_" . $seat_number;
                                                ?>
                                                <div class="form-check level-1 child-wrapper" data-level="1">
                                                    <input class="form-check-input" type="checkbox" name="<?php echo esc_attr($key."_".$seat_number); ?>" id="<?php echo esc_attr($key."_".$seat_number); ?>" value="<?php echo esc_attr($sub_val); ?>" <?php echo (in_array($sub_val, $transportValues)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="<?php echo esc_attr($key."_".$seat_number); ?>"><?php echo $seat_number." Seater"; ?></label>
                                                </div>
                                                <?php
                                            }
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                    <!-- Hotel Container (will be populated dynamically) -->
                    <div id="hotel-container">
                                            <!-- Makka Template -->
                        <div id="makka-template" class="hotel-stay makka-feature-wrap">
                            <div class="makka-heading">
                                <h3 class="custom-package-title">Makka Features</h3>
                            </div>
                            <div class="hotel-column-wrap">
                                <div class="hotel-fields">

                                    <div class="hotel-type-wrap makka">
                                        <?php get_hotel_type('makka', $package_data['hoteltaxonomy']['makka'] ?? 0); ?>
                                    </div>

                                    <div class="hotel-distance-wrap makka">
                                        <?php get_hotel_distance('makka'); ?>
                                    </div>

                                    <div class="hotel-name-wrap makka">
                                        <?php get_hotel_name('makka', $package_data['hotelId']['makka'] ?? ''); ?>
                                    </div>

                                    <div class="hotel-date-range-wrap makka">
                                        <div class="hotel-stay makka-hotel">
                                            <label class="hotel-label">Makkah Hotel Stay:</label>
                                            <div class="stay-fields">
                                                <input type="date" class="stay-input stay-from" disabled>
                                                <input type="date" class="stay-input stay-to" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <?php add_hotel_room('makka', $package_data['rooms']['makka'] ?? array()); ?>

                                    <?php add_food_section('makka', $package_data['food']['makka'] ?? array()); ?>

                                    <?php if (array_key_exists("hotel_message", $settings_option)) {?>
                                        <div class="hotel-message-wrap makka">
                                            <?php get_hotel_message('makka', $package_data['message']['makka'] ?? ''); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if (array_key_exists("hotel_map", $settings_option)) {?>
                                <div class="hotel-map makka">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116833.83187900356!2d90.33728817319133!3d23.780975728128134!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087026b81%3A0x8fa563bbdd5904c2!2sDhaka!5e0!3m2!1sen!2sbd!4v1733832932617!5m2!1sen!2sbd" height="450" style="border:0; width:100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Madina Template -->
                        <div id="madina-template" class="hotel-stay madina-feature-wrap">
                            <div class="madina-heading">
                                <h3 class="custom-package-title">Madina Features</h3>
                            </div>
                            <div class="hotel-column-wrap">
                                <div class="hotel-fields">

                                    <div class="hotel-type-wrap madina">
                                        <?php get_hotel_type('madina', $package_data['hoteltaxonomy']['madina'] ?? 0); ?>
                                    </div>

                                    <div class="hotel-distance-wrap madina">
                                        <?php get_hotel_distance('madina'); ?>
                                    </div>

                                    <div class="hotel-name-wrap madina">
                                        <?php get_hotel_name('madina', $package_data['hotelId']['madina'] ?? ''); ?>
                                    </div>

                                    <div class="hotel-date-range-wrap madina">
                                        <div class="hotel-stay madina-hotel">
                                            <label class="hotel-label">Madina Hotel Stay (From to To):</label>
                                            <div class="stay-fields">
                                                <input type="date" class="stay-input stay-from" disabled>
                                                <input type="date" class="stay-input stay-to" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <?php add_hotel_room('madina',  $package_data['rooms']['madina'] ?? array()); ?>

                                    <?php add_food_section('madina', $package_data['food']['madina'] ?? array()); ?>

                                    <?php if (array_key_exists("hotel_message", $settings_option)) {?>
                                        <div class="hotel-message-wrap madina">
                                            <?php get_hotel_message('madina', $package_data['message']['madina'] ?? ''); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if (array_key_exists("hotel_map", $settings_option)) {?>
                                    <div class="hotel-map madina">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116833.83187900356!2d90.33728817319133!3d23.780975728128134!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087026b81%3A0x8fa563bbdd5904c2!2sDhaka!5e0!3m2!1sen!2sbd!4v1733832932617!5m2!1sen!2sbd" height="450" style="border:0; width:100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="button-wrapper">
                <?php if (!empty($settings_settings)) : ?>
                    <div class="submission-button">
                        <?php if (array_key_exists("show_summary", $settings_settings)) : ?>
                            <div class="view_summary">
                                <button class="custom-btn">Show Summary</button>
                            </div>
                        <?php endif; ?>
                        <?php if (array_key_exists("save_for_later", $settings_settings)) : ?>
                            <div class="save_for_later">
                                <button class="custom-btn">Save for Later</button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Summary -->
            <?php
                $summary_output = "";
                $file_path = plugin_dir_path(dirname(__FILE__)) . 'templates/summary.php';
                if (file_exists($file_path)) {
                    $summary_output .= include $file_path; // Append the returned content
                } else {
                    $summary_output .= '<p>Error: Summary not found.</p>';
                }
            ?>

            <!-- Save for later -->
            <div class="panel save-forlater-wrapper">
                <div class="panel-heading">Save for Later</div>
                <div class="panel-body">
                    <div class="form-floating mb-3">
                    <label for="save-forlater-name">Package Name:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="save-forlater-name"
                        placeholder="Give a name to save for later"
                        value="<?php echo isset($saved_data_arr['package_name']) ? esc_attr($saved_data_arr['package_name']) : ''; ?>"
                    >
                    </div>
                </div>
                <div class="panel-footer">
                    <button class="custom-btn save-forlater-submit">Save for now</button>
                </div>
            </div>

        </div>
    <?php
    return ob_get_clean(); // Return the buffered content as a string
?>