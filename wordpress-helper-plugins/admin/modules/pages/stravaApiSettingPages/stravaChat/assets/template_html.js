import $ from "jquery"

export default function templateHtml() {
    this.chatlive = function (user_id, name, avatar, date, mess) {
        return `<div class="chat_list" data-user_id="${user_id}">
                        <div class="chat_people">
                            <div class="chat_img"><img src="${avatar}"
                                                       alt="sunil"></div>
                            <div class="chat_ib">
                                <h5>${name} <span class="chat_date">${date}</span></h5>
                                <p>${mess}</p>
                            </div>
                        </div>
                    </div>`

    }

    var json_history_chat = {
        "data": [{
            "src": 0,
            "time": 1614326267621,
            "type": "text",
            "message": "End.",
            "message_id": "12ec7195e9e423b87af7",
            "from_id": "2378013480520699910",
            "to_id": "8110366740718803304",
            "from_display_name": "TechVSI",
            "from_avatar": "https:\/\/s240-ava-talk.zadn.vn\/4\/5\/5\/5\/2\/240\/d649d3b22c7e55efd7d99388c4747890.jpg",
            "to_display_name": "Ph\u1ea1m Th\u1ebf Thu\u1eadn",
            "to_avatar": "https:\/\/s240-ava-talk.zadn.vn\/8\/6\/1\/d\/5\/240\/070eae57e2447f9392111c770de1c7ff.jpg"
        }, {
            "src": 1,
            "time": 1614326231537,
            "type": "text",
            "message": "G\u00f9ucj",
            "message_id": "df97ffcd96bc5ce005af",
            "from_id": "8110366740718803304",
            "to_id": "2378013480520699910",
            "from_display_name": "Ph\u1ea1m Th\u1ebf Thu\u1eadn",
            "from_avatar": "https:\/\/s240-ava-talk.zadn.vn\/8\/6\/1\/d\/5\/240\/070eae57e2447f9392111c770de1c7ff.jpg",
            "to_display_name": "TechVSI",
            "to_avatar": "https:\/\/s240-ava-talk.zadn.vn\/4\/5\/5\/5\/2\/240\/d649d3b22c7e55efd7d99388c4747890.jpg"
        }, {
            "src": 1,
            "time": 1614326224406,
            "type": "text",
            "message": "Bye",
            "message_id": "49b8924dfe3c34606d2f",
            "from_id": "8110366740718803304",
            "to_id": "2378013480520699910",
            "from_display_name": "Ph\u1ea1m Th\u1ebf Thu\u1eadn",
            "from_avatar": "https:\/\/s240-ava-talk.zadn.vn\/8\/6\/1\/d\/5\/240\/070eae57e2447f9392111c770de1c7ff.jpg",
            "to_display_name": "TechVSI",
            "to_avatar": "https:\/\/s240-ava-talk.zadn.vn\/4\/5\/5\/5\/2\/240\/d649d3b22c7e55efd7d99388c4747890.jpg"
        }, {
            "src": 1,
            "time": 1614326202951,
            "type": "text",
            "message": "V\u00f9ug",
            "message_id": "082567ee119fdbc3828c",
            "from_id": "8110366740718803304",
            "to_id": "2378013480520699910",
            "from_display_name": "Ph\u1ea1m Th\u1ebf Thu\u1eadn",
            "from_avatar": "https:\/\/s240-ava-talk.zadn.vn\/8\/6\/1\/d\/5\/240\/070eae57e2447f9392111c770de1c7ff.jpg",
            "to_display_name": "TechVSI",
            "to_avatar": "https:\/\/s240-ava-talk.zadn.vn\/4\/5\/5\/5\/2\/240\/d649d3b22c7e55efd7d99388c4747890.jpg"
        }, {
            "src": 0,
            "time": 1614326200731,
            "type": "text",
            "message": "Fycucu",
            "message_id": "db0006f67187bbdbe294",
            "from_id": "2378013480520699910",
            "to_id": "8110366740718803304",
            "from_display_name": "TechVSI",
            "from_avatar": "https:\/\/s240-ava-talk.zadn.vn\/4\/5\/5\/5\/2\/240\/d649d3b22c7e55efd7d99388c4747890.jpg",
            "to_display_name": "Ph\u1ea1m Th\u1ebf Thu\u1eadn",
            "to_avatar": "https:\/\/s240-ava-talk.zadn.vn\/8\/6\/1\/d\/5\/240\/070eae57e2447f9392111c770de1c7ff.jpg"
        }, {
            "src": 1,
            "time": 1614326194478,
            "type": "text",
            "message": "C\u00f9ucu",
            "message_id": "d27faeaed4df1e8347cc",
            "from_id": "8110366740718803304",
            "to_id": "2378013480520699910",
            "from_display_name": "Ph\u1ea1m Th\u1ebf Thu\u1eadn",
            "from_avatar": "https:\/\/s240-ava-talk.zadn.vn\/8\/6\/1\/d\/5\/240\/070eae57e2447f9392111c770de1c7ff.jpg",
            "to_display_name": "TechVSI",
            "to_avatar": "https:\/\/s240-ava-talk.zadn.vn\/4\/5\/5\/5\/2\/240\/d649d3b22c7e55efd7d99388c4747890.jpg"
        }, {
            "src": 0,
            "time": 1614326191355,
            "type": "text",
            "message": "Xttxy",
            "message_id": "2105f41f886e42321b7d",
            "from_id": "2378013480520699910",
            "to_id": "8110366740718803304",
            "from_display_name": "TechVSI",
            "from_avatar": "https:\/\/s240-ava-talk.zadn.vn\/4\/5\/5\/5\/2\/240\/d649d3b22c7e55efd7d99388c4747890.jpg",
            "to_display_name": "Ph\u1ea1m Th\u1ebf Thu\u1eadn",
            "to_avatar": "https:\/\/s240-ava-talk.zadn.vn\/8\/6\/1\/d\/5\/240\/070eae57e2447f9392111c770de1c7ff.jpg"
        }, {
            "src": 0,
            "time": 1614326184065,
            "type": "text",
            "message": "Vui l\u00f2ng ch\u1edd \u0111\u1ee3i..",
            "message_id": "f4f5d07aaf0b65573c18",
            "from_id": "2378013480520699910",
            "to_id": "8110366740718803304",
            "from_display_name": "TechVSI",
            "from_avatar": "https:\/\/s240-ava-talk.zadn.vn\/4\/5\/5\/5\/2\/240\/d649d3b22c7e55efd7d99388c4747890.jpg",
            "to_display_name": "Ph\u1ea1m Th\u1ebf Thu\u1eadn",
            "to_avatar": "https:\/\/s240-ava-talk.zadn.vn\/8\/6\/1\/d\/5\/240\/070eae57e2447f9392111c770de1c7ff.jpg"
        }, {
            "src": 0,
            "time": 1614326183917,
            "type": "text",
            "message": "\u0110\u00e3 gh\u00e9p n\u1ed1i!",
            "message_id": "19025d9d22ece8b0b1ff",
            "from_id": "2378013480520699910",
            "to_id": "8110366740718803304",
            "from_display_name": "TechVSI",
            "from_avatar": "https:\/\/s240-ava-talk.zadn.vn\/4\/5\/5\/5\/2\/240\/d649d3b22c7e55efd7d99388c4747890.jpg",
            "to_display_name": "Ph\u1ea1m Th\u1ebf Thu\u1eadn",
            "to_avatar": "https:\/\/s240-ava-talk.zadn.vn\/8\/6\/1\/d\/5\/240\/070eae57e2447f9392111c770de1c7ff.jpg"
        }, {
            "src": 1,
            "time": 1614326182497,
            "type": "text",
            "message": "Say hi",
            "message_id": "e4f32c5a6c2ba677ff38",
            "from_id": "8110366740718803304",
            "to_id": "2378013480520699910",
            "from_display_name": "Ph\u1ea1m Th\u1ebf Thu\u1eadn",
            "from_avatar": "https:\/\/s240-ava-talk.zadn.vn\/8\/6\/1\/d\/5\/240\/070eae57e2447f9392111c770de1c7ff.jpg",
            "to_display_name": "TechVSI",
            "to_avatar": "https:\/\/s240-ava-talk.zadn.vn\/4\/5\/5\/5\/2\/240\/d649d3b22c7e55efd7d99388c4747890.jpg"
        }], "error": 0, "message": "Success"
    }
    this.listMessage = function (data = {}) {
        var render_list_message = '';
        data = JSON.parse(data)
        if (data.data.length > 0) {
            $.each(data.data, function (index, value) {
                if (value.src === 0) {
                    render_list_message += outGoingMessage(value.message, value.time)
                } else {
                    render_list_message += inCommingMessage(value.from_avatar, value.message, value.time)
                }
            })
        }
        return render_list_message
    }

    var inCommingMessage = function (avatar, message, date) {
        return `<div class="incoming_msg">
                        <div class="incoming_msg_img"><img src="${avatar}" alt="sunil"></div>
                        <div class="received_msg">
                            <div class="received_withd_msg">
                                <p>${message}</p>
                                <span class="time_date"> ${date}</span></div>
                        </div>
                    </div>`
    }
    var outGoingMessage = function (message, date) {
        return `<div class="outgoing_msg">
                        <div class="sent_msg">
                            <p>${message}</p>
                            <span class="time_date">${date}</span></div>
                    </div>`
    }


}