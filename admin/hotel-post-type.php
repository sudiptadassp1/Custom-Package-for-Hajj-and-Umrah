<?php
    class Hotel_Post_Type {

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
            add_action('init', [$this, 'create_hotel']);
            add_action('init', [$this, 'registerHotelTaxonomies']);
            // $this->registerHotelTaxonomies(); // Register custom taxonomies

    
        }

        public function create_hotel(){
            $labels = array(
                'name'                  => _x('Hotels', 'Post Type General Name', 'textdomain'),
                'singular_name'         => _x('Hotel', 'Post Type Singular Name', 'textdomain'),
                'menu_name'             => __('Hotels', 'textdomain'),
                'name_admin_bar'        => __('Hotel', 'textdomain'),
                'archives'              => __('Hotel Archives', 'textdomain'),
                'attributes'            => __('Hotel Attributes', 'textdomain'),
                'parent_item_colon'     => __('Parent Hotel:', 'textdomain'),
                'all_items'             => __('All Hotels', 'textdomain'),
                'add_new_item'          => __('Add New Hotel', 'textdomain'),
                'add_new'               => __('Add New Hotel', 'textdomain'),
                'new_item'              => __('New Hotel', 'textdomain'),
                'edit_item'             => __('Edit Hotel', 'textdomain'),
                'update_item'           => __('Update Hotel', 'textdomain'),
                'view_item'             => __('View Hotel', 'textdomain'),
                'view_items'            => __('View Hotels', 'textdomain'),
                'search_items'          => __('Search Hotels', 'textdomain'),
                'not_found'             => __('Not found', 'textdomain'),
            );
    
            $args = array(
                'label'                 => __('Hotel', 'textdomain'),
                'public'                => true,
                'labels'                => $labels,
                'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
                'has_archive'           => true,
                'menu_icon'             => 'dashicons-building',
            );
    
            register_post_type('hotel', $args);
        }

        // Register custom taxonomies for the hotel post type
        public function registerHotelTaxonomies() {
            // Register "Makka Hotel Type" taxonomy
            $labels_makka = array(
                'name'              => _x('Makka Hotel Types', 'taxonomy general name', 'textdomain'),
                'singular_name'     => _x('Makka Hotel Type', 'taxonomy singular name', 'textdomain'),
                'search_items'      => __('Search Makka Hotel Types', 'textdomain'),
                'all_items'         => __('All Makka Hotel Types', 'textdomain'),
                'edit_item'         => __('Edit Makka Hotel Type', 'textdomain'),
                'add_new_item'      => __('Add New Makka Hotel Type', 'textdomain'),
                'menu_name'         => __('Makka Hotel Types', 'textdomain'),
            );

            $args_makka = array(
                'labels'            => $labels_makka,
                'hierarchical'      => true, // True for category-like behavior
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'      => true,
                'show_admin_column' => true,
                'show_in_rest'      => true, // Enable for Gutenberg editor
            );

            register_taxonomy('makka_hotel_type', array('hotel'), $args_makka);

            // Register "Madina Hotel Type" taxonomy
            $labels_madina = array(
                'name'              => _x('Madina Hotel Types', 'taxonomy general name', 'textdomain'),
                'singular_name'     => _x('Madina Hotel Type', 'taxonomy singular name', 'textdomain'),
                'search_items'      => __('Search Madina Hotel Types', 'textdomain'),
                'all_items'         => __('All Madina Hotel Types', 'textdomain'),
                'edit_item'         => __('Edit Madina Hotel Type', 'textdomain'),
                'add_new_item'      => __('Add New Madina Hotel Type', 'textdomain'),
                'menu_name'         => __('Madina Hotel Types', 'textdomain'),
            );

            $args_madina = array(
                'labels'            => $labels_madina,
                'hierarchical'      => true,
                'public'            => true,
                'show_ui'           => true,
                'show_in_menu'      => true,
                'show_admin_column' => true,
                'show_in_rest'      => true,
            );

            register_taxonomy('madina_hotel_type', array('hotel'), $args_madina);
        }
    }
?>