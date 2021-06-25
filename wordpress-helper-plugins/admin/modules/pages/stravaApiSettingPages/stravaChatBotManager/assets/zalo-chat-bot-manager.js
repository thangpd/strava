import $ from "jquery"
import SlimSelect from 'slim-select'
import templateHtml from "./template_html";

let messageType;
let events = [];

$(function () {
    onChangeFile;
    initMultipleSelect();
    updateSettingWebhook();
    getSettingWebhook();
    onSave();

    $('#exampleModal').on('show.bs.modal', function (e) {
        var keyword = $(e.relatedTarget).data('keyword');

        isEditModal(keyword);
        
        if(keyword) {
            var event = events.filter((e) => e.keyword = keyword);
            event = (event.length > 0) ? event[0] : null;

            // Bind data
            messageType.set(event.action);
            $(e.currentTarget).find('#txtKeyword').val(event.keyword);

            event.action.forEach(function(type) {
                let field = $(`.val-${type}`).find('.val-field');
                if(field) {
                    if(type == 'image') {
                        
                    }
                    else {
                        field.val(event[type]);
                    }
                }
            });    
        }
    })

    $('#exampleModal').on('hide.bs.modal', function (e) {
        messageType.set([]);
        $(e.currentTarget).find('#txtKeyword').val('');
        $(e.currentTarget).find('#txtText').val('');
    })
})

function isEditModal(value) {
    if(value) {
        $('.add-title').hide();
        $('.on-add').hide();
        $('.edit-title').show();
        $('.on-update').show();
    }
    else {        
        $('.add-title').show();
        $('.on-add').show();
        $('.edit-title').hide();
        $('.on-update').hide();
    }
}

function onChangeFile() {
    $('#fImage').on('change', function(event) {
        console.log(event);
    });
}

function onSave() {
    $('.on-save').on('click', function() {
        if(messageType.selected().length > 0) {
            let fields = {};
            messageType.selected().forEach(function(type) {
                let field = $(`.val-${type}`).find('.val-field');
                if(field) {
                    if(type == 'image') {                        
                        fields[type] = field.files;
                    }
                    else {
                        fields[type] = field.val();
                    }
                }
            });            
            var types = Object.keys(fields);
            var keyword = $('#txtKeyword').val();
            var e = {
                action: types,
                keyword: keyword,
                ...fields
            }
            events.push(e)
            var $template = (new templateHtml()).eventItem($('.event-list .event-item').length + 1,
                keyword,
                types,
                fields.text
                )
            $('.event-list').append($template)
        }
    });
}

function getSettingWebhook() {
    var data = {
        'action': 'get_setting_webhook',
    }
    $.ajax({
        'method': 'GET',
        'data': data,
        'url': ajax_object.ajax_url,
    }).done(function (res) {
        let settings = JSON.parse(res);
        if (typeof settings.data === 'object') {
            events = settings.data;
            var $eventLength = (new templateHtml()).eventLength(settings.length);
            $('.event-length').append($eventLength)            
            $.each(settings.data, function (index, value) {
                var $template = (new templateHtml()).eventItem(index + 1,
                    value.keyword,
                    value.action,
                    value.text
                    )
                $('.event-list').append($template)
            })
        }
    })
}

function updateSettingWebhook() {
    let setting = [
        {
            keyword: '#anchuoi',
            action: ['text'],
            text: 'Chu chim non'
        }
    ]
    var data = {
        'action': 'update_setting_webhook',
        'setting': setting
    }
    $.ajax({
        'method': 'POST',
        'data': data,
        'url': ajax_object.ajax_url,
    }).done(function (res) {
        console.log(res);
    })
}

function initMultipleSelect() {
    let rules = {
        text: ['text','image', 'button'],        
        image: ['image', 'text', 'button'],
        list: ['list'],
        button: ['button', 'text', 'image'],
        file: ['file']
    }
    let allows = [];
    
    const displayData = [
        {text: 'Text', value: 'text', disabled: false},
        {text: 'Image', value: 'image', disabled: false},
        {text: 'List', value: 'list', disabled: false},
        {text: 'Button', value: 'button', disabled: false},
        {text: 'File', value: 'file', disabled: false}
    ]

    messageType = new SlimSelect({
        select: '#messageType',
        beforeOnChange: (info) => {
            let newData;
            if(info.length > 0) {
                info.forEach(function(event) {
                    if(messageType.selected().indexOf(event.value) == -1) {
                        newData = event.value;
                    }
                });
            }
            if(info.length > 0 && allows.length > 0 && allows.indexOf(newData) == -1) {
                return false;
            }
        },
        onChange: (info) => {
            allows = [];
            let newData;

            $('.val').hide();

            if(info.length > 0) {
                info.forEach(function(event) {
                    let isHas = event.value in rules;
                    if(isHas) {
                        allows = allows.concat(rules[event.value]);
                    }
                    if(messageType.selected().indexOf(event.value) == -1) {
                        newData = event.value;
                    }
                    $(`.val-${event.value}`).css('display','flex');
                });
            }

            let l = messageType.data.data;
            l.forEach(function(e,i) {
                if(info.length > 0 && allows.indexOf(e.value) == -1) {
                    setTimeout(function() {                        
                        $(`.ss-option[data-id=${e.id}]`).addClass('ss-disabled');
                    }, 100);
                }
            });
        },
    });

    messageType.setData(displayData);
}