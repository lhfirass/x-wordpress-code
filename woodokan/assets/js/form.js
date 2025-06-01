jQuery(document).ready(function($) {
    "use strict";

    /*========================================
    *   Creating confirm order template function
    =========================================*/

    function createConfirmation(data) {

        let $customerInfo = '';
        data.checkoutData.preview.forEach(element => {
            $customerInfo += `
                    <div class="shipping-info">
                        <p>${element[0]}</p>
                        <b>${element[1]}</b>
                    </div>`;
        });


        let $subTotal = data.cartSubtotal;
        let $total = data.cartTotal;
        let $variationId = data.variationId;
        let $quantity = data.productQuantity;
        let $shipping = data.Shipping;
        let $checkoutNote;
        let str = data.checkoutNote;
        let codexpressTranslation = expcodAjaxObject.codexpressTranslation

        if (!str.replace(/\s/g, '').length) {
            $checkoutNote = '';
        } else {
            $checkoutNote = `
            <div class="codexpress-checkout-card">
            <div class="codexpress-checkout-card-header">
                <span> ${codexpressTranslation.notice} </span>
            </div>
            <div class="codexpress-checkout-card-body">
                <p>${data.checkoutNote}</p>
            </div>
        </div>`;
        }


        let $variation = '';
        if (!$variationId.replace(/\s/g, '').length) {
            $variation = '';
        } else {
            $variation = `
            <div class="order-summary-detail">
            <p>${codexpressTranslation.type}</p>
            <p>${$variationId}</p>
        </div>`;
        }

        let $orderInfo = `
        <div class="codexpress-checkout-billing">
        <div class="codexpress-checkout-billing-body">
            <div class="codexpress-checkout-card">
                <div class="codexpress-checkout-card-header">
                    <span> ${codexpressTranslation.your_order} </span>
                </div>
                <div class="codexpress-checkout-card-body">
                  ${$customerInfo}
                    <div>
                        <div class="order-summary-detail">
                            <p>${codexpressTranslation.shipping}</p>
                            <p>${$shipping}</p>
                        </div>
                        <div class="order-summary-detail">
                            <p>${codexpressTranslation.quantity}</p>
                            <p>${$quantity}</p>
                        </div>
                        ${$variation}

                        <div class="order-summary-detail">
                            <p>${codexpressTranslation.product_price}</p>
                            <p>${$subTotal}</p>     
                        </div>
                        <div class="order-summary-detail total-box">
                            <p>${codexpressTranslation.total}</p>
                            <p>${$total}</p>  
                        </div>
                    </div>

                </div>
                <div class="codexpress-checkout-card-footer">
                    <a href="javascript:void(0)" id="edit-customer-informations">${codexpressTranslation.edit}</a>
                </div>
            </div>
            ${$checkoutNote}

        </div>
        <div class="codexpress-checkout-billing-footer">
            <button class="expcod-placeorder">
            <span class="place-order-text">${codexpressTranslation.place_order}</span>
                <div class="expcod-loading-btn-animation">
                    <div class="lds-spinner" ><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                </div>
            </button>
        </div>
    </div>`;

        return $orderInfo;
    }

    /*====================================================
     * Before Send functions
     *====================================================*/

    function beforeSendFunction() {
        $(this).prop('disabled', true);
        if ($(this).hasClass('disabled')) { return; }
        $("#buy_now_btn_loader").css({ 'display': 'flex' });
        $("#woodokan_buy_now_button").css({ 'opacity': '.3' });

    }

    /*====================================================
     * finish request functions
     *====================================================*/
    function finisReqFunction() {

        $("#buy_now_btn_loader").css({ 'display': 'none' });
        $("#woodokan_buy_now_button").css({ 'opacity': '1' });
    }
    /*====================================================
     * error functions
     *====================================================*/
    function errorReqFunction() {}

    function showValidationErrors(fields) {

        for (const property in fields) {

            if (fields[property].valid == false) {

                $(`input[name="${property}"]`).css({ 'border-color': 'red', 'border-width': '2px' });

                $(`#${property}`).html(fields[property].message);
            };
        }
    }
    /*====================================================
     * Buy now ajax request functions
     *====================================================*/
    let expcodBuyNowBtn = $('#buy_now_btn');

    expcodBuyNowBtn.on('click', function(e) {

        if ($(this).hasClass('disabled')) {
            return;
        }
        e.preventDefault();
        let expcodFormData = $('#woodokan_form').serialize();

        $('input[name^=field_type_]').css({ 'border-color': '', 'border-width': '' });
        $(`[id^=field_type_]`).html('');

        $.ajax({
            type: 'POST',
            url: expcodAjaxObject.ajax_url,
            data: expcodFormData,
            success: function(data) {
                let response = data;
                /*
                 ** Order Placed sucessfully function
                 **
                 */

                if (response.success == true) {
                    finisReqFunction();

                    if (response.steps == 1) {
                        $('.expcod-loading-btn-animation').fadeOut()
                        $('.woodokan-form-elements').fadeOut()
                        $('.codexp-success-message').html(response.message);
                        $('.codexp-success-message').fadeIn();
                        $('#expcod-checkout').fadeOut();
                        window.location = response.redirect;

                    } else {
                        let checkoutTemplate = createConfirmation(response);
                        $('#expcod-checkout').html(checkoutTemplate);
                        $('.express-cod-checkout-form').fadeOut();
                        $('#expcod-checkout').fadeIn();

                        $('#edit-customer-informations').on('click', function() {

                            $('#buy_now_btn').prop('disabled', false);
                            showValidationErrors(response.fields);
                            finisReqFunction();
                            $('#expcod-checkout').fadeOut('fast', function() {
                                $('.express-cod-checkout-form').fadeIn();
                            });
                        })

                        $('.expcod-placeorder').on('click', function() {
                            placeOrder()
                        })
                    }




                } else if (response.success == false && response.validity == false) {
                    $('#buy_now_btn').prop('disabled', false);
                    showValidationErrors(response.fields);
                    finisReqFunction();

                } else if (response.success == false && response.validity == true) {

                    $('.woodokan-error-message').html(response.message);
                    $('.woodokan-error-message').fadeIn();
                    $('#woodokan_form').fadeOut();
                    finisReqFunction();

                }
            },

            error: function(data) {

                errorReqFunction();
            },

            beforeSend: function() {

                beforeSendFunction();
            }
        });
    })

    /*====================================================
     * Quantity inputs
     *====================================================*/
    $('#plus_quantity').on('click', function() {

        $('#quantitiy_input').val(parseInt($('#quantitiy_input').val()) + 1);
        $('#quantity-placeholder').html(parseInt($('#quantitiy_input').val()));

        wd_update_sum($('#quantitiy_input').val());
    })

    $('#minus_quantity').on('click', function() {

        if ($('#quantitiy_input').val() <= 1) {
            return;
        }

        $('#quantitiy_input').val($('#quantitiy_input').val() - 1);
        $('#quantity-placeholder').html($('#quantitiy_input').val());
        wd_update_sum($('#quantitiy_input').val());
    })

    /*====================================================
     * Confirm order ajax request
     *====================================================*/

    function placeOrder() {

        $.ajax({
            type: 'POST',
            url: expcodAjaxObject.ajax_url,
            data: {
                action: 'expcod_place_order',
            },
            success: function(data) {
                let response = data

                if (response.success == true) {

                    $('.expcod-loading-btn-animation').fadeOut()
                    $('.codexp-success-message').html(response.message);
                    $('.codexp-success-message').fadeIn();
                    $('#expcod-checkout').fadeOut();
                    setTimeout(() => { window.location = response.redirect; }, 3000);
                }
            },
            beforeSend: function() {

                $('.place-order-text').fadeOut('fast', function() {
                    $('.expcod-loading-btn-animation').fadeIn()
                })
            }
        })
    }





})