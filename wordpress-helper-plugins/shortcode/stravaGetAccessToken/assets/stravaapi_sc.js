import $ from "jquery";


$(function () {
    console.log('zaloapi_get_access token sc');

    function cancelHandler() {

        if (window.opener) { //If popup -> close
            window.parent.close();
        }
    }

    cancelHandler()
})