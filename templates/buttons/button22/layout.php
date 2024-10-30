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
<a href="javascript:void(0);" class="blope-btn-button22 blope-donation-btn blope-btn-animate {flexible}" {attributes}>
    <span class="blope-btn-button22-left"><strong class="blope-currency">{currency_symbol}<strong class="blope-btn-amount">{amount}</strong></strong>
    </span>
    <span class="blope-btn-content">
        <span class="blope-btn-title">{title}</span>
        <span class="blope-btn-desc">{desc}</span>
    </span>
    <span class="blope-btn-button22-right"><i class="fa fa-gift"></i></span>
</a>
<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
<style type="text/css">
    .blope-btn-button22-left{width:74px; height:54px; background:url({template_url}/images/left.png) left  no-repeat  ; display: block; float: left;}
    .blope-btn-button22-right{width:77px; height:54px; background:url({template_url}/images/right.png) left  no-repeat  ; display: block; float: left;}

    .blope-btn-button22,
    .blope-btn-button22:hover
    {position:relative; outline: none; display:inline-block; border:none !important;  box-shadow: 0px  0px  #fff !important;text-decoration:none!important;   }
    .blope-btn-button22 .fa{font-size:20px; color:#fff; z-index:1;position:absolute;     right: 20px;    top: 18px;}
    .blope-btn-button22 .blope-btn-content {
        background:url({template_url}/images/mid.png)   repeat-x  ;
        height:36px;
        padding:8px 0 10px 0;
        color:#df4555;
        font-family: 'Ubuntu', sans-serif !important;
        display: inline-block !important;
        font-size:16px;
        line-height: 20px !important;
        font-weight: bold;
        text-align: center;
        float: left;
        max-width: 68%;    overflow: hidden;
    }
    .blope-btn-button22 .blope-btn-title{
        color:#df4555;
        font-family: 'Ubuntu', sans-serif !important;
        display: block !important;
        font-size: 16px;
        line-height: 20px !important;
        font-weight: bold;
    }
    .blope-btn-button22 .blope-btn-desc{
         color:#df4555;
        display: block !important;
        font-family: 'Ubuntu', sans-serif !important;
        font-size:10px; line-height: 18px !important;
        font-weight: bold;

    }
    .blope-btn-button22 .blope-currency{
        font-size:15px!important;  font-family: 'Ubuntu', sans-serif !important;color:#fff; z-index:1;position:absolute;     left: 8px;    top: 18px;
        font-weight: bold;width:40px;        text-align: center;
    }
    .blope-btn-button22 .blope-btn-amount{
        font-size:15px!important;  font-family: 'Ubuntu', sans-serif !important;color:#fff;  font-weight: bold;
    }
</style>
