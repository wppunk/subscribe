<?php

namespace Subscribe\Tests\Acceptance;

use AcceptanceTester;

/**
 * Class SubmitCest
 */
class SubmitTimeoutCest {

	/**
	 * Succeeding subscribe.
	 *
	 * @param AcceptanceTester $I Tester.
	 */
	public function subscribe_success( AcceptanceTester $I ) {
		$I->amOnPage( '/subscribe/' );
		$I->wait( 1 );
		$I->fillField( '.subscribe-form [name="email"]', 'krya@krya.krya' );
		$I->wait( 1 );
		$I->click( '.subscribe-form [type="submit"]' );
		$I->wait( 1 );
		$I->waitForJqueryAjax( 1 );
		$I->wait( 1 );
		$I->see( 'Thank you for subscribing to the newsletter' );
		$I->wait( 1 );
		$I->seeElement( '.subscribe-message--success' );
		$I->wait( 1 );
		$I->dontSeeElement( '.subscribe-message--error' );
		$I->wait( 1 );
	}

	/**
	 * Failing to subscribe because subscriber already exists.
	 *
	 * @param AcceptanceTester $I Tester.
	 */
	public function subscriber_exists( AcceptanceTester $I ) {
		$I->amOnPage( '/subscribe/' );
		$I->wait( 1 );
		$I->fillField( '.subscribe-form [name="email"]', 'krya@krya.krya' );
		$I->wait( 1 );
		$I->click( '.subscribe-form [type="submit"]' );
		$I->wait( 1 );
		$I->waitForJqueryAjax( 1 );
		$I->wait( 1 );
		$I->click( '.subscribe-form [type="submit"]' );
		$I->wait( 1 );
		$I->waitForJqueryAjax( 1 );
		$I->wait( 1 );
		$I->see( 'You are already a subscriber' );
		$I->wait( 1 );
		$I->seeElement( '.subscribe-message--error' );
		$I->wait( 1 );
		$I->dontSeeElement( '.subscribe-message--success' );
	}

	/**
	 * Failing to subscribe because subscriber has invalid email address.
	 *
	 * @param AcceptanceTester $I Tester.
	 */
	public function subscriber_with_invalid_email( AcceptanceTester $I ) {
		$I->amOnPage( '/subscribe/' );
		$I->wait( 1 );
		$I->fillField( '.subscribe-form [name="email"]', 'krya@krya' );
		$I->wait( 1 );
		$I->click( '.subscribe-form [type="submit"]' );
		$I->wait( 1 );
		$I->waitForJqueryAjax( 1 );
		$I->wait( 1 );
		$I->see( 'Invalid email address' );
		$I->wait( 1 );
		$I->seeElement( '.subscribe-message--error' );
		$I->wait( 1 );
		$I->dontSeeElement( '.subscribe-message--success' );
		$I->wait( 1 );
	}
}
