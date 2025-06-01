<div style="position:reelative">
<script src="//code.tidio.co/mecpjchnt4prhngwrqnhhaklg37znsk4.js" async></script></div>
<style>
.woodokan-card-footer{display: none;}
</style>
<?php $wd_text_dir = new WP_locale();if($wd_text_dir->text_direction == 'ltr'):?>								
<div class="woodokan-custom-dash">
	<div class="row text-center">
		<div class="col-4">
			<div class="woodokan-card">
				<div class="woodokan-card-img">
					<img src="<?php echo  EXPCOD_URL .'assets/images/need-help.png';?>" style="width:100%">
				</div>
				<div class="woodokan-card-body" style="padding:10px">
				</div>
			</div>
		</div>
		<div class="col-4">
		<div class="woodokan-card">
				<div class="woodokan-card-img">
					<img src="<?php echo  EXPCOD_URL .'assets/images/custom-plugin.png';?>" style="width:100%">
				</div>
				<div class="woodokan-card-body" style="padding:10px">	
				</div>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
	<div class="woodokan-custom-dash">
	<div class="row text-center">
		<div class="col-4">
			<div class="woodokan-card">
				<div class="woodokan-card-img">
					<img src="<?php echo  EXPCOD_URL .'assets/images/ar/need-help.png';?>" style="width:100%">
				</div>
				<div class="woodokan-card-body" style="padding:10px">
				</div>
			</div>
		</div>
		<div class="col-4">
		<div class="woodokan-card">
				<div class="woodokan-card-img">
					<img src="<?php echo  EXPCOD_URL .'assets/images/ar/custom-plugin.png';?>" style="width:100%">
				</div>
				<div class="woodokan-card-body" style="padding:10px"></div>
			</div>
		</div>
	</div>
</div>
<?php endif;?>