<?php
/*
Plugin Name: Bloks Stripe Donation
Plugin URI: http://bloks.co/plugins/stripe-donation
Description: Bloks Stripe Donation plugin, this is free version.
Author: Bloks Team
Version: 1.0
Author URI: http://bloks.co/
Text Domain: blope
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Define constants
 */
define("BLOPE_LIVE", true); //Bloks_Stripe Status
define("BLOPE_PATH", dirname(__FILE__)); //Plugin Base File
define("BLOPE_DIR", basename(BLOPE_PATH)); //Plugin Base Directory
define("BLOPE_PLUGIN_BASENAME", plugin_basename( __FILE__ ) ); //Plugin Base Name
define("BLOPE_URL", plugins_url("/",__FILE__)); //Plugin Base URL
define("BLOPE_VERSION", "1.0"); //Plugin Version
define("BLOPE_STRIPE_API_VERSION", "5.2.0" ); //Stripe API PHP Version supported
define("BLOPE_REQUIRED_PHP_VERSION", "5.3.0" ); //PHP Required Version
define("BLOPE_REQUIRED_WP_VERSION", "4.0" ); //Wordpress Required Version

/**
 * Check PHP version required
 */
if(version_compare(phpversion(), BLOPE_REQUIRED_PHP_VERSION) < 0) {
    wp_die( __('Insufficient PHP Version.', 'blope') );
}

/**
 * Include functions
 */
include_once( BLOPE_PATH . '/includes/functions.php');

/**
 * Require Loader
 */
require_once BLOPE_PATH . '/classes/class.blope.loader.php';

/**
 * Main instance of Bloks Stripe Donation plugin.
 *
 */
class Bloks_Stripe
{
    /**
     * Bloks_Stripe constructor.
     * @access public
     */
    function __construct()
    {
        $this->initLibrary();
        $this->loadHooks();

    }

    /**
     * Init Stripe library
     */
    private function initLibrary()
    {
        //Stripe PHP library
        if ( ! class_exists( '\Stripe\Stripe' ) ) {
            require_once(BLOPE_PATH . '/vendor/stripe-php/init.php');
        } else {
            if(version_compare(\Stripe\Stripe::VERSION, BLOPE_STRIPE_API_VERSION) != 0) {
                wp_die( BLOPE_PLUGIN_BASENAME . ': ' . __('Another plugin has loaded an incompatible Stripe API client. Deactivate all other Stripe plugins, and try to activate Bloks Stripe Donation plugin again.', 'blope') );
            }
        }
    }

    /**
     * Add Hooks
     */
    public function loadHooks()
    {
        add_action( 'plugins_loaded', array($this, 'loadPluginTextDomain') ); //load language/textdomain

    }

    /**
     * Load language text domain
     */
    public function loadPluginTextDomain()
    {
        load_plugin_textdomain( 'blope', false, BLOPE_DIR . '/languages/' );
    }
    /**
     * Install Plugin
     *
     * @access public
     * @return void
     **/
    public static function blopeActivation()
    {

        Bloks_Stripe_Loader::installDatabase();

    }


    /**
     * Un-install Plugin
     *
     * @access public
     * @return void
     **/
    public static function blopeDeactivation()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'blope_donation_buttons';
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
    }

}

new Bloks_Stripe();
register_activation_hook(__FILE__,array("Bloks_Stripe","blopeActivation"));
register_deactivation_hook(__FILE__,array("Bloks_Stripe","blopeDeactivation"));

