jQuery(document).ready(function($) {

    /*====================================================
     * Put event listeners
     *====================================================*/

    // Redirections section [ select box vhange ]
    $('#redirection_method_select').on('change', function() {
            if ($(this).val() === 'wc-order-received') {
                $('#woodokan-link-input').hide();
            } else {
                $('#woodokan-link-input').show();
            }
        })
        // Save button
    $('#fields-form').on('submit', function(e) {
            e.preventDefault();
            /*
             ** expcodSection.sectionName object is from localized script
             ** to define current section
             */
            switch (expcodSection.sectionName) {

                case 'main':

                    submit_codexp_fields();

                    break;

                case 'stylings':

                    submit_codexp_stylings();

                    break;

                case 'redirections':

                    submit_codexp_redirections();

                    break;
                case 'shipping':

                    submit_codexp_shipping();

                    break;
                case 'sheets':

                    submit_codexp_sheets();

                    break;
            }
        })
        // Fields configuration accordion
    $('.field-toggle').on('click', function() {
            $(this).parent().parent().find('.field-config-body').slideToggle();
            $(this).find('span').toggleClass('rolled');


        })
        /*====================================================
         * Initialize javascript libraries
         *====================================================*/

    // Alert notification
    var notyf = new Notyf({
        duration: 2000,
        position: {
            x: 'right',
            y: 'bottom',
        }
    });

    // wordpress color picker
    $('.color-field').wpColorPicker();
    // drag and drop sortable
    sortable('.wd_easyorder_sortable', {
        forcePlaceholderSize: true,
        placeholderClass: 'my-placeholder',
        itemSerializer: (serializedItem, sortableContainer) => {
            return {
                position: serializedItem.index + 1,
                fieldType: $(serializedItem.node).find('.field_type').val().trim(),
                placeholderText: $(serializedItem.node).find('.placeholder_text').val().trim(),
                filedActive: $(serializedItem.node).find('.active_checkbox').is(':checked'),
                isRequired: $(serializedItem.node).find('.is_required').val().trim(),
                fullSizing: $(serializedItem.node).find('.input_size').val().trim(),
            }
        }
    });
    // Google sheets - Woocommerce order fields 
    sortable('.sheet-box',{
        itemSerializer: (serializedItem, sortableContainer) => {
            return {
                position: serializedItem.index + 1,
                dataType: $(serializedItem.node).find('.data_type').val().trim(),
                filedActive: $(serializedItem.node).find('.active_checkbox').is(':checked'),
            }
        }
    });

    /*
    ==============================================================
    Config  Section
    ==============================================================
    */
    function submit_codexp_fields() {


        $('#settings').val(JSON.stringify(sortable('.wd_easyorder_sortable', 'serialize')[0].items));
        let expcodData = {
            security: expcodAjaxObject.wd_nonce,
            action: 'expcod_settings',
            formDta: $('#settings').val(),
            settings: 'expcod_fields'
        }



        $.ajax({
            type: 'POST',
            url: expcodAjaxObject.url,
            data: expcodData,
            success: function(data) {

                if (data.success == false) {

                    notyf.error(data.message);

                } else {

                    notyf.success(data.message);
                }

                $(".woodokan-settings-overlay").css("display", "flex").fadeOut();
            },
            error: function(data) {

                $(".woodokan-settings-overlay").css("display", "flex").fadeOut();
                notyf.error('An error occured');

            },
            beforeSend: function() {

                $(".woodokan-settings-overlay").css("display", "flex").fadeIn();
            }
        });
    }



    /*
    ==============================================================
    Stylings
    ==============================================================
    */


    function submit_codexp_stylings() {


        let stylingsObj = {
            main_color: $('#main_color').val(),
            button_text: $('#button_text').val(),
            form_title: $('#form_title').val(),
            quantity_input: $('#quantity_input').val(),
            sticky_button: $('#sticky_button').val(),
            order_summary: $('#order_summary').val(),
            order_summary_default_state: $('#order_summary_default_state').val(),
            input_border_color: $('#input_border_color').val(),
            input_border_color_onfocus: $('#input_border_color_onfocus').val(),
            input_text_color: $('#input_text_color').val(),
            input_background_color: $('#input_background_color').val(),
            input_height: $('#input_height').val(),
            input_border_width: $('#input_border_width').val(),
            input_border_radius: $('#input_border_radius').val(),
            input_placeholder_text_color: $('#input_placeholder_color').val(),
            input_placeholder_text_size: $('#input_placeholder_size').val(),
            input_border_width_onfocus: $('#input_border_width_onfocus').val(),
            //start Button
            button_text_color: $('#button_text_color').val(),
            button_text_color_onhover: $('#button_text_color_onhover').val(),
            button_background_color: $('#button_background_color').val(),
            button_background_color_onhover: $('#button_background_color_onhover').val(),
            button_border_color: $('#button_border_color').val(),
            button_height: $('#button_height').val(),
            button_text_size: $('#button_text_size').val(),
            button_border_width: $('#button_border_width').val(),
            //label
            label_text_color: $('#label_text_color').val(),
            label_text_size: $('#label_text_size').val(),
            label_text_weight: $('#label_text_weight').val(),
            label_margin_bottom: $('#label_margin_bottom').val(),
            label_margin_top: $('#label_margin_top').val(),
            label_visibility: $('#label_visibility').val(),
            // form 
            form_border_color: $('#form_border_color').val(),
            form_border_width: $('#form_border_width').val(),
            form_border_type: $('#form_border_type').val(),
            form_border_radius: $('#form_border_radius').val(),
            form_margin_top: $('#form_margin_top').val(),
            form_margin_bottom: $('#form_margin_bottom').val(),
            form_padding: $('#form_padding').val(),
            form_max_width: $('#form_max_width').val(),
            form_bg_color: $('#form_bg_color').val(),
        }

        $('#settings').val(JSON.stringify(stylingsObj));

        let expcodData = {
            security: expcodAjaxObject.wd_nonce,
            action: 'expcod_settings',
            formDta: $('#settings').val(),
            settings: 'expcod_stylings'
        }

        $.ajax({
            type: 'POST',
            url: expcodAjaxObject.url,
            data: expcodData,
            success: function(data) {

                if (data.success == false) {

                    notyf.error(data.message);

                } else {

                    notyf.success(data.message);
                }

                $(".woodokan-settings-overlay").css("display", "flex").fadeOut();
            },

            error: function(data) {

                $(".woodokan-settings-overlay").css("display", "flex").fadeOut();
                notyf.error('An error occured');
            },
            beforeSend: function() {
                $(".woodokan-settings-overlay").css("display", "flex").fadeIn();

            }
        });

    }

    /*
    ==============================================================
    Redirections 
    ==============================================================
    */

    function submit_codexp_redirections() {

        let expcodRedirect = {
            url: $('#thank_you_page_url').val(),
            method: $('#redirection_method_select').val(),
            steps: $('#order_steps').val(),
            form_display: $('#display_form_in').val()
        }


        $('#settings').val(JSON.stringify(expcodRedirect));

        let expcodData = {

            security: expcodAjaxObject.wd_nonce,
            action: 'expcod_settings',
            formDta: $('#settings').val(),
            settings: 'expcod_redirections'
        }

        $.ajax({
            type: 'POST',
            url: expcodAjaxObject.url,
            data: expcodData,
            success: function(data) {
                if (data.success == false) {
                    notyf.error(data.message);
                } else {
                    notyf.success(data.message);
                }
                $(".woodokan-settings-overlay").css("display", "flex").fadeOut();
            },
            error: function(data) {
                $(".woodokan-settings-overlay").css("display", "flex").fadeOut();
                notyf.error('An error occured');
            },
            beforeSend: function() {
                $(".woodokan-settings-overlay").css("display", "flex").fadeIn();
            }
        });
    }

    /*
    ==============================================================
    Redirections shipping
    ==============================================================
    */

    sortable('#var_elements_card', {
        forcePlaceholderSize: true,
        placeholderClass: 'my-placeholder',
        itemSerializer: (serializedItem, sortableContainer) => {
            return {
                position: serializedItem.index + 1,
                element_name: $(serializedItem.node).find('.vari-element-name').val().trim(),
                element_value: $(serializedItem.node).find('.vari-element-price').val().trim(),

            }
        }
    });

    function submit_codexp_shipping() {
        $('#settings').val(JSON.stringify(sortable('#var_elements_card', 'serialize')[0].items));
        console.log(JSON.stringify(sortable('#var_elements_card', 'serialize')[0].items))
        let expcodData = {

            security: expcodAjaxObject.wd_nonce,
            action: 'expcod_settings',
            formDta: $('#settings').val(),
            settings: 'expcod_shipping'
        }
        $.ajax({
            type: 'POST',
            url: expcodAjaxObject.url,
            data: expcodData,
            success: function(data) {
                if (data.success == false) {
                    notyf.error(data.message);
                } else {
                    notyf.success(data.message);
                }
                $(".woodokan-settings-overlay").css("display", "flex").fadeOut();
            },
            error: function(data) {
                $(".woodokan-settings-overlay").css("display", "flex").fadeOut();
                notyf.error('An error occured');
            },
            beforeSend: function() {
                $(".woodokan-settings-overlay").css("display", "flex").fadeIn();
            }
        });

    }
    /*
    ==============================================================
    Shipping 
    ==============================================================
    */

    $('.delete-shipping-state').on('click', function() {
        $(this).parent().parent().parent().remove();
    })

    /*
    ==============================================================
    Google Sheets 
    ==============================================================
    */

    function submit_codexp_sheets(){
        $('#settings').val(JSON.stringify(sortable('.sheet-box', 'serialize')[0].items));
        console.log($('#settings').val());
        let serv =  $('#sheet-serv-account').val();
        
        let formDtaSer = JSON.stringify({
            'data' : sortable('.sheet-box', 'serialize')[0].items,
            'editor' :$('#sheet-serv-account').val(),
            'spreadsheet': $('#sheet-url').val(),
            'page':$('#sheet-page').val()
        });
    
        let expcodData = {
            security: expcodAjaxObject.wd_nonce,
            action: 'expcod_settings',
            formDta: formDtaSer,
            settings: 'expcod_sheets'
        }
    
        $.ajax({
            type: 'POST',
            url: expcodAjaxObject.url,
            data: expcodData,
            success: function(data) {
                if (data.success == false) {
                    notyf.error(data.message);
                } else {
                    notyf.success(data.message);
                }
                $(".woodokan-settings-overlay").css("display", "flex").fadeOut();
            },
            error: function(data) {
                $(".woodokan-settings-overlay").css("display", "flex").fadeOut();
                notyf.error('An error occured');
            },
            beforeSend: function() {
                $(".woodokan-settings-overlay").css("display", "flex").fadeIn();
            }
        });
    }


 
    
   ;
    $('#json_key').on('change',function(){
        
        $('#formAjax').submit();
    })
    $('#formAjax').on('submit',function(event) {
        event.preventDefault();
        var myFile = document.getElementById('json_key');  // Our HTML files' ID
        var statusP = document.getElementById('status')
       
      
        statusP.innerHTML = '<span class="spinner is-active"></span>Uploading...';
      
        // Get the files from the form input
        var files = myFile.files;
      
        // Create a FormData object
        var formData = new FormData();
      
        // Select only the first file from the input array
        var file = files[0];
      
        // Add the file to the AJAX request
        formData.append('formAjax', file,file.name);
        formData.append('action','uplaod_json_woodokan');
      
      
        // Set up the request
        // let expcodData = {
        //     security: expcodAjaxObject.wd_nonce,
        //     action: 'uplaod_json_woodokan',
        //     formDta: formData,
        //     settings: 'expcod_sheets'
        // }
        console.log(expcodAjaxObject.url)

        $.ajax({
            url: expcodAjaxObject.url,
      type: "POST",
      data:  new FormData(this),
      contentType: false,
            cache: false,
      processData:false,
      beforeSend : function()
      {
       
      },
      success: function(data){
        statusP.innerHTML = '<div class="notice notice-success notice-alt"><p>File uploaded successfully!</p></div>';
        statusP.innerHTML += '<div class="notice"><p>'+data.acc+'</p></div>';
      }
        
         ,
        error: function(e) 
         {
            statusP.innerHTML = 'Error';
         }          
       });
      }) 
   
    

})