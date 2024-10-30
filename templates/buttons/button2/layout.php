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
<a href="javascript:void(0);" class="blope-btn-button2 blope-donation-btn blope-btn-animate {flexible}" {attributes}>
        <span class="blope-btn-title"><?php echo $title; ?></span> <span class="blope-currency"><?php echo $currency_symbol; ?></span><span class="blope-btn-amount"><?php echo (int)$amount; ?></span>
</a>
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
<style type="text/css">
    .blope-btn-button2 ,
    .blope-btn-button2:hover {
        background: #ffea00 url({template_url}/images/hand.png) center bottom no-repeat;
        display: inline-block;
        position: relative;
        text-align: center;
        box-shadow: 0px 1px 1px rgba(255, 255, 255, 0.8) inset, 1px 1px 3px rgba(0, 0, 0, 0.2) !important;
        border-radius: 20px;
        border: 10px solid #725598 !important;
        margin: 0px;
        overflow: hidden;
        transition: box-shadow 0.3s ease-in-out;
        text-decoration: none;
        padding:23px 15px 120px 15px;
        font-family: 'Roboto Slab', serif;
        font-size: 45px;
        font-weight: bold;
        color:#494351;
    }
    .blope-btn-button2:hover { color:#494351;}
    .blope-btn-button2 span{  font-family: 'Roboto Slab', serif;       font-size: 45px;        font-weight: bold;}



</style>
