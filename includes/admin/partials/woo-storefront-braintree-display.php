<h1>Braintree Server Settings</h1>

<form action="<?php echo esc_url( admin_url( 'admin-post.php') ); ?>" method="post" id="woo-storefront-braintree-settings-form">
	<br>
    <fieldset>
        <legend>
            <h3>Sandbox Credentials</h3>
            <p>It's recommended that you set these credentials first and test your Braintree configuration in a sandboxed environment before you go live.</p>
        </legend>
        <br>
        Merchant ID:
        <br>
        <input title="Merchant ID" type="text" name="sandbox_merchant_id">
        <br>
        Public Key:
        <br>
        <input title="Public Key" type="text" name="sandbox_public_key">
        <br>
        Private Key
        <br>
        <input title="Private Key" type="text" name="sandbox_private_key">
    </fieldset>
    <br>
	<fieldset>
		<legend>
			<h3>Production Credentials</h3></legend>
		<br>
		Merchant ID:
		<br>
		<input title="Merchant ID" type="text" name="production_merchant_id">
		<br>
		Public Key:
		<br>
		<input title="Public Key" type="text" name="production_public_key">
		<br>
		Private Key
		<br>
		<input title="Private Key" type="text" name="production_privateKey">
	</fieldset>
	<br>
	<fieldset>
		<legend>
			<h3>Build Environment:</h3></legend>
		<br>
		<input title="Sandbox Environment" type="radio" name="sandboxToggle" value="sandbox" checked> Sandbox Environment
		<br>
		<input title="Production Environment" type="radio" name="sandboxToggle" value="production"> Production Environment
		<br>
	</fieldset>
	<br>
	<p><input type="submit" value="Save"></p>

</form>