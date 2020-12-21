<?php
/**
 * Bootstrap file for unit tests that run before all tests.
 *
 * @since   {VERSION}
 * @link    {URL}
 * @license GPLv2 or later
 * @package PluginName
 * @author  {AUTHOR}
 */

use tad\FunctionMocker\FunctionMocker;

define( 'SUBSCRIBE_VERSION', '1.0.0' );
define( 'SUBSCRIBE_PATH', realpath( __DIR__ . '/../../../' ) . '/' );
define( 'SUBSCRIBE_URL', 'https://site.com/wp-content/plugins/subscribe/' );
define( 'ABSPATH', realpath( SUBSCRIBE_PATH . '../../' ) . '/' );

FunctionMocker::init(
	[
		'blacklist'             => [
			realpath( SUBSCRIBE_PATH ),
		],
		'whitelist'             => [
			realpath( SUBSCRIBE_PATH . '/subscribe.php' ),
			realpath( SUBSCRIBE_PATH . '/src' ),
			realpath( SUBSCRIBE_PATH . '/.tests/php/unit/stubs' ),
		],
		'redefinable-internals' => [
			'filter_input',
		],
	]
);

\WP_Mock::bootstrap();

