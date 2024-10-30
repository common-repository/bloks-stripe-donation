<?php
/**
 * Render html for button layout
 *
 * @package     Bloks_Stripe
 * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<span class="blope-donation-custom-amount-container" style="display: none;">
    <span class="blope-donation-custom-amount">
        <!--<span class="blope-custom-currency">{currency_symbol}</span>-->
        <input class="blope-donation-custom-amount-input" type="text" value="" placeholder="{currency_symbol}">
    </span>
    <span class="blope-donation-custom-btn"><?php _e('OK', 'blope'); ?></span>
</span>

