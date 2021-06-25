jQuery(document).ready(function ($) {
    var footer_dropdowns = $('.dropdown-footer .elementor-widget-heading')
    if (footer_dropdowns.length > 0) {
        $.each(footer_dropdowns, function (index, value) {
            console.log(index)
            console.log(value)
            $(value).on('click', function (e) {
                $(this).toggleClass('active')
                console.log($(this).next().toggle());
            })
        })
    }
});