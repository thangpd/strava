<?php
/**
 * Date: 3/1/21
 * Time: 10:39 AM
 */
wp_head();

?>

    <div class="wrapper-chatbot">
        <h3 class="chatbot-heading">Events</h3>

        <div class="event-list">
            <div class="event-item-action">
                <div class="event-length"></div>
                <div class="chatbox-search">[SEARCH]</div>
                <div><button class="primary" data-toggle="modal" data-target="#exampleModal">Add Event</button></div>
            </div>
            <div class="event-item-header">
                <div class="event-field">#</div>
                <div class="event-field">KEYWORD</div>
                <div class="event-field">ACTION TYPE</div>
                <div class="event-field">DESCRIPTION</div>
                <div class="event-action-field"></div>
            </div>
            <!-- <div class="event-item">
                <div class="event-field">#CUPHAP</div>
                <div class="event-field">[ACTION TYPE]</div>
                <div class="event-field">[DESCRIPTION]</div>
                <div class="event-action-field">[EDIT/DELETE ACTION]</div>
            </div>
            <div class="event-item">
                <div class="event-field">#CUPHAP</div>
                <div class="event-field">[ACTION TYPE]</div>
                <div class="event-field">[DESCRIPTION]</div>
                <div class="event-action-field">[EDIT/DELETE ACTION]</div>
            </div>
            <div class="event-item">
                <div class="event-field">#CUPHAP</div>
                <div class="event-field">[ACTION TYPE]</div>
                <div class="event-field">[DESCRIPTION]</div>
                <div class="event-action-field">[EDIT/DELETE ACTION]</div>
            </div> -->
        </div>
        
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title add-title">Add new event</h5>
                    <h5 class="modal-title edit-title" style="display:none">Edit event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="txtKeyword" class="col-sm-3 col-form-label">Keyword</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtKeyword" placeholder="Input your keyword">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Message type</label>
                        <div class="col-sm-9">
                            <select multiple id="messageType">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row val val-text">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Text</label>
                        <div class="col-sm-9">
                            <textarea name="txtText" class="form-control val-field" id="txtText" rows="3"></textarea>  
                        </div>
                    </div>
                    <div class="form-group row val val-image">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-9">
                            <input name="fImage" type="file" class="form-control-file val-field" id="fImage">
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="primary on-add">Add Event</button>
                    <button type="button" class="primary on-update" style="display:none">Update Event</button>
                </div>
                </div>
            </div>
        </div>
    </div>

<?php

wp_footer();
