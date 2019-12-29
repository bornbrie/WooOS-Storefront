<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/bornbrie
 * @since             1.0.0
 * @package           WooStorefront
 *
 * @wordpress-plugin
 * Plugin Name:       WooStorefront
 * Plugin URI:        https://github.com/bornbrie/WooStorefront
 * Description:       WooStorefront enables a set of public facing WooCommerce API endpoints, extended using the WP-API protocols. It allows both a browse and checkout flow for your WooCommerce store via the API while logged in as a customer.
 * Version:           1.0.0
 * Author:            Brianna Lee
 * Author URI:        https://github.com/bornbrie
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-storefront
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOO_STOREFRONT_V1', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require dirname( __FILE__ ) . '/includes/class-woo-os.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_storefront() {

	$plugin = new Woo_Storefront();
	$plugin->run();

}
run_woo_storefront();
