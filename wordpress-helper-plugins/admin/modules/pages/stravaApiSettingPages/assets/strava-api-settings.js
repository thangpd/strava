import $ from "jquery"
import validate from "jquery-validation"

$(function () {
    if ($.validator) {
        // $.validator is defined
        console.log('validate is loaded')
    }
    /* console.log(el_zalo_const.field_names.opt_appid)
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
     */

    $('.get-subsciption-token').on('click', function (e) {
        e.preventDefault();
        var j_form = $('.strava-form')
        // var opt_appid = j_form.find('input[name="' + el_zalo_const.field_names.opt_appid + '"')
        // var opt_callback = j_form.find('input[name="' + el_zalo_const.field_names.opt_callback + '"')
        var verify_token = j_form.find('input[name="' + 'verify_token' + '"');
        var client_id = j_form.find('input[name="' + 'client_id' + '"');
        var client_secret = j_form.find('input[name="' + 'client_secret' + '"');
        var callback_url = j_form.find('input[name="' + 'callback_url' + '"');
        var data = {
            verify_token: verify_token.val(),
            client_id: client_id.val(),
            client_secret: client_secret.val(),
            callback_url: callback_url.val()
        };
        console.log(data)
        var url = 'https://www.strava.com/api/v3/push_subscriptions'
        $.ajax({
            url: url,
            method: "POST",
            data: data
        })
    })

})