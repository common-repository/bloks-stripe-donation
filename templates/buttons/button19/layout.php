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
<a href="javascript:void(0);" class="blope-btn-button19 blope-donation-btn blope-btn-animate {flexible}" {attributes}>
    <span class="blope-btn-title"><?php echo $title; ?></span> <span class="blope-currency"><?php echo $currency_symbol; ?></span><span class="blope-btn-amount"><?php echo (int)$amount; ?></span>
    <span class="blope-btn-right"><i class="fa fa-gift"></i></span>
</a>
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
<style type="text/css">
    .blope-btn-button19,
    .blope-btn-button19:hover
    {
        background: #fff600 ;
        display: inline-block;
        position: relative;
        text-align: center;
        box-shadow: 0px 0px  #fff600 !important;
        border-radius: 5px;
        margin: 0px;
        overflow: hidden;
        transition: box-shadow 0.3s ease-in-out;
        text-decoration: none;
        padding:0px 20px 0px 74px;
        font-family: 'Roboto Slab', serif;
        font-size: 22px;
        font-weight: 400;
        color:#5b5ed1  !important;
        border:none !important;
        position: relative;
        height: 52px;
        overflow: hidden;
        line-height: 54px !Important;
    }

    .blope-btn-button19 span{  font-family: 'Roboto Slab', serif;    font-weight: 400;     font-size: 22px;       }
    .blope-btn-button19 .fa{margin-left: 20px;font-size: 22px;   font-weight: bold; position: absolute;top:14px; right:16px; z-index: 2; }
    .blope-btn-button19  .blope-btn-right{ background:url({template_url}/left.png) left  repeat-x !important ;width:74px; height:54px;
        position: absolute;left:-5px; top:0px; display: block;
    }


</style>
