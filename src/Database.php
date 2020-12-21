<?php
/**
 * Database class file.
 *
 * @package Subscribe
 */

namespace Subscribe;

/**
 * Class Database
 */
class Database {

	/**
	 * Create table.
	 */
	public static function create_table() {

		global $wpdb;

		$sql = 'CREATE TABLE ' . self::table_name() . '(
    		`email` VARCHAR(36) NOT NULL UNIQUE
		) ' . $wpdb->get_charset_collate();

		if ( ! function_exists( 'maybe_create_table' ) ) {
			// @codeCoverageIgnoreStart
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			// @codeCoverageIgnoreEnd
		}
		maybe_create_table( self::table_name(), $sql );
	}

	/**
	 * Save email to db.
	 *
	 * @param string $email Email.
	 *
	 * @return bool|int
	 */
	public function save( $email ) {

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
		return $wpdb->insert(
			self::table_name(),
			[
				'email' => sanitize_email( $email ),
			]
		);
	}

	/**
	 * Get table name.
	 *
	 * @return string
	 */
	private static function table_name() {

		global $wpdb;

		return $wpdb->prefix . 'subscribers';
	}
}
