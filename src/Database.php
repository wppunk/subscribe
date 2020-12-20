<?php

namespace Subscribe;

class Database {

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

	public function save( $email ) {

		global $wpdb;
		return $wpdb->insert(
			self::table_name(),
			[
				'email' => sanitize_email( $email ),
			]
		);
	}

	private static function table_name() {

		global $wpdb;

		return $wpdb->prefix . 'subscribers';
	}
}
