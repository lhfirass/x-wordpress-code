<?php $fields_styling = codexp()->settings->get('stylings');?>
<?php do_action('wlf_berore_dashboard_settings');?>
<div class="styling-container">
    <div class="row">
        <div class="col-md-12">
        <div class="styling-section-card">
                <div class="styling-section-card-header">
                    <h4> <?php _e('Form stylings' , 'cod-express-checkout') ?> </h4>
                </div>
                <div class="styling-section-card-body">
                <div class="style-element">
                            <span> <p><?php _e('Form minimum width' , 'cod-express-checkout') ?></p></span>
                            <span>  <input type="number"  min="500" name="" id="form_max_width"  class="small-text" value="<?php echo esc_html($fields_styling->form_max_width) ?>"></span>
                        </div>  
                <div class="style-element">
                            <span> <p><?php _e('Border radius (px)' , 'cod-express-checkout') ?></p></span>
                            <span>  <input type="number" min="0" data-target="--expcod-form-borderRadius" name="" id="form_border_radius"  class="small-text" value="<?php echo esc_html($fields_styling->form_border_radius) ?>"></span>
                        </div>  
                        <div class="style-element">
                            <span> <p><?php _e('Margin top (px)' , 'cod-express-checkout') ?></p></span>
                            <span>  <input type="number" min="15" data-target="--expcod-form-marginTop" name="" id="form_margin_top"  class="small-text" value="<?php echo esc_html($fields_styling->form_margin_top) ?>"></span>
                        </div>  
                        <div class="style-element">
                            <span> <p><?php _e('Margin bottom (px)' , 'cod-express-checkout') ?></p></span>
                            <span>  <input type="number" min="15" data-target="--expcod-form-marginBottom" name="" id="form_margin_bottom"  class="small-text" value="<?php echo esc_html($fields_styling->form_margin_bottom) ?>"></span>
                        </div>  
                        <div class="style-element">
                            <span> <p><?php _e('Padding (px)' , 'cod-express-checkout') ?></p></span>
                            <span>  <input type="number" min="0" data-target="--expcod-form-padding" name="" id="form_padding"  class="small-text" value="<?php echo esc_html($fields_styling->form_padding) ?>"></span>
                        </div>  
                <div class="style-element">
                            <span> <p><?php _e('From border color' , 'cod-express-checkout') ?></p></span>
                            <span>  <input type="text" data-target="--expcod-form-borderColor"  name="" id="form_border_color" class="color-field" value="<?php echo esc_html($fields_styling->form_border_color) ?>"></span>
                        </div>
                <div class="style-element">
                            <span> <p><?php _e('From border type' , 'cod-express-checkout') ?></p></span>
                            <span> 
                                <select name="" id="form_border_type" data-target="--expcod-label-display">
                                    <option value="solid" <?php  selected($fields_styling->form_border_type,'solid')?>><?php _e('solid' , 'cod-express-checkout') ?></option>
                                    <option value="dashed" <?php selected($fields_styling->form_border_type,'dashed')?>><?php _e('dashed' , 'cod-express-checkout') ?></option>
                                </select>
                            </span>
                        </div>
                        <div class="style-element">
                            <span> <p><?php _e('Border width (px)' , 'cod-express-checkout') ?></p></span>
                            <span> <input type="number" min="0"  data-target="--expcod-form-borderWidth" name="" id="form_border_width"  class="small-text" value="<?php echo esc_html($fields_styling->form_border_width) ?>"></span>
                        </div>  
                    <div class="style-element">
                            <span> <p> <?php _e('Form title color' , 'cod-express-checkout') ?></p></span>
                            <span>  <input type="text" name="" data-target="--expcod-label-color" id="label_text_color" class="color-field" value="<?php echo esc_html($fields_styling->label_text_color) ?>"></span>
                    </div>
                    <div class="style-element">
                            <span> <p> <?php _e('Form background color' , 'cod-express-checkout') ?></p></span>
                            <span>  <input type="text" name="" data-target="--expcod-label-color" id="form_bg_color" class="color-field" value="<?php echo esc_html($fields_styling->form_bg_color) ?>"></span>
                    </div>
                    <div class="style-element">
                            <span> <p> <?php _e('Form title size' , 'cod-express-checkout') ?></p></span>
                            <span> <input type="number" min="16" name="" data-target="--expcod-label-fontSize" id="label_text_size"  class="small-text" value="<?php echo esc_html($fields_styling->label_text_size) ?>"></span>
                        </div> 
                    <div class="style-element">
                        <span> <p> <?php _e('Button text' , 'cod-express-checkout') ?></p></span>
                        <span> <input type="text" name="" data-target="--expcod-label-marginTop"  id="button_text"  class="large-text" value="<?php echo esc_html($fields_styling->button_text) ?>"></span>
                    </div> 
                    <div class="style-element">
                            <span> <p><?php _e('Form title' , 'cod-express-checkout') ?></p></span>
                            <span>  <input type="text" id="form_title"  name=""   value="<?php echo esc_html($fields_styling->form_title)?>"></span>
                    </div>
                    <div class="style-element">
                            <span> <p><?php _e('Quantity input' , 'cod-express-checkout') ?></p></span>
                            <span> 
                                <select name="" id="quantity_input" data-target="--expcod-label-display">
                                    <option value="none" <?php  selected($fields_styling->quantity_input,'none')?>><?php _e('invisible' , 'cod-express-checkout') ?></option>
                                    <option value="block" <?php selected($fields_styling->quantity_input,'block')?>><?php _e('visible' , 'cod-express-checkout') ?></option>
                                </select>    
                            </span>
                    </div> 
                    <div class="style-element">
                            <span> <p><?php _e('sticky button' , 'cod-express-checkout') ?></p></span>
                            <span> 
                                <select name="" id="sticky_button" data-target="--expcod-label-display">
                                    <option value="none" <?php  selected($fields_styling->sticky_button,'none')?>><?php _e('invisible' , 'cod-express-checkout') ?></option>
                                    <option value="flex" <?php selected($fields_styling->sticky_button,'flex')?>><?php _e('visible' , 'cod-express-checkout') ?></option>
                                </select>    
                            </span>
                    </div> 
                    <div class="style-element">
                            <span> <p><?php _e('Order summary' , 'cod-express-checkout') ?></p></span>
                            <span> 
                                <select name="" id="order_summary" >
                                    <option value="none" <?php  selected($fields_styling->order_summary,'none')?>><?php _e('invisible' , 'cod-express-checkout') ?></option>
                                    <option value="block" <?php selected($fields_styling->order_summary,'block')?>><?php _e('visible' , 'cod-express-checkout') ?></option>
                                </select>    
                            </span>
                    </div> 
                    <div class="style-element">
                            <span> <p><?php _e('Order summary default state' , 'cod-express-checkout') ?></p></span>
                            <span> 
                                <select name="" id="order_summary_default_state" >
                                    <option value="none" <?php  selected($fields_styling->order_summary_default_state,'none')?>><?php _e('invisible' , 'cod-express-checkout') ?></option>
                                    <option value="block" <?php selected($fields_styling->order_summary_default_state,'block')?>><?php _e('visible' , 'cod-express-checkout') ?></option>
                                </select>    
                            </span>
                    </div> 
                     
                </div>
        </div>
            <div class="styling-section-card">
                <div class="styling-section-card-header">
                    <h4> <?php _e('Form inputs' , 'cod-express-checkout') ?> </h4>
                </div>
                <div class="styling-section-card-body">
        


                    <div class="style-element ">
                        <span> <p>  <?php _e('Border color' , 'cod-express-checkout') ?>  </p></span>
                        <span>  <input type="text" name="" id="input_border_color" class="color-field" data-target="--expcod-inp-border-color" value="<?php echo esc_html($fields_styling->input_border_color) ?>"></span>
                    </div>
                    <div class="style-element ">
                        <span> <p> <?php _e('Border color (onfocus)' , 'cod-express-checkout') ?>  </p></span>
                        <span>    <input type="text" name="" id="input_border_color_onfocus" data-target="--expcod-inp-borderColor-onfocus" class="color-field" value="<?php echo esc_html($fields_styling->input_border_color_onfocus) ?>"></span>
                    </div>
                    <div class="style-element ">
                        <span> <p>  <?php _e('Text color' , 'cod-express-checkout') ?>   </p></span>
                        <span> <input type="text" name="" id="input_text_color" class="color-field" data-target="--expcod-txt-color"  value="<?php echo  esc_html($fields_styling->input_text_color) ?>"></span>
                    </div>
                    <div class="style-element ">
                        <span> <p> <?php _e('Background color' , 'cod-express-checkout') ?> </p></span>
                        <span> <input type="text" name="" id="input_background_color" data-target="--expcod-inp-bg-color" class="color-field" value="<?php echo  esc_html($fields_styling->input_background_color) ?>"></span>
                    </div>  
                    <div class="style-element ">
                        <span> <p> <?php _e('Height (px)' , 'cod-express-checkout') ?>    </p></span>
                        <span> <input type="number" min="0" name="input_height" id="input_height" data-target="--expcod-inp-height" min="45" max="65" class="small-text"  value="<?php echo  esc_html($fields_styling->input_height) ?>"></span>
                    </div>  
                    <div class="style-element ">
                        <span> <p> <?php _e('Border width (px)' , 'cod-express-checkout') ?>  </p></span>
                        <span> <input type="number" min="0" name="input_border_width" id="input_border_width" data-target="--expcod-inp-border-width" min="0" max="4" class="small-text"  value="<?php echo  esc_html($fields_styling->input_border_width) ?>"></span>
                    </div>  
                    <div class="style-element ">
                        <span> <p> <?php _e('Border radius (px)' , 'cod-express-checkout') ?></p></span>
                        <span> <input type="number" min="0" name="input_border_radius" id="input_border_radius" data-target="--expcod-inp-border-radius" min="0" max="10"  class="small-text" value="<?php echo  esc_html($fields_styling->input_border_radius) ?>"></span>
                    </div>  
                    <div class="style-element ">
                        <span> <p> <?php _e('Placeholder size (px)' , 'cod-express-checkout') ?></p></span>
                        <span> <p>  <input type="number" min="0"  name="" id="input_placeholder_size" data-target="--expcod-placeholder-fontSize"  class="small-text" min="13" max="20" value="<?php echo  esc_html($fields_styling->input_placeholder_text_size) ?>"></span>
                    </div>  
                    <div class="style-element ">
                        <span> <p> <?php _e('Border width (px) (onfocus) ' , 'cod-express-checkout') ?></p></span>
                        <span> <input type="number" min="0"  name="" id="input_border_width_onfocus"  data-target="--expcod-inp-borderWidth-onfocus" class="small-text"  min="0" max="5" value="<?php echo  esc_html($fields_styling->input_border_width_onfocus) ?>"></span>
                    </div>  
                </div>
            </div>
            <div class="styling-section-card">
                <div class="styling-section-card-header">
                    <h4><?php _e('Buy now button' , 'cod-express-checkout') ?></h4>
                </div>
                <div class="styling-section-card-body">
                    <div class="style-element">
                        <span> <p> <?php _e('Text color' , 'cod-express-checkout') ?></p></span>
                        <span>  <input type="text" data-target="--expcod-buyNow-txtColor" name="" id="button_text_color" class="color-field" value="<?php echo  esc_html($fields_styling->button_text_color) ?>"></span>
                    </div>
                    <div class="style-element">
                        <span> <p> <?php _e('Text color (onhover)' , 'cod-express-checkout') ?></p></span>
                        <span> <input type="text" name="" data-target="--expcod-buyNow-color-onhover"  id="button_text_color_onhover" class="color-field" value="<?php echo esc_html($fields_styling->button_text_color_onhover) ?>"></span>
                    </div>
                    <div class="style-element">
                        <span> <p> <?php _e('Background color' , 'cod-express-checkout') ?></p></span>
                        <span>  <input type="text" name="" data-target="--expcod-buyNow-bgColor" id="button_background_color" class="color-field" value="<?php echo esc_html($fields_styling->button_background_color) ?>"></span>
                    </div>
                    <div class="style-element">
                        <span> <p> <?php _e('Background color (hover)' , 'cod-express-checkout') ?> </p></span>
                        <span>   <input type="text" name=""  data-target="--expcod-buyNow-bgColor-onhover" id="button_background_color_onhover" class="color-field" value="<?php echo esc_html($fields_styling->button_background_color_onhover) ?>"></span>
                    </div>
                    <div class="style-element">
                        <span> <p> <?php _e('Border color' , 'cod-express-checkout') ?></p></span>
                        <span>  <input type="text" name=""  data-target="--expcod-buyNow-borderColor" id="button_border_color" class="color-field" value="<?php echo esc_html($fields_styling->button_border_color) ?>"></span>
                    </div>
                    <div class="style-element">
                        <span> <p> <?php _e('Height (px)' , 'cod-express-checkout') ?></p></span>
                        <span> <input type="number"min="0"  name=""  data-target="--expcod-buyNow-height" id="button_height"  class="small-text" value="<?php echo esc_html($fields_styling->button_height) ?>"></span>
                    </div>  
                    <div class="style-element">
                        <span> <p> <?php _e('Font size (px)' , 'cod-express-checkout') ?></p></span>
                        <span> <input type="number" min="0" name="" data-target="--expcod-buyNow-fontSize" id="button_text_size"  class="small-text" value="<?php echo esc_html($fields_styling->button_text_size )?>"></span>
                    </div>  
                    <div class="style-element">
                        <span> <p> <?php _e('Border width (px)' , 'cod-express-checkout') ?></p></span>
                        <span> <input type="number" min="0" name="" data-target="--expcod-buyNow-borderWidth" id="button_border_width"  class="small-text" value="<?php echo esc_html($fields_styling->button_border_width) ?>"></span>
                    </div>  
                   
                </div>
            </div>
            <div class="styling-section-card" style="display:none" >
                    <div class="styling-section-card-header">
                        <h4> <?php _e('Labels' , 'cod-express-checkout') ?></h4>
                    </div>
                    <div class="styling-section-card-body">
                    
                       
                        <div class="style-element">
                            <span> <p> <?php _e('Font weight' , 'cod-express-checkout') ?></p></span>
                            <span> 
                                <select name="" id="label_text_weight" data-target="--expcod-label-fontWeight">
                                    <option value="normal" <?php selected($fields_styling->label_text_weight ,'normal')?>><?php _e('Normal' , 'cod-express-checkout') ?></option>
                                    <option value="lighter" <?php  selected($fields_styling->label_text_weight ,'lighter')?>><?php _e('Lighter' , 'cod-express-checkout') ?></option>
                                    <option value="bold" <?php selected($fields_styling->label_text_weight ,'bold')?>><?php _e('Bold' , 'cod-express-checkout') ?></option>
                                    <option value="bolder" <?php  selected($fields_styling->label_text_weight ,'bolder')?>><?php _e('Bolder' , 'cod-express-checkout') ?></option>
                                </select>    
                            </span>
                        </div>  
                        <div class="style-element">
                            <span> <p><?php _e('Visible' , 'cod-express-checkout') ?></p></span>
                            <span> 
                                <select name="" id="label_visibility" data-target="--expcod-label-display">
                                    <option value="none" <?php  selected($fields_styling->label_visibility,'none')?>><?php _e('invisible' , 'cod-express-checkout') ?></option>
                                    <option value="block" <?php selected($fields_styling->label_visibility,'block')?>><?php _e('visible' , 'cod-express-checkout') ?></option>
                                </select>    
                            </span>
                        </div>  
                        <div class="style-element">
                            <span> <p><?php _e('Margin bottom (px)' , 'cod-express-checkout') ?> </p></span>
                            <span> <input type="number" min="0" name=""  data-target="--expcod-label-marginBottom" id="label_margin_bottom"  class="small-text" value="0"></span>
                        </div>  
                        <div class="style-element">
                            <span> <p> <?php _e('Margin top (px)' , 'cod-express-checkout') ?></p></span>
                            <span> <input type="number" min="0"  name="" data-target="--expcod-label-marginTop"  id="label_margin_top"  class="small-text" value="0"></span>
                        </div>  
                        
                    </div>
            </div>
            <div class="styling-section-card" style="display:none">
                    <div class="styling-section-card-header">
                        <h4><?php _e('Form' , 'cod-express-checkout') ?></h4>
                    </div>
                    <div class="styling-section-card-body" style="display:none">
              
                        <div class="style-element">
                            <span> <p><?php _e('Border color' , 'cod-express-checkout') ?></p></span>
                            <span>  <input type="text" data-target="--expcod-form-borderColor"  name="" id="form_border_color" class="color-field" value="<?php echo esc_html($fields_styling->form_border_color) ?>"></span>
                        </div>
                       
                        
                    </div>
                </div>
        </div>
        <div class="col-md-6 " style="display:none" >
        <div class="styling-section-card" style="position:sticky;top:40px">
                <div class="styling-section-card-header">
                    <h4> <?php _e('Checkout form preview' , 'cod-express-checkout') ?> </h4>
                </div>
                <div class="styling-section-card-body">
               
                    <div class="express-checkout-preview">
                        <div class="express-form">
                            <div class="wd-form-label"><?php echo esc_html($fields_styling->form_title)?> </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div><label for=""><?php _e('Example text' , 'cod-express-checkout') ?></label></div>
                                        <div><input type="text" name="" id="" placeholder="<?php _e('Example text' , 'cod-express-checkout') ?>"></div>
                                    </div>
                                    <div class="col-6">
                                    <div><label for=""><?php _e('Example text' , 'cod-express-checkout') ?></label></div>
                                        <div><input type="text" name="" id="" placeholder="<?php _e('Example text' , 'cod-express-checkout') ?>"></div>
                                    </div>
                                    <div class="col-12">
                                    <div><label for=""><?php _e('Example text' , 'cod-express-checkout') ?></label></div>
                                        <div><input type="text" name="" id="" placeholder="<?php _e('Example text' , 'cod-express-checkout') ?>"></div>
                                    </div>
                                    <div class="col-12">
                                    <div><button id="buy_now_btn"><?php echo esc_html($fields_styling->button_text) ?></button></div>
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
    .express-form{
        margin-top: var(--expcod-form-marginTop);
        margin-bottom:var(--expcod-form-marginBottom);
        border-style : solid;
        border-color:var(--expcod-form-borderColor);
        border-width: var(--expcod-form-borderWidth);
        border-radius: var(--expcod-form-borderRadius);
        padding : var(--expcod-form-padding)
    }
    .express-form input{
        width: 100%;
        display: block;
        border-style : solid ;
        border-width : var(--expcod-inp-border-width);
        border-color : var(--expcod-inp-border-color);
        height: var(--expcod-inp-height);
        border-radius : var(--expcod-inp-border-radius);
        background-color: var(--expcod-inp-bg-color);
        color : var(--expcod-txt-color);
        font-size: var(--expcod-placeholder-fontSize);
        transition : .3s ease-in-out;
    }

    .express-form input:focus{
        border-color : var(--expcod-inp-borderColor-onfocus);
        border-width: var(--expcod-inp-borderWidth-onfocus);
        box-shadow: 0 5px 20px 0 rgb(0 0 0 / 5%);
    }

    .express-form input::placeholder{
       font-size: var(--expcod-placeholder-fontSize) !important;
    }

    .express-form  button{
        width: 100%;
        display: block;
        margin-top: 20px;
        color: var(--expcod-buyNow-txtColor);
        background-color: var(--expcod-buyNow-bgColor);
        border-color : var(--expcod-buyNow-borderColor);
        border-style : solid ;
        border-width : var(--expcod-buyNow-borderWidth);
        font-size: var(--expcod-buyNow-fontSize);
        height : var(--expcod-buyNow-height);
        border-radius :5px;
        cursor: pointer;
        transition : .3s ease-in-out;
    }

    .express-form  button:hover{
        color:var(--expcod-buyNow-color-onhover);
        background-color: var(--expcod-buyNow-bgColor-onhover)
    }

    .express-form  label{
       margin:10px 0 5px;
       display: block;
    }

    .wd-form-label{
        color :var(--expcod-label-color);
        font-size: var(--expcod-label-fontSize);
        margin-bottom: var(--expcod-label-marginBottom);
        margin-top: var(--expcod-label-marginTop);
        font-weight: var(--expcod-label-fontWeight);
    }
</style>
