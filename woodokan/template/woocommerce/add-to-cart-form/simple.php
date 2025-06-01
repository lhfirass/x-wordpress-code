<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */
 
defined( 'ABSPATH' ) || exit;
$fields = codexp()->settings->get('fields');
$wd_label = codexp()->settings->get('stylings')->form_title;
$show_inp = codexp()->settings->get('stylings')->quantity_input;
$shipping_list = codexp()->settings->get('shipping');

global $product;


if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

<?php do_action('woodokan_countdown',$product->is_on_sale()) ?>
<script> var is_product_do_variable = false ;</script>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<div class="codexp-error-message"></div>
<div class="cod-checkout">
<div id="expcod-checkout" style="display:none"></div>
<div class="express-cod-checkout-wrapper">
	<form class="express-cod-checkout-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' id="woodokan_form">
	<label  class="exp-cod-label"><?php echo $wd_label;?> </label>
	<span style="display: block; height:20px"></span>
	<div class="codexp-success-message" style="margin-bottom:10px"></div>

	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
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
							
						<?php endif; $is_shipping_option = true; ?>	
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
		
		<?php do_action( 'woocommerce_before_add_to_cart_quantity' );?>

		<div class="row woodokan-form-elements">
		<?php
		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
			
			<div class="col-12 <?php if($show_inp != 'none'):?>col-md-8<?php endif; ?>">
			<button class="btn btn-success wdk-shaked single_add_to_cart_button btn-lg w-100 d-block buy_now_btn expcod-buy-now-btn" id="buy_now_btn" type="button">
				<!-- button text -->
				<span id="woodokan_buy_now_button" class="expcod-buyNow-text"> <?php echo  codexp()->settings->get('stylings')->button_text;?></span>
				<!-- Loading Animation -->
				<div class="expcod-brn-loader-animation" id="buy_now_btn_loader">
					<div class="lds-spinner" ><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
				</div>
			</button>
			</div>
		</div>
		<input type="hidden" name="product_type" value="simple" />
		<input type="hidden" name="action" value="new_expcod_order">
		<input type="hidden" name="codexp_nonce" value="<?php echo wp_create_nonce( 'codexp_nonce' );?>">
		<?php if(isset($is_shipping_option) &&  $is_shipping_option==true): ?>
		<input type="hidden" name="expcod_shipping_price" value="" id='expcod_shipping_price'>
		<?php else: ?>
		<input type="hidden" name="expcod_shipping_price" value="<?php echo get_post_meta($product->get_id(),'expcod_shipping_price')[0] ?>" id='expcod_shipping_price'>
		<?php endif; ?>
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

		<?php  do_action( 'order_summary_wd_dropdown',$product );?>	
	</form>
</div>
	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
	</div>
<?php endif; ?>
