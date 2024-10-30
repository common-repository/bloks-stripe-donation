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
<a href="javascript:void(0);" class="blope-btn-button16 blope-donation-btn blope-btn-animate {flexible}" {attributes}>
    <span class="blope-btn-title"><?php echo $title; ?></span> <span class="blope-currency"><?php echo $currency_symbol; ?></span><span class="blope-btn-amount"><?php echo (int)$amount; ?></span>
    <span class="blope-btn-right"></span>
</a>
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
<style type="text/css">
    .blope-btn-button16,
    .blope-btn-button16:hover
    {
        background: #03c9a8 ;
        display: inline-block;
        position: relative;
        text-align: center;
        box-shadow: 0px 2px  #019e7f !important;
        border-radius: 5px;
        margin: 0px;
        overflow: hidden;
        transition: box-shadow 0.3s ease-in-out;
        text-decoration: none;
        padding:0px 71px 0px 20px;
        font-family: 'Roboto Slab', serif;
        font-size: 22px;
        font-weight: bold;
        color:#fff  !important;
        border:none !important;
        position: relative;
        height: 52px;
        overflow: hidden;
        line-height: 54px !Important;
    }

    .blope-btn-button16 span{  font-family: 'Roboto Slab', serif;    font-weight: bold;     font-size: 22px;        font-weight: bold;}
    .blope-btn-button16 .fa{margin-left: 20px;font-size: 22px;   font-weight: bold; }
    .blope-btn-button16  .blope-btn-right{ background:url({template_url}/right.png) left  repeat-x !important ;width:54px; height:54px;
        position: absolute;right:0px; top:0px; display: block;
    }


</style>
