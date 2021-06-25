import $ from "jquery"

export default function () {


    this.sendMessage = function (user_id, message) {
        var data = {
            action: 'send_zalo_message',
            message: message,
            user_id: user_id,
        }
        console.log(data)
        return $.ajax({
            'method': 'POST',
            'url': ajax_object.ajax_url,
            'data': data,
        }).done(function (res) {
            return res
        })
    }


}