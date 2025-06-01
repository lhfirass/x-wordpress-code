<?php $sheets  = codexp()->settings->get('sheets');?>
<?php


$sheets_filelds = [
	'order_date' => "Order date",
	'client_last_name' => "Client last name",
	'client_first_name' => "Client first name",
	'client_phone' => "Client phone",
	'client_add' => "Client Address",
	'order_quantity' => "Order quantity",
	'order_product' => "Order product",
	'order_id' => "Order ID",
	'order_total' => "Order total",
	'order_date' => "Order date",
]

?>
<div class="woodokan-inner-dark-wrapper wd-p-10">
	<div class="">
		<div class="">
			<div class="row">
			
				<div class="col-6">
						<div class="woodokan-card ">
							
						<div class="woodokan-card-header wd-p-20 wd-title-1 sheet-title">
						<!-- <img src="https://www.mindphp.com/images/knowledge/112560/GoogleSheets.png" alt="" > -->
							<?php _e('Google sheets configuration' , 'cod-express-checkout') ?>
						</div>
						
						<form  method="post" id="formAjax">
					<div class="woodokan-card-body wd-p-10">
							<div>
								<div class="wd-input-group ">
									<label><?php _e('Credentials file (.json)' , 'cod-express-checkout') ?> </label>
									<input type="file" name="json_key" id="json_key"  dir="ltr" style="width:100%" >	
									<input type="hidden" name="action" value="uplaod_json_woodokan" id="json_key"  dir="ltr" style="width:100%" >	
								</div>
								<div class="wd-input-group " id="status">
									
								</div>
								
							</div>
						
						
					</form>
							<div>
								<div class="wd-input-group ">
									<label><?php _e('Connection status' , 'cod-express-checkout') ?> </label>
									
									<select  id="sheet-serv-account">
										
										<option value="1" <?php selected($sheets->editor,1)?>>Yes! Send data to google sheet</option>
										<option value="2" <?php selected($sheets->editor,2)?>>No! Do not send data to google sheets</option>
										
									</select>
								</div>
							</div>
							<div>
								<div class="wd-input-group ">
									<label><?php _e('Spread Sheet URL' , 'cod-express-checkout') ?> </label>
									<input type="text" name="" id="sheet-url" value="<?php echo $sheets->spreadsheet  ?>" dir="ltr" style="width:100%">	
								</div>
							</div>
							<div id="woodokan-link-input">
								<div class="wd-input-group ">
									<label><?php _e('sheet pege name' , 'cod-express-checkout') ?> </label>
									<input type="text" name="" id="sheet-page" value="<?php echo $sheets->page  ?>" dir="ltr" style="width:100%">
								</div>
							</div>
						</div>
					</div>
				
				</div>
				<div class="col-6">
						<div class="woodokan-card ">
						<div class="woodokan-card-header wd-p-20 wd-title-1 woocommerce-title">
							<!-- <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/WooCommerce_logo.svg/1200px-WooCommerce_logo.svg.png" alt="" > -->
							<?php _e('Woocommerce order data' , 'cod-express-checkout') ?>
						</div>
						<div class="woodokan-card-body wd-p-10">
							<div class="row sheet">

								<div class="col-12 ">
								<!-- start Item --->
								<div class="woodokan-inputs-editor sheet-box" aria-dropeffect="move">
									<?php foreach($sheets->data as $sheet): ?>
									<div class="woodokan-field-item" draggable="true" role="option" aria-grabbed="false">
										<div class="woodokan-field">
											<div class="field-heading"><?php echo $sheets_filelds[$sheet->dataType]; ?> </div>
											<div class="field-activate">
												<label class="checkbox-ios">
													<input type="checkbox" class="active_checkbox" <?php checked( $sheet->filedActive, true); ?>>
													<span class="checkbox-ios-switch"></span>
													<input type="hidden" value="<?php echo $sheet->dataType; ?>" class="data_type">
												</label>
											</div>
										</div>
									</div>
									<?php endforeach; ?>				
								</div>
								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.woodokan-card *{
		box-sizing: border-box;
	}
	.sheet-cell{
		background-color: #f6f6f6;
		padding: 10px;
		max-height: 200px;
		border: 1px solid #0000003b;
		overflow-y: scroll;
		
	}
	.order-info > div{
		padding: 10px;
		margin-bottom: 10px;
		background-color: white;
		cursor: move;
		border: 1px solid #0000003b;
	}
	.sheet-cell{
		min-height: 50px;
	}
	.woocommerce-title img{
		width: 63px;
    margin-bottom: -17px;
    margin-right: 12px;
}
	.sheet-title img{
		width: 63px;
   
    margin-bottom: -10px;
    margin-right: 12px;
}
	
</style>

