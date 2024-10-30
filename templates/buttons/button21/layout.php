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
 * $ID is css button Id. ex: blope_btn_9999
 * $animate is button animate
 * $custom_amount is button custom amount with value 0 or 1
 * $amount is amount fixed
 * $currency
 * $currency_symbol ex: $
 * $title is title of the button
 * $desc is short description of the button
 *
 * */
?>
<a href="javascript:void(0);" class="blope-btn-button21 blope-donation-btn blope-btn-animate {flexible}" {attributes}>
    <span class="blope-btn-title">{title}</span> <span class="blope-currency">{currency_symbol}</span><span class="blope-btn-amount">{amount}</span><i class="fa fa-gift"></i>
</a>
<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
<style type="text/css">
    .blope-btn-button21,
    .blope-btn-button21:hover
    {
        background: #f1b401!important ;
        display: inline-block;
        position: relative;
        text-align: center;
        box-shadow: 0px  0px  #5c68d8 !important;
        border-radius: 0px !important;
        margin: 0px;
        overflow: hidden;
        transition: box-shadow 0.3s ease-in-out;
        text-decoration: none;
        padding:12px 20px 12px 20px;
        font-family: 'Ubuntu', sans-serif;
        font-size: 24px;
        font-weight: bold;
        color:#fff  !important;
        border:none !important;
    }

    .blope-btn-button21 span{ font-family: 'Ubuntu', sans-serif;    font-weight: bold;     font-size: 24px;     }
    .blope-btn-button21 .fa{margin-left: 20px;font-size: 25px;  }



</style>
