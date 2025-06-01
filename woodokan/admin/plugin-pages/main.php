<?php 
$fieldAliases = array(
    'field_type_1' => __('First name','cod-express-checkout'),
    'field_type_2' => __('Last Name','cod-express-checkout'),
    'field_type_3' => __('Adress','cod-express-checkout'),
    'field_type_4' => __('City','cod-express-checkout'),
    'field_type_5' => __('Shipping Locations with price','cod-express-checkout'),
    'field_type_6' => __('Email','cod-express-checkout'),
    'field_type_7' => __('Phone','cod-express-checkout'),
    'field_type_8' => __('Country','cod-express-checkout'),
    'field_type_9' => __('Customer note','cod-express-checkout'),
    'field_type_10'=> __('Postal code','cod-express-checkout'),
    'field_type_11'=> __('Company','cod-express-checkout')
);?>
<div id="wpbody" role="main">
	<div>
		<div class="wrap">
			<div id="poststuff" class="mt-5" style="margin-top:30px">
				<div id="post-body" class="metabox-holder columns- ">
					
				<!-- <div class="notice"><p><?php _e('Free trial from Woodokan plugin','cod-express-checkout');  ?></p></div> -->
				
				<div class="woodokan-custom-dash" >
						<div class="row">
							<div class="col-12 ">
								<div class="woodokan-content">
									<div class="woodokan-card">
										<div class="woodokan-card-heading">
											<?php  $page_url =  esc_url(admin_url( "admin.php?page=".$_GET["page"] ));?>
											<a href="<?php echo $page_url; ?>" class="button  button-hero <?php if(!isset($_GET['page_section'])){ echo 'wooodkan-button-active';}else{echo 'wooodkan-button-not-active';};?>">
												<?php _e('Checkout fields' , 'cod-express-checkout') ?>
											</a>
											<a href="<?php echo $page_url .'&page_section=stylings' ?>" class="button  button-hero <?php if(isset($_GET['page_section']) && $_GET['page_section']=="stylings"){ echo 'wooodkan-button-active';}else{echo 'wooodkan-button-not-active';};?>">
												<?php _e('Styling' , 'cod-express-checkout') ?> 
											</a>
											<a href="<?php echo $page_url .'&page_section=shipping' ?>" class="button  button-hero <?php if(isset($_GET['page_section']) && $_GET['page_section']=="shipping"){ echo 'wooodkan-button-active';}else{echo 'wooodkan-button-not-active';};?>">
												<?php _e('Shipping locations' , 'cod-express-checkout') ?>
											</a>
											<a href="<?php echo $page_url .'&page_section=redirections' ?>" class="button  button-hero <?php if(isset($_GET['page_section']) && $_GET['page_section']=="redirections"){ echo 'wooodkan-button-active';}else{echo 'wooodkan-button-not-active';};?>">
												<?php _e('General settings' , 'cod-express-checkout') ?>
											</a>
										
										
										</div>
										<div class="woodokan-card-body">
											<!--==========================================
														Include settings section
											=============================================-->
											<?php
												if(isset($_GET['page_section']) && $_GET['page_section']=="stylings"):
													require EXPCOD_PATH.'admin/plugin-pages/sections/stylings.php';
												elseif(isset($_GET['page_section']) && $_GET['page_section']=="redirections"):
													require EXPCOD_PATH.'admin/plugin-pages/sections/redirect.php';	
												elseif(isset($_GET['page_section']) && $_GET['page_section']=="sheets"):
													require EXPCOD_PATH.'admin/plugin-pages/sections/sheets.php';	
												elseif(isset($_GET['page_section']) && $_GET['page_section']=="pixels"):
													require EXPCOD_PATH.'admin/plugin-pages/sections/pixels.php';	
												// elseif(isset($_GET['page_section']) && $_GET['page_section']=="support"):
												// 	require EXPCOD_PATH.'admin/plugin-pages/sections/support.php';	
												elseif(isset($_GET['page_section']) && $_GET['page_section']=="upgrade"):
													require EXPCOD_PATH.'admin/plugin-pages/sections/upgrade.php';	
												elseif(isset($_GET['page_section']) && $_GET['page_section']=="shipping"):
													require EXPCOD_PATH.'admin/plugin-pages/sections/shipping.php';	
												elseif(isset($_GET['page_section']) && $_GET['page_section']=="import_location"):
													require EXPCOD_PATH.'admin/plugin-pages/sections/import-shipping-locations.php';	
												// elseif(isset($_GET['page_section']) && $_GET['page_section']=="apps"):
												// 	require EXPCOD_PATH.'admin/plugin-pages/sections/apps.php';	
												else:
													require EXPCOD_PATH.'admin/plugin-pages/sections/config.php';
												endif;?>
										</div>
										<div class="woodokan-card-footer">
											<div class="woodokan-settings-overlay"><span class="spinner is-active"></span></div>
												<form id="fields-form">
														<?php do_settings_sections('codexpress_fiels');?>			
														<button type="submit" class="button button-primary button-hero"> <?php _e('Save changes' , 'cod-express-checkout') ?></button>
												</form>
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
	</div>