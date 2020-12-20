/* global subscribeVars */

'use strict';

jQuery( function( $ ) {

	const $form = $( '.subscribe-form' );
	$form.on( 'submit', function( e ) {
		const $message = $( this ).find( '.subscribe-message' );

		e.preventDefault();

		if ( $form.hasClass( 'submitting' ) ) {
			return;
		}

		$.ajax( {
			url: subscribeVars.adminUrl,
			method: 'POST',
			data: {
				'action': 'subscribe_form',
				'nonce': $( this ).find( '[name="subscribe_nonce"]' ).val(),
				'email': $( this ).find( '[name="email"]' ).val(),
			},
			beforeSend: function( xhr ) {
				$form.addClass( 'submitting' );
				$message.removeClass( 'subscribe-message--success', 'subscribe-message--error' ).slideUp();
			},
			success: function( response ) {
				$message.text( response.data ).addClass( 'subscribe-message--success' ).slideDown();
			},
			error: function( response ) {
				$message.text( response.responseJSON.data ).addClass( 'subscribe-message--error' ).slideDown();
			},
			complete: function() {
				$form.removeClass( 'submitting' );
			},
		} );
	} );
} );
