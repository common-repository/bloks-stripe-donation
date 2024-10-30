<?php
/**
 * List button HTML
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
//get the data we need
$listButtons = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "blope_donation_buttons;");

$options = get_option('blope_options');
$currencySymbol = blopeGetCurrencySymbol($options['currency']);

?>
<div class="wrap blope-wrapper blope-table-list">
    <h1 class="heading-inline">
        <span><?php _e('Bloks Stripe Donation Buttons', 'blope'); ?></span>
        <a href="<?php echo admin_url("admin.php?page=blope-donations&act=create"); ?>" class="page-title-action"><?php _e('Add New','blope'); ?></a>
    </h1>
    <div id="blope-message"></div>
    <div id="blope-manage-buttons" class="blope-content-wrap">
        <table class="wp-list-table widefat fixed striped pages">
            <thead>
            <tr>
                <th><?php _e('Button Label', 'blope'); ?></th>
                <th><?php _e('Button Amount', 'blope'); ?></th>
                <th><?php _e('Button Shortcode', 'blope'); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody id="blopeButtonsTable">
            <?php foreach ($listButtons as $btn): ?>
                <tr>
                    <td><a class="" href="<?php echo admin_url("admin.php?page=blope-donations&act=edit&bid=$btn->button_id"); ?>"><?php echo $btn->button_title; ?></a></td>
                    <?php if ($btn->button_custom_amount == 0): ?>
                        <td><?php echo $currencySymbol . sprintf('%0.2f', $btn->button_amount / 100.0); ?></td>
                    <?php else: ?>
                        <td><?php _e('Flexible', 'blope'); ?></td>
                    <?php endif; ?>
                    <td>[bloks_button id="<?php echo $btn->button_id; ?>"]</td>
                    <td>
                        <a class="button button-primary" href="<?php echo admin_url("admin.php?page=blope-donations&act=edit&bid=$btn->button_id"); ?>"><?php _e('Edit', 'blope'); ?></a>
                        <button class="button delete" data-id="<?php echo $btn->button_id; ?>"><?php _e('Delete', 'blope'); ?></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

