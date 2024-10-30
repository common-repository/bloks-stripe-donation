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
 * {attributes} all button attributes
 * {custom_amount} is button custom amount with value 0 or 1
 * {amount} is amount fixed
 * {flexible} add class 'blope-donation-flexible' if has custom amount
 * {currency}
 * {currency_symbol} ex: $
 * {title} is title of the button
 * {desc} is short description of the button
 *
 * */
?>
<a class="blope-btn-basic blope-donation-btn blope-btn-animate {flexible}" {attributes}>
    <span class="blope-btn-title">{title}</span>
    <span class="blope-btn-amount-wrap">
        <span class="blope-currency">{currency_symbol}</span>
        <span class="blope-btn-amount">{amount}</span>
    </span>
</a>
<style type="text/css">
    .blope-btn-basic {
        position: relative;
        display: inline-block;
        text-align: center;
        padding: 12px 28px;
        border-radius: 4px;
        background-color: #3ea8e5;
        background-image: -webkit-gradient(linear,left top,left bottom,from(#44b1e8),to(#3098de));
        background-image: -webkit-linear-gradient(top,#44b1e8,#3098de);
        background-image: linear-gradient(-180deg,#44b1e8,#3098de);
        box-shadow: 0 1px 0 0 rgba(46,86,153,.15), inset 0 1px 0 0 rgba(46,86,153,.1), inset 0 -1px 0 0 rgba(46,86,153,.4);
        font-size: 17px;
        font-family: Verdana;
        line-height: 21px;
        font-weight: 700;
        text-shadow: 0 -1px 0 rgba(0,0,0,.12);
        color: #fff;
        cursor: pointer;
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    .blope-btn-basic:hover {
        cursor: pointer;
        color: #fff;
    }
    .blope-btn-basic:active {
        cursor: pointer;
        color: #fff;
        background-image: -webkit-gradient(linear,left top,left bottom,from(#328ac3),to(#277bbe));
        background-image: -webkit-linear-gradient(top,#328ac3,#277bbe);
        background-image: linear-gradient(180deg,#328ac3,#277bbe);
    }
    .blope-btn-basic span.blope-btn-title {
        display: inline-block;
        cursor: pointer;
        color: #fff;
        font-family: Verdana;
        font-size: 17px;
        font-weight: 700;
        text-shadow: 0 -1px 0 rgba(0,0,0,.12);
    }
    .blope-btn-basic:hover span.blope-btn-title {}
    .blope-btn-basic .blope-btn-amount-wrap {}
    .blope-btn-basic .blope-currency {display: inline-block; cursor: pointer; color: #fff; font-size: 17px; font-weight: 700;}
    .blope-btn-basic .blope-btn-amount {display: inline-block; cursor: pointer; color: #fff; margin-left: -5px; font-size: 17px; font-weight: 700;}
</style>
