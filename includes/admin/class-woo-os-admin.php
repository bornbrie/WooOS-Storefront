<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/bornbrie
 * @since      1.0.0
 *
 * @package    Woo_Os
 * @subpackage Woo_Os/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Os
 * @subpackage Woo_Os/admin
 * @author     Brianna Lee <bornbrie@icloud.com>
 */
class Woo_OS_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Os_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Os_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-os-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Os_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Os_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-os-admin.js', array('jquery'), $this->version, false);

    }

    /**
     * Add the settings page in the admin menu.
     */
    public function add_plugin_admin_menu()
    {
    	add_menu_page(
    		'WooOS',
		    'WooOS',
		    'manage_woocommerce',
		    'woo-os',
		    array($this, 'display_admin')
	    );
    }

    public function options_update()
    {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }

    public function add_action_links($links)
    {
        $settings_link = array(
            '<a href"' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>'
        );
        return array_merge($settings_link, $links);
    }

    public function display_admin()
    {
	    if (!current_user_can('manage_options'))
	    {
		    wp_die( __('You do not have sufficient permissions to access this page. Please contact an admin of this site to gain access.') );
	    }

        include_once( 'partials/woo-os-main-page-display.php' );
    }

    public function handle_general_settings_form( $input )
    {

    }

    public function handle_authentication_settings_form( $input )
    {

    }

    public function handle_braintree_settings_form( $input )
    {

	    $gateway = new Braintree_Gateway([
		    'environment' => 'sandbox',
		    'merchantId' => $input['merchant_id'],
		    'publicKey' => $input['public_key'],
		    'privateKey' => $input['private_key']
	    ]);

    	$customerId = get_current_user_id();

	    $clientToken = $gateway->clientToken()->generate([
		    "customerId" => $customerId
	    ]);

	    echo($clientToken);
    }


}