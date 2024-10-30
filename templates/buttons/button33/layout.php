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
<a href="javascript:void(0);" class="blope-btn-button33 blope-donation-btn blope-btn-animate {flexible}" {attributes}>
    <i class="fa fa-gift"></i>
    <span class="blope-btn-content">
        <span class="blope-btn-title">{title}</span>
        <span class="blope-currency">{currency_symbol}</span><span class="blope-btn-amount">{amount}</span>
    </span>
</a>
<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
<style type="text/css">
    .blope-btn-button33:before{
        width:112px; height:57px; display:inline-block;content:'';
        background:url({template_url}/images/button-left.png) right no-repeat;vertical-align: middle;vertical-align: top;
        position: absolute;
        left:0px;top:0px;
    }
    .blope-btn-button33 span {
        height:57px;
        display:inline-block;
        color:#fff!important;
        text-decoration:none;
        font-size:25px;
        font-weight:bold;
        font-family: 'Ubuntu', sans-serif;
        line-height: 60px;
        vertical-align: top;
    }
    .blope-btn-button33 span.blope-btn-content{
        background:url({template_url}/images/bg-button.png) left  repeat-x;
        padding:0 46px 0 0px;
        vertical-align: top;
        overflow: hidden;
        border-radius:0 23px 17px 0;
        margin-left: 110px;
    }
    .blope-btn-button33 strong{
        font-family: 'Ubuntu', sans-serif !important;
        font-weight:bold;
        font-size:25px;
        line-height: 62px;
        vertical-align: top;
        line-height: 62px;
    }
    .blope-btn-button33,
    .blope-btn-button33:hover
    {position:relative; display:inline-block; border:none !important;  box-shadow: 0px  0px  #fff !important;text-decoration:none!important;}
    .blope-btn-button33 .fa{font-size:24px; color:#fff; position:absolute;     left: 16px;    top: 15px; z-index:1;}
</style>
