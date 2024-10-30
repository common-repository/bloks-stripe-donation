<?php
/**
 * Settings HTML
 *
 * @package     Bloks_Stripe
  * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$default = array(
    'mode' => 'test',
    'currency' => 'usd',
    'image_url' => BLOPE_URL . 'assets/images/marketplace.png',
    'site_name' => get_bloginfo(),
    'site_desc' => '',
    'locale' => '',
    'secret_key_test' => '',
    'secret_key_test' => '',
    'publish_key_test' => '',
    'secret_key_live' => '',
    'publish_key_live' => '',
    'blope_version' => BLOPE_VERSION
);

$options = get_option('blope_options');
$options = wp_parse_args($options, $default);

$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';

?>
<div class="wrap blope-wrapper">
    <h1><span><?php _e('Bloks Stripe Settings', 'blope'); ?></span></h1>
    <div class="blope-submit blope-settings-submit">
        <img src="<?php echo plugins_url( '/assets/images/loader.gif', BLOPE_PLUGIN_BASENAME ); ?>" alt="<?php _e( 'Loading...', 'blope' ); ?>" id="blope-loading"/>
        <button id="blope-settings-submit" type="submit" class="button button-primary"><?php esc_attr_e('Save Changes', 'blope') ?></button>
    </div>
    <h2 class="nav-tab-wrapper">
        <a href="?page=blope-settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a>
        <a href="?page=blope-settings&tab=stripe" class="nav-tab <?php echo $active_tab == 'stripe' ? 'nav-tab-active' : ''; ?>">Stripe</a>
    </h2>
    <form class="form-horizontal" action="" method="post" id="settings-form">
        <div class="blope-content-wrap">
            <div id="blope-message"><p><strong></strong></p></div>
            <?php if($options['secret_key_live'] == '' || $options['publish_key_live'] == '') : ?>
            <p class="alert alert-info">The Stripe API keys are required for donations to work. You can find your keys on your
                <a href="https://dashboard.stripe.com/account/apikeys">Stripe API Dashboard</a></p>
            <?php endif; ?>
            <p class="tips"></p>
            <input type="hidden" name="action" value="blope_update_settings"/>
            <table id="general_setting" class="form-table <?php echo $active_tab != 'general' ? 'hide' : ''; ?>">
                <tr valign="top">
                    <th scope="row">
                        <label class="control-label" for="site_name">
                            <?php _e("Store Name: ", 'blope'); ?>
                            <span class="tooltip-star" title="<?php _e("The name of your store or website. Defaults to Site Title if left blank.", 'blope'); ?>">!</span>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="site_name" id="site_name" value="<?php echo $options['site_name']; ?>" class="regular-text code">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="control-label" for="site_name">
                            <?php _e("Store Descriptions: ", 'blope'); ?>
                            <span class="tooltip-star" title="<?php _e("The descriptions of your store or website. Defaults to descriptions if left blank.", 'blope'); ?>">!</span>
                        </label>
                    </th>
                    <td>
                        <textarea rows="5" cols="53" name="site_desc" id="blope_site_desc"><?php echo $options['site_desc']; ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="control-label" for="image_url">
                            <?php _e("Store Logo Image: ", 'blope'); ?>
                            <span class="tooltip-star" title="<?php _e("A relative or absolute URL pointing to a square image of your brand or product. The recommended minimum size is 128x128px. The supported image types are: .gif, .jpeg, and .png.", 'blope'); ?>">!</span>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="image_url" id="image_url" value="<?php echo $options['image_url']; ?>" class="regular-text code">
                        <button class="button insert-image-url"><?php _e('Choose Image', 'blope'); ?></button>
                        <img class="img-display" src="<?php echo $options['image_url']; ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label class="control-label" for="currency">
                            <?php _e( "Currency: ", 'blope' ); ?>
                            <span class="tooltip-star" title="<?php _e("Specify a currency using it's 3-letter ISO Code. Defaults to USD if left blank. Go to 'https://support.stripe.com/questions/which-currencies-does-stripe-support/' for detail", 'blope'); ?>">!</span>
                        </label>
                    </th>
                    <td>
                        <div class="blope-currency-select">
                            <select id="currency" name="currency">
                                <option value=""><?php esc_attr_e('Select from the list', 'blope'); ?></option>
                                <?php
                                foreach (blopeGetAvailableCurrencies() as $key => $curr ) {
                                    $option = '<option value="' . $key . '"';
                                    if ( $options['currency'] === $key ) {
                                        $option .= 'selected="selected"';
                                    }
                                    $option .= '>';
                                    $option .= $curr['name'] . ' (' . $curr['code'] . ')';
                                    $option .= '</option>';
                                    echo $option;
                                }
                                ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="control-label" for="locale">
                            <?php _e("Locale: ", 'blope'); ?>
                            <span class="tooltip-star" title="<?php _e("'auto' is used by default to select a language based on the user's browser configuration. To select a particular language, pass the two letter ISO 639-1 code such as 'zh' for Chinese. Go to 'https://support.stripe.com/questions/what-languages-does-stripe-checkout-support' to see languages supported by Stripe Checkout", 'blope'); ?>">!</span>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="locale" id="locale" value="<?php echo $options['locale']; ?>" class="regular-text code">
                        <p class="description"></p>
                    </td>
                </tr>

            </table>
            <table id="stripe_setting" class="form-table <?php echo $active_tab != 'stripe' ? 'hide' : ''; ?>">
                <tr valign="top">
                    <th scope="row">
                        <label class="control-label"><?php _e("API Mode: ", 'blope'); ?> </label>
                    </th>
                    <td>
                        <label class="radio">
                            <input type="radio" name="mode" id="modeTest" value="test" <?php echo ($options['mode'] == 'test') ? 'checked' : '' ?> > Test
                        </label> <label class="radio">
                            <input type="radio" name="mode" id="modeLive" value="live" <?php echo ($options['mode'] == 'live') ? 'checked' : '' ?>> Live
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="control-label" for="secret_key_test"><?php _e("Stripe Test Secret Key: ", 'blope'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="secret_key_test" id="secret_key_test" placeholder="<?php _e("Enter Your Stripe Test Secret Key ", 'blope'); ?>" value="<?php echo $options['secret_key_test']; ?>" class="regular-text code">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="control-label" for="publish_key_test"><?php _e("Stripe Test Publishable Key: ", 'blope'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="publish_key_test" name="publish_key_test" placeholder="<?php _e("Enter Your Stripe Test Publishable Key ", 'blope'); ?>" value="<?php echo $options['publish_key_test']; ?>" class="regular-text code">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="control-label" for="secret_key_live"><?php _e("Stripe Live Secret Key: ", 'blope'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="secret_key_live" id="secret_key_live" placeholder="<?php _e("Enter Your Stripe Live Secret Key ", 'blope'); ?>" value="<?php echo $options['secret_key_live']; ?>" class="regular-text code">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="control-label" for="publish_key_live"><?php _e("Stripe Live Publishable Key: ", 'blope'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="publish_key_live" name="publish_key_live" placeholder="<?php _e("Enter Your Stripe Live Publishable Key ", 'blope'); ?>" value="<?php echo $options['publish_key_live']; ?>" class="regular-text code">
                    </td>
                </tr>
            </table>

        </div>
    </form>

</div>
