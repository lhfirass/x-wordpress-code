<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
$fields = codexp()->settings->get('fields');
$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
$wd_form_title = codexp()->settings->get('stylings')->form_title;
$wd_button_text = codexp()->settings->get('stylings')->button_text;
$shipping_list = codexp()->settings->get('shipping');
#------------ get product variations




// var_dump($vars);


do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<?php do_action('woodokan_countdown',$product->is_on_sale()) ?>

<div class="codexp-error-message"></div>
<div id="woodokan-form-wrapper">
<div id="expcod-checkout"></div>
<div class="express-cod-checkout-wrapper">
<form class=" variations_form express-cod-checkout-form" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>" id="woodokan_form">
<label  class="exp-cod-label"><?php echo $wd_form_title;?> </label>
<span style="display: block; height:20px"></span>
<div class="codexp-success-message" style="margin-bottom:10px"></div>


<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'cod-express-checkout' ) ) ); ?></p>
	<?php else : ?>
		<script> var is_product_do_variable = true ;</script>
		<div class="variations " cellspacing="0" role="presentation">
			
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					
					<!-- <label class="" for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label> -->
						
							<?php
							$attr_id = wc_attribute_taxonomy_id_by_name( $attribute_name ); $text_value = get_option( "woocommerce_custom_attribute_field-$attr_id" ); 
							 
								wc_dropdown_variation_attribute_options(
									array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
										'show_option_none'=>$text_value
									)
								);
								echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( '', 'cod-express-checkout' ) . '</a>' ) ) : '';
							?>	
				<?php endforeach; ?>
			
							</div>
		<?php do_action( 'woocommerce_after_variations_table' ); ?>
		<div class="row woodokan-form-elements"> <!----- Start fields ------>
				
				<div class="col-md-12"><!---- -Start  Customer info label ----->
					
				</div><!----- End Customer info label ----->
				<script>var  is_shipping_options = false ;</script>
				<?php foreach($fields as $field): ?>

					<!----- shipping pricies ----->
					<?php if($field->fieldType == 'field_type_5'): ?>
						<?php if($field->filedActive == true):?>
					<div class="col-md-<?php echo $field->fullSizing == 1	?   '6' : '12'; ?>">
						<div class="" style="margin-bottom:20px">
						<?php if(!empty($field->labelText)):?>
							
						<?php endif; $is_shipping_option = true;?>	
						    <select name="<?php echo esc_attr($field->fieldType); ?>" class="expcod-input" id="shipping_price" style="width:100%">
							<option value="none"><?php echo esc_attr__($field->placeholderText); ?></option>
									<?php foreach($shipping_list as $item):?>
										<option value="<?php echo $item->element_name ?>" data-elprice="<?php echo $item->element_value ?>"><?php echo $item->element_name ?></option>
										<?php endforeach;?>
							</select>
							<small style="color:red" id="<?php echo esc_attr($field->fieldType); ?>"></small>
							<script> is_shipping_options = true ;</script>

				
						
						</div>
					</div>
					<?php  endif; ?>
					<?php continue;endif; ?>
					<!----- end shipping pricies ----->


					<!----- tel ----->
					<?php if($field->fieldType == 'field_type_7'): ?>
						<?php if($field->filedActive == true):?>
					<div class="col-md-<?php echo $field->fullSizing == 1	?   '6' : '12'; ?>">
						<div class="" style="margin-bottom:20px">
						<?php if(!empty($field->labelText)):?>
							
						<?php endif; ?>	
							<input type="tel" class="form-control expcod-input" id="floatingInput" name="<?php echo esc_attr($field->fieldType); ?>" placeholder="<?php echo esc_attr__($field->placeholderText); ?>">
							<small style="color:red" id="<?php echo esc_attr($field->fieldType); ?>"></small>
						
						</div>
					</div>
					<?php  endif; ?>
					<?php continue;endif; ?>
					<!----- end tel ----->


					<!--- other fields ----->
					
					<?php if($field->filedActive == true):?>
					<div class="col-md-<?php echo $field->fullSizing == 1	?   '6' : '12'; ?>">
						<div class="" style="margin-bottom:20px">
						<?php if(!empty($field->labelText)):?>
							
						<?php endif; ?>	
							<input type="text" class="form-control expcod-input" id="floatingInput" name="<?php echo esc_attr($field->fieldType); ?>" placeholder="<?php echo esc_attr__($field->placeholderText); ?>">
							<small style="color:red" id="<?php echo esc_attr($field->fieldType); ?>"></small>
						
						</div>
					</div>
					<?php  endif; ?>
					<!--- other fields ----->


				<?php endforeach; ?>
			
			</div> <!---- End fields------>
		<div class="single_variation_wrap">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
	<input type="hidden" name="codexp_nonce" value="<?php echo wp_create_nonce( 'codexp_nonce' );?>">
	<?php if(current_user_can('administrator')): ?>



	<?php endif; do_action( 'order_summary_wd_dropdown',$product );?>
</form>
<!-- <span id="colored-wheel"></span> -->
</div>
</div>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
