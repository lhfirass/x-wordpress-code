jQuery(document).ready(function($) {
    "use strict";
    $('#save-stylings').on('click', function() {
        let stylingsObj = {
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
            form_border_radius: $('#form_border_radius').val(),
            form_margin_top: $('#form_margin_top').val(),
            form_margin_bottom: $('#form_margin_bottom').val(),
            form_padding: $('#form_padding').val(),
        }

        $('#stylings').val(JSON.stringify(stylingsObj));

        let expcodData = {
            security: expcodAjaxObject.wd_nonce,
            action: 'expcod_settings',
            formDta: $('#stylings').val(),
            settings: 'expcod_stylings'
        }
        $.ajax({
            type: 'POST',
            url: expcodAjaxObject.ajax_url,
            data: expcodData,
            success: function(data) {
                $(".codexp-customizer-footer-overlay").css("display", "flex").fadeOut();
            },
            error: function(data) {
                $(".codexp-customizer-footer-overlay").css("display", "flex").fadeOut();
                // notyf.error('An error occured');
            },
            beforeSend: function() {
                $(".codexp-customizer-footer-overlay").css("display", "flex").fadeIn();
            }
        });

    })

    /*
     * Customizer toggle  visibility
     * customizer color picker
     * cutomizer reactivity
     */

    // [ 01 ] Making COD Express form css variables reactive with the customizer
    let rootelement = document.documentElement;
    let colorWell = document.querySelectorAll(".codcustomiser-color");
    window.addEventListener("load", startup, false);

    function startup() { 
        colorWell.forEach(element => {
            element.addEventListener("input", updateFirst);
        });
    }

    function updateFirst(event) {

        rootelement.style.setProperty(event.target.dataset.target, event.target.value);
    }

    let els = document.querySelectorAll(".codcustomiser-number");
    els.forEach(element => {
        element.addEventListener("change", function() {
            rootelement.style.setProperty(event.target.dataset.target, event.target.value + "px");

        });
    });

    let customizerSelect = document.querySelectorAll(".codcustomiser-select");
    customizerSelect.forEach(element => {
        element.addEventListener("change", function() {
            rootelement.style.setProperty(event.target.dataset.target, event.target.value);
        });
    });



    // [ 02 ] COD express customizer toggle , show and replacement
    document.getElementById('wp-admin-bar-show-codexpress-customizer').onclick = function() { // show customizer function
        let position = localStorage.getItem('codexpress-sidebar-poisition');
        if (localStorage.getItem("codexpress-sidebar-poisition") === null) {
            localStorage.setItem('codexpress-sidebar-poisition', 'right');
            position = 'right';
        }

        if (position != false) {
            if (position == 'right') {
                document.querySelector('.codexp-customizer').style.right = '-100%';
                document.getElementById('cod-customizer-sideleft').style.display = 'flex';
            } else {
                document.querySelector('.codexp-customizer').style.left = '-100%';
                document.getElementById('cod-customizer-sideright').style.display = 'flex';
            }
        } else {
            document.querySelector('.codexp-customizer').style.right = '-100%';
            document.getElementById('cod-customizer-sideleft').style.display = 'flex';
            localStorage.setItem('codexpress-sidebar-poisition', 'right');
            position = 'right';
        }

        document.querySelector('.codexp-customizer').style.display = 'block';
        setTimeout(function() {
            document.querySelector('.codexp-customizer').style[position] = '0%';
        }, 100)

        this.style.display = 'none';
    }



    document.getElementById('cod-customizer-hide').onclick = function() { // hide customizer function
        let position = localStorage.getItem('codexpress-sidebar-poisition');

        document.querySelector('.codexp-customizer').style[position] = '-100%';
        setTimeout(function() {
            document.getElementById(`cod-customizer-side${position}`).style.display = 'none';
        }, 100)
        localStorage.setItem('codexpress-sidebar-poisition', position);
        document.getElementById('wp-admin-bar-show-codexpress-customizer').style.display = "block";

    }


    document.getElementById('cod-customizer-sideleft').onclick = function() { // place customizer in the left side

        document.querySelector('.codexp-customizer').style.right = '-100%';
        document.querySelector('.codexp-customizer').style.left = 'unset';

        setTimeout(function() {
            document.querySelector('.codexp-customizer').style.display = 'none';
            document.querySelector('.codexp-customizer').style.right = 'unset';
            document.querySelector('.codexp-customizer').style.left = '-100%';
            document.querySelector('.codexp-customizer').style.display = 'block';
            document.getElementById('cod-customizer-sideleft').style.display = 'none';
            document.getElementById('cod-customizer-sideright').style.display = 'flex';
            setTimeout(function() {
                document.querySelector('.codexp-customizer').style.left = '0';
            }, 100)
        }, 500);

        localStorage.setItem('codexpress-sidebar-poisition', 'left');
    }


    document.getElementById('cod-customizer-sideright').onclick = function() { // place customizeer in the right side
        let $this = this;
        document.querySelector('.codexp-customizer').style.left = '-100%';
        document.querySelector('.codexp-customizer').style.right = 'unset';

        setTimeout(function() {
            document.querySelector('.codexp-customizer').style.display = 'none';

            document.querySelector('.codexp-customizer').style.left = 'unset';
            document.querySelector('.codexp-customizer').style.right = '-100%';
            document.querySelector('.codexp-customizer').style.display = 'block';
            $this.style.display = 'none';
            document.getElementById('cod-customizer-sideright').style.display = 'none';
            document.getElementById('cod-customizer-sideleft').style.display = 'flex';
            setTimeout(function() {
                document.querySelector('.codexp-customizer').style.right = '0';
            }, 100)

        }, 500);
        localStorage.setItem('codexpress-sidebar-poisition', 'right');
    }
})