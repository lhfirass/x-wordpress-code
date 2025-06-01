<?php
$expcod_post = get_post();
   if(!empty( $expcod_post )){
    $expcod_isEnabled       =  get_post_meta($expcod_post->ID,'expcod_displayForm') ;
    $expcod_shippingPrice   =  get_post_meta($expcod_post->ID,'expcod_shipping_price') ;
    $expcod_checkoutNotice  =  get_post_meta($expcod_post->ID,'expcod_checkout_note') ;
    $expcod_counterhours    =  get_post_meta($expcod_post->ID,'expcod_counter_hours') ;
   }

   if(empty($expcod_isEnabled)){ 
    $expcod_isEnabled[0] = 0;
   }

   if(empty($expcod_shippingPrice)){ 
    $expcod_shippingPrice[0] = 0;
   }

   if(empty($expcod_checkoutNotice) ){ 
    $expcod_checkoutNotice[0] = '';
   }
   
   if(empty($expcod_counterhours) ){ 
    $expcod_counterhours[0] = '';
   }
?>

<div class="codexpress">
    <p><label for="select_id"><?php _e('Show Express checkout form','cod-express-checkout');?></label></th></p>		         
    <select name="show-expcod-checkout" id="expcod-metabox-option" style="width:100%">
        <option value="0"  <?php selected( $expcod_isEnabled[0], 0 ); ?>><?php _e('Disable','cod-express-checkout');?></option>
        <option value="1"  <?php selected( $expcod_isEnabled[0], 1 ); ?>><?php _e('Enable','cod-express-checkout');?></option>
    </select>

    <p><label for="select_id"><?php _e('Shipping price','cod-express-checkout');?></label></th></p>		         
    <input type="number" min="0" name="shipping-expcod-checkout" id="" style="width:100%" value="<?php echo $expcod_shippingPrice[0] ?>">
    <p><label for="woodokan_form"><?php _e('Shortcode','cod-express-checkout');?></label></th></p>		         
    <input type="text" readonly  min="0" style="width:100%" value="<?php echo '[woodokan_form id='.$expcod_post->ID.']'; ?>">

    <div style="display:none">
    <p><label for="select_id"><?php _e('Checkout notice','cod-express-checkout');?></label></th></p>		         
    <textarea name="note-expcod-checkout" id=""  rows="3" style="width:100%"><?php echo $expcod_checkoutNotice[0] ?></textarea>      
    </div>
</div>
