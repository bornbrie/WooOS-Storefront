<?php
/**
 * Created by PhpStorm.
 * User: brianna
 * Date: 5/6/18
 * Time: 8:47 PM
 */

class Woo_OS_Braintree_Controller
{
	var $is_sandboxed;

	/**
	 * @param mixed $is_sandboxed
	 */
	public function setIsSandboxed( $is_sandboxed ) {
		$this->is_sandboxed = $is_sandboxed;
	}

	var $sandbox_merchant_id;
	var $sandbox_public_key;
	var $sandbox_private_key;

	var $production_merchant_id;
	var $production_public_key;
	var $production_private_key;

	/**
	 * var: gateway: Briantree_Gateway instance for accessing the nonce and transaction tokens.
	 */
	var $gateway;

	/**
	 * The environment that the braintree instance is running in.
	 *
	 * @return string: 'sandbox' or 'production'
	 */
	private function environment() {
		return $this->is_sandboxed ? 'sandbox' : 'production';
	}

	function merchant_id() {
		return $this->is_sandboxed ? $this->sandbox_merchant_id : $this->production_merchant_id;
	}

	function public_key() {
		return $this->is_sandboxed ? $this->sandbox_public_key : $this->production_public_key;
	}

	/**
	 * @return String
	 */
	function private_key() {
		return $this->is_sandboxed ? $this->sandbox_private_key : $this->production_private_key;
	}

	/**
	 * Woo_Os_Braintree_Controller constructor.
	 *
	 * @param $sandboxed
	 * @param $merchant_id
	 * @param $public_key
	 * @param $private_key
	 */
	function __construct( $sandboxed, $merchant_id, $public_key, $private_key ) {

		$this->is_sandboxed = $sandboxed;

		if ( $this->is_sandboxed ) {
			$this->sandbox_merchant_id = $merchant_id;
			$this->sandbox_public_key  = $public_key;
			$this->sandbox_private_key = $private_key;
		} else {
			$this->production_merchant_id = $merchant_id;
			$this->production_public_key  = $public_key;
			$this->production_private_key = $private_key;
		}

		$this->gateway = new Braintree_Gateway([
			'environment' => $this->environment(),
			'merchantId' => $this->merchant_id(),
			'publicKey' => $this->public_key(),
			'privateKey' => $this->private_key()
		]);

		$clientToken = $this->gateway->clientToken()->generate([
			'customerId' => 'get_current_user_id()'
		]);
	}

	function braintree_activate() {
		$this->createTable();
	}

	function generateRandomString( $length = 9 ) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()+|}{":?><.,/`~-=';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		/**
		 * Now check here if the string is in the database
		 * I am using two custom functions is_string_available() and save_string_into_db
		 * You have to write this function to check with the database
		 */
		if( is_string_available( $randomString ) ){
			save_string_into_db( $randomString );
			return $randomString;
		} else {
			$this->generateRandomString();
		}
	}

	function is_string_available( $randomString ) {
		global $wpdb;

		// Write code to check if the string is available in DB
		$mysqli = new mysqli(SERVER, DBUSER, DBPASS, DATABASE);
		$result = $mysqli->query("SELECT id FROM $wpdb->prefix . 'woo_os' WHERE braintree_token = $randomString");
		if ( $result->num_rows == 0)
		{
			// Nothing found, safe to write string to db.
			return true;

		} else {
			// Found existing row.
			return false;
		}

	}

	function save_string_into_db( $randomString ) {
		global $wpdb;

		$current_user_id = get_current_user_id();

		$table_name = $wpdb->prefix . 'woo_os';
		$wpdb->insert(
			$table_name,
			array(
				'id' => $current_user_id,
				'braintree_key' => $randomString
			)
		);
	}
}

register_activation_hook(__FILE__, $this->braintree_activate());