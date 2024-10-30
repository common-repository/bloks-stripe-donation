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
<a class="blope-donation-btn blope-btn-button27 blope-btn-animate {flexible}" href="javascript::void(0);" {attributes}>
    <i class="fa fa-gift "></i>
    <span class="blope-btn-content">
        <span class="blope-btn-title">{title}</span>
        <span class="blope-currency">{currency_symbol}</span><span class="blope-btn-amount">{amount}</span>
    </span>
</a>
<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
<style type="text/css">
    a.blope-donation-btn{    vertical-align: middle;    border: none !important;}
    a.blope-donation-btn:hover{    text-decoration: none;    border: none !important;}
    a.blope-donation-btn  .fa {
        font-family:  FontAwesome !important;
    }
    .blope-btn-button27:after{
        width:46px; height:62px; display:inline-block;content:'';
        background:url({template_url}/images/button-right.png) right no-repeat;vertical-align: middle;vertical-align: top;
        position: absolute;
        right: -46px;
        top: 0px;
    }
    .blope-btn-button27 span {
        height:62px;
        display:inline-block;
        color:#464952;
        text-decoration:none;
        font-size:25px;
        font-weight:bold;
        font-family: 'Ubuntu', sans-serif;
        line-height: 62px;
        vertical-align: top;
    }
    .blope-btn-button27 span.blope-btn-content{
        background:url({template_url}/images/button-left.png) left no-repeat;
        padding:0 0px 0 115px;
        overflow: hidden;
    }
    .blope-btn-button27 span i{font-weight:bold;        font-size:25px;}
    .blope-btn-button27,
    .blope-btn-button27:hover
    {position:relative; display:inline-block; border:none !important;  box-shadow: 0px  0px  #fff !important;margin-right: 46px;}
    .blope-btn-button27 .fa{font-size:28px; color:#fff; position:absolute;     left: 16px;    top: 13px; z-index:1;}
</style>
