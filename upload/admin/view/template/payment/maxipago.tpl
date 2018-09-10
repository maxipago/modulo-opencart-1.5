<?php echo $header; ?>

<div id="content" class="oc-1.5">

    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>

    <?php if (isset($error)) { ?>
        <div class="warning"><?php echo $error; ?></div>
    <?php } ?>

    <?php if ($error_warning) { ?>
        <div class="warning">
            <?php echo $error_warning; ?>
        </div>
    <?php } ?>

    <?php if (isset($success)) { ?>
        <?php if ( is_array($success)) { ?>
            <?php foreach($success as $success_message) { ?>
                <div class="success"><?php echo $success_message; ?></div>
            <?php } ?>
        <?php } else { ?>
            <div class="success"><?php echo $success; ?></div>
        <?php } ?>
    <?php } ?>

    <div class="box">
        <div class="heading">
            <h1><?php echo $heading_title; ?></h1>

            <div class="buttons">
                <a href="<?php echo $sync_url;?>" class="button">
                    <span>
                        <?php echo $text_sync;?>
                    </span>
                </a>

                <a onclick="$('#form-maxipago').submit();" class="button">
                    <span>
                        <?php echo $button_save; ?>
                    </span>
                </a>

                <a onclick="window.location='<?php echo $cancel; ?>';" class="button">
                    <span>
                        <?php echo $button_cancel; ?>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <p class="warning">
            <?php echo $text_cron; ?><br>
            30 1 * * * wget -O /dev/null <?php echo $catalog_sync_url;?>
        </p>

        <div class="attention">
            <h3><?php echo $text_notification;?></h3>
            <p><?php echo $text_notification_configure;?></p>
            <hr />
            <p><strong><?php echo $text_url_success;?>: </strong><?php echo $catalog_success_url;?></p>
            <p><strong><?php echo $text_url_error;?>: </strong><?php echo $catalog_error_url;?></p>
            <p><strong><?php echo $text_url_notification;?>: </strong><?php echo $catalog_notification_url;?></p>
        </div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-maxipago">

            <div class="vtabs">
                <a href="#tab-general" class="selected" data-toggle="tab"><?php echo $tab_general; ?></a>
                <a href="#tab-order-cc" data-toggle="tab"><?php echo $tab_order_cc; ?></a>
                <a href="#tab-order-dc" data-toggle="tab"><?php echo $tab_order_dc; ?></a>
                <a href="#tab-order-redepay" data-toggle="tab"><?php echo $tab_order_redepay; ?></a>
                <a href="#tab-order-ticket" data-toggle="tab"><?php echo $tab_order_ticket; ?></a>
                <a href="#tab-order-eft" data-toggle="tab"><?php echo $tab_order_eft; ?></a>
                <a href="#tab-order-status" data-toggle="tab"><?php echo $tab_order_status; ?></a>
            </div>

            <!-- TAB GENERAL SETTINGS -->
            <div id="tab-general" class="vtabs-content">
                <table class="form">
                    <tbody>
                        <!-- STATUS -->
                        <tr class="form-group required">
                            <td>
                                *
                                <label class="col-sm-2 control-label" for="input-status">
                                    <?php echo $entry_status; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <select name="maxipago_status" id="input-status" class="form-control">
                                        <?php if ($maxipago_status) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </td>
                        </tr>

                        <!-- STORE ID -->
                        <tr class="form-group required">

                            <td>
                                <label class="col-sm-2 control-label" for="input-store-id">
                                     *   <?php echo $entry_store_id; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_store_id"
                                       value="<?php echo $maxipago_store_id; ?>"
                                       placeholder="<?php echo $entry_store_id; ?>" id="input-store-id" class="form-control"/>
                                <?php if ($error_store_id) { ?>
                                <div class="text-danger"><?php echo $error_store_id; ?></div>
                                <?php } ?>
                            </div>
                            </td>
                        </tr>

                        <!-- CONSUMER KEY -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-consumer-key">
                                    * <?php echo $entry_consumer_key; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_consumer_key"
                                       value="<?php echo $maxipago_consumer_key; ?>"
                                       placeholder="<?php echo $entry_consumer_key; ?>" id="input-consumer-key" class="form-control"/>
                                <?php if ($error_consumer_key) { ?>
                                <div class="text-danger"><?php echo $error_consumer_key; ?></div>
                                <?php } ?>
                            </div>
                            </td>
                        </tr>

                        <!-- SECRET KEY -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-secret-key">
                                    *    <?php echo $entry_secret_key; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_secret_key"
                                       value="<?php echo $maxipago_secret_key; ?>"
                                       placeholder="<?php echo $entry_secret_key; ?>" id="input-secret-key" class="form-control"/>
                                <?php if ($error_secret_key) { ?>
                                <div class="text-danger">
                                    <?php echo $error_secret_key; ?>
                                </div>
                                <?php } ?>
                            </div>
                            </td>
                        </tr>

                        <!-- METHOD TITLE -->
                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label" for="input-method-title">
                                    <?php echo $entry_method_title; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_method_title"
                                       value="<?php echo $maxipago_method_title ?: 'maxiPago!'; ?>"
                                       placeholder="<?php echo $entry_method_title; ?>"
                                       id="input-method-title" class="form-control"/>
                            </div>
                            </td>
                        </tr>

                        <!-- TEST OR PRODUCTION -->
                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label">
                                    <?php echo $entry_environment; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_environment" id="input-maxipago-environment" class="form-control">
                                    <option value="test" <?php echo ($maxipago_environment == 'test') ? 'selected="selected"' : null;?>><?php echo $entry_test; ?></option>
                                    <option value="production" <?php echo ($maxipago_environment == 'production') ? 'selected="selected"' : null;?>><?php echo $entry_production; ?></option>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <!-- Custom Field (Number) -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label">
                                    *    <?php echo $entry_street_number ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <select name="maxipago_street_number" class="form-control">
                                        <?php foreach($custom_fields as $custom_field) { ?>
                                        <?php if ($custom_field['location'] == 'address') { ?>
                                        <?php if ($maxipago_street_number == $custom_field['custom_field_id']) { ?>
                                        <option value="<?php echo $custom_field['custom_field_id'] ?>" selected><?php echo $custom_field['name'] ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $custom_field['custom_field_id'] ?>"><?php echo $custom_field['name'] ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>

                                    <a href="<?php echo $link_custom_field ?>" class="btn btn-primary"><?php echo $text_custom_field ?></a>
                                    <?php if ($error_street_number) { ?>
                                    <div class="text-danger"><?php echo $error_street_number; ?></div>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>


                        <!-- Custom Field (Complement) -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label">
                                    * <?php echo $entry_street_complement ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <select name="maxipago_street_complement" class="form-control">
                                        <?php foreach($custom_fields as $custom_field) { ?>
                                        <?php if ($custom_field['location'] == 'address') { ?>
                                        <?php if ($maxipago_street_complement == $custom_field['custom_field_id']) { ?>
                                        <option value="<?php echo $custom_field['custom_field_id'] ?>" selected><?php echo $custom_field['name'] ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $custom_field['custom_field_id'] ?>"><?php echo $custom_field['name'] ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>

                                    <a href="<?php echo $link_custom_field ?>" class="btn btn-primary"><?php echo $text_custom_field ?></a>
                                    <?php if ($error_street_complement) { ?>
                                        <div class="text-danger"><?php echo $error_street_complement; ?></div>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>

                        <!-- MINIMUM AMOUNT -->
                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label" for="input-minimum-amount">
                                    <?php echo $entry_minimum_amount; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_minimum_amount"
                                       value="<?php echo $maxipago_minimum_amount; ?>"
                                       placeholder="<?php echo $entry_minimum_amount; ?>" id="input-minimum-amount" class="form-control"/>
                            </div>
                            </td>
                        </tr>

                        <!-- MAXIMUM AMOUNT -->
                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label" for="input-maximum-amount">
                                    <?php echo $entry_maximum_amount; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_maximum_amount"
                                       value="<?php echo $maxipago_maximum_amount; ?>"
                                       placeholder="<?php echo $entry_maximum_amount; ?>" id="input-maximum-amount" class="form-control"/>
                            </div>
                            </td>
                        </tr>

                        <!-- GEO ZONE -->
                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label" for="input-geo-zone">
                                    <?php echo $entry_geo_zone; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_geo_zone_id" id="input-geo-zone" class="form-control">
                                    <option value="0"><?php echo $text_all_zones; ?></option>
                                    <?php foreach ($geo_zones as $geo_zone) { ?>
                                    <?php if ($geo_zone['geo_zone_id'] == $maxipago_geo_zone_id) { ?>
                                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <!-- ORDER -->
                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label" for="input-sort-order">
                                    <?php echo $entry_sort_order; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_sort_order"
                                       value="<?php echo $maxipago_sort_order; ?>"
                                       placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order"
                                       class="form-control"/>
                            </div>
                            </td>
                        </tr>

                        <!-- LOG -->
                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label" for="input-logging">
                                    <?php echo $entry_logging; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_logging" id="input-logging" class="form-control">
                                    <?php if ($maxipago_logging) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="tab-order-cc" class="vtabs-content">
                <table class="form">
                    <tbody>
                        <!-- TAB CC -->
                        <!-- ENABLE CC -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-cc-enabled">
                                    * <?php echo $entry_cc_enabled; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_cc_enabled" id="input-cc-enabled" class="form-control">
                                    <option value="1" <?php echo ($maxipago_cc_enabled) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_enabled; ?>
                                    </option>
                                    <option value="0" <?php echo (!$maxipago_cc_enabled) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_disabled; ?>
                                    </option>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <!-- CHARGE BACK WHEN CANCEL -->
                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label" for="input-order-cc-reverse">
                                    <?php echo $entry_cc_order_reverse; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_cc_order_reverse" id="input-order-cc-reverse" class="form-control">
                                    <?php if ($maxipago_cc_order_reverse) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <!-- MAX INSTALLMENTS -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-cc-max-installments">
                                    * <?php echo $entry_cc_max_installments; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_cc_max_installments"
                                       value="<?php echo $maxipago_cc_max_installments; ?>"
                                       id="input-cc-max-installments"
                                       class="form-control"/>
                            </div>
                            </td>
                        </tr>

                        <!-- INSTALLMENTS WITHOUT INTEREST -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-cc-installments-without-interest">
                                    * <?php echo $entry_cc_installments_without_interest; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_cc_installments_without_interest"
                                       value="<?php echo $maxipago_cc_installments_without_interest; ?>"
                                       id="input-cc-installments-without-interest"
                                       class="form-control"/>
                            </div>
                            </td>
                        </tr>

                        <!-- INTEREST TYPE -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-cc-interest-type">
                                    * <?php echo $entry_cc_interest_type; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_cc_interest_type" id="input-cc-interest-type" class="form-control">
                                    <option
                                            value="simple"
                                    <?php echo ($maxipago_cc_interest_type == 'simple') ? 'selected="selected"' : null;?>>
                                    <?php echo $entry_simple; ?>
                                    </option>
                                    <option
                                            value="compound"
                                    <?php echo ($maxipago_cc_interest_type == 'compound') ? 'selected="selected"' : null;?>>
                                    <?php echo $entry_compound; ?>
                                    </option>
                                    <option
                                            value="price"
                                    <?php echo ($maxipago_cc_interest_type == 'price') ? 'selected="selected"' : null;?>>
                                    <?php echo $entry_price; ?>
                                    </option>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <!-- INTEREST RATE -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-cc-interest-rate">
                                    * <?php echo $entry_cc_interest_rate; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_cc_interest_rate"
                                       value="<?php echo $maxipago_cc_interest_rate; ?>"
                                       placeholder="<?php echo $entry_cc_interest_rate; ?>"
                                       id="input-cc-interest-rate"
                                       class="form-control"/>
                            </div>
                            </td>
                        </tr>

                        <!-- MINIMUN RATE -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-cc-min-per-installments">
                                    * <?php echo $entry_cc_min_per_installments; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_cc_min_per_installments"
                                       value="<?php echo $maxipago_cc_min_per_installments; ?>"
                                       placeholder="<?php echo $entry_cc_min_per_installments; ?>"
                                       id="input-cc-min-per-installments"
                                       class="form-control"/>
                            </div>
                            </td>
                        </tr>

                        <!-- PROCESSING TYPE -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="select-cc-processing-type">
                                    * <?php echo $entry_cc_processing_type; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_cc_processing_type" id="select-cc-processing-type" class="form-control">
                                    <option value="auth"
                                    <?php echo ($maxipago_cc_processing_type == 'auth') ? 'selected="selected"' : null;?>>
                                    <?php echo $entry_cc_auth; ?>
                                    </option>
                                    <option value="sale"
                                    <?php echo ($maxipago_cc_processing_type == 'sale') ? 'selected="selected"' : null;?>>
                                    <?php echo $entry_cc_sale; ?>
                                    </option>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <!-- FRAUD CHECK -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="select-cc-fraud-check">
                                    * <?php echo $entry_cc_fraud_check; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_cc_fraud_check" id="select-cc-fraud-check" class="form-control">
                                    <option value="1" <?php echo ($maxipago_cc_fraud_check) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_enabled; ?>
                                    </option>
                                    <option value="0" <?php echo (!$maxipago_cc_fraud_check) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_disabled; ?>
                                    </option>
                                </select>
                            </div>
                            </td>
                        </tr>

                    <!-- FRAUD PROCESSOR //NEW -->
                    <tr class="form-group required">
                        <td>
                            <label class="col-sm-2 control-label" for="select-cc-fraud-processor">
                                * <?php echo $entry_cc_fraud_processor; ?>
                            </label>
                        </td>
                        <td>
                            <div class="col-sm-10">
                                <select name="maxipago_cc_fraud_processor" id="select-cc-fraud-processor" class="form-control">
                                    <option value="99" <?php echo ($maxipago_cc_fraud_processor == '99') ? 'selected="selected"' : null;?>>
                                    <?php echo $text_kount; ?>
                                    </option>
                                    <option value="98" <?php echo ($maxipago_cc_fraud_processor == '98') ? 'selected="selected"' : null;?>>
                                    <?php echo $text_clearsale; ?>
                                    </option>
                                </select>
                            </div>
                        </td>
                    </tr>

                    <tr class="form-group">
                        <td>
                            <label class="col-sm-2 control-label">
                                <?php echo $entry_cc_clearsale_app; ?>
                            </label>
                        </td>
                        <td>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                   name="maxipago_cc_clearsale_app"
                                   value="<?php echo $maxipago_cc_clearsale_app; ?>"
                                   placeholder="<?php echo $entry_cc_clearsale_app; ?>" />
                            </div>
                        </td>
                    </tr>

                    <tr class="form-group required">
                        <td>
                            <label class="col-sm-2 control-label" for="select-cc-auto-capture">
                                * <?php echo $entry_cc_auto_capture; ?>
                            </label>
                        </td>
                        <td>
                            <div class="col-sm-10">
                                <select name="maxipago_cc_auto_capture" id="select-cc-auto-capture" class="form-control">
                                    <option value="Y" <?php echo ($maxipago_cc_auto_capture == 'Y') ? 'selected="selected"' : null;?>>
                                    <?php echo $text_yes; ?>
                                    </option>
                                    <option value="N" <?php echo ($maxipago_cc_auto_capture == 'N') ? 'selected="selected"' : null;?>>
                                    <?php echo $text_no; ?>
                                    </option>
                                </select>
                            </div>
                        </td>
                    </tr>

                    <tr class="form-group required">
                        <td>
                            <label class="col-sm-2 control-label" for="select-cc-auto-void">
                                * <?php echo $entry_cc_auto_void; ?>
                            </label>
                        </td>
                        <td>
                            <div class="col-sm-10">
                                <select name="maxipago_cc_auto_void" id="select-cc-auto-void" class="form-control">
                                    <option value="Y" <?php echo ($maxipago_cc_auto_void == 'Y') ? 'selected="selected"' : null;?>>
                                    <?php echo $text_yes; ?>
                                    </option>
                                    <option value="N" <?php echo ($maxipago_cc_auto_void == 'N') ? 'selected="selected"' : null;?>>
                                    <?php echo $text_no; ?>
                                    </option>
                                </select>
                            </div>
                        </td>
                    </tr>

                    <!-- ENABLE 3DS //NEW -->
                    <!--<tr class="form-group required">
                        <td>
                            <label class="col-sm-2 control-label" for="select-cc-3ds">
                                * <?php echo $entry_cc_3ds; ?>
                            </label>
                        </td>
                        <td>
                            <div class="col-sm-10">
                                <select name="maxipago_cc_3ds" id="select-cc-3ds" class="form-control">
                                    <option value="0" <?php echo ($maxipago_cc_3ds) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_no; ?>
                                    </option>
                                    <option value="1" <?php echo (!$maxipago_cc_3ds) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_yes; ?>
                                    </option>
                                </select>
                            </div>
                        </td>
                    </tr>-->

                    <!-- 3DS PROCESSOR //NEW -->
                    <!--<tr class="form-group required">
                        <td>
                            <label class="col-sm-2 control-label" for="select-cc-3ds-processor">
                                * <?php echo $entry_cc_3ds_processor; ?>
                            </label>
                        </td>
                        <td>
                            <div class="col-sm-10">
                                <select name="maxipago_cc_3ds_processor" id="select-cc-3ds-processor" class="form-control">
                                    <option value="decline" <?php echo ($maxipago_cc_3ds_processor) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_test; ?>
                                    </option>
                                    <option value="continue" <?php echo (!$maxipago_cc_3ds_processor) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_production; ?>
                                    </option>
                                </select>
                            </div>
                        </td>
                    </tr>-->

                    <!-- 3DS FAILURE ACTION //NEW -->
                    <!--<tr class="form-group required">
                        <td>
                            <label class="col-sm-2 control-label" for="select-cc-3ds-failure-action">
                                * <?php echo $entry_cc_3ds_failure_action; ?>
                            </label>
                        </td>
                        <td>
                            <div class="col-sm-10">
                                <select name="maxipago_cc_3ds_failure-action" id="select-cc-3ds-failure-action" class="form-control">
                                    <option value="0" <?php echo ($maxipago_cc_3ds_failure_action) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_decline; ?>
                                    </option>
                                    <option value="1" <?php echo (!$maxipago_cc_3ds_failure_action) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_continue; ?>
                                    </option>
                                </select>
                            </div>
                        </td>
                    </tr>-->

                        <!-- CC CAN SAVE -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="select-cc-can-save">
                                    * <?php echo $entry_cc_can_save; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_cc_can_save" id="select-cc-can-save" class="form-control">
                                    <option value="0"
                                    <?php echo ($maxipago_cc_can_save == '0') ? 'selected="selected"' : null;?>>
                                    <?php echo $text_no; ?>
                                    </option>
                                    <option value="1"
                                    <?php echo ($maxipago_cc_can_save == '1') ? 'selected="selected"' : null;?>>
                                    <?php echo $text_yes; ?>
                                    </option>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <!-- PROCESSORS -->
                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label">
                                    <?php echo $entry_cc_processors; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_visa_processor">
                                        Visa
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="maxipago_visa_processor" id="maxipago_visa_processor">
                                            <?php foreach ($entry_cc_processors_visa as $k => $v): ?>
                                            <?php $selected = ($maxipago_visa_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_mastercard_processor">
                                        MasterCard
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="maxipago_mastercard_processor" id="maxipago_mastercard_processor">
                                            <?php foreach ($entry_cc_processors_master as $k => $v): ?>
                                            <?php $selected = ($maxipago_mastercard_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_amex_processor">
                                        Amex (American Express)
                                    </label>

                                    <div class="col-sm-7">
                                        <select name="maxipago_amex_processor" id="maxipago_amex_processor">
                                            <?php foreach ($entry_cc_processors_amex as $k => $v): ?>
                                            <?php $selected = ($maxipago_amex_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_diners_processor">
                                        Diners Club
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="maxipago_diners_processor" id="maxipago_diners_processor">
                                            <?php foreach ($entry_cc_processors_diners as $k => $v): ?>
                                            <?php $selected = ($maxipago_diners_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_elo_processor">
                                        Elo
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="maxipago_elo_processor" id="maxipago_elo_processor">
                                            <?php foreach ($entry_cc_processors_elo as $k => $v): ?>
                                            <?php $selected = ($maxipago_elo_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_discover_processor">
                                        Discover
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="maxipago_discover_processor" id="maxipago_discover_processor">
                                            <?php foreach ($entry_cc_processors_discover as $k => $v): ?>
                                            <?php $selected = ($maxipago_discover_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_hipercard_processor">
                                        Hipercard
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="maxipago_hipercard_processor" id="maxipago_hipercard_processor">
                                            <?php foreach ($entry_cc_processors_hipercard as $k => $v): ?>
                                            <?php $selected = ($maxipago_hipercard_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_hiper_processor">
                                        Hiper
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="maxipago_hiper_processor" id="maxipago_hiper_processor">
                                            <?php foreach ($entry_cc_processors_hiper as $k => $v): ?>
                                            <?php $selected = ($maxipago_hiper_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_jcb_processor">
                                        JCB
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="maxipago_jcb_processor" id="maxipago_jcb_processor">
                                            <?php foreach ($entry_cc_processors_jcb as $k => $v): ?>
                                            <?php $selected = ($maxipago_jcb_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_aura_processor">
                                        Aura
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="maxipago_aura_processor" id="maxipago_aura_processor">
                                            <?php foreach ($entry_cc_processors_aura as $k => $v): ?>
                                            <?php $selected = ($maxipago_aura_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="maxipago_credz_processor">
                                        Credz
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="maxipago_credz_processor" id="maxipago_credz_processor">
                                            <?php foreach ($entry_cc_processors_credz as $k => $v): ?>
                                            <?php $selected = ($maxipago_credz_processor == $k) ? 'selected' : null;?>
                                            <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                            <?php echo $v;?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="tab-order-dc" class="vtabs-content">
                <table class="form">
                    <tbody>
                        <!-- TAB DEBIT CARD -->
                        <!-- ENABLE DEBIT CARD -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="maxipago_dc_enabled">
                                    * <?php echo $entry_dc_enabled; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <select name="maxipago_dc_enabled" id="maxipago_dc_enabled" class="form-control">
                                        <option value="0" <?php echo (!$maxipago_dc_enabled) ? 'selected="selected"' : null;?>>
                                            <?php echo $text_disabled; ?>
                                        </option>
                                        <option value="1" <?php echo ($maxipago_dc_enabled) ? 'selected="selected"' : null;?>>
                                            <?php echo $text_enabled; ?>
                                        </option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <!-- SOFT DESCRIPTOR -->
                        <tr>
                            <td>
                                <label class="col-sm-2 control-label" for="maxipago_dc_soft_descriptor">
                                    <?php echo $entry_dc_soft_descriptor; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <input class="form-control" value="<?php echo $maxipago_dc_soft_descriptor; ?>"
                                        name="maxipago_dc_soft_descriptor" id="maxipago_dc_soft_descriptor"  />
                                </div>
                            </td>
                        </tr>
                        <!-- MPI PROCESSOR -->
                        <tr>
                            <td>
                                <label class="col-sm-2 control-label" for="maxipago_dc_mpi_processor">
                                    <?php echo $entry_dc_mpi_processor; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <select name="maxipago_dc_mpi_processor" id="maxipago_dc_mpi_processor" class="form-control">
                                        <option value="41" <?php echo ($maxipago_dc_mpi_processor == "41" ? "selected" : ""); ?>>
                                            <?php echo $entry_dc_mpi_processor_test; ?>
                                        </option>
                                        <option value="40" <?php echo ($maxipago_dc_mpi_processor == "40" ? "selected" : ""); ?>>
                                            <?php echo $entry_dc_mpi_processor_deployment; ?>
                                        </option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <!-- FILURE ACTION -->
                        <tr>
                            <td>
                                <label class="col-sm-2 control-label" for="maxipago_dc_failure_action">
                                    <?php echo $entry_dc_failure_action; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <select name="maxipago_dc_failure_action" id="maxipago_dc_failure_action" class="form-control">
                                        <option value="decline" <?php echo ($maxipago_dc_failure_action == "decline" ? "selected" : ""); ?>>
                                            <?php echo $entry_dc_failure_action_decline; ?>
                                        </option>
                                        <option value="continue" <?php echo ($maxipago_dc_failure_action == "continue" ? "selected" : ""); ?>>
                                            <?php echo $entry_dc_failure_action_continue; ?>
                                        </option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <!-- PROCESSORS -->
                        <tr>
                            <td>
                                <label class="col-sm-2 control-label">
                                    <?php echo $entry_dc_processors; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="maxipago_dc_visa_processor">
                                            Visa
                                        </label>
                                        <div class="col-sm-7">
                                            <select name="maxipago_dc_visa_processor" id="maxipago_dc_visa_processor">
                                                <?php foreach ($entry_dc_processors_visa as $k => $v): ?>
                                                <?php $selected = ($maxipago_dc_visa_processor == $k) ? 'selected' : null;?>
                                                <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                                <?php echo $v;?>
                                                </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="maxipago_dc_mastercard_processor">
                                            Mastercard
                                        </label>
                                        <div class="col-sm-7">
                                            <select name="maxipago_dc_mastercard_processor" id="maxipago_dc_mastercard_processor">
                                                <?php foreach ($entry_dc_processors_mastercard as $k => $v): ?>
                                                <?php $selected = ($maxipago_dc_mastercard_processor == $k) ? 'selected' : null;?>
                                                <option value="<?php echo $k; ?>" <?php echo $selected?>>
                                                <?php echo $v;?>
                                                </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div id="tab-order-redepay" class="vtabs-content">
                <table class="form">
                    <tbody>
                        <!-- TAB REDEPAY -->
                        <!-- ENABLE REDEPAY -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input_redepay_enabled">
                                    * <?php echo $entry_redepay_enabled; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_redepay_enabled" id="input_redepay_enabled" class="form-control">
                                    <option value="0" <?php echo (!$maxipago_redepay_enabled) ? 'selected="selected"' : null;?>>
                                        <?php echo $text_disabled; ?>
                                    </option>
                                    <option value="1" <?php echo ($maxipago_redepay_enabled) ? 'selected="selected"' : null;?>>
                                        <?php echo $text_enabled; ?>
                                    </option>
                                </select>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="tab-order-ticket" class="vtabs-content">
                <table class="form">
                    <tbody>
                        <!-- TAB TICKET -->
                        <!-- ENABLE TICKET -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-ticket-enabled">
                                    * <?php echo $entry_ticket_enabled; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_ticket_enabled" id="input-ticket-enabled" class="form-control">
                                    <option value="0" <?php echo (!$maxipago_ticket_enabled) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_disabled; ?>
                                    </option>
                                    <option value="1" <?php echo ($maxipago_ticket_enabled) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_enabled; ?>
                                    </option>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <!-- DAYS TO EXPIRE -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-ticket-days-to-expire">
                                    * <?php echo $entry_ticket_days_to_expire; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <input type="text" name="maxipago_ticket_days_to_expire"
                                       value="<?php echo $maxipago_ticket_days_to_expire; ?>"
                                       placeholder="<?php echo $entry_ticket_days_to_expire; ?>"
                                       id="input-ticket-days-to-expire"
                                       class="form-control"/>
                            </div>
                            </td>
                        </tr>

                        <!-- INSTRUCTIONS -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-ticket-instructions">
                                    * <?php echo $entry_ticket_instructions; ?>
                                </label>

                            </td>
                            <td>
                                <div class="col-sm-10">
                                <textarea name="maxipago_ticket_instructions" id="input-ticket-instructions"class="form-control"><?php echo $maxipago_ticket_instructions; ?></textarea>
                            </div>
                            </td>
                        </tr>

                        <!-- BANK -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-ticket-bank">
                                    * <?php echo $entry_ticket_bank; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_ticket_bank" id="input-ticket-bank" class="form-control">
                                    <option value="">
                                        <?php echo $text_select; ?>
                                    </option>
                                    <?php foreach ($entry_ticket_banks as $v => $bank): ?>
                                    <?php $selected  = ($maxipago_ticket_bank == $v) ? 'selected' : null;?>
                                    <option value="<?php echo $v;?>" <?php echo $selected;?>>
                                    <?php echo $bank; ?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="tab-order-eft" class="vtabs-content">
                <table class="form">
                    <tbody>
                        <!-- TAB EFT -->
                        <!-- ENABLE EFT -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-eft-enabled">
                                    * <?php echo $entry_eft_enabled; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_eft_enabled" id="input-eft-enabled" class="form-control">
                                    <option value="0" <?php echo (!$maxipago_eft_enabled) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_disabled; ?>
                                    </option>
                                    <option value="1" <?php echo ($maxipago_eft_enabled) ? 'selected="selected"' : null;?>>
                                    <?php echo $text_enabled; ?>
                                    </option>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <!-- BANKS -->
                        <tr class="form-group required">
                            <td>
                                <label class="col-sm-2 control-label" for="input-eft-banks">
                                    * <?php echo $entry_eft_banks; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <?php foreach ($entry_eft_banks_list as $v => $bank): ?>
                                <label>
                                    <?php $checked = in_array($v, $maxipago_eft_banks) ? 'checked' : null;?>
                                    <input type="checkbox" name="maxipago_eft_banks[]" id="input-eft-banks" value="<?php echo $v;?>" class="form-control" <?php echo $checked;?> />
                                    <?php echo $bank;?>
                                </label>
                                <?php endforeach;?>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="tab-order-status" class="vtabs-content">
                <table class="form">
                    <tbody>
                        <!-- TAB STATUSES -->
                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label">
                                    <?php echo $entry_order_processing; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_order_processing" id="input-order-status-processing" class="form-control">
                                    <?php foreach ($order_statuses as $order_status): ?>
                                    <?php if ($order_status['order_status_id'] == $maxipago_order_processing) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label">
                                    <?php echo $entry_order_authorized; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_order_authorized" id="input-order-status-authorized" class="form-control">
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <?php if ($order_status['order_status_id'] == $maxipago_order_authorized) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label">
                                    <?php echo $entry_order_refunded; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_order_refunded" id="input-order-status-refunded" class="form-control">
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <?php if ($order_status['order_status_id'] == $maxipago_order_refunded) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            </td>
                        </tr>

                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label">
                                    <?php echo $entry_order_approved; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                <select name="maxipago_order_approved" id="input-order-status-approved" class="form-control">
                                    <?php foreach ($order_statuses as $order_status) { ?>
                                    <?php if ($order_status['order_status_id'] == $maxipago_order_approved) { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                                </div>
                            </td>
                        </tr>

                        <tr class="form-group">
                            <td>
                                <label class="col-sm-2 control-label">
                                    <?php echo $entry_order_cancelled; ?>
                                </label>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <select name="maxipago_order_cancelled" id="input-order-status-cancelled" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $maxipago_order_cancelled) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected">
                                            <?php echo $order_status['name']; ?>
                                        </option>
                                        <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>">
                                            <?php echo $order_status['name']; ?>
                                        </option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<?php echo $footer; ?>
<script>
    if ($('select#select-cc-processing-type').val() != 'auth') {
        $('select#select-cc-fraud-check').val(0);;
        $('select#select-cc-fraud-check').prop('disabled', true);
    }

    $('select#select-cc-processing-type').on('change', function(){
       if ($(this).val() == 'auth') {
           $('select#select-cc-fraud-check').prop('disabled', false);
       } else {
           $('select#select-cc-fraud-check').val(0);;
           $('select#select-cc-fraud-check').prop('disabled', true);
       }
    });
</script>
<script type="text/javascript">
    $('.vtabs a').tabs();
</script>