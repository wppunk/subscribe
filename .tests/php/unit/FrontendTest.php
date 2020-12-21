<?php
/**
 * FrontendTest class file.
 *
 * @package Subscribe\Tests
 */

namespace Subscribe\Tests;

use Subscribe\Frontend;
use WP_Mock;

/**
 * Class FrontendTest
 */
class FrontendTest extends SubscribeTestCase {

	/**
	 * Test add_hooks().
	 */
	public function test_add_hooks() {
		$subject = new Frontend();

		WP_Mock::expectActionAdded( 'wp_enqueue_scripts', [ $subject, 'enqueue_styles' ] );
		WP_Mock::expectActionAdded( 'wp_enqueue_scripts', [ $subject, 'enqueue_scripts' ] );

		$subject->add_hooks();
	}

	/**
	 * Test enqueue_styles().
	 */
	public function test_enqueue_styles() {
		$subject = new Frontend();

		WP_Mock::userFunction( 'wp_enqueue_style' )->with(
			'subscribe',
			SUBSCRIBE_URL . 'assets/css/main.css',
			[],
			SUBSCRIBE_VERSION,
		)->once();

		$subject->enqueue_styles();
	}

	/**
	 * Test enqueue_scripts().
	 */
	public function test_enqueue_scripts() {
		$subject = new Frontend();

		WP_Mock::passthruFunction( 'admin_url' );

		WP_Mock::userFunction( 'wp_enqueue_script' )->with(
			'subscribe',
			SUBSCRIBE_URL . 'assets/js/main.js',
			[ 'jquery' ],
			SUBSCRIBE_VERSION,
			true
		)->once();

		WP_Mock::userFunction( 'wp_localize_script' )->with(
			'subscribe',
			'subscribeVars',
			[
				'adminUrl' => 'admin-ajax.php',
			]
		)->once();

		$subject->enqueue_scripts();
	}
}
