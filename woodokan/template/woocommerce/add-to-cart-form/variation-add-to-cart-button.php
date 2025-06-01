<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
$show_inp = codexp()->settings->get('stylings')->quantity_input;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );?>
<div class="row woodokan-form-elements">
	<?php woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		)
	); ?>

	<?php do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>

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
	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<!-- <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" /> -->
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_type" value="variable" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
	<input type="hidden" name="action" value="new_expcod_order">
	<?php if(isset($is_shipping_option) &&  $is_shipping_option==true): ?>
		<input type="hidden" name="expcod_shipping_price" value="" id='expcod_shipping_price'>
		<?php else: ?>
		<input type="hidden" name="expcod_shipping_price" value="<?php echo get_post_meta($product->get_id(),'expcod_shipping_price')[0] ?>" id='expcod_shipping_price'>
		<?php endif; ?>
</div>
