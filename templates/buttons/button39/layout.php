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
<a href="javascript:void(0);" class="blope-btn-button39 blope-donation-btn blope-btn-animate {flexible}" {attributes}>
    <span class="blope-btn-title">
        <?php echo $title; ?></span> <span class="blope-currency"><?php echo $currency_symbol; ?></span><span class="blope-btn-amount"><?php echo (int)$amount; ?></span>
    <span class="blope-btn-desc">{desc}</span><i class="fa fa-gift"></i>
</a>
<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
<style type="text/css">
    .blope-btn-button39,
    .blope-btn-button39:hover
    {
        background: #eb4760!important ;
        display: inline-block;
        position: relative;
        text-align: left;
        box-shadow: 0px  4px  #c83c52 !important;
        border-radius: 5px !important;
        margin: 0px;
        overflow: hidden;
        transition: box-shadow 0.3s ease-in-out;
        text-decoration: none;
        padding:6px 90px 6px 20px;
        line-height: 30px;
        font-family: 'Roboto Slab', serif;
        font-size: 30px;
        font-weight: bold;
        color:#fff  !important;
    }

    .blope-btn-button39 span{  font-family: 'Roboto Slab', serif;    font-weight: bold;     font-size: 27px;     }
    .blope-btn-button39 .fa{
        margin-left: 18px;font-size:19px;
        background: #cb1b36; width:40px; height:40px; border-radius:50%; line-height: 40px;
        position: absolute;right:20px; top:10px;    text-align: center;
    }
    .blope-btn-button39 span.blope-btn-desc{
        font-family: 'Raleway', sans-serif;font-size: 12px;        font-weight: bold;    display: block;
        color:#ffafbb;
    }



</style>
