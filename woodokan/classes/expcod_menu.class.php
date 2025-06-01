<?php

class Expcod_Menu{

    public function __construct()
    {

        $this->add_menu_page();
        add_action('admin_init',array($this , 'add_settings_section'));
        add_action('admin_init', array($this ,'wd_add_settings_field'));
    }

    
    /**
     * add menu in admin dashboard
     *
     * @return void
     */
    public function add_menu_page() 
    { 

    

        $the_admin_page =  add_menu_page(


            __('Form','cod-express-checkout'),
            __('Woodokan','cod-express-checkout'),

            'manage_woocommerce',

            'wd_easyorder_options',

            array($this,'admin_configs_page'),
            'dashicons-editor-paste-word',
            6

           );

           add_submenu_page(
            'wd_easyorder_options',
            'Google sheets',
            'Google sheets',
            'manage_options',
            'woodokan-sheets-integration&tab=googlesheets',
            'wpdocs_my_custom_submenu_page_callback' );
            global $submenu;
            $submenu['wd_easyorder_options'][0][0] = 'Form';

           

           /*
           ** Add help tabs to plugin pages
           */
           function the_admin_page () {

                require(EXPCOD_PATH.'admin/plugin-pages/components/help-tabs.php');
            }
     
      }

    public function admin_configs_page()
    {
   
        require(EXPCOD_PATH.'admin/plugin-pages/main.php');
    }



    public function add_settings_section()
    {
          
        add_settings_section(
            'wd_product_checkout_settings',
            '',
            null,
            'codexpress_fiels'
        );

    }

    public function wd_add_settings_field()
    {
        
        register_setting(
            'general_group',
            'wd_settings'
        );

       
        add_settings_field( 
            'wd_checkouts_json_field',
            '', 
            array($this ,'render_setgs_field'),
            'codexpress_fiels',
            'wd_product_checkout_settings'
          
        );
    }

    
    /**
     * print a field under save settings button in admin front of the plugin
     *
     * @return void
     */
    public function render_setgs_field()
    {


        if(isset($_GET['page_section']) && $_GET['page_section']=="stylings"){

            echo '<input type="hidden" name="wd_settings[expcod_stylings]" id="settings">';

        }elseif(isset($_GET['page_section']) && $_GET['page_section']=="redirections"){

            echo '<input type="hidden" name="wd_settings[expcod_redirections]" id="settings">';

        }elseif(isset($_GET['page_section']) && $_GET['page_section']=="sheets"){

            echo '<input type="hidden" name="wd_settings[expcod_sheets]" id="settings">';

       
        }elseif(isset($_GET['page_section']) && $_GET['page_section']=="pixels"){

            echo '<input type="hidden" name="wd_settings[expcod_pixels]" id="settings">';

      
        }elseif(isset($_GET['page_section']) && $_GET['page_section']=="shipping"){

            echo '<input type="hidden" name="wd_settings[expcod_shipping]" id="settings">';


        }elseif(isset($_GET['page_section']) && $_GET['page_section']=="sheets"){

            echo '<input type="hidden" name="wd_settings[expcod_sheets]" id="sheets">';

        }else{
            echo '<input type="hidden" name="wd_settings[expcod_fields]" id="settings">';
    
        }
        
    }

}