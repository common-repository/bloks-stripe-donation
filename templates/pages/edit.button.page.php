<?php
/**
 * Edit button HTML
 *
 * @package     Bloks_Stripe
 * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $wpdb;

$button_id = isset( $_GET[ 'bid' ] ) ? sanitize_key($_GET[ 'bid' ]) : 0;
$buttonData = new stdClass();
$buttonData->button_id = $button_id;
$buttonData->button_amount = 500;
$buttonData->button_custom_amount = 0;
$buttonData->button_style = 'basic';
$buttonData->button_title = 'Donate';
$buttonData->button_desc = '';
$buttonData->button_animate = 'flash';
$buttonData->button_panel_label = 'Donate';
$buttonData->button_success_message = '';
$buttonData->button_store_desc = '';
$buttonData->enable_billing_address = 0;
$buttonData->enable_shipping = 0;
$buttonData->enable_zip_code = 0;
$buttonData->enable_remember = 0;
$buttonData->enable_bitcoin = 0;

$label_submit = 'Create';
if($action == 'edit' && $button_id != '0') {
    //get the data we need
    $button = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "blope_donation_buttons WHERE button_id=%d", $button_id));
    if($button) {
        $buttonData = $button;
        $label_submit = 'Save';
    }
}

?>
<div class="wrap blope-wrapper">
    <h1 class="heading-inline heading-edit">
        <span><?php _e('Donation Button', 'blope'); ?></span>
    </h1>
    <div class="blope-submit">
        <img src="<?php echo plugins_url('/assets/images/loader.gif', BLOPE_PLUGIN_BASENAME); ?>" alt="Loading..." id="blope-loading"/>
        <button id="blope-btn-submit" class="button button-primary" type="submit"><?php echo $label_submit; ?></button>
    </div>
    <div id="blope-message"></div>
    <p class="tips hide"></p>
    <form class="form-horizontal" action="" method="POST" id="blope-button-form">
        <div class="blope-content-wrap" id="blope-action-button">

            <?php if($action == 'create') : ?>
                <input type="hidden" name="action" value="blope_create_donation_button">
            <?php else : ?>
                <input type="hidden" name="action" value="blope_edit_donation_button">
            <?php endif; ?>
            <input type="hidden" name="button_id" value="<?php echo $buttonData->button_id; ?>">
            <div class="blope-button-wrapper">
                <div class="blope-button-wrap-inner">
                    <div class="blope-tab-attributes" id="blope-attributes">
                        <!-- Accordion -->
                        <div id="blope-accordion">
                            <h3 class="blope-accordion-title"><span><?php _e('General', 'blope'); ?></span></h3>
                            <div class="blope-accordion-content">
                                <div class="form-group type-text">
                                    <label class="control-label" for="blope_btn_title">
                                        <?php _e('Button label', 'blope'); ?>
                                        <span class="tooltip-star" title="<?php _e('Please enter label for the button here. This is the text appear on the button.', 'blope'); ?>">!</span>
                                    </label>
                                    <input type="text" class="regular-text" name="button_title" id="blope_btn_title" value="<?php echo $buttonData->button_title; ?>">
                                </div>
                                <div class="form-group type-text">
                                    <label class="control-label" for="blope_btn_desc">
                                        <?php _e("Button Sub Label: ", 'zstripe'); ?>
                                        <span class="tooltip-star" title="<?php _e('Please enter the sub text for the label here. Normally this text will be placed under the main label. If you don\'t see the text in preview, which mean the style you\'ve selected doesn\'t support Sub label.', 'blope'); ?>">!</span>
                                    </label>
                                    <input type="text" class="regular-text" name="button_desc" id="blope_btn_desc" value="<?php echo $buttonData->button_desc; ?>">
                                </div>
                                <div class="form-group type-text">
                                    <div class="blope-form-box">
                                        <label class="control-label" for="blope_btn_style">
                                            <?php _e('Button Style', 'blope'); ?>
                                            <span class="tooltip-star" title="<?php _e('Please select the look and feel for the button. Some styles will come with special effect while mouse hover.', 'blope'); ?>">!</span>
                                        </label>
                                        <select class="small-text" name="button_style" id="blope_btn_style">
                                            <?php echo Bloks_Stripe_Admin::getListOptionStyle($buttonData->button_style); ?>
                                        </select>
                                    </div>
                                    <div class="blope-form-box form-box">
                                        <label class="control-label" for="blope_btn_animate">
                                            <?php _e('Animation', 'blope'); ?>
                                            <span class="tooltip-star" title="<?php _e('These cool animations will play when you scroll to the button in frontend. Please note that animation will play once per page load.', 'blope'); ?>">!</span>
                                        </label>
                                        <select class="small-text" name="button_animate" id="blope_btn_animate">
                                            <?php blopeGetAnamations($buttonData->button_animate); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group type-text">
                                    <label class="control-label" for="specific_amount">
                                        <?php _e('Amount', 'blope'); ?>
                                        <span class="tooltip-star" title="<?php _e('This is the Amount users will donate you. 
Fixed amount will ask all users donate the same amount as you set here (e.g: $20). 
Flexible amount will allow users to donate you whatever amount they want by entering the number into the box.', 'blope'); ?>">!</span>
                                    </label>
                                    <span class="radio inline first">
                                        <input type="radio" name="button_custom_amount" id="specific_amount" value="0" <?php echo ($buttonData->button_custom_amount == '0') ? 'checked="checked"' : '' ?> >
                                        <?php _e('Fixed', 'blope'); ?>
                                        <input type="number" step="1" min="1" class="small-text" name="button_amount" id="blope_btn_amount" value="<?php echo (int)$buttonData->button_amount/100; ?>"/>
                                    </span>
                                    <span class="radio inline last">
                                        <input type="radio" name="button_custom_amount" id="custom_amount" value="1" <?php echo ($buttonData->button_custom_amount == '1') ? 'checked="checked"' : '' ?> >
                                        <?php _e('Flexible', 'blope'); ?>
                                    </span>
                                </div>
                                <div class="form-group type-textarea">
                                    <label class="control-label" for="button_success_message">
                                        <?php _e("Success Message", 'zstripe'); ?>
                                        <span class="tooltip-star" title="<?php _e('This is also known as Thank you message. 
The message will appear to user after they successfully made the donation. The message will display in popup similar to donation popup.', 'blope'); ?>">!</span>
                                    </label>
                                    <textarea rows="5" cols="30" name="button_success_message" id="button_success_message"><?php echo esc_attr($buttonData->button_success_message); ?></textarea>
                                </div>
                            </div>
                            <h3 class="blope-accordion-title"><span><?php _e('Advanced', 'blope'); ?></span></h3>
                            <div class="blope-accordion-content">
                                <div class="form-group type-text">
                                    <label class="control-label" for="button_panel_label">
                                        <?php _e('Payment button label', 'blope'); ?>
                                        <span class="tooltip-star" title="<?php _e('This is the Label of donation button appear in donation form. E.g: Donate $20', 'blope'); ?>">!</span>
                                    </label>
                                    <input type="text" class="regular-text" name="button_panel_label" id="button_panel_label" value="<?php echo $buttonData->button_panel_label; ?>">
                                </div>
                                <div class="form-group type-textarea">
                                    <label class="control-label" for="button_store_desc">
                                        <?php _e("Store Descriptions: ", 'zstripe'); ?>
                                        <span class="tooltip-star" title="<?php _e('This is the text of description for your site in donation form. This should be brief as the Stripe popup only show limited text.', 'blope'); ?>">!</span>
                                    </label>
                                    <textarea rows="5" cols="30" name="button_store_desc" id="button_store_desc"><?php echo stripslashes(esc_attr($buttonData->button_store_desc)); ?></textarea>
                                </div>
                                <div class="form-group type-text hide">
                                    <label class="control-label" for="show_remember_me">
                                        <?php _e('Enable Remember Me', 'blope'); ?>
                                        <span class="tooltip-star" title="<?php _e('Show remember me check box on payment form', 'blope'); ?>">!</span>
                                    </label>
                                    <span class="radio inline first">
                                        <input type="radio" name="enable_remember" id="show_remember_me" value="1" <?php echo ($buttonData->enable_remember == '1') ? 'checked="checked"' : '' ?>> Yes
                                    </span>
                                    <span class="radio inline last">
                                        <input type="radio" name="enable_remember" id="hide_remember_me" value="0" <?php echo ($buttonData->enable_remember == '0') ? 'checked="checked"' : '' ?>> No
                                    </span>

                                </div>
                                <div class="form-group type-text hide">
                                    <label class="control-label" for="show_zip_code">
                                        <?php _e('Enable Zip Code', 'blope'); ?>
                                        <span class="tooltip-star" data-toggle="popover" data-placement="right" title="" data-original-title="<?php _e('Show or hide Zip Code', 'blope'); ?>">!</span>
                                    </label>
                                    <span class="radio inline first">
                                        <input type="radio" name="enable_zip_code" id="show_zip_code" value="1" <?php echo ($buttonData->enable_zip_code == '1') ? 'checked="checked"' : '' ?>> Yes
                                    </span>
                                    <span class="radio inline last">
                                        <input type="radio" name="enable_zip_code" id="hide_zip_code" value="0" <?php echo ($buttonData->enable_zip_code == '0') ? 'checked="checked"' : '' ?>> No
                                    </span>

                                </div>
                                <div class="form-group type-text hide">
                                    <label class="control-label" for="show_shipping_address">
                                        <?php _e('Enable Shipping', 'blope'); ?>
                                        <span class="tooltip-star" data-toggle="popover" data-placement="right" title="" data-original-title="<?php _e('Show or hide Shipping address', 'blope'); ?>">!</span>
                                    </label>
                                    <span class="radio inline first">
                                        <input type="radio" name="enable_shipping" id="show_shipping_address" value="1" <?php echo ($buttonData->enable_shipping == '1') ? 'checked="checked"' : '' ?>> Yes
                                    </span>
                                    <span class="radio inline last">
                                        <input type="radio" name="enable_shipping" id="hide_shipping_address" value="0" <?php echo ($buttonData->enable_shipping == '0') ? 'checked="checked"' : '' ?>> No
                                    </span>
                                </div>
                                <div class="form-group type-text hide">
                                    <label class="control-label" for="show_enable_bitcoin">
                                        <?php _e('Enable Bitcoin', 'blope'); ?>
                                        <span class="tooltip-star" data-toggle="popover" data-placement="right" title="" data-original-title="<?php _e('Enable Bitcoin feature', 'blope'); ?>">!</span>
                                    </label>
                                    <span class="radio inline first">
                                        <input type="radio" name="enable_bitcoin" id="show_enable_bitcoin" value="1" <?php echo ($buttonData->enable_bitcoin == '1') ? 'checked="checked"' : '' ?>> Yes
                                    </span>
                                    <span class="radio inline last">
                                        <input type="radio" name="enable_bitcoin" id="hide_enable_bitcoin" value="0" <?php echo ($buttonData->enable_bitcoin == '0') ? 'checked="checked"' : '' ?>> No
                                    </span>
                                </div>
                                <div class="form-group type-text">
                                    <label class="control-label" for="show_billing_address">
                                        <?php _e('Enable Billing Address', 'blope'); ?>
                                        <span class="tooltip-star" title="<?php _e('Enable the Billing Address form. When set to Yes, your donation form will have 2 steps, one is for credit card info and the other for Billing Address.', 'blope'); ?>">!</span>
                                    </label>
                                    <span class="radio inline first">
                                        <input type="radio" name="enable_billing_address" id="show_billing_address" value="1" <?php echo ($buttonData->enable_billing_address == '1') ? 'checked="checked"' : '' ?> > Yes
                                    </span>
                                    <span class="radio inline last">
                                        <input type="radio" name="enable_billing_address" id="hide_billing_address" value="0" <?php echo ($buttonData->enable_billing_address == '0') ? 'checked="checked"' : '' ?> > No
                                    </span>
                                </div>
                                <div class="form-group type-text hide">
                                    <label class="control-label" for="success_redirect_url">
                                        <?php _e('Redirect On Success', 'blope'); ?>
                                        <span class="tooltip-star" data-toggle="popover" data-placement="right" title="" data-original-title="<?php _e('The URL that the user should be redirected to after a successful donate.', 'blope'); ?>">!</span>
                                    </label>
                                    <input type="text" class="regular-text" name="success_redirect_url" id="success_redirect_url" value="<?php echo $buttonData->success_redirect_url; ?>">
                                </div>
                                <div class="form-group type-text hide">
                                    <label>
                                        <?php _e('Redirect On Failure', 'blope'); ?>
                                        <span class="tooltip-star" data-toggle="popover" data-placement="right" title="" data-original-title="<?php _e('The URL that the user should be redirected to after a failure donate.', 'blope'); ?>">!</span>
                                    </label>
                                    <input type="text" class="regular-text" name="success_redirect_url" id="success_redirect_url" value="<?php echo $buttonData->failure_redirect_url; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blope-tab-preview" id="blope-preview">
                        <div class="blope-preview-button" id="blope-preview-button">
                            <div id="blope-preview-loading"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

