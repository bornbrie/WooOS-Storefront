<?php
/**
 * Created by PhpStorm.
 * User: brianna
 * Date: 5/4/18
 * Time: 4:04 PM
 */

class Woo_OS_Categories_REST_Controller extends WC_REST_Product_Categories_Controller {

	protected $namespace = 'wc/v2';
	protected $route = '/products/categories/public';

	/**
	 * Register the routes for the endpoints of the controller.
	 */
	public function register_routes() {

		/**
		 * GET all product categories
		 */
		register_rest_route( $this->namespace, $this->route, array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_all_public_categories' ),
					'permission_callback' => array( $this, 'get_all_public_categories_permissions_check' )
				)
			)
		);
	}

	/**
	 * Get a collection of products
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_all_public_categories( $request ) {

		$orderby = 'name';
		$order = 'asc';
		$hide_empty = false ;
		$cat_args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
		);

		$categories = get_terms( 'product_cat', $cat_args );

		$data = array();
		foreach ( $categories as $category ) {
			$categorydata = parent::prepare_item_for_response( $category, $request );
			$data[]   = parent::prepare_response_for_collection( $categorydata );
		}

		if ( empty( $data ) ) {
			return new WP_Error( 'No categories found', __( 'The requested product categories were not found', array( 'status' => '200' ) ) );
		}

		return new WP_REST_Response( $data, 200 );
	}

	/**
	 * Check if a given request has access to get items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|bool
	 */
	public function get_public_categories_permissions_check( $request ) {
		return true;
	}

	/**
	 * Sets up the proper HTTP status code for authorization.
	 *
	 * @return int
	 */
	public function authorization_status_code() {
		$status = 401;
		if ( is_user_logged_in() ) {
			$status = 403;
		}

		return $status;
	}

}

function register_woo_os_public_products_REST_controller() {
	$controller = new Woo_OS_Categories_REST_Controller();
	$controller->register_routes();
}