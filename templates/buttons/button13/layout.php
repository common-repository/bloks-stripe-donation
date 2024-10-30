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
<a href="javascript:void(0);" class="blope-btn-button13 blope-donation-btn blope-btn-animate {flexible}" {attributes}>
    <span class="blope-btn-title">{title}</span> <span class="blope-currency">{currency_symbol}</span><span class="blope-btn-amount">{amount}</span><i class="fa fa-heart"></i>
</a>
<style type="text/css">
    .blope-btn-button13 ,
    .blope-btn-button13:hover
    {
        background: #5aabe2 ;
        display: inline-block;
        position: relative;
        text-align: center;
        box-shadow: 0px 2px  #4395cd !important;
        border-radius: 5px;
        margin: 0px;
        overflow: hidden;
        transition: box-shadow 0.3s ease-in-out;
        text-decoration: none;
        padding:16px 20px 16px 20px;
        font-family: arial, serif;
        font-size: 22px;
        font-weight: bold;
        color:#fff  !important;
        border:none !important;
    }
    .blope-btn-button13:hover { color:#fff;}
    .blope-btn-button13 span{  font-family: arial, serif;       font-size: 22px;        font-weight: bold;}
    .blope-btn-button13 .fa{margin-left: 20px;}


</style>
