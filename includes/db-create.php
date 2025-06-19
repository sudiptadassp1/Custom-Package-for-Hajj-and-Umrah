<?php
    class DB_Create {

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string    $plugin_name    The ID of this plugin.
         */
        private $plugin_name;
    
        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string    $version    The current version of this plugin.
         */
        private $version;
    
        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         * @param      string    $plugin_name       The name of this plugin.
         * @param      string    $version    The version of this plugin.
         */
        public function __construct( $plugin_name, $version ) {
    
            $this->plugin_name = $plugin_name;
            $this->version = $version;
            add_action('init', [$this, 'save_for_later_DB']);
            add_action('init', [$this, 'submitted_cutom_package_DB']);
        }

        public function save_for_later_DB(){
            global $wpdb;
            $table_name = $wpdb->prefix. "save_for_later_db";
            global $charset_collate;
            $charset_collate = $wpdb->get_charset_collate();
            global $db_version;
            $sql ="";

            if( $wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") !=  $table_name)
            {   
                $sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    package_name varchar(55) DEFAULT NULL,
                    user_id int DEFAULT 0 NULL,
                    package_data_object longtext DEFAULT  NULL,

                    PRIMARY KEY  (id)
                ) $charset_collate;";
            }
            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta( $sql );
        }

        public function submitted_cutom_package_DB(){
            global $wpdb;
            $table_name = $wpdb->prefix. "submitted_custom_package";
            global $charset_collate;
            $charset_collate = $wpdb->get_charset_collate();
            global $db_version;
            $sql ="";

            if( $wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") !=  $table_name)
            {   
                $sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    cphu_full_name varchar(55) DEFAULT NULL,
                    cphu_mobile varchar(55) DEFAULT NULL,
                    cphu_email longtext DEFAULT NULL,

                    cphu_object longtext DEFAULT NULL,
                    cphu_status varchar(55) DEFAULT NULL,
                    PRIMARY KEY  (id)
                ) $charset_collate;";
            }
            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta( $sql );
        }
    }

?>