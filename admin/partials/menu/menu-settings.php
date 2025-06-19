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

 class Menu_Settings{
    public static function settings_page(){
        ?>
            <div class="wrap">
                <h1>Settings page</h1>
                <p>Select the options you want to see in yout custom package</p>
                <hr/>

                <div class="settings_tabs-container">
                    <div class="settings_tabs">
                        <div class="settings_tab active" data-tab="1">Options</div>
                        <div class="settings_tab" data-tab="2">Settings</div>
                        <div class="settings_tab" data-tab="3">Repeater Input</div>
                        <div class="settings_tab" data-tab="4">Display</div>
                    </div>
                    <div class="settings_content active" id="settings_tab-1">
                        <?php
                            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'menu/options.php';
                        ?>
                    </div>
                    <div class="settings_content" id="settings_tab-2">
                        <?php
                            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'menu/settings.php';
                        ?>
                    </div>
                    <div class="settings_content" id="settings_tab-3">
                        <?php
                            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'menu/repeater-input.php';
                        ?>
                    </div>
                    <div class="settings_content" id="settings_tab-4">
                        <?php
                            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'menu/display.php';
                        ?>
                    </div>
                </div>
            </div>
        
        <?php
    }
 }
?>