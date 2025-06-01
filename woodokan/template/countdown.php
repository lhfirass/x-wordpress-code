



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there is an active promotion  var seconds_cell = document.getElementById('sec_cell');
		var seconds_cell = document.getElementById('sec_cell');
                                    var minutes_cell = document.getElementById('min_cell');
                                    var hours_cell = document.getElementById('hours_cell');
                                    var days_cell = document.getElementById('days_cell');       
            // Get the promotion end date
            var saleEndDate = '<?php echo get_post_meta(get_the_ID(), '_sale_price_dates_to', true); ?>';
    <?php
$sale_end_date =get_post_meta(get_the_ID(), '_sale_price_dates_to', true);
$current_date = current_time('mysql');
$end_date = $sale_end_date;
// $remaining_time = $end_date - $current_date;
echo "var still_time = "  . $end_date - strtotime($current_date);
?>
          

			
			console.log(still_time);
			let currentDate = new Date();
								  
								   let end_date = saleEndDate *1000;
								  
								  
										
									  
								   
									 let diff =  (end_date+86400000) - currentDate.getTime() ;
									 let seconds = diff /1000;
									 seconds = seconds.toFixed(0) ;
									
			
			setInterval( function( ){
                                    
				
				let minutes = Math.floor(seconds / 60);
                let hours = Math.floor(minutes / 60);
                let days = Math.floor(hours / 24);
				console.log(seconds);
								
								 
 
									
								 
				let rest_days = days;
                let rest_hours = hours % 24;
                let rest_minutes = minutes % 60;
                let rest_seconds = seconds % 60;
									//  console.log(rest_days);
									//  console.log(rest_hours);
									//  console.log(rest_minutes);
									//  console.log(rest_seconds);

								  
								   seconds_cell.innerText = seconds%60<10? '0'+ rest_seconds.toFixed(0) :  rest_seconds.toFixed(0);
								   minutes_cell.innerText = minutes%60<10? '0'+ rest_minutes.toFixed(0) :  rest_minutes.toFixed(0) ;
								   hours_cell.innerText = hours%24<10?'0'+ rest_hours.toFixed(0) : Math.floor(rest_hours);
								   days_cell.innerText = days<10?'0'+ (rest_days.toFixed(0) -1) : rest_days.toFixed(0) -1;
								 
								   
								   
		  
					 
				 //   progreess_bar.style.width = progress_bar + '%';
				   
					 
					 
				 seconds--;											 
																   
														   

							   },1000)
       
    });
</script>

<!---- start counter --------->
<style>
	
/* countdown single product */
.tt-product-single-info > *:nth-child(1).tt-wrapper {
  margin-top: 5px;
}

.tt-countdown_box_02 {
  text-align: center;
  margin-top: -7px;
  width: 100%;
  z-index: 5;
}
.tt-countdown_box_02 .tt-countdown_inner {
  overflow: hidden;
  width: 100%;
}
.tt-countdown_box_02 .countdown-row {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: center;
  align-content: center;
  align-items: center;
}
.tt-countdown_box_02 .countdown-row .countdown-section {
  width: 100%;
  max-width: 65px;
  position: relative;
  margin: 0 5px;
  padding: 19px 0 13px;
  white-space: nowrap;
  background-color: rgb(247, 248, 250);
  color: #191919;
  border-radius: 6px;
  border:1px solid #a6a6a6
}
.tt-countdown_box_02 .countdown-row .countdown-section .countdown-amount {
  font-size: 16px;
  line-height: 15px;
  display: block;
  font-weight: 500;
}
.tt-countdown_box_02 .countdown-row .countdown-section .countdown-period {
  display: block;
  padding-top: 1px;
}
/* .tt-countdown_box_02 .countdown-row .countdown-section:first-child {
  margin-left: 0;
}
.tt-countdown_box_02 .countdown-row .countdown-section:last-child {
  margin-right: 0;
} */
@media (max-width: 1229px) {
  .tt-countdown_box_02 .countdown-row .countdown-section {
    padding: 15px 0;
    max-width: 60px;
    margin: 0 3px;
    font-size: 13px;
    line-height: 16px;
  }
  .tt-countdown_box_02 .countdown-row .countdown-section .countdown-amount {
    font-size: 15px;
  }
  .tt-countdown_box_02 .countdown-row .countdown-section .countdown-period {
    padding-top: 0;
  }
}

</style>
<div class="tt-wrapper">
  <p style="text-align:center"><?php echo  __('Promotion ends after','cod-express-checkout') ?></p>
							<div class="tt-countdown_box_02">
								<div class="tt-countdown_inner">
									<div class="tt-countdown" data-date="2020-11-01" data-year="Yrs" data-month="Mths" data-week="Wk" data-day="Day" data-hour="Hrs" data-minute="Min" data-second="Sec"><span class="countdown-row"><span class="countdown-section"><span class="countdown-amount" id="days_cell">--</span><span class="countdown-period"><?php echo  __('Day','cod-express-checkout') ?></span></span><span class="countdown-section"><span class="countdown-amount" id="hours_cell">--</span><span class="countdown-period"><?php echo  __('Hrs','cod-express-checkout') ?></span></span><span class="countdown-section"><span class="countdown-amount" id="min_cell">--</span><span class="countdown-period"><?php echo  __('Min','cod-express-checkout') ?></span></span><span class="countdown-section"><span class="countdown-amount" id="sec_cell">--</span><span class="countdown-period"><?php echo  __('Sec','cod-express-checkout') ?></span></span></span></div>
								</div>
							</div>
						</div>
<!---- end counter ------------>