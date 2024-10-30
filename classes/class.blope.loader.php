<?php
/**
 * Init base and provide autoload
 *
 * @package     Bloks_Stripe
 * @subpackage  Classes/Loader
 * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Bloks_Stripe_Loader
{
    /**
     * class init
     * @access static
     **/
    public static $instance;

    /**
     * Plugin Database
     * @access private
     **/
    private $db = null;

    /**
     * Plugin Admin
     * @access private
     **/
    private $admin = null;

    /**
     * Plugin Stripe
     * @access private
     **/
    private $stripe = null;

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Bloks_Stripe_Loader();
        }
        return self::$instance;
    }

    /**
     * Bloks_Stripe_Loader constructor.
     */
    public function __construct()
    {
        $this->includeCommon();
        $this->addHooks();
        $this->stripe = new Bloks_Stripe_Sripe();
        $this->db = new Bloks_Stripe_Database();
        $this->admin = new Bloks_Stripe_Admin();

    }

    public function includeCommon()
    {
        include 'class.blope.stripe.php';
        include 'class.blope.database.php';
        include 'class.blope.widget.php';
        include 'class.blope.admin.php';

        //set option defaults
        $options = get_option('blope_options');
        if ($options == '') {
            $arr = array(
                'mode' => 'test',
                'secret_key_test'     => '',
                'publish_key_test'    => '',
                'secret_key_live'     => '',
                'publish_key_live'    => '',
                'currency' => 'usd',
                'image_url' => BLOPE_URL . 'assets/images/marketplace.png',
                'site_name' => get_bloginfo(),
                'site_desc' => '',
                'locale' => ''
            );
            update_option('blope_options', $arr);
        }

    }

    public function addHooks()
    {
        add_action('wp_ajax_blope_donation_charge', array($this, 'blopeDonationCharge'));
        add_action('wp_ajax_nopriv_blope_donation_charge', array($this, 'blopeDonationCharge'));
        add_shortcode('bloks_button', array($this, 'blopeDonationButton'));
        //load frontend script
        add_action('wp_enqueue_scripts', array($this, 'initFrontendScript'));

    }

    public function blopeDonationCharge()
    {

        check_ajax_referer( 'blope_donation_charge', 'stripeSecurity' );

        try {

            $options = get_option('blope_options');

            //set API key
            if ($options['mode'] === 'test') {
                $this->stripe->setApiKey($options['secret_key_test']);
            } else {
                $this->stripe->setApiKey($options['secret_key_live']);
            }


            $token          =  sanitize_text_field($_POST['stripeToken']);
            $email          =  sanitize_email($_POST['stripeEmail']);
            $amount         =  (int)$_POST['stripeAmount'];
            $button_id      =  sanitize_key($_POST['stripeButtonId']);
            $description    = '';

            $button = $this->db->getDonationButtonById($button_id);
            $html_msg = __('Thank you for your donation', 'blope');
            if($button && $button->button_success_message != '')
                $html_msg = stripslashes(html_entity_decode($button->button_success_message));

            $metadata = array();
            $metadata = apply_filters( 'blope_custom_meta', $metadata );

            // create Customer
            $customer = $this->stripe->createCustomer($token, $email, $metadata);

            // Create the charge on Stripe's servers - this will charge the user's default card
            $charge = $this->stripe->chargeCustomer($customer['id'], $amount, $description, $metadata, $email);

            $return = array(
                'success' => true,
                'msg'     => 'Donate Successful!',
                'html_msg' => $html_msg
            );


        } catch ( Stripe_CardError $e ) {
            $message = $this->stripe->getStripeMessageError( $e->getCode() );
            if ( is_null( $message ) ) {
                $message = esc_html( $e->getMessage() );
            }
            $return = array(
                'success' => false,
                'msg'     => $message,
                'html_msg' => 'Donate failure'
            );
        }
        catch (Exception $e)
        {
            //show notification of error
            $return = array(
                'success' => false,
                'msg'     => esc_html( $e->getMessage() ),
                'html_msg' => 'Donate failure'
            );
        }

        wp_send_json($return);
    }

    /**
     * Render donation button layout
     *
     * @param $atts
     *
     * @return mixed|void
     */
    public function blopeDonationButton($atts) {
        $id = null;
        $default = array(
            'mode' => 'test',
            'image_url' => BLOPE_URL . 'assets/images/marketplace.png',
            'site_name' => get_bloginfo(),
            'site_desc' => '',
            'currency' => 'usd',
            'locale' => '',
            'publish_key_test' => '',
            'publish_key_live' => ''
        );
        $options = get_option('blope_options');
        $options = wp_parse_args($options, $default);

        extract(shortcode_atts(array(
            'id' => '1',
        ), $atts));

        //load button data into scope
        $buttonData = $this->getButtonData($id);

        //load scripts and styles
        $this->blopeLoadStyles($options, $buttonData);
        $this->blopeLoadScripts($options, $buttonData);

        //get the button style
        $content = blopeGetButtonOutput($buttonData);

        return apply_filters('blope_donation_button_output', $content);
    }


    public function blopeLoadScripts($options, $buttonData)
    {
        wp_enqueue_script('stripe-js', 'https://checkout.stripe.com/checkout.js', array('jquery'));
        wp_enqueue_script('blope-js', plugins_url('assets/js/scripts.js', dirname(__FILE__)), array('stripe-js'), BLOPE_VERSION);

        $admin_url = admin_url('admin-ajax.php');
        wp_localize_script('blope-js', 'blope_stripe_key', (($options['mode'] === 'test')?$options['publish_key_test']:$options['publish_key_live']));
        wp_localize_script('blope-js', 'blope_image_url', ($options['image_url'] == '' ? BLOPE_URL . 'assets/images/marketplace.png' : $options['image_url']));
        wp_localize_script('blope-js', 'blope_site_name', $options['site_name']);
        wp_localize_script('blope-js', 'blope_site_desc', $options['site_desc']);
        wp_localize_script('blope-js', 'blope_currency', $options['currency']);
        wp_localize_script('blope-js', 'blope_unit', ($options['currency'] == 'usd'?'100':'1'));
        wp_localize_script('blope-js', 'blope_locale', ($options['locale'] == ''?'auto':$options['locale']));
        wp_localize_script('blope-js', 'blope_nonce', wp_create_nonce('blope_donation_charge'));
        wp_localize_script('blope-js', 'ajax_url', ( is_ssl() ? str_replace('http:', 'https:', $admin_url) : str_replace('https:', 'http:', $admin_url) )); // replace https with http for admin-ajax calls for SSLed backends

    }

    public function blopeLoadStyles($options, $buttonData)
    {


    }

    public function initFrontendScript(){
        wp_enqueue_style('blope-reset-css', plugins_url('assets/css/reset.min.css', dirname(__FILE__)), null, BLOPE_VERSION );
        wp_enqueue_style('blope-animate-css', plugins_url('assets/css/animate.min.css', dirname(__FILE__)), null, BLOPE_VERSION );
        wp_enqueue_style('blope-frontend-style-css', plugins_url('/assets/css/styles.css', dirname(__FILE__)), null, BLOPE_VERSION);
    }

    /**
     * Get Button Information
     *
     * @param string $id
     * @return mixed
     */
    public function getButtonData($id)
    {
        $butonData = $this->db->getDonationButtonById($id);
        return $butonData;
    }

    public static function installDatabase()
    {
        Bloks_Stripe_Database::installDatabase();
    }

}

Bloks_Stripe_Loader::getInstance();
