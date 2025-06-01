<?php
function wt_dropdown_choice( $args ){
    if( is_product() ) {
          
            $args['class'] = 'customdropdown';
    }  
    return $args;    
}



add_action('order_summary_wd_dropdown' , 'order_total_block');

function order_total_block($product  ){
$wd_currency_symbol =  get_woocommerce_currency_symbol();
if ( $product->is_type( 'variable' ) ) {
    $vars = $product->get_available_variations();
    $varsarrr = [];
foreach($vars as $var){

$varsarrr[$var['variation_id']] = $var['display_price'];
};


// echo json_encode($varsarrr);

echo '  <script>var wdk_variations_array = '.  json_encode($varsarrr) .';</script>';
}
 
 ?>
<!----- inputs ----->
<input type="hidden" value="<?php echo $product->get_price()?>" id="p_price">
<input type="hidden" value="" id="variation_price">
<input type="hidden" value="" id="init_price">


<div class="order-total-block-container">
<div class="order-total-block-header" id='order_summary_dropdown'>
    <span>ملخص الطلبية <span class="cart-sum"><i class="fa-solid fa-basket-shopping"></i></span></span>
    <span class="bt-flesh"><i class="fa-solid fa-chevron-down"></i></span>
</div>
<div class="order-total-block-body" id='order_summary_body'>
    <div class="sum-champ">
    <span><?php _e('Product' , 'cod-express-checkout') ?></span>
        
        <span>
            <tr>
            <td ><span id="wdk_product_price">--</span></td>
                <td><?php echo $wd_currency_symbol?></td>
                
            </tr>
        </span>
        
    </div>
    <div class="sum-champ">
        <span><?php _e('Quantity' , 'cod-express-checkout') ?></span>
        <span>
           
           <span class="wdk_quantity_label">
           <span id="wdk_product_quantity"></span>
           <span>x</span>
           </span>
            
                
            
        </span>
    </div>
    <div class="sum-champ">
        <span>الشحن</span>
        <span>
            <tr>
            <td><span id="wdk_product_shipping">--</span></td>
            <td ><span id="wdk_product_shipping_csymbol"><?php echo $wd_currency_symbol?></span></td>
                
            </tr>
        </span>
    </div>
    <div class="sum-champ">
        <span><?php _e('Total' , 'cod-express-checkout') ?></span>
        <span>
            <tr>
            <td><span id="wdk_product_total">--</span></td>
            <td><?php echo $wd_currency_symbol?></td>
                
            </tr>
        </span>
    </div>
</div>
<div class="order-total-block-footer"></div>
</div>


<script>


  

// get order summary cels  
 var wdk_product_price      = document.getElementById('wdk_product_price');
 var wdk_product_quantity   = document.getElementById('wdk_product_quantity');
 var wdk_product_shipping   = document.getElementById('wdk_product_shipping');
 var wdk_product_total      = document.getElementById('wdk_product_total');
 var wdk_product_shipping_csymbol   = document.getElementById('wdk_product_shipping_csymbol');

// get values from inputes 
 var variation_id_inp   =  document.getElementsByName('variation_id')[0];
 var variation_price    =  document.getElementById('variation_price');
 var init_price         =  document.getElementById('init_price');
 var sum_q              =  document.getElementById('quantitiy_input');
 var sum_shipping       =  document.getElementById('shipping_price');
 var expcod_shipping_price = document.getElementById('expcod_shipping_price')
 if(!is_shipping_options){
    var product_shipping_price = <?php
         $sh_price =  get_post_meta($product->get_id(),'expcod_shipping_price');
         if($sh_price){
            if($sh_price[0]){
                echo $sh_price[0];
            }else{
                echo "00";
            }
         }else{
            echo 00;
         }
         
         ?>;

 }

 //init quantity value in order summary
 wdk_product_quantity.innerHTML = sum_q.value;
 /*
 ** When quantity input value changed eventRender order summary
 **
 */
 function render_order_summary(){

    // ------- Shipping logic goes here
    var var_shipping = null;

    if(is_shipping_options == true){
      /* if there is shipping options get shipping value from them */
        var_shipping = sum_shipping.selectedOptions[0].getAttribute('data-elprice')
        expcod_shipping_price.value = var_shipping;

        if(sum_shipping.selectedOptions[0].value == 'none'){

            init_vales();
            return;
        }
    }

    // -------- var price logic 
    let price = null;

    if(is_product_do_variable == true){
        if(variation_id_inp.value){
            /* if product has variations get price from variation price */
             price = wdk_variations_array[variation_id_inp.value];
        }else{
            init_vales()
            return;
        }
       
    }else{
        /* if product does not have variations the get product price */
         price = <?php echo $product->get_price()?>;
    }
  
 // calculate Total
  let quantity = sum_q.value ;
  wdk_product_quantity.innerHTML = quantity;
  let total;
  if(is_shipping_options){
     total = +var_shipping + (price*quantity);
  }else{
     total = + product_shipping_price + (price*quantity);
  }

  wdk_product_total.innerHTML = total;

 // Display price
  wdk_product_price.innerText =  price ;

 // Display shipping price
 if(is_shipping_options == true){
        if(var_shipping ==0){

    wdk_product_shipping_csymbol.style.display ='none';
    wdk_product_shipping.innerHTML =  '<span class="wdk_free_shipping"><?php _e('Free shipping' , 'cod-express-checkout')?> </span>' ;

    }else{

    wdk_product_shipping_csymbol.style.display ='inline';
    wdk_product_shipping.innerHTML =  var_shipping ;  
    }     
 }else{
    if(product_shipping_price ==0){

        wdk_product_shipping_csymbol.style.display ='none';
        wdk_product_shipping.innerHTML =  '<span class="wdk_free_shipping"><?php _e('Free shipping' , 'cod-express-checkout')?> </span>' ;

        }else{

        wdk_product_shipping_csymbol.style.display ='inline';
        wdk_product_shipping.innerHTML =  product_shipping_price ;  
        }  


 }

  
 }

 /*
 ** When quantity input value changed event
 **
 */
if(is_product_do_variable){
    variation_id_inp.onchange = function(){   render_order_summary();}
}


 /*
 ** When shipping input value changed event
 **
 */
if(is_shipping_options){
    sum_shipping.onchange = function(){ render_order_summary();}
}else{
    
}

 /*
 ** When quantity input value changed event
 **
 */
function wd_update_sum(q = 1){ wdk_product_quantity.innerHTML = sum_q.value; render_order_summary();}

function init_vales(){
  
if(!is_product_do_variable){
    if(is_shipping_options){
        wdk_product_price.innerText = '--'
        wdk_product_shipping_csymbol.style.display ='none';
        wdk_product_shipping.innerHTML =  '--' ;
        wdk_product_total.innerHTML = '--'
    }else{
        wdk_product_price.innerText = '--'
        wdk_product_shipping_csymbol.style.display ='none';
        wdk_product_shipping.innerHTML =  '--' ;
        wdk_product_total.innerHTML = '--'
    }
}else{
    if(is_shipping_options){
        wdk_product_price.innerText = '--'
        wdk_product_shipping_csymbol.style.display ='none';
        wdk_product_shipping.innerHTML =  '--' ;
        wdk_product_total.innerHTML = '--'
    }else{
        wdk_product_price.innerText = '--'
        wdk_product_shipping_csymbol.style.display ='none';
        wdk_product_shipping.innerHTML =  '--' ;
        wdk_product_total.innerHTML = '--'
    } 
}
}
if(is_shipping_options || is_product_do_variable){
    init_vales();
}else{
    render_order_summary()
}




let order_summary_dropdown = document.getElementById('order_summary_dropdown');
let order_summary_body = document.getElementById('order_summary_body');
order_summary_dropdown.onclick = function(){

if(order_summary_body.style.display == 'block'){
    order_summary_body.style.display = 'none'
}else{
    order_summary_body.style.display = 'block'
}
}
</script>
<?php 
}
function save_woocommerce_custom_product_attribute( $id ) {
if ( is_admin() && isset( $_POST['custom_attribute_field'] ) ) {
    $option = "woocommerce_custom_attribute_field-$id";
    update_option( $option, sanitize_text_field( $_POST['custom_attribute_field'] ) );
}
}
add_action( 'woocommerce_attribute_added', 'save_woocommerce_custom_product_attribute' );
add_action( 'woocommerce_attribute_updated', 'save_woocommerce_custom_product_attribute' );


function woocommerce_custom_product_attribute_field() {
$id = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;
$value = $id ? get_option( "woocommerce_custom_attribute_field-$id" ) : '';
?>

    <div class="form-field">
        <label for="custom_attribute_field"><?php _e('Placeholder','cod-express-checkout') ?></label>
        <div class="form-field">
            <input name="custom_attribute_field" type="text" id="custom_attribute_field" value="<?php echo esc_attr( $value ); ?>" />
            
        </div>
<?php
}
add_action( 'woocommerce_after_add_attribute_fields', 'woocommerce_custom_product_attribute_field' );
add_action( 'woocommerce_after_edit_attribute_fields', 'woocommerce_custom_product_attribute_field' );
// add_action('wlf_berore_dashboard_settings', 'wdlf_display_upgrade_message');

function wdlf_display_upgrade_message(){
    ?>
    <style>
.styling-container::before {
    content: ' ';
    top: 0;
    width: 100%;
    position: absolute;
    right: 0;
    height: 100%;
    z-index: 1;
    background: #ffffff87;
}
.styling-container{
    position: relative;
}
        </style>
    <div class="notice notice-info"><p><?php _e('The ability to customize this settings is only available in Pro plane , Please upgrade to pro if you want to use this feature.' , 'cod-express-checkout') ?></p> <p><a href="#" class="button button-primary button-hero"><span class="dashicons wdk-upgrade-to-pro dashicons-star-filled" style="vertical-align:center"></span><?php _e('Upgrade To lifetime Plan' , 'cod-express-checkout') ?></a></p></div><?php
}