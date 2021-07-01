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
            return (i + 1) + '/' + slider.slideCount;
        }
    });

    $('.popup-modal__challenges-list').slick({
        arrows: true,
        slidesToShow: 2,
        prevArrow: "<div class='slick-prev arrow-left'><i class='fal fa-chevron-left'></i></div>",
        nextArrow: "<div class='slick-next arrow-right'><i class='fal fa-chevron-right'></i></div>",
        dots: false,
        responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: false
              }
            }
        ]
    });


    $(document).on('click', '.more-challenge', function(e) {
        e.preventDefault();

        var parent = $(this).parents('.wrap-modal-user-profile');
        parent.addClass('active');
    });

    $('.overlay').on('click', function (e) {
        e.preventDefault();
        var parent = $(this).parents('.wrap-modal-user-profile');
        parent.removeClass('active');
    });

    $('.strava-challenges__list.strava-challenges__list-slick').slick({
        arrows: false,
        dots: true,
        slidesToShow: 2,
        customPaging: function(slider, i) {
            return '<i class="fas fa-circle"></i>';
        },
        responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: true
              }
            }
        ]
    });
});

// button connect strava
$(document).ready(function () {
    console.log('button connect strava');


    $('.get-access-token').on('click', function (e) {
        e.preventDefault();
        var opt_client_id = $(this).data('client_id')
        var opt_callback = $(this).data('url')
        var state = $(this).data('state');
        var url = 'https://www.strava.com/oauth/authorize?client_id=' + opt_client_id + '&response_type=code&redirect_uri=' + opt_callback + '&scope=read,activity:read&state=' + state
        // var url = 'https://www.strava.com/oauth/authorize'
        console.log(url)
        var zalo_popup = window.open(url, 'popup', 'width=600,height=600');
        var popupTick = setInterval(function () {
            if (zalo_popup.closed) {
                clearInterval(popupTick);
                location.reload(true)
                console.log('window closed!');
            }
        }, 500);

    })
    $('.deauthorize_strava').on('click', function (e) {
        console.log('ok')
        let user_id = $(this).data('user_id')
        var data = {
            'action': 'deauthorizeStrava',
            'user_id': user_id
        }
        $.ajax({
            'method': 'POST',
            'data': data,
            'url': ajax_object.ajax_url,
        }).done(function (res) {
            if(res.code==200){
                location.reload(true)
            }else{
                console.log(res)
                location.reload(true)
            }
        })
    })
});
