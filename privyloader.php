<?php
/*
Plugin Name: Privy Widget Loader
Plugin URI: http://getprivy.com/
Description: Easily integrate the Privy merchant widget (getprivy.com).
Version: 0.0.1
Author: gantastic
License: GPL2
*/

define('PRIVY_LOADER_VERSION', '0.0.1');

if ( is_admin() )
	require_once dirname( __FILE__ ) . '/admin.php';

wp_enqueue_script( "privy_widget", "http://getprivy.com/widget/".get_option('privy_merchant_id').".js" );

?>