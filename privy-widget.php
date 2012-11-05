<?php
/*
Plugin Name: Privy Widget
Plugin URI: http://privy.github.com/privy-wp-plugin/
Description: This plugin adds the Privy javascript widget to all of your pages.
Version: 1.0
Author: Privy
Author URI: http://getprivy.com
License: MIT
*/

/*
Copyright (c) 2012 Privy

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

add_action('admin_menu', 'privy_create_settings_page');

function privy_create_settings_page() {
	add_options_page('Privy Widget', 'Privy Widget', 'manage_options', 'privy_settings_page', 'privy_settings_page');
}

add_action( 'admin_init', 'register_privy_settings' );

function register_privy_settings() {
	register_setting( 'privy-settings-group', 'business_identifier', 'privy_settings_validate' );
}

function privy_settings_page() {
	?>
	<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Privy Widget Plugin</h2>
	<br/>
	<form method="post" action="options.php"> 
	<?php
		settings_fields( 'privy-settings-group' );
		do_settings_fields( 'privy-settings-group' );
	?>
	<label>Your business identifier:</label><br/>
	<input type="text" name="business_identifier" value="<?php echo get_option('business_identifier'); ?>" />

	<?php submit_button(); ?>
	</form>
	</div>
	<?php
}

function privy_settings_validate($input) {
	$newinput = $input;
	if(!preg_match('/^[a-z0-9]{24}$/i', $newinput)) {
		$newinput = '';
	}
	return $newinput;
}

function privy_widget() {
	wp_enqueue_script('privy-widget', plugins_url('privy-widget.js', __FILE__));
	$params = array('business_identifier' => get_option('business_identifier'));
	wp_localize_script('privy-widget', 'PrivyWidgetParams', $params);
}

add_action('wp_footer', 'privy_widget');

?>