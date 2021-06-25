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
                   for="<?php echo $context->opt_appid['key']; ?>"><?php _e( "App ID:", 'el-helper' ); ?></label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="<?php echo $context->opt_appid['key']; ?>"
                       id="<?php echo $context->opt_appid['key']; ?>"
                       value="<?php echo $context->opt_appid['value']; ?>"/>
                <small id="" class="form-text text-muted">Description</small>
            </div>
        </div>


        <div class="form-group row">
            <label class="col-sm-4 col-form-label"
                   for="<?php echo $context->opt_callback['key'] ?>"><?php _e( "Callback Url:", 'el-helper' ); ?></label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="<?php echo $context->opt_callback['key'] ?>"
                       id="<?php echo $context->opt_callback['key'] ?>"
                       value="<?php echo $context->opt_callback['value']; ?>"/>
                <small id="" class="form-text text-muted">Description</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="<?php echo $context->opt_accesstoken['key']; ?>" class="col-sm-4 col-form-label">
				<?php _e( "Access Token", 'el-helper' ); ?>
            </label>
            <div class="col-sm-3">
                <input type="password" class="form-control-plaintext"
                       name="<?php echo $context->opt_accesstoken['key']; ?>"
                       id="<?php echo $context->opt_accesstoken['key']; ?>"
                       readonly="readonly"
                       value="<?php echo $context->opt_accesstoken['value']; ?>"
                />
            </div>
            <div class="col-sm-3">
				<?php if ( empty( $context->opt_accesstoken['value'] ) && ! empty( $context->opt_appid['value'] ) ) {
					?>
                    <a href="#"
                       class="btn btn-primary get-access-token"><?php esc_attr_e( 'Get Access Token' ) ?></a>
					<?php
				} ?>
            </div>
        </div>


        <div class="form-group row">
            <label class="col-sm-4 col-form-label"
                   for="<?php echo $context->opt_webhook['key']; ?>"><?php _e( "Webhook URL:", 'el-helper' ); ?></label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="<?php echo $context->opt_webhook['key']; ?>"
                       id="<?php echo $context->opt_webhook['key']; ?>"
                       value="<?php echo $context->opt_webhook['value']; ?>"/>
                <small id="" class="form-text text-muted">Description</small>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label"
                   for="<?php echo $context->opt_oath_webhook['key']; ?>"><?php _e( "OA Webhook Secret Key:", 'el-helper' ); ?></label>
            <div class="col-sm-8">
                <input class="form-control" type="password" name="<?php echo $context->opt_oath_webhook['key']; ?>"
                       id="<?php echo $context->opt_oath_webhook['key']; ?>"
                       value="<?php echo $context->opt_oath_webhook['value']; ?>"/>
                <small id="" class="form-text text-muted">Description</small>
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
