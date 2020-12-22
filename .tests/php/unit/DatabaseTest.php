<?php
/**
 * DatabaseTest class file.
 *
 * @package Subscribe\Tests
 */

namespace Subscribe\Tests\Unit;

use Subscribe\Database;

use Mockery;
use WP_Mock;
use wpdb;

/**
 * Class DatabaseTest
 */
class DatabaseTest extends SubscribeTestCase {

	/**
	 * Finish test.
	 */
	public function tearDown(): void {
		unset( $GLOBALS['wpdb'] );
		parent::tearDown();
	}

	/**
	 * Tests create_table().
	 */
	public function test_create_table() {
		global $wpdb;

		$prefix     = 'wp_';
		$table_name = $prefix . 'subscribers';
		$collate    = 'DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci';
		$sql        = 'CREATE TABLE ' . $table_name . '(
    		`email` VARCHAR(36) NOT NULL UNIQUE
		) ' . $collate;

		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$wpdb         = Mockery::mock( wpdb::class );
		$wpdb->prefix = $prefix;
		$wpdb
			->shouldReceive( 'get_charset_collate' )
			->andReturn( $collate );

		WP_Mock::userFunction( 'maybe_create_table' )->with( $table_name, $sql );

		Database::create_table();
	}

	/**
	 * Test save().
	 */
	public function test_save() {
		global $wpdb;

		$prefix     = 'wp_';
		$table_name = $prefix . 'subscribers';
		$email      = 'a@a.com';
		$expected   = 1;

		WP_Mock::passthruFunction( 'sanitize_email' );

		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$wpdb         = Mockery::mock( wpdb::class );
		$wpdb->prefix = $prefix;
		$wpdb
			->shouldReceive( 'insert' )
			->with( $table_name, [ 'email' => $email ] )
			->andReturn( $expected );

		$subject = new Database();

		$this->assertSame( $expected, $subject->save( $email ) );
	}
}
