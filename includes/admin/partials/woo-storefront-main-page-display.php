<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/bornbrie
 * @since      1.0.0
 *
 * @package    Woo_Os
 * @subpackage Woo_Os/admin/partials
 */

function woo_os_admin_tabs_content( $current = 'general' ) {
	$tabs = array(
		'general'   => __( 'General', 'plugin-textdomain' ),
		'authentication'  => __( 'Client Authentication', 'plugin-textdomain' ),
        'braintree' => __( 'Braintree Token', 'plugin-textdomain' )
	);
	$html = '<h2 class="nav-tab-wrapper">';
	foreach( $tabs as $tab => $name ){
		$class = ( $tab == $current ) ? 'nav-tab-active' : '';
		$html .= '<a class="nav-tab ' . $class . '" href="?page=woo-os&tab=' . $tab . '">' . $name . '</a>';
	}
	$html .= '</h2>';
	echo $html;
}

?>

    <br>
    <img src="<?php echo plugin_dir_url( dirname(__FILE__ ) ) . 'images/woo_os_logo.png' ?>" width="25%">

    <?php settings_fields($this->plugin_name); ?>

    <?php
        $tab = ( ! empty( $_GET['tab'] ) ) ? esc_attr( $_GET['tab'] ) : 'general';
        woo_os_admin_tabs_content( $tab );

        if ( $tab == 'general' ) {
            include_once('woo-storefront-general-settings-display.php');

        }
        else if ( $tab == 'authentication' ) {
	        include_once('woo-storefront-authentication-display.php');

        }
        else if ( $tab == 'braintree' ) {
	        include_once('woo-storefront-braintree-display.php');

        }
        else {
	        echo '<p>The selected tab does not have any content, because the selected tab does not exist!</p>';
        }
    ?>