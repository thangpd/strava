import $ from "jquery"

$(function () {
    console.log('strava api');

    //close popup for zalo access token
    function cancelHandler() {
        if ($('.strava_access_token_page').length !== 0) {
            if (window.opener) { //If popup -> close
                window.parent.close();
            }
        }
    }

    cancelHandler()
})