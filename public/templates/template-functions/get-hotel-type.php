<?php
    function get_hotel_type($location, $saved_value = 0){
        ?>
            <div class="form-group">
                <label for="<?php echo $location?>-Select-style-input" class="form-label">Select Hotel Type:</label>
                <select name="<?php echo $location; ?>-Select-style-input" id="<?php echo $location; ?>-Select-style-input" class="form-select" onchange="fetchHotelNames(this.value, '<?php echo $location; ?>')">
                    <option value="0">-- Select --</option>
                    <?php
                    // Get terms for taxonomy: e.g., "makka_hotel_type" or "madina_hotel_type"
                    $terms = get_terms( array(
                        'taxonomy'   => $location . '_hotel_type',
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hide_empty' => false,
                    ) );
                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                        foreach ( $terms as $term ) {
                            echo '<option value="' . esc_attr($term->term_id) . '" ' . selected($term->term_id, $saved_value, false) . '>' . esc_html($term->name) . '</option>';
                        }
                    } else {
                        echo '<option disabled>No hotel types found</option>';
                    }
                    ?>
                </select>
            </div>
        <?php
    }
?>