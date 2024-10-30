<?php
/**
 * A Admin class for manage donation buttons
 *
 * @package     Bloks_Stripe
 * @subpackage  Classes/Admin
 * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
class Bloks_Stripe_Admin
{

    /**
     * Plugin Database
     * @access private
     **/
    private $db = null;

    /**
     * Bloks_Stripe_Admin constructor.
     */
    public function __construct()
    {
        $this->hooks();
        $this->db = new Bloks_Stripe_Database();
    }

    public function hooks()
    {
        // addHooks for admin
        add_action('admin_init', array($this, 'adminInit'));
        add_action('admin_menu', array($this, 'addMenuPages'));
        add_action( 'admin_enqueue_scripts', array($this, 'loadAdminScripts'));
        add_action('init', array($this, 'loadEditorButtons'));
        add_filter('plugin_action_links_'. BLOPE_PLUGIN_BASENAME, array($this, 'pluginAddSettingsLink'));

        // register widget
        add_action( 'widgets_init', array($this, 'blopeRegisterWidget'));

        add_action( 'admin_footer', array($this, 'assignButtonsList'));

        // addHooks for admin actions
        add_action('wp_ajax_blope_update_settings', array($this, 'updateSettings'));
        add_action('wp_ajax_blope_create_donation_button', array($this,'createDonationButton'));
        add_action('wp_ajax_blope_edit_donation_button', array($this, 'editDonationButton'));
        add_action('wp_ajax_blope_delete_donation_button', array($this, 'deleteDonationButton'));
        add_action('wp_ajax_blope_load_style_button', array($this, 'loadStyleButton'));
        add_action('wp_ajax_blope_get_list_buttons', array($this, 'getListButtons'));

    }

    public function adminInit()
    {
        wp_enqueue_style('blope-reset-css', plugins_url('assets/css/reset.min.css', dirname(__FILE__)), null, BLOPE_VERSION );
        wp_register_style('blope-admin-css', plugins_url('/assets/css/admin.css', dirname(__FILE__)), null, BLOPE_VERSION);
    }

    public function addMenuPages()
    {

        // Add the top-level admin menu
        $page_title = 'Bloks Stripe Donation';
        $menu_title = 'Bloks Stripe';
        $capability = 'manage_options';
        $menu_slug = 'blope-donations';
        $function = array($this,'adminDonationButtonsPage');
        $icon_url = plugins_url('assets/images/logo.png', dirname(__FILE__));
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, 30);

        // Add sub menu page with same slug as parent to ensure no duplicates
        $sub_menu_title = 'Donation Buttons';
        $menu_hook = add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, $function);
        add_action('admin_print_scripts-' . $menu_hook, array($this, 'adminScripts')); //this ensures script/styles only loaded for this plugin admin pages

        $submenu_page_title = 'Bloks Stripe Settings';
        $submenu_title = 'Settings';
        $submenu_slug = 'blope-settings';
        $submenu_function = array($this,'adminSettingsPage');
        $menu_hook = add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);
        add_action('admin_print_scripts-' . $menu_hook, array($this, 'adminScripts'));


    }

    public function adminScripts()
    {
        wp_enqueue_media();
        wp_enqueue_script( 'blope-admin-js', plugins_url( '/assets/js/admin.js', dirname( __FILE__ ) ), array(
            'jquery',
            'jquery-ui-tabs',
            'jquery-ui-core',
            'jquery-ui-widget',
            'jquery-ui-accordion',
            'jquery-ui-autocomplete',
            'jquery-ui-button',
            'jquery-ui-tooltip',
            'jquery-ui-sortable'
        ), BLOPE_VERSION);
        wp_enqueue_script( 'blope-ddslick-js', plugins_url( '/assets/js/jquery.ddslick.min.js', dirname( __FILE__ ) ), array('blope-admin-js'), BLOPE_VERSION);
        wp_enqueue_script( 'blope-tooltipster-js', plugins_url( '/assets/js/tooltipster.bundle.min.js', dirname( __FILE__ ) ), array('blope-admin-js'), BLOPE_VERSION);
        wp_enqueue_script( 'blope-customizer-js', plugins_url( '/assets/js/customizer.js', dirname( __FILE__ ) ), array('blope-admin-js'), BLOPE_VERSION);

        // replace https with http for admin-ajax calls for SSLed backends
        $admin_url = admin_url('admin-ajax.php');
        wp_localize_script('blope-admin-js', 'admin_ajaxurl', ( is_ssl() ? str_replace('http:', 'https:', $admin_url) : str_replace('https:', 'http:', $admin_url) ));
        wp_localize_script('blope-admin-js', 'xblope_security', wp_create_nonce( 'xblope-nonce' ));
        wp_enqueue_style('blope-reset-css', plugins_url('/assets/css/reset.min.css', dirname(__FILE__)), null, BLOPE_VERSION);
//        wp_enqueue_style('blope-admin-css', plugins_url('/assets/css/admin.css', dirname(__FILE__)), null, BLOPE_VERSION);
        wp_enqueue_style('blope-tooltipster-css', plugins_url('/assets/css/tooltipster.bundle.min.css', dirname(__FILE__)), null, BLOPE_VERSION);
        wp_enqueue_style('blope-animate-css', plugins_url('/assets/css/animate.min.css', dirname(__FILE__)), null, BLOPE_VERSION);
    }

    public function loadAdminScripts($hook)
    {
        // Load only on ?page=blope-donations and ?page=blope-settings
        if($hook == 'toplevel_page_blope-donations' || $hook == 'toplevel_page_blope-settings') {

        }
        wp_enqueue_style('blope-admin-css', plugins_url('/assets/css/admin.css', dirname(__FILE__)), null, BLOPE_VERSION);
    }

    public function adminSettingsPage()
    {
        if (!current_user_can('manage_options'))
            wp_die('You do not have sufficient permissions to access this page.');

        include BLOPE_PATH . '/templates/pages/settings.page.php';
    }

    public function adminDonationButtonsPage()
    {
        if (!current_user_can('manage_options'))
            wp_die('You do not have sufficient permissions to access this page.');

        $action = isset( $_GET[ 'act' ] ) ? sanitize_text_field($_GET[ 'act' ]) : '';
        switch (TRUE)
        {
            case ($action =='create' || $action == 'edit'):;
                include BLOPE_PATH . '/includes/animations.php';
                include BLOPE_PATH . '/templates/pages/edit.button.page.php';
                break;
            default:
                include BLOPE_PATH . '/templates/pages/list.buttons.page.php';
                break;

        }
    }

    public static function getListOptionStyle($active)
    {
        $styleFolder = BLOPE_PATH . '/templates/buttons/';
        $systemFolder = array(".", "..", ".htaccess", ".htpasswd");
        $listStyles = scandir($styleFolder);
        $list_option = '';
        $buttonStyleUrl = BLOPE_URL.'templates/buttons/';
        if(!empty($listStyles)) {
            foreach ($listStyles as $styleName) {
                if(is_dir($styleFolder.$styleName) && !in_array($styleName, $systemFolder) && file_exists($styleFolder.$styleName . DIRECTORY_SEPARATOR. 'layout.php') ) {
                    $title = $styleName;
                    $configFile = $styleFolder.$styleName . DIRECTORY_SEPARATOR. 'config.php';
                    if(file_exists($configFile)) {
                        $config = include $configFile;
                        if(!empty($config) && !empty($config['title'])) {
                            $title = $config['title'];
                        }

                        $desc = isset($config['desc']) ? $config['desc'] : 'Another awesome style!';
                    }
                    $attrs = '';
                    $previewImg = $buttonStyleUrl.'preview.png';
                    if(file_exists($styleFolder.$styleName . DIRECTORY_SEPARATOR. 'preview.png')) {
                        $previewImg = $buttonStyleUrl.$styleName.'/preview.png';
                    }

                    $attrs[] = 'data-imagesrc="'.$previewImg.'"';
                    $attrs[] = 'data-description="'.$desc.'"';


                    $list_option .= '<option value="'. $styleName.'" '. ($styleName == $active?'selected="selected"':'').implode(' ', $attrs).'>';
                    $list_option .= ucwords($title);
                    $list_option .= '</option>';
                }
            }
        }
        return $list_option;
    }

    public function updateSettings()
    {
        // Save the posted value in the database
        $options = get_option('blope_options');
        $options['site_name'] = sanitize_text_field($_POST['site_name']);
        $options['site_desc'] = sanitize_textarea_field($_POST['site_desc']);
        $options['image_url'] = esc_url($_POST['image_url']);
        $options['publish_key_test'] = sanitize_text_field($_POST['publish_key_test']);
        $options['secret_key_test'] = sanitize_text_field($_POST['secret_key_test']);
        $options['publish_key_live'] = sanitize_text_field($_POST['publish_key_live']);
        $options['secret_key_live'] = sanitize_text_field($_POST['secret_key_live']);
        $options['mode'] = sanitize_text_field($_POST['mode']);
        $options['currency'] = sanitize_text_field($_POST['currency']);
        $options['locale'] = sanitize_text_field($_POST['locale']);

        // $options['transient_expiration'] = sanitize_text_field($_POST['transient_expiration']);

        update_option('blope_options', $options);

        wp_send_json(array('success' => true));

    }

    public function createDonationButton()
    {

        $button_custom_amount = (int)$_POST['button_custom_amount'];
        $button_amount = isset($_POST['button_amount'])?(int)$_POST['button_amount']:0;
        $button_title = isset($_POST['button_title'])?sanitize_text_field(stripslashes_deep($_POST['button_title'])):'';
        $button_desc = isset($_POST['button_desc'])?sanitize_textarea_field(stripslashes_deep($_POST['button_desc'])):'';
        $button_success_message = isset($_POST['button_success_message'])?sanitize_textarea_field(stripslashes_deep($_POST['button_success_message'])):'';
        $button_store_desc = isset($_POST['button_store_desc'])?sanitize_textarea_field(stripslashes_deep($_POST['button_store_desc'])):'';
        $button_style = sanitize_text_field($_POST['button_style']);
        $button_css = isset($_POST['button_css'])?wp_filter_nohtml_kses($_POST['button_css']):'';
        $button_animate = sanitize_text_field($_POST['button_animate']);
        $button_panel_label = isset($_POST['button_panel_label'])?sanitize_text_field(stripslashes_deep($_POST['button_panel_label'])):'';
        $success_redirect_url = isset($_POST['success_redirect_url'])?esc_url_raw($_POST['success_redirect_url']):'';
        $failure_redirect_url = isset($_POST['failure_redirect_url'])?esc_url_raw($_POST['failure_redirect_url']):'';
        $enable_billing_address = (int)$_POST['enable_billing_address'];
        $enable_shipping = (int)$_POST['enable_shipping'];
        $enable_zip_code = (int)$_POST['enable_zip_code'];
        $enable_remember = (int)$_POST['enable_remember'];
        $enable_bitcoin = (int)$_POST['enable_bitcoin'];

        $data = array(
            'button_custom_amount' => $button_custom_amount,
            'button_amount' => $button_amount * 100,
            'button_title' => $button_title,
            'button_desc' => $button_desc,
            'button_style' => $button_style,
            'button_css' => $button_css,
            'button_animate' => $button_animate,
            'button_panel_label' => $button_panel_label,
            'button_success_message' => $button_success_message,
            'button_store_desc' => $button_store_desc,
            'success_redirect_url' => $success_redirect_url,
            'failure_redirect_url' => $failure_redirect_url,
            'enable_billing_address' => $enable_billing_address,
            'enable_shipping' => $enable_shipping,
            'enable_zip_code' => $enable_zip_code,
            'enable_remember' => $enable_remember,
            'enable_bitcoin' => $enable_bitcoin
        );


        $this->db->insertDonationButton($data);

        wp_send_json(array(
            'success' => true,
            'message' => __('Button created.', 'blope'),
            'doRedirect' => true,
            'redirectURL' => admin_url('admin.php?page=blope-donations')
        ));
    }

    public function editDonationButton()
    {
        $button_id = sanitize_key($_POST['button_id']);
        $button_custom_amount = (int)$_POST['button_custom_amount'];
        $button_amount = isset($_POST['button_amount'])?(int)$_POST['button_amount']:0;
        $button_title = isset($_POST['button_title'])?sanitize_text_field(stripslashes_deep($_POST['button_title'])):'';
        $button_desc = isset($_POST['button_desc'])?sanitize_textarea_field(stripslashes_deep($_POST['button_desc'])):'';
        $button_success_message = isset($_POST['button_success_message'])?sanitize_textarea_field(stripslashes_deep($_POST['button_success_message'])):'';
        $button_store_desc = isset($_POST['button_store_desc'])?sanitize_textarea_field(stripslashes_deep($_POST['button_store_desc'])):'';
        $button_style = sanitize_text_field($_POST['button_style']);
        $button_css = isset($_POST['button_css'])?wp_filter_nohtml_kses($_POST['button_css']):'';
        $button_animate = sanitize_text_field($_POST['button_animate']);
        $button_panel_label = isset($_POST['button_panel_label'])?sanitize_text_field(stripslashes_deep($_POST['button_panel_label'])):'';
        $success_redirect_url = isset($_POST['success_redirect_url'])?esc_url_raw($_POST['success_redirect_url']):'';
        $failure_redirect_url = isset($_POST['failure_redirect_url'])?esc_url_raw($_POST['failure_redirect_url']):'';
        $enable_billing_address = (int)$_POST['enable_billing_address'];
        $enable_shipping = (int)$_POST['enable_shipping'];
        $enable_zip_code = (int)$_POST['enable_zip_code'];
        $enable_remember = (int)$_POST['enable_remember'];
        $enable_bitcoin = (int)$_POST['enable_bitcoin'];

        $data = array(
            'button_amount' => $button_amount * 100,
            'button_custom_amount' => $button_custom_amount,
            'button_title' => $button_title,
            'button_desc' => $button_desc,
            'button_style' => $button_style,
            'button_css' => $button_css,
            'button_animate' => $button_animate,
            'button_panel_label' => $button_panel_label,
            'button_success_message' => $button_success_message,
            'button_store_desc' => $button_store_desc,
            'success_redirect_url' => $success_redirect_url,
            'failure_redirect_url' => $failure_redirect_url,
            'enable_billing_address' => $enable_billing_address,
            'enable_shipping' => $enable_shipping,
            'enable_zip_code' => $enable_zip_code,
            'enable_remember' => $enable_remember,
            'enable_bitcoin' => $enable_bitcoin
        );


        $this->db->updateDonationButton($button_id, $data);

        wp_send_json(array(
            'success' => true,
            'message' => __('Button saved.', 'blope'),
            'doRedirect' => false,
            'redirectURL' => admin_url('admin.php?page=blope-donations&act=edit&bid='. $button_id)
        ));
    }

    /**
     *  Delete button by button id
     */
    public function deleteDonationButton()
    {
        $id = sanitize_key($_POST['id']);

        $this->db->deleteDonationButton($id);
        wp_send_json(array(
                'success' => true,
                'message' => __('Button deleted.', 'blope'),
            )
        );

    }

    public function loadStyleButton()
    {
        // check for nonce
        check_ajax_referer( 'xblope-nonce', 'security' );

        $id = isset($_POST['id']) ? sanitize_key($_POST['id']) : 0;
        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 0;
        $style = isset($_POST['style']) ? sanitize_text_field($_POST['style']) : 'basic';
        $desc = isset($_POST['desc']) ? sanitize_text_field($_POST['desc']) : '';
        $flexible = isset($_POST['flexible']) ? (int)$_POST['flexible'] : 0;

        $buttonData = new stdClass();
        $buttonData->button_title = $title;
        $buttonData->button_amount = $amount;
        $buttonData->button_id = $id;
        $buttonData->button_style = $style;
        $buttonData->button_desc = $desc;
        $buttonData->button_custom_amount = $flexible;

        //get the button style
        $content = blopeGetButtonOutput($buttonData);

        wp_send_json(array(
            'success' => true,
            'html' => stripslashes_deep($content)
        ));
    }

    public function blopeRegisterWidget()
    {
        register_widget( 'Bloks_Stripe_Widget' );
    }

    public function loadEditorButtons()
    {

        add_filter( "mce_external_plugins", array($this, 'addEditorButtons') );
        add_filter( 'mce_buttons', array($this, 'registerEditorButtons') );
    }

    public function pluginAddSettingsLink($links)
    {
        $settings_link = array(
            '<a href="' . admin_url( 'admin.php?page=blope-settings' ) . '">' . __( 'Settings', 'blope' ) . '</a>',
        );
        return array_merge( $links, $settings_link );
    }

    /**
     * Add button to editor
     *
     * @param $plugin_array
     *
     * @return mixed
     */
    public function addEditorButtons( $plugin_array ) {
        $plugin_array['blope'] = plugins_url( '/assets/js/plugin.js', dirname( __FILE__ ) );
        return $plugin_array;
    }

    /**
     * Register button to editor
     *
     * @param $buttons
     *
     * @return mixed
     */
    public function registerEditorButtons( $buttons ) {
        array_push( $buttons, 'blope' ); // blokstripe'
        return $buttons;
    }

    /**
     * Function to output button list ajax script
     * @since  1.0
     * @return string
     */
    public function assignButtonslist() {
        // create nonce
        global $pagenow;
        if( $pagenow != 'admin.php' ){
            $nonce = wp_create_nonce( 'xblope-nonce' );
            ?>
            <script type="text/javascript">
                jQuery( document ).ready( function( $ ) {
                    var data = {
                        'action'	: 'blope_get_list_buttons', // wp ajax action
                        'security'	: '<?php echo $nonce; ?>' // nonce value created earlier
                    };
                    // fire ajax
                    jQuery.post( ajaxurl, data, function( response ) {
                        // if nonce fails then not authorized else settings saved
                        if( response === '-1' ){
                            // do nothing
                            console.log('error');
                        } else {
                            if (typeof(tinyMCE) != 'undefined') {
                                if (tinyMCE.activeEditor != null) {
                                    tinyMCE.activeEditor.settings.blopeButtonsList = response;
                                }
                            }
                        }
                    });
                });
            </script>
            <?php
        }
    }

    /**
     * Function to fetch buttons
     * @since  1.0
     * @return string
     */
    public function getListButtons()
    {
        // check for nonce
        check_ajax_referer( 'xblope-nonce', 'security' );

        $buttons = $this->db->getListButtons();

        $list = array();
        if($buttons) {
            foreach ( $buttons as $btn ) {
                $selected = '';

                $list[] = array(
                    'text' =>	$btn->button_title,
                    'value'	=>	$btn->button_id
                );
            }
        }

        wp_send_json( $list );
    }

}
