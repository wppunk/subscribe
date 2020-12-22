<?php
/**
 * FormTest class file.
 *
 * @package Subscribe\Tests
 */

namespace Subscribe\Tests\Unit;

use Subscribe\Database;
use Subscribe\Form;

use Mockery;
use tad\FunctionMocker\FunctionMocker;
use WP_Mock;

/**
 * Class FormTest
 */
class FormTest extends SubscribeTestCase {

	/**
	 * Test add_hooks().
	 */
	public function test_add_hooks() {
		$db      = Mockery::mock( Database::class );
		$subject = new Form( $db );

		WP_Mock::userFunction( 'add_shortcode' )->with( 'subscribe_form', [ $subject, 'view' ] );

		WP_Mock::expectActionAdded( 'wp_ajax_subscribe_form', [ $subject, 'ajax_callback' ] );
		WP_Mock::expectActionAdded( 'wp_ajax_nopriv_subscribe_form', [ $subject, 'ajax_callback' ] );

		$subject->add_hooks();
	}

	/**
	 * Test view().
	 */
	public function test_view() {
		$db      = Mockery::mock( Database::class );
		$subject = new Form( $db );

		WP_Mock::userFunction( 'wp_create_nonce' )->with( 'subscribe-form' )->andReturn( 'ddeeffcc' );

		$expected = '		<form action="" method="POST" class="subscribe-form">
			<input type="hidden" name="subscribe_nonce" value="ddeeffcc">
			<input type="email" name="email" required="required" placeholder="Your email address">
			<input type="submit" value="Subscribe">
			<div class="subscribe-message" style="display: none"></div>
		</form>
		';

		$this->assertSame( $expected, $subject->view() );
	}

	/**
	 * Test ajax_callback().
	 *
	 * @param string $email            Email.
	 * @param int    $save_result      Result of save to database method.
	 *
	 * @dataProvider dp_ajax_callback
	 */
	public function test_ajax_callback( $email, $save_result ) {
		$db = Mockery::mock( Database::class );
		$db->shouldReceive( 'save' )->with( $email )->andReturn( $save_result );

		$subject = new Form( $db );

		WP_Mock::userFunction( 'check_ajax_referer' )->with( 'subscribe-form', 'nonce' );
		WP_Mock::userFunction( 'sanitize_email' )->with( $email )->andReturn( $email );

		FunctionMocker::replace(
			'filter_input',
			function ( $type, $var_name, $filter ) use ( $email ) {
				if ( INPUT_POST === $type && 'email' === $var_name && FILTER_SANITIZE_EMAIL === $filter ) {
					return $email;
				}

				return null;
			}
		);

		if ( ! $email ) {
			WP_Mock::userFunction( 'wp_send_json_error' )->with( 'Invalid email address', 400 )->once();
		}

		if ( 1 !== $save_result ) {
			WP_Mock::userFunction( 'wp_send_json_error' )->with( 'You are already a subscriber', 400 )->once();
		}

		WP_Mock::userFunction( 'wp_send_json_success' )->with( 'Thank you for subscribing to the newsletter' )->once();

		$subject->ajax_callback();
	}

	/**
	 * Data provider for test_ajax_callback().
	 *
	 * @return array[]
	 */
	public function dp_ajax_callback() {
		return [
			[ '', 0 ],
			[ '', 1 ],
			[ 'a@a.com', 0 ],
			[ 'a@a.com', 1 ],
		];
	}
}
