jQuery(document).ready(function($) {
    var sliding = false;
    $('.codexpress-field-toggler').on('click dblclick', function() {

        if (!sliding) {
            sliding = true;
            $(this).parent().parent().find('.codexpress-field-body').slideToggle(150, function() {
                sliding = false;
            });
            $(this).find('span').toggleClass('rolled');

        }
    })

    /**** start tabination **** */


    $('.tab-item').on('click', function() {

        let data = $(this).data('target');
        $('.tab-item').removeClass('active');
        $(this).addClass('active');
        console.log(data)
        $('.tab-content').css({ "display": "none" });

        $('.' + data).css({ "display": "block" });

    })
})