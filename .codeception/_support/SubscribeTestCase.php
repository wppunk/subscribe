<?php
/**
 * SubscribeTestCase class file.
 *
 * @package Subscribe\Tests
 */

namespace Subscribe\Tests;

use PHPUnit\Framework\TestCase;
use Mockery;
use tad\FunctionMocker\FunctionMocker;
use WP_Mock;

/**
 * Class SubscribeTestCase
 */
class SubscribeTestCase extends TestCase {

	/**
	 * Setup test
	 */
	public function setUp(): void {
		FunctionMocker::setUp();
		parent::setUp();
		WP_Mock::setUp();
	}

	/**
	 * End test
	 */
	public function tearDown(): void {
		WP_Mock::tearDown();
		Mockery::close();
		parent::tearDown();
		FunctionMocker::tearDown();
	}
}
