<?php



Class Expcod_Admin{
    public function __construct(){
        add_action( 'admin_menu',array($this , 'add_admin_menu') );
        register_activation_hook( EXPCOD_FILE ,  array($this , 'activate'));
        add_action( 'admin_enqueue_scripts', array($this ,  'woodokan_settings_main_styles' ));
        add_action('add_meta_boxes',array($this , 'add_product_metaboxes'));
        add_action('save_post' , array($this , 'save_meta_box'));  
    }


    
    /**
     * activate
     *
     * @return void
     */
    public  function activate()
    {
        include EXPCOD_PATH . 'admin/install/activate.php';
    }

            
    /**
     * add_admin_menu
     *
     * @return void
     */
    public function add_admin_menu()
    {    
        $Expcod_Admin_Menu = new Expcod_Menu();
    }

    public function woodokan_settings_main_styles(){

        wp_register_style( 'expcod-extra-css',  EXPCOD_URL .'assets/css/extra.css',  array(),  false, 'all' ) ;
        wp_enqueue_style('expcod-extra-css');

        if(isset($_GET['page']) && $_GET['page']==='wd_easyorder_options'){
    
            wp_register_style( 'expcod-setttings-css',  EXPCOD_URL .'assets/css/settings.css',  array(),  false, 'all' ) ;
            wp_enqueue_style('expcod-setttings-css');
            wp_add_inline_style( 'expcod-setttings-css', $this->css_vars() );
            wp_register_style( 'grid-css',  EXPCOD_URL .'assets/css/bootstrap-grid.css',  array(),  false, 'all' ) ;
            wp_enqueue_style('grid-css');
            wp_register_style( 'alert-css',  EXPCOD_URL .'assets/css/notify.min.css',  array(),  false, 'all' ) ;
            wp_enqueue_style('alert-css');
            wp_register_script( 'alert-js',  EXPCOD_URL .'assets/js/notify.min.js',  array(),  false, true) ;
            wp_enqueue_script('alert-js');
    
            wp_register_style( 'expcod-fontawesome',  EXPCOD_URL .'assets/css/all.min.css',  array(),  false, 'all' ) ;
            wp_enqueue_style('expcod-fontawesome');
            wp_register_script( 'html5sortable-js',  EXPCOD_URL .'assets/js/html5sortable.min.js',  array(),  false, true) ;
            wp_enqueue_script('html5sortable-js');
            wp_enqueue_style( 'wp-color-picker' ); 
            wp_enqueue_script(  'wp-color-picker' ); 
            wp_enqueue_style( 'wp-color-picker' ); 
            wp_register_script('expcod-settings-js' , EXPCOD_URL .'assets/js/settings.js',array('jquery'),false,true);
            wp_enqueue_script('expcod-settings-js');
            wp_localize_script( 'expcod-settings-js', 'expcodAjaxObject',array( 'url' => admin_url( 'admin-ajax.php' ),'wd_nonce'=> wp_create_nonce('wd_nonce')));

           if(isset($_GET['page_section'])){
            wp_localize_script( 'expcod-settings-js', 'expcodSection',array( 'sectionName' => $_GET['page_section']));
           }else{
            wp_localize_script( 'expcod-settings-js', 'expcodSection',array( 'sectionName' => 'main'));
           }
        }
    }



    public function add_product_metaboxes()
    {

        add_meta_box( 
            'expcod-form',
            __( 'Express cod checkout','cod-express-checkout' ),
            array($this , 'render_expcod_metabox'),
            'product',
            'side',
            'default',
            'high'
        );
        // add_meta_box( 
        //     'expcod-form-var-price',
        //     __( 'Product promotion for woodoan form ','cod-express-checkout' ),
        //     array($this , 'render_expcod_var_price_metabox'),
        //     'product',
        //     'normal',
        //     'default',
        //     'high'
        // );
    }

    public function render_expcod_metabox($post){

        include(EXPCOD_PATH . 'admin/plugin-pages/components/product-metabox.php');
    }
    public function render_expcod_var_price_metabox($post){

        include(EXPCOD_PATH . 'admin/plugin-pages/components/product-metabox-var-price.php');
    }
    
    /**
     * save_meta_box
     *
     * @param  mixed $post_id
     * @return void
     */
    public function save_meta_box($post_id){
        if ( ! current_user_can( 'manage_options' ) ) {
           return;
        }

        if( isset($_POST['action'])  
            && $_POST['action'] == 'editpost' 
            && isset($_POST['show-expcod-checkout'])
        ){
         
            $showFormoption = sanitize_text_field($_POST['show-expcod-checkout']);
            $prev_showFormoption = get_post_meta($post_id,'expcod_displayForm');
            update_post_meta( $post_id , 'expcod_displayForm', $showFormoption ,   $prev_showFormoption[0] );

            $shippingPrice = sanitize_text_field($_POST['shipping-expcod-checkout']);
            $prev_shippingPrice = get_post_meta($post_id,'expcod_shipping_price');
            update_post_meta( $post_id , 'expcod_shipping_price', $shippingPrice ,   $prev_shippingPrice[0] );


            $checkoutNote = sanitize_text_field($_POST['note-expcod-checkout']);
            $prev_checkoutNote = get_post_meta($post_id,'expcod_checkout_note');
            update_post_meta( $post_id , 'expcod_checkout_note', $checkoutNote ,   $prev_checkoutNote[0] );



        }
        // if( isset($_POST['action'])  
        //     && $_POST['action'] == 'editpost' 
        //     && isset($_POST['woodokan_var_price'])
        // ){
            
         
        //     $checkoutNote = $_POST['woodokan_var_price'];
           
        //    $prev_checkoutNote = get_post_meta($post_id,'woodokan_var_price');
        //     update_post_meta( $post_id , 'woodokan_var_price', $checkoutNote ,   $prev_checkoutNote[0] );



        // }
    }

    public function css_vars()
    {
        $expcod_styles = codexp()->settings->get('stylings');
        $vars          = "
        :root {
            --expcod-inp-border-width:{$expcod_styles->input_border_width}px;
            --expcod-inp-border-color:$expcod_styles->input_border_color ;
            --expcod-inp-height:{$expcod_styles->input_height}px;
            --expcod-inp-border-radius:{$expcod_styles->input_border_radius}px;
            --expcod-inp-bg-color:$expcod_styles->input_background_color;
            --expcod-txt-color:$expcod_styles->input_text_color;
            --expcod-placeholder-fontSize : {$expcod_styles->input_placeholder_text_size}px !important;
            --expcod-inp-borderColor-onfocus: $expcod_styles->input_border_color_onfocus;
            --expcod-inp-borderWidth-onfocus: {$expcod_styles->input_border_width_onfocus}px;

            --expcod-buyNow-txtColor :$expcod_styles->button_text_color;
            --expcod-buyNow-bgColor:$expcod_styles->button_background_color;
            --expcod-buyNow-borderColor: $expcod_styles->button_border_color;
            --expcod-buyNow-borderWidth: {$expcod_styles->button_border_width}px;
            --expcod-buyNow-fontSize: {$expcod_styles->button_text_size}px;
            --expcod-buyNow-height: {$expcod_styles->button_height}px;
            --expcod-buyNow-color-onhover :  $expcod_styles->button_text_color_onhover;
            --expcod-buyNow-bgColor-onhover:   $expcod_styles->button_background_color_onhover;
          
            --expcod-label-color :  $expcod_styles->label_text_color;
            --expcod-label-fontSize :  {$expcod_styles->label_text_size}px;
            --expcod-label-marginBottom :   {$expcod_styles->label_margin_bottom}px;
            --expcod-label-marginTop :  {$expcod_styles->label_margin_top}px;
            --expcod-label-fontWeight :  $expcod_styles->label_text_weight;
            --expcod-label-display :  $expcod_styles->label_visibility;
          
          
            --expcod-form-marginTop :  {$expcod_styles->form_margin_top}px;
            --expcod-form-marginBottom :  {$expcod_styles->form_margin_bottom}px;
            --expcod-form-borderColor:$expcod_styles->form_border_color;
            --expcod-form-borderWidth: {$expcod_styles->form_border_width}px;
            --expcod-form-borderRadius: {$expcod_styles->form_border_radius}px;
            --expcod-form-padding: {$expcod_styles->form_padding}px;
          }";
          return  $vars;
    }

    
}