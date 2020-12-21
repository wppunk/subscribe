<?php
/**
 * Frontend class file.
 *
 * @package Subscribe
 */

namespace Subscribe;

/**
 * Class Frontend
 */
class Frontend {

	/**
	 * Add hooks.
	 */
	public function add_hooks() {

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Enqueue styles.
	 */
	public function enqueue_styles() {

		wp_enqueue_style(
			'subscribe',
			SUBSCRIBE_URL . 'assets/css/main.css',
			[],
			SUBSCRIBE_VERSION,
		);
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {

		wp_enqueue_script(
			'subscribe',
			SUBSCRIBE_URL . 'assets/js/main.js',
			[ 'jquery' ],
			SUBSCRIBE_VERSION,
			true
		);
		wp_localize_script(
			'subscribe',
			'subscribeVars',
			[
				'adminUrl' => admin_url( 'admin-ajax.php' ),
			]
		);
	}
}
