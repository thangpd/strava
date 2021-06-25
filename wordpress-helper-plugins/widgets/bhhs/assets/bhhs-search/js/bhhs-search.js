(function ($) {
    console.log('post mansory elhelper')
    console.log($(document))
    // $('.khachhang-slider').slick()
    if (window.matchMedia("(max-width: 426px)").matches) {
        /* the viewport is less than 768 pixels wide */
        $('.post-mansonry-container').slick({
            dots: true,
            infinite: true,
            autoplay: false,
            autoplaySpeed: 2000,
            pauseOnFocus: false,
            pauseOnHover: false,
            pauseOnDotsHover: false,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    }
})(jQuery);