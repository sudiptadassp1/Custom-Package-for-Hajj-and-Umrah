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
      * This page is for basic meta field and repeater meta field for hotel post type
      */
    
    function hotel_add_meta_boxes( $post ){
        add_meta_box(
            'hotel_meta_box', 
            __( 'Hotel Fields', 'traveltour' ), 
            'hotel_meta_box_callback', 
            'hotel',
            'normal',
            'low'
        );
    }
    add_action( 'add_meta_boxes', 'hotel_add_meta_boxes' );

    function hotel_meta_box_callback($post){
        wp_nonce_field( basename( __FILE__ ), 'hotel_meta_box' );
        ?>
            <input type="hidden" name="hotel_id" class="hotel_id" value="<?php echo $post->ID; ?>">
            <div class="hotel-basic-info-wrap">
                <h3 class="hotel-basic-info">Hotel Basic Information</h3>
                <hr />
                <div class="info-field-wrap">
                    <div class="row">
                        <div class="input-group">
                            <label for="road-name">Road Name:</label>
                            <input type="text" id="road-name" class="input-field" placeholder="Enter Hotel's Road Name" value="<?php echo !empty(get_post_meta($post->ID, 'hotel_road_name', true)) ? esc_attr(get_post_meta($post->ID, 'hotel_road_name', true)) : ''; ?>">
                        </div>
                        <div class="input-group">
                            <label for="city-name">City Name:</label>
                            <select id="city-name" class="input-field" name="city_name">
                                <option value="makka" <?php echo (get_post_meta($post->ID, 'hotel_city_name', true) === 'makka') ? 'selected' : ''; ?>>Makkah</option>
                                <option value="madina" <?php echo (get_post_meta($post->ID, 'hotel_city_name', true) === 'madina') ? 'selected' : ''; ?>>Madina</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <label for="distance-meter">Distance (Meters):</label>
                            <input type="number" id="distance-meter" class="input-field" placeholder="Enter Distance From Haram/Masjid al-Nabawi" value="<?php echo esc_attr(get_post_meta($post->ID, 'hotel_distance', true)); ?>">
                        </div>
                        <div class="input-group">
                            <label for="map-location">Map URL:</label>
                            <input type="text" id="map-location" class="input-field" placeholder="Enter Map URL" value="<?php echo esc_attr(get_post_meta($post->ID, 'hotel_map', true)); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="date_info">Add Costing:</h3><hr/>
            <div class="hotel-segment-wrap">
                <?php
                    $costing_obj = get_post_meta($post->ID, 'hotel_costing_object');
                    if(!empty($costing_obj) && !is_null($costing_obj) && ($costing_obj[0] != "")){
                        foreach($costing_obj[0] as $key=>$cost_arr){
                            ?>
                                <div class="segment-inner-wrap cost-<?php echo $key+1; ?>">
                                    <span class="delete-segment" data-segment="<?php echo $key+1; ?>">X</span>
                                    <div class="date-time-span">
                                        <div class="time-field-wrap">
                                            <div class="input-group">
                                                <label for="from-date-<?php echo $key+1; ?>">Enter From Date:</label>
                                                <input type="date" id="from-date-<?php echo $key+1; ?>" class="from-date-input" placeholder="Enter From Date" value="<?php echo $cost_arr['from_date']; ?>" />
                                            </div>
                                            <div class="input-group">
                                                <label for="to-date-<?php echo $key+1; ?>">Enter To Date:</label>
                                                <input type="date" id="to-date-<?php echo $key+1; ?>" class="to-date-input" placeholder="Enter To Date" value="<?php echo $cost_arr['to_date']; ?>" />
                                            </div>
                                        </div>
                                        <div class="costing-wrap">
                                            <h5 class="costing-label">Cost Within Date Range:</h5>
                                            <hr />
                                            <div class="room-cost-wrap">
                                                <div class="room-type single room">
                                                    <label>Single Bed:</label>
                                                    <input type="number" class="room-cost single-room weekday" placeholder="Weekdays Cost" value="<?php echo $cost_arr['single-room']['weekday'] ?? ''; ?>" />
                                                    <input type="number" class="room-cost single-room weekend" placeholder="Weekend Cost" value="<?php echo $cost_arr['single-room']['weekend'] ?? ''; ?>" />
                                                </div>
                                                <div class="room-type double room">
                                                    <label>Double Bed:</label>
                                                    <input type="number" class="room-cost double-room weekday" placeholder="Weekdays Cost" value="<?php echo $cost_arr['double-room']['weekday'] ?? ''; ?>" />
                                                    <input type="number" class="room-cost double-room weekend" placeholder="Weekend Cost" value="<?php echo $cost_arr['double-room']['weekend'] ?? ''; ?>" />
                                                </div>
                                                <div class="room-type triple room">
                                                    <label>Triple Bed:</label>
                                                    <input type="number" class="room-cost triple-room weekday" placeholder="Weekdays Cost" value="<?php echo $cost_arr['triple-room']['weekday'] ?? ''; ?>" />
                                                    <input type="number" class="room-cost triple-room weekend" placeholder="Weekend Cost" value="<?php echo $cost_arr['triple-room']['weekend'] ?? ''; ?>" />
                                                </div>
                                                <div class="room-type quad room">
                                                    <label>Quad Bed:</label>
                                                    <input type="number" class="room-cost quad-room weekday" placeholder="Weekdays Cost" value="<?php echo $cost_arr['quad-room']['weekday'] ?? ''; ?>" />
                                                    <input type="number" class="room-cost quad-room weekend" placeholder="Weekend Cost" value="<?php echo $cost_arr['quad-room']['weekend'] ?? ''; ?>" />
                                                </div>
                                                <div class="room-type quint room">
                                                    <label>Quint Bed:</label>
                                                    <input type="number" class="room-cost quint-room weekday" placeholder="Weekdays Cost" value="<?php echo $cost_arr['quint-room']['weekday'] ?? ''; ?>" />
                                                    <input type="number" class="room-cost quint-room weekend" placeholder="Weekend Cost" value="<?php echo $cost_arr['quint-room']['weekend'] ?? ''; ?>" />
                                                </div>
                                            </div>
                                            <div class="food-cost-wrap">
                                                <div class="food-type">
                                                    <label>Breakfast:</label>
                                                    <input type="number" class="food-cost breakfast weekday" placeholder="Weekdays Cost" value="<?php echo $cost_arr['breakfast']['weekday'] ?? ''; ?>" />
                                                    <input type="number" class="food-cost breakfast weekend" placeholder="Weekend Cost" value="<?php echo $cost_arr['breakfast']['weekend'] ?? ''; ?>" />
                                                </div>
                                                <div class="food-type">
                                                    <label>Half Board:</label>
                                                    <input type="number" class="food-cost half-board weekday" placeholder="Weekdays Cost" value="<?php echo $cost_arr['half-board']['weekday'] ?? ''; ?>" />
                                                    <input type="number" class="food-cost half-board weekend" placeholder="Weekend Cost" value="<?php echo $cost_arr['half-board']['weekend'] ?? ''; ?>" />
                                                </div>
                                                <div class="food-type">
                                                    <label>Full Board:</label>
                                                    <input type="number" class="food-cost full-board weekday" placeholder="Weekdays Cost" value="<?php echo $cost_arr['full-board']['weekday'] ?? ''; ?>" />
                                                    <input type="number" class="food-cost full-board weekend" placeholder="Weekend Cost" value="<?php echo $cost_arr['full-board']['weekend'] ?? ''; ?>" />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php
                        }
                    }
                    
                ?>
            </div>
            <div class="bottom-buttons-wrap">
                <button class="add-segment-btn">+ Add Costing</button>
                <button class="save-meta-data">Save Meta Data</button>
            </div>
            
        <?php
    }

?>