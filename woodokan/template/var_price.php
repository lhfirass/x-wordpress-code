<style>
					.woodokan-var-price{
						
						padding-bottom: 10px;
						padding-top: 10px;
						display: flex;
						justify-content: space-between;
					}
					.woodokan-var-price:not(:last-of-type){
						border-bottom: 1px dashed #c8c8c8;
						
					}
				</style>
				<div class="woodokan-var-price-container">
                <?php foreach($meta as $var_price): ?>
					<div class="woodokan-var-price">
                       
						<div class="var-price-inp">
							<input type="radio" name="var_price" id="">
							<label><?php echo $var_price->var_price_label ?> </label>
						</div>
						<div class="var-price-label">
							<b><?php echo $var_price->var_price_price ?></b>
						</div>
					</div>
                    <?php endforeach; ?>
					
					
					
					
				</div>