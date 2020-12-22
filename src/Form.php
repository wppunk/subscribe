<?php
/**
 * Form class file
 *
 * @package Subscribe
 */

namespace Subscribe;

use wpdb;

/**
 * Class Form
 */
class Form {

	/**
	 * Database class instance.
	 *
	 * @var Database
	 */
	private $database;

	/**
	 * Form constructor.
	 *
	 * @param Database $database Database class instance.
	 */
	public function __construct( Database $database ) {

		$this->database = $database;
	}

	/**
	 * Add hooks.
	 */
	public function add_hooks() {

		add_shortcode( 'subscribe_form', [ $this, 'view' ] );

		add_action( 'wp_ajax_subscribe_form', [ $this, 'ajax_callback' ] );
		add_action( 'wp_ajax_nopriv_subscribe_form', [ $this, 'ajax_callback' ] );
	}

	/**
	 * Output form.
	 */
	public function view() {

		ob_start();
		?>
		<form action="" method="POST" class="subscribe-form">
			<input type="hidden" name="subscribe_nonce" value="<?php echo esc_attr( wp_create_nonce( 'subscribe-form' ) ); ?>">
			<input type="email" name="email" required="required" placeholder="<?php esc_html_e( 'Your email address', 'subscribe' ); ?>">
			<input type="submit" value="<?php esc_html_e( 'Subscribe', 'subscribe' ); ?>">
			<div class="subscribe-message" style="display: none"></div>
		</form>
		<?php

		return ob_get_clean();
	}

	/**
	 * Ajax callback.
	 */
	public function ajax_callback() {

		check_ajax_referer( 'subscribe-form', 'nonce' );
		$email = sanitize_email( filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL ) );

		if ( empty( $email ) ) {
			wp_send_json_error( esc_html__( 'Invalid email address', 'subscribe' ), 400 );
		}

		if ( 1 !== $this->database->save( $email ) ) {
			wp_send_json_error( esc_html__( 'You are already a subscriber', 'subscribe' ), 400 );
		}

		wp_send_json_success(
			esc_html__( 'Thank you for subscribing to the newsletter' )
		);
	}
}
