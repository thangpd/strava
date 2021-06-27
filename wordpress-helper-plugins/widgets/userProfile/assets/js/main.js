import $ from "jquery";
import "slick-carousel";

$(document).ready(function () {
    $('.table-tab').slick({
        arrows: true,
        prevArrow: "<div class='slick-prev arrow-left'><i class='fal fa-chevron-left'></i></div>",
        nextArrow: "<div class='slick-next arrow-right'><i class='fal fa-chevron-right'></i></div>",
        dots: true,
        dotsClass: 'table-paging',
        customPaging: function (slider, i) {
            return  (i + 1) + '/' + slider.slideCount;
        }
    });

    $('.popup-modal__challenges').slick({
        arrows: true,
        prevArrow: "<div class='slick-prev arrow-left'><i class='fal fa-chevron-left'></i></div>",
        nextArrow: "<div class='slick-next arrow-right'><i class='fal fa-chevron-right'></i></div>",
        dots: false,
    });

    $('.popup-strava-challenges').on('click', function(e) {
        e.preventDefault();
        var parent = $(this).parents('.wrap-modal-user-profile');
    
        parent.addClass('active');
    });

    $('.overlay').on('click', function(e) {
        e.preventDefault();

        var parent = $(this).parents('.wrap-modal-user-profile');
        parent.removeClass('active');
    })

});