import $ from "jquery"

export default function templateHtml() {
    this.eventLength = function (length) {
        return `<i class="fad fa-list"></i> ${length} events found`
    }
    this.eventItem = function (index, keyword, actionType, description) {
        return `<div class="event-item">
                    <div class="event-field">${index}</div>
                    <div class="event-field">${keyword}</div>
                    <div class="event-field">${actionType}</div>
                    <div class="event-field">${description}</div>
                    <div class="event-action-field">
                        <a class="event-edit" href="#" data-keyword="${keyword}" data-toggle="modal" data-target="#exampleModal">Edit</a>
                    </div>
                </div>`
    }
}