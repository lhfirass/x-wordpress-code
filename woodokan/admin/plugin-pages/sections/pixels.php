<?php $pixels  = codexp()->settings->get('pixels');?>
<div class="woodokan-inner-dark-wrapper wd-p-10">
	<div class="">
		<div class="">
			<div class="row">
				<div class="col-6">
						<div class="woodokan-card facebook-pixel">
						<div class="woodokan-card-header wd-p-20 wd-title-1 sheet-title">
						<i class="fa-brands fa-square-facebook"></i>
							<?php _e('Facebook Pixel' , 'cod-express-checkout') ?>
						</div>
						<div class="woodokan-card-body wd-p-10">
							<div class="wd-input-group ">
								<label><?php _e('Pixel id' , 'cod-express-checkout') ?> </label>
								<input type="text" name="" id="facebook-pixel" value="<?php echo $pixels->fbPixel?>" dir="ltr" style="width:100%">
								<small><?php _e('Add a piece of code to your website that lets you measure, optimise and build audiences for your ad campaigns.' , 'cod-express-checkout')?></small>	
								<ol>
									<li><?php _e('View page' , 'cod-express-checkout') ?></li>
									<li><?php _e('Add to cart' , 'cod-express-checkout') ?></li>
									<li><?php _e('Place order' , 'cod-express-checkout') ?></li>
								</ol>
								<p></p>
								<div><a href="#" class="button button-danger"><i class="fa-brands fa-youtube"></i><?php _e('How to install Fcaebook Pixel' , 'cod-express-checkout') ?></a></div>
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
#header-editor { 
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
.facebook-pixel{
	border : 3px solid #3F51B5;
	border-radius :3px
}
.facebook-pixel .woodokan-card-header{
	background-color: #3F51B5;
	color:white;
	margin: 0 -3px;
	border : none
}
.tiktok-pixel{
	border : 3px solid black;
	border-radius :3px
}
.tiktok-pixel .woodokan-card-header{
	background-color: black;
	color:white;
	margin: 0 -3px;
	border : none
}
</style>
