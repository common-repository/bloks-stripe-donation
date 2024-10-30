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
<a href="javascript:void(0);" class="blope-btn-button45 blope-donation-btn blope-btn-animate {flexible}" {attributes}>
    <label><span class="blope-currency">{currency_symbol}<strong class="blope-btn-amount">{amount}</strong><br /></span>
    <span class="blope-btn-title">
        {title}</span></label>

</a>
<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
<style type="text/css">
    .blope-btn-button45,
    .blope-btn-button45:hover
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
        font-family: 'Ubuntu', sans-serif !important;
        font-size: 30px;
        font-weight: bold;
        color:#fff  !important;
        width:110px; height:128px;
        line-height: 200px;
        padding-top: 72px;
        padding-left: 45px;
        padding-right: 45px;
        border: none !important;
    }
    .blope-btn-button45 .blope-btn-title{
        display: inline-block;
        color:#0063b7; font-size: 18px; margin-top: 55px; width:100px; margin:0 auto;
        height: 45px;              overflow: hidden;
    }
    .blope-btn-button45 .blope-currency{ margin:0 auto;color:#0063b7; font-size: 18px; text-align: center;   }
    .blope-btn-button45 .blope-currency strong{ font-size: 18px;  font-family: 'Ubuntu', sans-serif !important;   font-weight: bold;}
    .blope-btn-button45 span{
        font-family: 'Ubuntu', sans-serif !important;   font-weight: bold;    color:#0063b7; font-size: 18px;
        text-align: center;
    }
    .blope-btn-button45 label{height:83px; display: table-cell; vertical-align: middle;    text-align: center;width:110px;}


</style>
