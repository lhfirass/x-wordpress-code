<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


    
    /**
     * Advanced Form Integration Main Class
     */
    class woodokan_google_sheets_integration
    {
        /**
         * Plugin Version
         *
         * @var  string
         */
        public  $version = '1.68.3' ;
        /**
         * Initializes the woodokan_google_sheets_integration class
         *
         * Checks for an existing woodokan_google_sheets_integration instance
         * and if it doesn't find one, creates it.
         *
         * @since 1.0.0
         * @return mixed | bool
         */
        public static function init()
        {
            static  $instance = false ;
            if ( !$instance ) {
                $instance = new woodokan_google_sheets_integration();
            }
            return $instance;
        }
        
        /**
         * Constructor for the woodokan_google_sheets_integration class
         *
         * Sets up all the appropriate hooks and actions
         *
         * @since 1.0
         * @return void
         */
        public function __construct()
        {
            register_activation_hook( __FILE__, [ $this, 'activate' ] );
            register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
            add_action(
                'wp_insert_site',
                array( $this, 'new_site_added' ),
                10,
                6
            );
            $this->init_plugin();
        }
        
        /**
         * Initialize plugin
         *
         * @since 1.0.0
         * @return void
         */
        public function init_plugin()
        {
            /* Define constats */
            $this->define_constants();
            /* Include files */
            $this->includes();
            /* Instantiate classes */
            $this->init_classes();
            /* Initialize the action hooks */
            $this->init_actions();
            /* Initialize the filter hooks */
            $this->init_filters();
        }
        
        /**
         * Function activate
         *
         * This function creates the database tables for the plugin.
         *
         * @param bool $networkwide Whether to activate the plugin network-wide.
         */
        public function activate( $networkwide )
        {
            if ( function_exists( 'is_multisite' ) && is_multisite() ) {
                
                if ( $networkwide ) {
                    global  $wpdb ;
                    $blogids = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs}" );
                    foreach ( $blogids as $blog_id ) {
                        switch_to_blog( $blog_id );
                        $this->create_table();
                        restore_current_blog();
                    }
                    return;
                }
            
            }
            $this->create_table();
            // Create default tables when plugin activates
        }
        
        /**
         * Function new_site_added
         *
         * This function creates the database tables for the plugin on a newly added site in a multisite network.
         *
         * @param object $site The newly added site object.
         */
        public function new_site_added( $site )
        {
            
            if ( is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
                switch_to_blog( $site->blog_id );
                $this->create_table();
                restore_current_blog();
            }
        
        }
        
        /**
         * Function create_table
         *
         * This function creates the database tables for the plugin.
         *
         * @return void
         */
        private function create_table()
        {
            global  $wpdb ;
            $collate = '';
            
            if ( $wpdb->has_cap( 'collation' ) ) {
                if ( !empty($wpdb->charset) ) {
                    $collate .= "DEFAULT CHARACTER SET {$wpdb->charset}";
                }
                if ( !empty($wpdb->collate) ) {
                    $collate .= " COLLATE {$wpdb->collate}";
                }
            }
            
            $table_schema = array( "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}woodokan_integration` (\n                    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n                    `title` text NOT NULL,\n                    `form_provider` varchar(255) NOT NULL,\n                    `form_id` varchar(255) NOT NULL,\n                    `form_name` varchar(255) DEFAULT NULL,\n                    `action_provider` varchar(255) NOT NULL,\n                    `task` varchar(255) NOT NULL,\n                    `data` longtext DEFAULT NULL,\n                    `extra_data` longtext DEFAULT NULL,\n                    `status` int(1) NOT NULL,\n                    `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n                    KEY `id` (`id`)\n                ) {$collate};", "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}woodokan_log` (\n                    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n                    `response_code` int(3) DEFAULT NULL,\n                    `response_message` varchar(255) DEFAULT NULL,\n                    `integration_id` bigint(20) DEFAULT NULL,\n                    `request_data` longtext DEFAULT NULL,\n                    `response_data` longtext DEFAULT NULL,\n                    `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n                    KEY `id` (`id`)\n                ) {$collate};" );
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            foreach ( $table_schema as $table ) {
                dbDelta( $table );
            }
        }
        
        /**
         * Plugin deactivation function
         *
         * @since 1.0
         * @return void
         */
        public function deactivate()
        {
        }
        
        /**
         * Function define_constants
         *
         * This function defines the plugin's constants.
         *
         * @return void
         */
        public function define_constants()
        {
            define( 'ADVANCED_FORM_INTEGRATION_VERSION', $this->version );
            // Plugin Version
            define( 'ADVANCED_FORM_INTEGRATION_FILE', __FILE__ );
            // Plugin Main Folder Path
            define( 'ADVANCED_FORM_INTEGRATION_PATH', dirname( ADVANCED_FORM_INTEGRATION_FILE ) );
            // Parent Directory Path
            define( 'ADVANCED_FORM_INTEGRATION_INCLUDES', ADVANCED_FORM_INTEGRATION_PATH . '/includes' );
            // Include Folder Path
            define( 'ADVANCED_FORM_INTEGRATION_URL', plugins_url( '', ADVANCED_FORM_INTEGRATION_FILE ) );
            // URL Path
            define( 'ADVANCED_FORM_INTEGRATION_ASSETS', ADVANCED_FORM_INTEGRATION_URL . '/assets' );
            // Asset Folder Path
            define( 'ADVANCED_FORM_INTEGRATION_VIEWS', ADVANCED_FORM_INTEGRATION_PATH . '/views' );
            // View Folder Path
            define( 'ADVANCED_FORM_INTEGRATION_PLATFORMS', ADVANCED_FORM_INTEGRATION_PATH . '/platforms' );
            // View Folder Path
            define( 'ADVANCED_FORM_INTEGRATION_TEMPLATES', ADVANCED_FORM_INTEGRATION_PATH . '/templates' );
            // View Folder Path
            define( 'ADVANCED_FORM_INTEGRATION_PRO', ADVANCED_FORM_INTEGRATION_PATH . '/pro' );
            // View Folder Path
        }
        
        /**
         * Include the required files
         *
         * @since 1.0
         * @return void
         */
        public function includes()
        {
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/class-adfoin-db.php';
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/class-adfoin-admin-menu.php';
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/class-adfoin-list-table.php';
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/class-adfoin-integration.php';
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/class-adfoin-log.php';
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/class-adfoin-log-table.php';
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/class-adfoin-submission.php';
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/class-adfoin-review.php';
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/class-oauth.php';
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/functions-cf7.php';
            include ADVANCED_FORM_INTEGRATION_INCLUDES . '/functions-adfoin.php';
            $platform_settings = woodokan_get_action_platform_settings();
            foreach ( $platform_settings as $platform => $value ) {
                if ( true == $value ) {
                    if ( file_exists( ADVANCED_FORM_INTEGRATION_PLATFORMS . "/{$platform}/{$platform}.php" ) ) {
                        include ADVANCED_FORM_INTEGRATION_PLATFORMS . "/{$platform}/{$platform}.php";
                    }
                }
            }
        }
        
        /**
         * Instantiate classes
         *
         * @since 1.0
         * @return void
         */
        public function init_classes()
        {
            // Admin Menu Class
            new woodokan_google_sheets_integration_Admin_Menu();
            // Submission Handler Class
            new woodokan_google_sheets_integration_Submission();
        }
        
        /**
         * Initializes action hooks
         *
         * @since 1.0
         * @return  void
         */
        public function init_actions()
        {
            add_action( 'init', array( $this, 'localization_setup' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'register_public_scripts' ) );
        }
        
        /**
         * Initialize plugin for localization
         *
         * @since 1.0
         *
         * @uses load_plugin_textdomain()
         *
         * @return void
         */
        public function localization_setup()
        {
            load_plugin_textdomain( 'advanced-form-integration', false, ADVANCED_FORM_INTEGRATION_FILE . '/languages/' );
        }
        
        /**
         * Initializes action filters
         *
         * @since 1.0
         * @return  void
         */
        public function init_filters()
        {
        }
        
        /**
         * Register Scripts
         *
         * @since 1.0
         * @return mixed | void
         */
        public function register_scripts( $hook )
        {
            wp_register_script(
                'adfoin-vuejs',
                ADVANCED_FORM_INTEGRATION_ASSETS . '/js/vue.min.js',
                array( 'jquery' ),
                '',
                1
            );
            wp_register_script(
                'adfoin-main-script',
                ADVANCED_FORM_INTEGRATION_ASSETS . '/js/script.js',
                array( 'adfoin-vuejs' ),
                $this->version,
                1
            );
            wp_register_style(
                'adfoin-main-style',
                ADVANCED_FORM_INTEGRATION_ASSETS . '/css/asset.css',
                array(),
                $this->version
            );
            $localize_scripts = array(
                'nonce'          => wp_create_nonce( 'advanced-form-integration' ),
                'delete_confirm' => __( 'Are you sure to delete the integration?', 'advanced-form-integration' ),
                'list_url'       => admin_url( 'admin.php?page=advanced-form-integration&status=1' ),
            );
            // $localize_scripts['afiCodeEditor'] = wp_enqueue_code_editor(array('type' => 'application/json'));
            wp_localize_script( 'adfoin-main-script', 'adfoin', $localize_scripts );
            $this->add_log_code_editor();
        }
        
        /**
         * Function add_log_code_editor
         *
         * This function adds a code editor to the Advanced Form Integration log page.
         *
         * @return void
         */
        public function add_log_code_editor()
        {
            if ( 'afi_page_advanced-form-integration-log' !== get_current_screen()->id ) {
                return;
            }
            $settings = wp_enqueue_code_editor( array(
                'type' => 'application/json',
            ) );
            if ( false === $settings ) {
                return;
            }
            wp_add_inline_script( 'code-editor', sprintf( 'jQuery( function() { wp.codeEditor.initialize( "#adfoin-log-request-data", %s ); } );', wp_json_encode( $settings ) ) );
        }
        
        /**
         * Register Public Script
         *
         * @since 1.53.0
         * @return mixed | void
         */
        public function register_public_scripts()
        {
            
            if ( 1 == get_option( 'woodokan_general_settings_utm' ) ) {
                wp_enqueue_script(
                    'js.cookie',
                    ADVANCED_FORM_INTEGRATION_ASSETS . '/js/js.cookie.js',
                    array( 'jquery' ),
                    $this->version,
                    1
                );
                wp_enqueue_script(
                    'afi-utm-grabber',
                    ADVANCED_FORM_INTEGRATION_ASSETS . '/js/utm-grabber.js',
                    array( 'jquery', 'js.cookie' ),
                    $this->version,
                    1
                );
            }
        
        }
    
    }
    $woodokan_gs = woodokan_google_sheets_integration::init();

