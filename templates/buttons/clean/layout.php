<?php
/**
 * Button layout
 *
 * @package     Bloks_Stripe
 * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/*
 * Button template variables
 *
 * {id} is css button Id. ex: blope_btn_9999
 * {custom_amount} is button custom amount with value 0 or 1
 * {amount} is amount fixed
 * {currency}
 * {currency_symbol} ex: $
 * {title} is title of the button
 * {desc} is short description of the button
 *
 * */
?>
<a class="blope-donation-btn blope-btn-clean blope-btn-animate {flexible}" {attributes} >
    <i class="btn-icon fa fa-cc-stripe"></i>
    <span class="blope-btn-title">{title}</span>
    <span class="blope-btn-amount-wrap">
        <span class="blope-currency">{currency_symbol}</span>
        <span class="blope-btn-amount">{amount}</span>
    </span>
</a>
<style type="text/css">
    .blope-btn-clean {
        background-color: #97cc76;
        background-image: linear-gradient(to bottom, #97cc76, #8bcc62);
        border: 1px solid #5f993a;
        box-shadow: inset 0 1px 0 #c6e6b3, inset 0 -1px 0 #79b356, inset 0 0 0 1px #a4cc8b, 0 2px 4px rgba(0, 0, 0, 0.2);
        color: rebeccapurple;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        border-radius: 3px;
        cursor: pointer;
        display: inline-block;
        font-family: Verdana, sans-serif;
        font-size: 12px;
        font-weight: 400;
        line-height: 20px;
        padding: 11px 16px 9px;
        margin: 0;
        transition: all 20ms ease-out;
        vertical-align: top;
    }
    .blope-btn-clean:active,
    .blope-btn-clean:hover {
        color: rebeccapurple;
        box-shadow: inset 0 1px 0 white, inset 0 -1px 0 #d9d9d9, inset 0 0 0 1px #f2f2f2;
    }
    .blope-btn-clean .btn-icon {
        font-size: 30px;
        color: rebeccapurple;
    }
    .blope-btn-clean span {
        font-weight: bold;
        line-height: 29px;
        display: inline-block;
        vertical-align: top;
        cursor: pointer;
    }
    .blope-btn-clean .blope-currency {display: inline-block; color: rebeccapurple; font-size: 17px; font-weight: bold;}
    .blope-btn-clean .blope-btn-amount {display: inline-block; color: rebeccapurple; margin-left: -5px; font-size: 17px; font-weight: bold;}
    .blope-btn-clean:hover .blope-currency,
    .blope-btn-clean:hover .blope-btn-amount {color: rebeccapurple;}

</style>
