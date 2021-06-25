import $ from "jquery"
import 'slick-carousel'


$(document).ready(function () {
    $('.r-carousel').slick({
        arrows: true,
        prevArrow: '<div class="r-carousel__button r-carousel__button--left"><div><img class="r-carousel__arrow-image r-carousel__arrow-image--left" src="https://cdn4.iconfinder.com/data/icons/miu/24/circle-back-arrow-glyph-48.png"></div></div>',
        nextArrow: '<div class="r-carousel__button r-carousel__button--right"><div><img class="r-carousel__arrow-image r-carousel__arrow-image--right" src="https://cdn4.iconfinder.com/data/icons/miu/24/circle-next-arrow-disclosure-glyph-48.png"></div></div>',
        //   infinite: true,
        // slidesToShow: 3,
        // slidesToScroll: 3
    });
});