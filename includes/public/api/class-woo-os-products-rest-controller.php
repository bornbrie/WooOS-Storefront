<?php
/**
 * Created by PhpStorm.
 * User: brianna
 * Date: 5/4/18
 * Time: 4:04 PM
 */

class Woo_OS_Products_REST_Controller extends WC_REST_Products_Controller {

	protected $namespace = '/wc/v2';
	protected $route = '/products/public';

	/**
	 * Register the routes for the products of the controller.
	 */
	public function register_routes() {

		/**
		 * GET Product Collection
		 * Register the REST route for listing a collection of products.
		 */
		register_rest_route( $this->namespace, $this->route, array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_public_products' ),
					'permission_callback' => array( $this, 'get_public_products_permissions_check' ),
					'args'                => $this->get_collection_params()
				)
			)
		);

		/**
		 * GET a product
		 * Register the REST Route for listing a single product.
		 */
		register_rest_route( $this->namespace, $this->route . '/(?P<id>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_public_product' ),
				'permission_callback' => array( $this, 'get_public_product_permissions_check' )
			)
		) );

	}

	/**
	 * Get a collection of products
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_public_products( $request ) {

		$params = $request->get_params();
		$args   = array(
			'status'            => 'publish',
			'include'           => $params( 'include' ),
			'exclude'           => $params( 'exclude' ),
			'parent'            => $params( 'parent' ),
			'parent_exclude'    => $params( 'parent_exclude' ),
			'limit'             => $params( 'limit' ),
			'page'              => $params( 'page' ),
			'paginate'          => $params( 'paginate' ),
			'offset'            => $params( 'offset' ),
			'order'             => $params( 'order' ),
			'orderby'           => $params( 'orderby' ),
			'sku'               => $params( 'sku' ),
			'tag'               => $params( 'tag' ),
			'category'          => $params( 'category' ),
			'weight'            => $params( 'weight' ),
			'length'            => $params( 'length' ),
			'width'             => $params( 'width' ),
			'height'            => $params( 'height' ),
			'price'             => $params( 'price' ),
			'regular_price'     => $params( 'regular_price' ),
			'sale_price'        => $params( 'sale_price' ),
			'featured'          => $params( 'featured' ),
			'sold_individually' => $params( 'sold_individually' ),
			'reviews_allowed'   => $params( 'reviews_allowed' ),
			'backorders'        => $params( 'backorders' ),
			'visibility'        => 'visible',
			'stock_status'      => 'instock',
			'average_rating'    => $params( 'average_rating' )
		);

		$products = wc_get_products( $args );

		$data = array();
		foreach ( $products as $item ) {
			$itemdata = parent::prepare_object_for_response( $item, $request );
			$data[]   = parent::prepare_response_for_collection( $itemdata );
		}

		if ( empty( $data ) ) {
			return new WP_Error( 'No products found', __( 'The requested products were not found', array( 'status' => '404' ) ) );
		}

		return new WP_REST_Response( $data, 200 );
	}

	/**
	 * Get one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_public_product( $request ) {
		//get parameters from request
		$request_params = $request->get_params();

		// Find ID of product
		$id = $request_params['id'];

		$product = wc_get_product( $id );

		if ( $product->is_downloadable() ) {
			return new WP_Error( 'Product is downloadable', __( 'The requested product is downloadable and not allowed in the public domain.', array( 'status' => '401' ) ) );
		}

		if ( ! $product->exists() ) {
			return new WP_Error( 'Product does not exist', __( 'The requested product does not exist', array( 'status' => '404' ) ) );
		}

		$data = parent::prepare_object_for_response( $product, $request );

		return new WP_REST_Response( $data, 200 );
	}

	/**
	 * Check if a given request has access to get items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|bool
	 */
	public function get_public_products_permissions_check( $request ) {
		return true;
	}

	/**
	 * Check if a given request has access to get a specific item
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|bool
	 */
	public function get_public_product_permissions_check( $request ) {
		return $this->get_public_products_permissions_check( $request );
	}

	/**
	 * Get the query params for collections
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return array(
			'include'        => array(
				'validate_callback' => function ( $param ) {
					return is_array( $param );
				}
			),
			'exclude'        => array(
				'validate_callback' => function ( $param ) {
					return is_array( $param );
				}
			),
			'parent'         => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'parent_exclude' => array(
				'validate_callback' => function ( $param ) {
					return is_array( $param );
				}
			),
			'limit'          => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'page'           => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'paginate'       => array(
				'validate_callback' => function ( $param ) {
					return is_bool( $param );
				}
			),
			'offset'         => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'order'          => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'orderby'        => array(
				'validate_callback' => function ( $param ) {
					return is_string( $param );
				}
			),
			'sku'            => array(
				'validate_callback' => function ( $param ) {
					return is_string( $param );
				}
			),
			'tag'            => array(
				'validate_callback' => function ( $param ) {
					return is_string( $param );
				}
			),
			'category'       => array(
				'validate_callback' => function ( $param ) {
					return is_string( $param );
				}
			),

			'search'            => array(
				'validate_callback' => function ( $param ) {
					return is_string( $param );
				}
			),
			'weight'            => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'length'            => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'width'             => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'height'            => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'price'             => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'regular_price'     => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'sale_price'        => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			),
			'featured'          => array(
				'validate_callback' => function ( $param ) {
					return is_bool( $param );
				}
			),
			'sold_individually' => array(
				'validate_callback' => function ( $param ) {
					return is_bool( $param );
				}
			),
			'reviews_allowed'   => array(
				'validate_callback' => function ( $param ) {
					return is_bool( $param );
				}
			),
			'backorders'        => array(
				'validate_callback' => function ( $param ) {
					return is_string( $param );
				}
			),
			'average_rating'    => array(
				'validate_callback' => function ( $param ) {
					return is_numeric( $param );
				}
			)
		);
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
