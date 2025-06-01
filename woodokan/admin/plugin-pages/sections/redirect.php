<?php $redirect  = codexp()->settings->get('redirections');?>
<?php do_action('wlf_berore_dashboard_settings');?>
<div class="woodokan-inner-dark-wrapper wd-p-10">
	<div class="">
		<div class="">
			<div class="woodokan-card styling-container">
				<div class="woodokan-card-header wd-p-20 wd-title-1">
					<?php _e('Thank you page settings' , 'cod-express-checkout') ?>
				</div>
				<div class="woodokan-card-body wd-p-10">
					<div style="margin-bottom:30px;display:none">
						<div class="wd-input-group">
							<label> order steps</label>
							<select name="order_steps" id="order_steps" style="max-width:100%;width:50%;">
								<option value="1" <?php selected($redirect->steps , "1") ?>><?php _e('One step','cod-express-checkout')?></option>
								<option value="2" <?php selected($redirect->steps , "2") ?>><?php _e('Two steps','cod-express-checkout')?></option>
							</select>	
						</div>
					</div>
					<div>
						<div class="wd-input-group ">
							<label><?php _e('Redirection method' , 'cod-express-checkout') ?> </label>
							<select name="select_id" id="redirection_method_select" style="max-width:100%;width:50%;">
								<option value="wc-order-received" <?php selected($redirect->method , "wc-order-received") ?>><?php _e('Woocommerce order received page','cod-express-checkout')?></option>
								<option value="custom-url" <?php selected($redirect->method , "custom-url") ?>><?php _e('Custom URL','cod-express-checkout')?></option>
							</select>	
						</div>
					</div>
					<div id="woodokan-link-input" <?php if($redirect->method === 'wc-order-received'): ?> style="display:none" <?php endif; ?>>
						<div class="wd-input-group ">
							<label><?php _e('URL' , 'cod-express-checkout') ?> </label>
							<input type="text" name="" id="thank_you_page_url" value="<?php echo esc_url($redirect->url);?>" dir="ltr" style="width:50%">
						</div>
					</div>
				</div>
			</div>
			<div class="woodokan-card " style="margin-top:10px">
				<div class="woodokan-card-header wd-p-20 wd-title-1">
					<?php _e('Main settings' , 'cod-express-checkout') ?>
				</div>
				<div class="woodokan-card-body wd-p-10">
					<div>
						<div class="wd-input-group ">
							<label><?php _e('Form display' , 'cod-express-checkout') ?> </label>
							<select  id="display_form_in" style="max-width:100%;width:50%;">
								<option value="1" <?php selected($redirect->form_display , 1) ?>><?php _e('All Products','cod-express-checkout')?></option>
								<option value="0" <?php selected($redirect->form_display , 0) ?>><?php _e('Activate manually','cod-express-checkout')?></option>
							</select>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>