<?php

Class Expcod_Front{


   public static $printCodFields = false;
   public static $filterIsOn = true;
    
    public function __construct()
    {
        add_action('template_redirect', array($this , 'product_page_checks'));
        add_action('get_upsel_model',array($this , 'print_upsell_model'));
        add_action('woodokan_countdown',array($this , 'woodokan_cownter'));
        // add_action('woodokan_var_price',array($this , 'woodokan_var_price'));
        
    }


    
    /**
     * product_page_checks checks if cod form should be printed
     * This will enquee scripts and filter default woocommerce template
     * only if neccessay
     * @return void
     */
    public function product_page_checks(){

        // check [ 1 ] : check if current page is a product page
        $e_landing = is_singular(array('e-landing-page','product'));
    
        if(!$e_landing){return;};
        // exit;

        // check [ 2 ] : check if CODexp is enabled for this product
        if(!$e_landing){
          
            $post       = get_post();
            $display_form = codexp()->settings->get('redirections')->form_display;
            if(!$display_form){
                $enabled    = get_post_meta($post->ID,'expcod_displayForm');
                if(empty($enabled) || $enabled[0] != 1){ return;}
            }
        }



        // check [ 3 ] : check if codexp active fields > 0
        $activeFields       = codexp()->settings->get('fields');
        $thereIsOne         = false;
        foreach($activeFields as $field){  
            if($field->filedActive == true){
                $thereIsOne = true;
            }
        }
        if(!$thereIsOne){ return;}

        // [RESULT] : if all checks passed then do this :
        
        add_action( 'wp_enqueue_scripts', array($this,'codexpress_form_styles') );
        if(!is_product()){
            $this->add_template_filter();
        }else{
        add_action('woocommerce_before_single_product' , array($this , 'add_template_filter'));
        add_action('woocommerce_product_meta_end' , array($this , 'remove_template_filter'));
        }

        add_action( 'wp_body_open', array($this , 'print_customizer'));
        if(!isset($_GET['ver'])){
            add_action( 'wp_footer', array($this , 'add_sticky_buy_now') );
        }
       
     
    }
    
    /**
     * add_template_filter
     *
     * @return void
     */
    public function add_template_filter(){
        add_filter( 'wc_get_template', array($this , 'intercept_wc_template'), 10, 3 );
    }
    
    /**
     * remove_template_filter
     *
     * @return void
     */
    public function remove_template_filter(){

        static::$filterIsOn = false;
    }

    
    /**
     * print_customizer
     *
     * @return void
     */
    public function print_customizer(){
        if(current_user_can('administrator')){
            // include(EXPCOD_PATH. 'template/customize-sidebar.php');

        }
           
            
    }
    
    /**
     * enquee_customizer_scripts
     *
     * @return void
     */
    public function enquee_customizer_scripts(){
      

    }
    
    /**
     * intercept_wc_template
     *
     * @param  mixed $template
     * @param  mixed $template_name
     * @param  mixed $template_path
     * @return void
     */
    public function intercept_wc_template( $template, $template_name, $template_path)
    {

       if(!static::$filterIsOn){
        /*
        ** This check is used to prevent template filter from being applied in 
        ** other contexts where add to card button is printed
        ** for example in sticky add to cart button , we do not want sticky add to cart button
        ** to be modified as well
        ** The remove_template_filter() methode is linked to woocommerce_product_meta_end
        ** when the hook is fired remove_template_filter() changes [static::$filterIsOn] to false
        ** means no need to apply this filter the future  and return $template as it is
        ** we did not used remove filter because it affects other sections
        **/
        return $template;
       }

        $custom_templates = array(

            "simple.php" =>"add-to-cart-form/simple.php",
            "variable.php"=>"add-to-cart-form/variable.php",
            "variation.php"=>"add-to-cart-form/variation.php",
            "variation-add-to-cart-button.php"=>"add-to-cart-form/variation-add-to-cart-button.php",
            "quantity-input.php"=>"add-to-cart-form/quantity-input.php"

        );
    
    
    
        foreach($custom_templates as $custom_template => $custom_template_path):

        if ( $custom_template === basename( $template ) ) {
            $template = trailingslashit( EXPCOD_PATH ) . 'template/woocommerce/'.$custom_template_path;
        }
        endforeach;
    
        return $template;
    }


    
    /**
     * codexpress_form_styles
     *
     * @return void
     */
    public function codexpress_form_styles()
    {

        wp_register_style( 'expcod-form-grid-css',  EXPCOD_URL .'assets/css/bootstrap-grid.css',  array(),  false, 'all' ) ;
        wp_enqueue_style('expcod-form-grid-css');
        wp_add_inline_style( 'expcod-form-grid-css', $this->css_vars() );
        
        wp_register_style( 'expcod-form-styles',  EXPCOD_URL .'assets/css/form.css',  array(),  WDLF_VERSION, 'all' ) ;
        wp_enqueue_style('expcod-form-styles');
        
        wp_register_style( 'expcod-fontawesome',  EXPCOD_URL .'assets/css/all.min.css',  array(),  false, 'all' ) ;
        wp_enqueue_style('expcod-fontawesome');

        wp_register_script( 'form-script',  EXPCOD_URL .'assets/js/form.js',  array('jquery'),  false,true ) ;
        wp_enqueue_script('form-script');

        wp_enqueue_script('jquery');
       
        
      

        $jsTranslation = array(
            'your_order' => __('Your order', 'cod-express-checkout'),
            'total' => __('Total', 'cod-express-checkout'),
            'shipping' => __('Shipping', 'cod-express-checkout'),
            'quantity' => __('Quantity', 'cod-express-checkout'),
            'product_price' => __('Product price', 'cod-express-checkout'),
            'edit' => __('Edit', 'cod-express-checkout'),
            'place_order' => __('Place order', 'cod-express-checkout'),
            'notice' => __('Notice', 'cod-express-checkout'),
            'type' => __('Type', 'cod-express-checkout')
           );

           $pixels = codexp()->settings->get('pixels');
           wp_localize_script( 'form-script', 'expcodAjaxObject',array( 'ajax_url' => admin_url( 'admin-ajax.php' ),'wd_nonce'=> wp_create_nonce('wd_nonce'),'codexpressTranslation'=>$jsTranslation,'pixels'=> $pixels));
    }

    
    /**
     * css_vars
     *
     * @return string Css variables in header
     */
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
            --expcod-sticky-button:   $expcod_styles->sticky_button;
            --expcod-quantity-input:   $expcod_styles->quantity_input;
            --expcod-order-summary:   $expcod_styles->order_summary;
            --expcod-order-default:   $expcod_styles->order_summary_default_state;
          
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
            --expcod-form-max-width: {$expcod_styles->form_max_width}px;
            --expcod-bg-color: {$expcod_styles->form_bg_color};
            --expcod-form-borderType: {$expcod_styles->form_border_type};
            
          }";
          return  $vars;
    }



    public function  add_sticky_buy_now(){
        ?>
        <style>
 

html {
  scroll-behavior: smooth;
}
body{
    padding-bottom:70px;
}
</style>
<div class="woodokan-sicky-buy-btn wdk-sticky-visible">
    <a id="sticky_button_woodokan" class=" wdk-sticky wdk-shaked-sticky">
    <?php echo  codexp()->settings->get('stylings')->button_text;?>
</a>
</div>
<script>
    document.getElementById('sticky_button_woodokan').addEventListener('click',function(){
        var form = document.getElementById("woodokan_form");
       
            var formRect = form.getBoundingClientRect();
            var offsetTop = formRect.top + window.pageYOffset - 150  ; // Adjust the offset as needed
            window.scrollTo({ top: offsetTop, behavior: 'smooth' });
    })
    var observer = new IntersectionObserver(function(entries) {
	// isIntersecting is true when element and viewport are overlapping
	// isIntersecting is false when element and viewport don't overlap
    let form = document.getElementById("woodokan_form");
            let offsetTop = form.offsetTop - 100; // Adjust the offse
            console.log(form.offsetTop);
	if(entries[0].isIntersecting === true){
        document.querySelector(".woodokan-sicky-buy-btn").classList.remove('wdk-sticky-visible')
    }else{
        document.querySelector(".woodokan-sicky-buy-btn").classList.add('wdk-sticky-visible')
    }
		
       
}, { threshold: [0] });

observer.observe(document.querySelector("#woodokan_form"));
</script>
<?php
    }


    public function print_upsell_model($ids){

        require_once EXPCOD_PATH . '/template/upsell.php';

    }




    public function woodokan_cownter($is_product_on_sale){
        if ($is_product_on_sale) {
            if(get_post_meta(get_the_ID(), '_sale_price_dates_to', true)){
                require_once EXPCOD_PATH . '/template/countdown.php';
            }
       
        }
    }
    public function woodokan_var_price($product){
        $post       = get_post();
        $meta = get_post_meta($post->ID , 'woodokan_var_price')[0];
        $meta = json_decode($meta);
      
        if(count($meta)>0){
            require_once EXPCOD_PATH . '/template/var_price.php'; 
        }
       
    }


}