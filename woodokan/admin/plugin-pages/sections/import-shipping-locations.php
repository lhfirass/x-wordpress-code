<?php $shipping_vars = codexp()->settings->get('shipping');?>
<div class="styling-container">
    <div class="row">
        <div class="col-md-12">
        <div class="styling-section-card" style="padding:10px" >
                <div class="styling-section-card-header">
                    <h4> <?php _e('Import shipping locations' , 'cod-express-checkout') ?> </h4>
                </div>
                <div class="styling-section-card-body variation-card-body" id="var_elements_card">

                    <form action="" method="post">
                    <select name="wdk-import-locations" id="shipping_locations_select_list">
                    <option value="alg">Algeria</option>
                </select>
                <button type="submit" class="button button-secondary" id="shipping_locations_import_btn">
					<?php _e('Import shipping  states' , 'cod-express-checkout') ?>
                </button>
                    </form>
                   
                </div>
             
        </div>
        </div> 
        </div>
    </div>

<style>
#fields-form{
    display: none;
}
</style>

