import $ from "jquery"
import templateHtml from "./template_html";
import sendMessageModel from "./sendMessageModel";

$(function () {

    function newMessage() {
        var message = $(".input_msg_write input.write_msg").val();
        if ($.trim(message) == '') {
            return false;
        }
        var user_id = $('.chat_list.active_chat').data('user_id')
        var res = new sendMessageModel().sendMessage(user_id, message)
        console.log(res)
        let $msgHistory = $(".msg_history");
        $(`<div class="outgoing_msg">
                        <div class="sent_msg">
                            <p>${message}</p>
                            <span class="time_date"> 11:01 AM    |    Today</span></div>
                    </div>`).appendTo($msgHistory);
        $('.input_msg_write input').val(null);
        $('.contact.active .preview').html('<span>You: </span>' + message);
        $msgHistory.animate({scrollTop: $(document).height()}, "fast");
    }

    $('.msg_send_btn').click(function () {
        newMessage();
    });

    $(window).on('keydown', function (e) {
        if (e.which == 13) {
            newMessage();
            return false;
        }
    });

    $('body').on('click', '.chat_list', function (e) {
        $('.chat_list').removeClass('active_chat')
        $(this).addClass('active_chat')
        var data = {
            'action': 'get_history_message_of_subscriber',
            'user_id': $(this).data('user_id'),
        }
        $.ajax({
            'method': "GET",
            data: data,
            'url': ajax_object.ajax_url,
        }).done(function (res) {
            var result = (new templateHtml()).listMessage(res)

            let $msgHistory = $('.msg_history');
            $msgHistory.html('')
            $msgHistory.append(result)
            $msgHistory.animate({scrollTop: $(document).height()}, "fast");

        })

    })
    var data = {
        'action': 'get_list_subscribers',
    }
    $.ajax({
        'method': 'GET',
        data: data,
        'url': ajax_object.ajax_url,
    }).done(function (res) {
        let list_subscriber = JSON.parse(res);
        if (typeof list_subscriber.data === 'object') {
            $.each(list_subscriber.data, function (index, value) {
                var $template = (new templateHtml()).chatlive(index,
                    value.data.display_name,
                    value.data.avatar,
                    value.data.birthday,
                    'test mess')
                $('.inbox_chat').append($template)
            })
        }

    })

})
