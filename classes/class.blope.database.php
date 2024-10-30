<?php
/**
 * Create table and provide some function to manage buttons table
 *
 * @package     Bloks_Stripe
 * @subpackage  Classes/Database
 * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Bloks_Stripe_Database {

    const donationButtonTable = 'blope_donation_buttons';

    public static function installDatabase() {
        //require for dbDelta()
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $table = $wpdb->prefix . self::donationButtonTable;

        $sql = "CREATE TABLE " . $table . " (
        button_id INT NOT NULL AUTO_INCREMENT,
        button_amount INT NOT NULL,
        button_custom_amount TINYINT(1) DEFAULT '0',
        button_title VARCHAR(100) NOT NULL DEFAULT 'Donate',
        button_desc VARCHAR(1024) DEFAULT NULL,
        button_style VARCHAR(100) NOT NULL DEFAULT 'basic',
        button_css LONGTEXT NOT NULL COLLATE 'utf8_general_ci',
        button_animate VARCHAR(100) NOT NULL DEFAULT 'fade',
        button_panel_label VARCHAR(100) NOT NULL DEFAULT 'Donate',
        button_success_message VARCHAR(1024) DEFAULT NULL,
        button_store_desc VARCHAR(1024) DEFAULT NULL,
        success_redirect_url VARCHAR(1024) DEFAULT NULL,
        failure_redirect_url VARCHAR(1024) DEFAULT NULL,
        enable_billing_address TINYINT(1) DEFAULT '0',
        enable_shipping TINYINT(1) DEFAULT '0',
        enable_zip_code TINYINT(1) DEFAULT '0',
        enable_remember TINYINT(1) DEFAULT '0',
        enable_bitcoin TINYINT(1) DEFAULT '0',
        PRIMARY KEY (button_id)
        ) $charset_collate;";

        dbDelta( $sql );

        //default button
        $default = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . self::donationButtonTable . " WHERE button_id=1;" );
        if ( $default === null ) {
            $data    = array(
                'button_title' => 'Donate',
                'button_amount'    => 1500 //$15.00
            );
            $formats = array( '%s', '%d' );
            $wpdb->insert( $wpdb->prefix . self::donationButtonTable, $data, $formats );
        }

    }

    /**
     * Insert new donation button
     * @param $button
     */
    public function insertDonationButton( $button ) {
        global $wpdb;
        $wpdb->insert( $wpdb->prefix . self::donationButtonTable, $button );
    }

    /**
     * Update donation button
     *
     * @param $id
     * @param $button
     */
    public function updateDonationButton( $id, $button ) {
        global $wpdb;
        $wpdb->update( $wpdb->prefix . self::donationButtonTable, $button, array( 'button_id' => $id ) );
    }

    /**
     * Delete donation button by provide id
     *
     * @param $id
     */
    public function deleteDonationButton( $id ) {
        global $wpdb;
        $wpdb->query( 'DELETE FROM ' . $wpdb->prefix . self::donationButtonTable . " WHERE button_id='" . $id . "';" );
    }

    /**
     * Get donation button by id
     *
     * @param $id
     *
     * @return array|null|object|void
     */
    public function getDonationButtonById( $id ) {
        global $wpdb;

        return $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . self::donationButtonTable . " WHERE button_id='" . $id . "';" );
    }

    /**
     * Get all button
     *
     * @return array|null|object
     */
    public function getListButtons()
    {
        global $wpdb;

        return $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . self::donationButtonTable);
    }
}
