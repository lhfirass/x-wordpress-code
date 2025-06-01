<?php $shipping_vars = codexp()->settings->get('shipping');?>
<?php do_action('wlf_berore_dashboard_settings');?>
<div class="styling-container">
    <div class="row">
        <div class="col-md-12">
        <div class="styling-section-card" style="padding:10px" >
                <div class="styling-section-card-header">
                    <h4> <?php _e('Shipping locations list' , 'cod-express-checkout') ?> </h4>
                </div>
                <div class="styling-section-card-body variation-card-body" id="var_elements_card">

                <?php foreach($shipping_vars as $shipping_var): ?>
                    <div class="variation-element variation-element">
                    <div class="row">
                        <div class="col-md-4">
                            <input  style="width:100%" type="text"  value="<?php  echo $shipping_var->element_name ?>" class="regular-text vari-element-name" placeholder="<?php _e('City' , 'cod-express-checkout')?>">
                        </div>
                        <div class="col-md-4">
                            <input  style="width:100%"  type="number"  value="<?php  echo $shipping_var->element_value ?>" class="regular-text vari-element-price" placeholder="<?php _e('Price' , 'cod-express-checkout')?>">
                        </div>
                        <div class="col-md-4">
                        <a href="javascript:void(0)" class="button button-small button-secondary delete-shipping-state"><?php _e('Delete' , 'cod-express-checkout')?></a>
                        </div>
                    </div>
                </div>

                <?php endforeach ?>
                   
                </div>
             
        </div>
        <?php  $page_url =  esc_url(admin_url( "admin.php?page=".$_GET["page"] ));?>
        <a href="javascript:void(0)" class="button button-secondary" onclick='add_var_element()'><?php _e('Add shipping location' , 'cod-express-checkout') ?></a>
        <a href="<?php echo $page_url .'&page_section=import_location' ?>" class="button button-secondary"><?php _e('Import shipping location' , 'cod-express-checkout') ?></a>
        </div> 
        </div>
    </div>

<style>
    .variation-card-body{

        background-color: #f6f6f6;
        padding: 10px;
    }
    .variation-element{
        border: 1px solid #cecece;
        margin-bottom:10px;
        padding:10px;
        border-radius:5px;
        background: white;
    }
    .styling-container .styling-section-card .styling-section-card-body {
    padding: 5px;
}
</style>

<script>
 
    function add_var_element(){
        var htmlEl = document.createElement('div');
     

     var var_element_template = `
     <div class="variation-element variation-element">
                  <div class="row">
                     <div class="col-md-4">
                         <input  style="width:100%" type="text"  value="" class="regular-text vari-element-name" placeholder="<?php _e('City' , 'cod-express-checkout')?>">
                     </div>
                     <div class="col-md-4">
                         <input  style="width:100%"  type="number"  value="" class="regular-text vari-element-price" placeholder="<?php _e('Price' , 'cod-express-checkout')?>">
                     </div>
                     <div class="col-md-4">
                     <a href="javascript:void(0)" class="button button-small button-secondary delete-shipping-state"><?php _e('Delete' , 'cod-express-checkout')?></a>
                     </div>
                  </div>
                </div>
     `;
     htmlEl.innerHTML = var_element_template;

        document.getElementById('var_elements_card').appendChild(htmlEl);
    }
</script>