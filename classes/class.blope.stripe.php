<?php
/**
 * Handler stripe payment gateway
 *
 * @package     Bloks_Stripe
 * @subpackage  Classes/Sripe
 * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Bloks_Stripe_Sripe
{

    /**
     * Get error message by error code
     *
     * @param $code
     *
     * @return mixed|null
     */
    public function getStripeMessageError($code)
    {
        $message = null;

        $arr_codes = array(
            'invalid_number' => __('The card number is not a valid credit card number.', 'blope'),
            'invalid_expiry_month' => __('The card\'s expiration month is invalid.', 'blope'),
            'invalid_expiry_year' => __('The card\'s expiration year is invalid.', 'blope'),
            'invalid_cvc' => __('The card\'s security code is invalid.', 'blope'),
            'invalid_swipe_data' => __('The card\'s swipe data is invalid.', 'blope'),
            'incorrect_number' => __('The card number is incorrect.', 'blope'),
            'expired_card' => __('The card has expired.', 'blope'),
            'incorrect_cvc' => __('The card\'s security code is incorrect.', 'blope'),
            'incorrect_zip' => __('The card\'s zip code failed validation.', 'blope'),
            'card_declined' => __('The card was declined.', 'blope'),
            'missing' => __('There is no card on a customer that is being charged.', 'blope'),
            'processing_error' => __(' An error occurred while processing the card.', 'blope')
        );

        if(in_array($code, $arr_codes))
            $message = $arr_codes[$code];
        return $message;

    }

    public function setApiKey($key) {
        if ($key != '') {
            try {
                \Stripe\Stripe::setApiKey($key);
            } catch (Exception $e) {
                //invalid key was set, ignore it
                wp_die(__('Invalid key was set, please set another key.','blope'));
            }
        }
    }

    /**
     * Create customer
     *
     * @param object $card
     * @param string $email
     * @param array $metadata
     *
     * @return \Stripe\Customer
     */
    public function createCustomer($card, $email, $metadata)
    {
        $customer = array(
            "card" => $card,
            "email" => $email,
            "metadata" => $metadata
        );

        return \Stripe\Customer::create($customer);
    }

    public function charge($card, $amount, $description, $metadata = null, $stripeEmail = null)
    {
        $options = get_option('blope_options');

        $charge = array(
            'card' => $card,
            'amount' => $amount,
            'currency' => $options['currency'],
            'description' => $description,
            'receipt_email' => $stripeEmail
        );

        if ($metadata)
            $charge['metadata'] = $metadata;

        $result = \Stripe\Charge::create($charge);

        return $result;
    }
    public function chargeCustomer($customer_id, $amount, $description, $metadata = null, $stripeEmail = null)
    {
        $options = get_option('blope_options');

        $charge = array(
            'customer' => $customer_id,
            'amount' => $amount,
            'currency' => ($options['currency'] == ''?'usd':$options['currency']),
            'description' => $description,
            'receipt_email' => $stripeEmail
        );

        if ($metadata)
            $charge['metadata'] = $metadata;

        $result = \Stripe\Charge::create($charge);

        return $result;
    }

}
