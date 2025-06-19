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
      * This page is for display template option and shortcode
      */

?>

<div class="package_display">
    <div class="display_wrap">
        <h4 class="display_heading">Display Style Template Option:</h4>
        <hr />
        <div class="style-section-wrapper">
            <div class="select-style">
                <div class="form-group">
                    <label for="Select-style-input" class="form-label">Select Style Template:</label>
                    <select name="Select-style-input" id="Select-style-input" class="form-select">
                        <option selected>-- Select --</option>
                        <option value="style_1" <?php //echo ($route['Select-style-input'] == 'style_1') ? 'selected' : ''; ?>>Style 1</option>
                    </select>
                </div>
            </div>
            <div class="preview-style-wrapper">
                <label for="Select-style-input" class="form-label">Preview Template:</label>
                <div class="preview-style"></div>
            </div>
        </div>

        <div class="shortcode-section-wrap">
            <div class="shortcode-section">
                <label for="shortcode-display" class="shortcode-label">Generated Shortcode:</label>
                <div class="shortcode-wrapper">
                    <input type="text" id="shortcode-display" class="shortcode-display" readonly value="[shortcode_placeholder]">
                    <button id="copy-shortcode-btn" class="copy-shortcode-btn">
                        Copy
                        <span class="tooltip" id="tooltip">Copied!</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
