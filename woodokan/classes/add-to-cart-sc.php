<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if ( ! function_exists( 'kia_add_to_cart_form_shortcode' ) ) {
	/**
	 * Display a single product with single-product/add-to-cart/$product_type.php template.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	function kia_add_to_cart_form_shortcode( $atts ) {

		if ( empty( $atts ) ) {
			return '';
		}

		if ( ! isset( $atts['id'] ) && ! isset( $atts['sku'] ) ) {
			return '';
		}

		if(isset($_GET['ver'])){
			return 'Woodokan lead form';
		}

		$atts = shortcode_atts(
			array(
				'id'                => '',
				'sku'               => '',
				'status'            => 'publish',
				'show_price'        => 'true',
				'hide_quantity'     => 'false',
				'allow_form_action' =>  'false',
			),
			$atts,
			'product_add_to_cart_form'
		);

		$query_args = array(
			'posts_per_page'      => 1,
			'post_type'           => 'product',
			'post_status'         => $atts['status'],
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => 1,
		);

		if ( ! empty( $atts['sku'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_sku',
				'value'   => sanitize_text_field( $atts['sku'] ),
				'compare' => '=',
			);

			$query_args['post_type'] = array( 'product', 'product_variation' );
		}

		if ( ! empty( $atts['id'] ) ) {
			$query_args['p'] = absint( $atts['id'] );
		}

		// Hide quantity input if desired.
		if ( 'true' === $atts['hide_quantity'] ) {
			add_filter( 'woocommerce_quantity_input_min', 'kia_add_to_cart_form_return_one' );
			add_filter( 'woocommerce_quantity_input_max', 'kia_add_to_cart_form_return_one' );
		}

		// Change form action to avoid redirect.
		if ( 'false' === $atts[ 'allow_form_action' ] ) {
			add_filter( 'woocommerce_add_to_cart_form_action', '__return_empty_string' );
		}	

		$single_product = new WP_Query( $query_args );

		$preselected_id = '0';

		// Check if sku is a variation.
		if ( ! empty( $atts['sku'] ) && $single_product->have_posts() && 'product_variation' === $single_product->post->post_type ) {

			$variation  = new WC_Product_Variation( $single_product->post->ID );
			$attributes = $variation->get_attributes();

			// Set preselected id to be used by JS to provide context.
			$preselected_id = $single_product->post->ID;

			// Get the parent product object.
			$query_args = array(
				'posts_per_page'      => 1,
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'no_found_rows'       => 1,
				'p'                   => $single_product->post->post_parent,
			);

			$single_product = new WP_Query( $query_args );
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					var $variations_form = $( '[data-product-page-preselected-id="<?php echo esc_attr( $preselected_id ); ?>"]' ).find( 'form.variations_form' );

					<?php foreach ( $attributes as $attr => $value ) { ?>
						$variations_form.find( 'select[name="<?php echo esc_attr( $attr ); ?>"]' ).val( '<?php echo esc_js( $value ); ?>' );
					<?php } ?>
				});
			</script>
			<?php
		}

		// For "is_single" to always make load comments_template() for reviews.
		$single_product->is_single = true;

		ob_start();

		global $wp_query;

		// Backup query object so following loops think this is a product page.
		$previous_wp_query = $wp_query;
		// @codingStandardsIgnoreStart
		$wp_query          = $single_product;
		// @codingStandardsIgnoreEnd

		wp_enqueue_script( 'wc-single-product' );

		while ( $single_product->have_posts() ) {
			$single_product->the_post();

			?>
			<div class="product single-product add_to_cart_form_shortcode" data-product-page-preselected-id="<?php echo esc_attr( $preselected_id ); ?>">
			    <style>
					.woodokan-lead-form-placeholder{
						display: none;
					}
					#woodokan_form{
						max-width: 100%;
					}
					.woodokan-lead-form-placeholder p{
						padding: 20px;
						border: 2px solid #1f4c9f;
						border-radius: 5px;
						text-align: center;
						background: white;

					}
					.elementor-element-edit-mode form.cart,.elementor-element-edit-mode .woodokan-sicky-buy-btn  {
						display: none !important;
					}
					.elementor-element-edit-mode .woodokan-lead-form-placeholder{
						display: block;
					}
					@media (max-width: 767px) {
					.exp-cod-label{
						position: static;
						transform: unset;
					}
    				}
				</style>
					<div class="woodokan-lead-form-placeholder">
					<p> <span>
					<?php
  					the_title();
				 ?>
					</span></p>
				
				</div>

              

				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>
			<?php
		}

		// Restore $previous_wp_query and reset post data.
		// @codingStandardsIgnoreStart
		$wp_query = $previous_wp_query;
		// @codingStandardsIgnoreEnd
		wp_reset_postdata();

		// Remove filters.
		if ( 'true' === $atts['hide_quantity'] ) {
			remove_filter( 'woocommerce_quantity_input_min', 'kia_add_to_cart_form_return_one' );
			remove_filter( 'woocommerce_quantity_input_max', 'kia_add_to_cart_form_return_one' );
		}

		if ( 'false' === $atts[ 'allow_form_action' ] ) {
			remove_filter( 'woocommerce_add_to_cart_form_action', '__return_empty_string' );
		}	

		return '<div class="woocommerce">' . ob_get_clean() . '</div>';
	}
}
		add_shortcode( 'woodokan_form', 'kia_add_to_cart_form_shortcode' );

		if ( ! function_exists( 'kia_add_to_cart_form_redirect' ) ) {
			/**
			 * Redirect to same page
			 *
			 * @return string
			 */
			function kia_add_to_cart_form_redirect( $url ) {
				return get_permalink();
			}
		}



		if ( ! function_exists( 'kia_add_to_cart_form_return_one' ) ) {
			/**
			 * Return integer
			 *
			 * @return int
			 */
			function kia_add_to_cart_form_return_one() {
				return 1;
			}
		}


function intercept_wc_template( $template, $template_name, $template_path)
    {

 
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
     function css_vars()
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





    function dddd(){
        wp_register_style( 'expcod-form-grid-css',  EXPCOD_URL .'assets/css/bootstrap-grid.css',  array(),  false, 'all' ) ;
        wp_enqueue_style('expcod-form-grid-css');
        wp_add_inline_style( 'expcod-form-grid-css', css_vars() );
        
        wp_register_style( 'expcod-form-styles',  EXPCOD_URL .'assets/css/form.css',  array(),  false, 'all' ) ;
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
    add_filter('wc_get_template','intercept_wc_template',10,3);
    add_action('wp_enqueue_scripts','dddd');