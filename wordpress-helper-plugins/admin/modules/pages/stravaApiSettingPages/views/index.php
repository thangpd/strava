<?php
/**
 * Date: 2/25/21
 * Time: 10:43 AM
 */
?>

<div class="wrap col-sm-7">
    <h2>Config Strava API</h2>
    <form class="strava-form " method="post" action="">
        <input type="hidden" name="<?php echo $context->hidden_field_name; ?>" value="multiform">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label"
                   for="client_id"><?php _e( "CLIENT ID:", 'el-helper' ); ?></label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="client_id"
                       id="client_id"
                       value="<?php echo CLIENT_ID ?>"/>
                <small id="" class="form-text text-muted">Description</small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label"
                   for="client_secret"><?php _e( "CLIENT SECRET:", 'el-helper' ); ?></label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="client_secret"
                       id="client_secret"
                       value="<?php echo CLIENT_SECRET ?>"/>
                <small id="" class="form-text text-muted">Description</small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label"
                   for="callback_url"><?php _e( "CALLBACK URL:", 'el-helper' ); ?></label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="callback_url"
                       id="callback_url"
                       value="<?php $receiveWebhookUrl = home_url() . \Elhelper\modules\stravaApiModule\models\StravaWebHookModel::getReceiveWebhookUrl();
				       echo $receiveWebhookUrl ?>"/>
                <small id="" class="form-text text-muted">Description</small>
            </div>
        </div>

        <div class="form-group row">
            <label for="verify_token" class="col-sm-4 col-form-label">
				<?php _e( "Verify Token", 'el-helper' ); ?>
            </label>
            <div class="col-sm-3">
                <input type="password" class="form-control-plaintext"
                       name="verify_token"
                       id="verify_token"
                       readonly="readonly"
                       value="inspire_verify_token<?php //echo $context->opt_accesstoken['value']; ?>"
                />
            </div>
            <div class="col-sm-3">
                <!--				--><?php //if ( empty( $context->opt_accesstoken['value'] ) && ! empty( $context->opt_appid['value'] ) ) {
				//					?>
                <a href="#"
                   class="btn btn-primary get-subsciption-token"><?php esc_attr_e( 'Subscription' ) ?></a>
				<?php
				//				} ?>
            </div>
        </div>


        <input type="submit"
               class="btn btn-primary" value="<?php esc_attr_e( 'Save' ) ?>">
        <hr/>
    </form>
    <form class="delete-form" method="post" action="">
        <input type="submit" name="delete" class="btn btn-danger"
               value="Delete Access Token"/>
    </form>
</div>
