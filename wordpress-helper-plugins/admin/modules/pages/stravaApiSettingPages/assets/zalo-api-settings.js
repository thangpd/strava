import $ from "jquery"
import validate from "jquery-validation"

$(function () {
    if ($.validator) {
        // $.validator is defined
        console.log('validate is loaded')
    }
    console.log(el_zalo_const.field_names.opt_appid)
    var rule_opt = {
        [el_zalo_const.field_names.opt_appid]: 'required',
    }
    console.log(rule_opt)
    var options = {
        rules: rule_opt,
        messages: {
            [el_zalo_const.field_names.opt_appid]: "Please enter your App ID",
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            form.submit();
        }
    }
    console.log(options)
    $('.zalo-form').validate(options)

    $('.get-access-token').on('click', function (e) {
        e.preventDefault();
        var j_form = $('.zalo-form')
        var opt_appid = j_form.find('input[name="' + el_zalo_const.field_names.opt_appid + '"')
        var opt_callback = j_form.find('input[name="' + el_zalo_const.field_names.opt_callback + '"')
        var url = 'https://oauth.zaloapp.com/v3/oa/permission?app_id=' + opt_appid.val() + '&redirect_uri=' + opt_callback.val() + '"'
        var zalo_popup = window.open(url, 'popup', 'width=600,height=600');
        var popupTick = setInterval(function () {
            if (zalo_popup.closed) {
                clearInterval(popupTick);
                location.reload(true)
                console.log('window closed!');
            }
        }, 500);

    })

})