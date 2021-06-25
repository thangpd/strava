import $ from "jquery";
import "slick-carousel";


$(document).ready(function () {
    console.log('ok');


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
});
