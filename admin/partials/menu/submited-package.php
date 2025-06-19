<?php
    global $wpdb;
    $table_name = $wpdb->prefix . "submitted_custom_package";
    $query = "SELECT * FROM $table_name";
    $results = $wpdb->get_results($query);
?>
    <div class="container booking_data_wrap">
        <h3 class="booking_title">Custom Package Request Details</h3>
        <hr/>
        <div class="booking_details_table">
            <table id="booking_data">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Details</th>
                    <th>Status</th>
                </tr>
                <?php
                    if(!empty($results)) {
                        foreach ($results as $items) {
                            
                            $array_obj = json_decode($items->cphu_object, true);
                            ?>
                                <tr>
                                    <td><?php esc_html_e($items->id); ?></td>
                                    <td><?php esc_html_e($items->cphu_full_name); ?></td>
                                    <td><?php esc_html_e($items->cphu_mobile); ?></td>
                                    <td><?php esc_html_e($items->cphu_email); ?></td>
                                    <td>
                                        <button class="button button5 custom_package_view_details" data-id="<?php esc_html_e($items->id); ?>">View Details</button>
                                        <div class="<?php esc_html_e($items->id); ?> custom-model-main">
                                            <div class="custom-model-inner">        
                                            <div class="close-btn">×</div>
                                                <div class="custom-model-wrap">
                                                    <div class="pop-up-content-wrap">
                                                        <h3 class="cphu_details_display_title">Custom Package Request Details</h3>
                                                        <hr>
                                                        <div class="cphu_details_display_body_wrap">
                                                            <div class="cphu_row">
                                                                <div class="cphu_details_name col">
                                                                    <span class="cphu_display_details_key">Name: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($items->cphu_full_name); ?></span>
                                                                </div>
                                                                <div class="cphu_details_phone col">
                                                                    <span class="cphu_display_details_key">Phone Number: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($items->cphu_mobile); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="cphu_row">
                                                                <div class="cphu_details_mail">
                                                                    <span class="cphu_display_details_key">Email: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($items->cphu_email); ?></span>
                                                                </div>
                                                            </div>


                                                            <div class="cphu_row">
                                    
                                                                <div class="cphu_details_transport col">
                                                                    <span class="cphu_display_details_key"> Transport: </span>
                                                                    <span class="cphu_display_details_value"><ul>
                                                                        <?php 
                                                                            if (isset($array_obj['Transport: ']) && !empty($array_obj['Transport: '])) {
                                                                                // Remove any HTML tags from the string
                                                                                $transportStr = strip_tags($array_obj['Transport: ']);
                                                                                
                                                                                // Split the string into an array using comma as the divider
                                                                                $transportArr = array_map('trim', explode(',', $transportStr));
                                                                                
                                                                                // Output each item inside a span element with class "transport_list"
                                                                                foreach ($transportArr as $transportItem) {
                                                                                    echo '<li class="transport_list">' . htmlspecialchars($transportItem) . '</li>' . "\n";
                                                                                }
                                                                            } else {
                                                                                echo "No transport information available.";
                                                                            }
                                                                        ?>
                                                                        </span>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <div class="cphu_row">
                                                                <div class="cphu_details_visa_sevice col">
                                                                    <span class="cphu_display_details_key">Visa Services: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($array_obj['Visa Service: ']); ?></span>
                                                                </div>
                                                                <div class="cphu_details_flight_type col">
                                                                    <span class="cphu_display_details_key">Flight Type: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($array_obj['Air Ticket Type: ']); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="cphu_row">
                                                                <div class="cphu_details_flight_type_messdage col">
                                                                    <span class="cphu_display_details_key">Preferred Airlines: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($array_obj['Airlines: ']); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="cphu_row">
                                                                <div class="cphu_details_guide">
                                                                    <span class="cphu_display_details_key col">Guides: </span>
                                                                    <span class="cphu_display_details_value">
                                                                        <?php esc_html_e($array_obj['Guide: ']); ?>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="cphu_row">
                                                                <div class="cphu_details_travellers col">
                                                                    <span class="cphu_display_details_key">Travellers: </span>
                                                                    <span class="cphu_display_details_value">
                                                                        <?php esc_html_e($array_obj['Travelers: ']); ?>
                                                                    </span>
                                                                </div>
                                                                <div class="cphu_details_flight_class col">
                                                                    <span class="cphu_display_details_key">Flight Class: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($array_obj['Flight Type: ']); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="cphu_row">
                                                                <div class="cphu_row_label">Makka Hotel Details</div>
                                                            </div>
                                                            <div class="cphu_row">
                                                                
                                                                <div class="cphu_details_hotel_name makka">
                                                                    <span class="cphu_display_details_key">Hotel Name: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($array_obj['Hotel Name: ']['makka']); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="cphu_row">
                                                                <div class="cphu_details_room type makka col">
                                                                    <span class="cphu_display_details_key">Room Type: </span>
                                                                    <span class="cphu_display_details_value">
                                                                        <?php esc_html_e($array_obj['Hotel Room: ']['makka']); ?>
                                                                    </span>
                                                                </div>
                                                                <div class="cphu_details_start_date makka col">
                                                                    <span class="cphu_display_details_key">No. of Days: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($array_obj['Hotel Stay: ']['makka']); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="cphu_row">
                                                                <div class="cphu_details_request makka col">
                                                                    <span class="cphu_display_details_key">Request Text: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($array_obj['Request: ']['makka']); ?></span>
                                                                </div>

                                                                <div class="cphu_details_food_times col">
                                                                    <span class="cphu_display_details_key">Food Times: </span>
                                                                    <span class="cphu_display_details_value">
                                                                        <?php esc_html_e( $array_obj['Hotel Food: ']['makka'] ?? '' ); ?>
                                                                    </span>
                                                                </div>
                                                            </div>




                                                            <div class="cphu_row">
                                                                <div class="cphu_row_label">Madina Hotel Details</div>
                                                            </div>
                                                            <div class="cphu_row">
                                                                <div class="cphu_details_hotel_name madina">
                                                                    <span class="cphu_display_details_key">Hotel Name: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($array_obj['Hotel Name: ']['madina']); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="cphu_row">
                                                                <div class="cphu_details_room type madina col">
                                                                    <span class="cphu_display_details_key">Room Type: </span>
                                                                    <span class="cphu_display_details_value">
                                                                        <?php esc_html_e($array_obj['Hotel Room: ']['madina']); ?>
                                                                    </span>
                                                                </div>
                                                                <div class="cphu_details_start_date madina col">
                                                                    <span class="cphu_display_details_key">No. of Days: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($array_obj['Hotel Stay: ']['madina']); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="cphu_row">
                                                                <div class="cphu_details_request madina col">
                                                                    <span class="cphu_display_details_key">Request Text: </span>
                                                                    <span class="cphu_display_details_value"><?php esc_html_e($array_obj['Request: ']['madina']); ?></span>
                                                                </div>

                                                                <div class="cphu_details_food_times col">
                                                                    <span class="cphu_display_details_key">Food Times: </span>
                                                                    <span class="cphu_display_details_value">
                                                                        <?php
                                                                        esc_html_e( $array_obj['Hotel Food: ']['madina'] ?? '' ); ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>  
                                            <div class="bg-overlay"></div>
                                        </div> 
                                    </td>
                                    <td>
                                        <select class="backend_custom_package_status" data-id="<?php esc_html_e($items->id); ?>">
                                            <option value="requested" <?php echo ($items->cphu_status === "requested")? "selected": ""; ?>>Requested</option>
                                            <option value="confirmed" <?php echo ($items->cphu_status === "confirmed")? "selected": ""; ?>>Confirmed</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php
                        }
                        
                    }
                ?>
            </table>
        </div>
    </div>
