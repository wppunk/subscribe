<?php
/**
 * Plugin Name:       Subscribe
 * Description:       Subscribe form.
 * Requires at least: 4.9
 * Requires PHP:      5.6
 * Author:            WPPunk, Kagg Design
 * Version:           1.0.0
 * Text Domain:       subscribe
 */

use Subscribe\Form;
use Subscribe\Database;
use Subscribe\Frontend;

define( 'SUBSCRIBE_VERSION', '1.0.0' );
define( 'SUBSCRIBE_PATH', plugin_dir_path( __FILE__ ) );
define( 'SUBSCRIBE_URL', plugin_dir_url( __FILE__ ) );

function subscribe_form() {

	require SUBSCRIBE_PATH . 'vendor/autoload.php';

	( new Form( new Database() ) )->add_hooks();
	( new Frontend() )->add_hooks();
}

add_action( 'plugins_loaded', 'subscribe_form' );

function subscribe_activate() {

	require SUBSCRIBE_PATH . 'vendor/autoload.php';

	Database::create_table();
}

register_activation_hook( __FILE__, 'subscribe_activate' );
