<?php
/**
 * Function provide array contain animation css
 *
 * @package     Bloks_Stripe
 * @subpackage  Functions
 * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function blopeGetAnamations($active)
{
    $animations =  array (
        'attention_seekers' =>
            array (
                0 => 'bounce',
                1 => 'flash',
                2 => 'pulse',
                3 => 'rubberBand',
                4 => 'shake',
                5 => 'headShake',
                6 => 'swing',
                7 => 'tada',
                8 => 'wobble',
                9 => 'jello',
            ),
        'bouncing_entrances' =>
            array (
                0 => 'bounceIn',
                1 => 'bounceInDown',
                2 => 'bounceInLeft',
                3 => 'bounceInRight',
                4 => 'bounceInUp',
            ),
        'bouncing_exits' =>
            array (
                0 => 'bounceOut',
                1 => 'bounceOutDown',
                2 => 'bounceOutLeft',
                3 => 'bounceOutRight',
                4 => 'bounceOutUp',
            ),
        'fading_entrances' =>
            array (
                0 => 'fadeIn',
                1 => 'fadeInDown',
                2 => 'fadeInDownBig',
                3 => 'fadeInLeft',
                4 => 'fadeInLeftBig',
                5 => 'fadeInRight',
                6 => 'fadeInRightBig',
                7 => 'fadeInUp',
                8 => 'fadeInUpBig',
            ),
        'fading_exits' =>
            array (
                0 => 'fadeOut',
                1 => 'fadeOutDown',
                2 => 'fadeOutDownBig',
                3 => 'fadeOutLeft',
                4 => 'fadeOutLeftBig',
                5 => 'fadeOutRight',
                6 => 'fadeOutRightBig',
                7 => 'fadeOutUp',
                8 => 'fadeOutUpBig',
            ),
        'flippers' =>
            array (
                0 => 'flip',
                1 => 'flipInX',
                2 => 'flipInY',
                3 => 'flipOutX',
                4 => 'flipOutY',
            ),
        'lightspeed' =>
            array (
                0 => 'lightSpeedIn',
                1 => 'lightSpeedOut',
            ),
        'rotating_entrances' =>
            array (
                0 => 'rotateIn',
                1 => 'rotateInDownLeft',
                2 => 'rotateInDownRight',
                3 => 'rotateInUpLeft',
                4 => 'rotateInUpRight',
            ),
        'rotating_exits' =>
            array (
                0 => 'rotateOut',
                1 => 'rotateOutDownLeft',
                2 => 'rotateOutDownRight',
                3 => 'rotateOutUpLeft',
                4 => 'rotateOutUpRight',
            ),
        'specials' =>
            array (
                0 => 'hinge',
                1 => 'jackInTheBox',
                2 => 'rollIn',
                3 => 'rollOut',
            ),
        'zooming_entrances' =>
            array (
                0 => 'zoomIn',
                1 => 'zoomInDown',
                2 => 'zoomInLeft',
                3 => 'zoomInRight',
                4 => 'zoomInUp',
            ),
        'zooming_exits' =>
            array (
                0 => 'zoomOut',
                1 => 'zoomOutDown',
                2 => 'zoomOutLeft',
                3 => 'zoomOutRight',
                4 => 'zoomOutUp',
            ),
        'sliding_entrances' =>
            array (
                0 => 'slideInDown',
                1 => 'slideInLeft',
                2 => 'slideInRight',
                3 => 'slideInUp',
            ),
        'sliding_exits' =>
            array (
                0 => 'slideOutDown',
                1 => 'slideOutLeft',
                2 => 'slideOutRight',
                3 => 'slideOutUp',
            ),
        'other' =>
            array(
              0 => 'none'
            ),
    );
    foreach ($animations as $lable => $items) {
        echo '<optgroup label="'. ucwords(str_replace('_',' ', $lable)).'"></optgroup>';
        if(is_array($items)) {
            foreach ($items as $item) {
                echo '<option value="'. $item.'" '. ($item == $active?'selected="selected"':'').'>'. $item.'</option>';
            }
        }
    }
}



