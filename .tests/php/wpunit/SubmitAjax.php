<?php

namespace Subscribe\Tests\WPUnit;

use Codeception\TestCase\WPAjaxTestCase;
use WPAjaxDieContinueException;

/**
 * Class SubmitAjax
 * @method expectException( string $class )
 * @method assertEquals( object $param, mixed $json_decode )
 */
class SubmitAjax extends WPAjaxTestCase {

	public function test_submit_without_email() {

		$_POST['nonce'] = wp_create_nonce( 'subscribe-form' );

		$this->expectException( WPAjaxDieContinueException::class );

		$this->_handleAjax( 'subscribe_form' );

		$this->assertEquals(
			(object) [
				'success' => false,
				'data'    => 'Invalid email address',
			],
			json_decode( $this->_last_response )
		);
	}

	public function test_submit_invalid_email() {

		$_POST['nonce'] = wp_create_nonce( 'subscribe-form' );
		$_POST['email'] = 'krya@krya';

		$this->expectException( WPAjaxDieContinueException::class );

		$this->_handleAjax( 'subscribe_form' );

		$this->assertEquals(
			(object) [
				'success' => false,
				'data'    => 'Invalid email address',
			],
			json_decode( $this->_last_response )
		);
	}

	public function test_submit() {

		$_POST['nonce'] = wp_create_nonce( 'subscribe-form' );
		$_POST['email'] = 'krya@krya.krya';

		$this->expectException( WPAjaxDieContinueException::class );

		$this->_handleAjax( 'subscribe_form' );

		$this->assertEquals(
			(object) [
				'success' => true,
				'data'    => 'Thank you for subscribing to the newsletter',
			],
			json_decode( $this->_last_response )
		);
	}
}

