<?php
 /**
  * WooStorefront REST API for WooCommerce
  *
  * Handles public product endpoints requests for WC-API.
  *
  * @author   Brianna Lee
  * @category API
  * @package  Cart REST API for WooCommerce/API
  * @since    1.0.0
  * @version  1.0.1
  */

 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }

 /**
  * Woo_Storefront_REST_API class.
  */
 class Woo_Storefront_Rest_API {

 	/**
 	 * Init WooStorefront REST API.
 	 *
 	 * @access  private
 	 * @since   1.0.0
 	 * @version 1.0.3
 	 */
 	public function woo_storefront_rest_api_init() {
 		// REST API was included starting WordPress 4.4.
 		if ( ! class_exists( 'WP_REST_Server' ) ) {
 			return;
 		}

 		$this->include_products_controller();
 		$this->include_categories_controller();

 		// Init WooOS Public REST API routes.
 		add_action( 'rest_api_init', array( $this, 'register_products_routes' ) );
 		add_action( 'rest_api_init', array( $this, 'register_categories_routes' ) );
 	}

 	/**
 	 * Include Products REST API controller.
 	 *
 	 * @access private
 	 * @since  1.0.0
 	 */
 	private function include_products_controller() {
 		// REST API v2 controller.
 		include_once( dirname( __FILE__ ) . '/class-woo-storefront-products-rest-controller.php' );
 	} // include()

 	/**
 	 * Register Products REST API routes.
 	 *
 	 * @access public
 	 * @since  1.0.0
 	 */
 	public function register_products_routes() {
 		$controller = new Woo_Storefront_Products_REST_Controller();
 		$controller->register_routes();
 	} // END register_products_routes

	 /**
	  * Include Product Categories REST API controller.
	  *
	  * @access private
	  * @since  1.0.0
	  */
	 private function include_categories_controller() {
		 // REST API v2 controller.
		 include_once( dirname( __FILE__ ) . 'class-woo-storefront-products-rest-controller.php' );
	 } // include()

	 /**
	  * Register Cart REST API routes.
	  *
	  * @access public
	  * @since  1.0.0
	  */
	 public function register_categories_routes() {
 		$controller = new Woo_Storefront_Categories_REST_Controller();
 		$controller->register_routes();
	 }

 } // END class