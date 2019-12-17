<?php
/**
 * Created by PhpStorm.
 * User: brianna
 * Date: 5/6/18
 * Time: 7:26 PM
 */
?>

<h1>General Settings</h1>

<form action="<?php echo esc_url( admin_url( 'admin-post.php') ); ?>" method="post" id="woo-os-general-settings-form">
	<br>
	<fieldset>
		<legend>
			<h3>WooCommerce Settings</h3>
		</legend>
        <br>
        Client Key <input title="Client Key" type="text" name="client_key">
        <br>
        Client Secret <input title="Client Secret" type="text" name="client_secret">
	</fieldset>
	<p><input type="submit" value="Save"></p>
</form>