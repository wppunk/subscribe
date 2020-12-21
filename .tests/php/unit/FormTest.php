<?php

namespace SubscribeTest;

use PHPUnit\Framework\TestCase;
use Subscribe\Form;

/**
 * Class FormTest
 *
 * @package SubscribeTest
 */
class FormTest extends TestCase {

	/**
	 * Test add_hooks().
	 */
	public function test_add_hooks() {
		$subject = \Mockery::mock( Form::class );

		\WP_Mock::userFunction( 'add_shortcode' )->with( 'subscribe_form', [ $subject, 'view' ] );

		\WP_Mock::expectActionAdded( 'wp_ajax_subscribe_form', [ $subject, 'ajax_callback' ] );
		\WP_Mock::expectActionAdded( 'wp_ajax_nopriv_subscribe_form', [ $subject, 'ajax_callback' ] );
	}
}
