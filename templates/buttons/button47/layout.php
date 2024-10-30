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
<a href="javascript:void(0);" class="blope-btn-button47 blope-donation-btn blope-btn-animate {flexible}" {attributes}>
    <span class="blope-btn-button47-top"></span>
    <span class="blope-btn-button47-mid">
        <span class="blope-btn-content">
            <span class="blope-btn-title">{title}</span>
            <span class="blope-currency">{currency_symbol}</span><span class="blope-btn-amount">{amount}</span>
        </span>
        <br />
        <span class="blope-btn-desc">{desc}</span>

    </span>
    <span class="blope-btn-button47-bottom"></span>

</a>
<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
<style type="text/css">
    .blope-btn-button47,
    .blope-btn-button47:hover
    {
        background:url({template_url}/images/bg.png) left  repeat-x !important ;
        display: inline-block;
        position: relative;
        text-align: left;
        box-shadow: 0px  0px  #fff !important;
        border-radius: 5px !important;
        margin: 0px;
        overflow: hidden;
        transition: box-shadow 0.3s ease-in-out;
        text-decoration: none;
        padding:0px;
        line-height: 30px;
        font-family: 'Raleway', sans-serif !important;
        font-size: 30px;
        font-weight: bold;

    }
    .blope-btn-button47-top{width:202px; height:31px;  background: url({template_url}/images/top.png) no-repeat;display: block;}
    .blope-btn-button47-bottom{width:202px; height:11px;  background: url({template_url}/images/bottom.png) no-repeat; display: block;}
    .blope-btn-button47-mid{width:192px; padding:0 5px; background: url({template_url}/images/mid.png) repeat-y;display: block; text-align: center;}
    .blope-btn-button47 .blope-btn-title,
    .blope-btn-button47  .blope-currency,
    .blope-btn-button47 .blope-btn-amount
    {
        color:#d60000; font-size: 24px;
        font-family: 'Raleway', sans-serif;
          font-weight: bold;
    }
    .blope-btn-button47 .blope-btn-desc{
        color:#d60000; font-size: 12px;
        font-family: 'Raleway', sans-serif;
        font-weight: bold;
    }



</style>
