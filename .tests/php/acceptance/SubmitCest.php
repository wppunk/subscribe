<?php

namespace Subscribe\Tests\Acceptance;

use AcceptanceTester;

/**
 * Class SubmitCest
 */
class SubmitCest {

	/**
	 * Succeeding subscribe.
	 *
	 * @param AcceptanceTester $I Tester.
	 */
	public function subscribe_success( AcceptanceTester $I ) {
		$I->amOnPage( '/subscribe/' );
		$I->fillField( '.subscribe-form [name="email"]', 'krya@krya.krya' );
		$I->click( '.subscribe-form [type="submit"]' );
		$I->waitForJqueryAjax( 1 );
		$I->see( 'Thank you for subscribing to the newsletter' );
		$I->seeElement( '.subscribe-message--success' );
		$I->dontSeeElement( '.subscribe-message--error' );
	}

	/**
	 * Failing to subscribe because subscriber already exists.
	 *
	 * @param AcceptanceTester $I Tester.
	 */
	public function subscriber_exists( AcceptanceTester $I ) {
		$I->amOnPage( '/subscribe/' );
		$I->fillField( '.subscribe-form [name="email"]', 'krya@krya.krya' );
		$I->click( '.subscribe-form [type="submit"]' );
		$I->waitForJqueryAjax( 1 );
		$I->click( '.subscribe-form [type="submit"]' );
		$I->waitForJqueryAjax( 1 );
		$I->see( 'You are already a subscriber' );
		$I->seeElement( '.subscribe-message--error' );
		$I->dontSeeElement( '.subscribe-message--success' );
	}

	/**
	 * Failing to subscribe because subscriber has invalid email address.
	 *
	 * @param AcceptanceTester $I Tester.
	 */
	public function subscriber_with_invalid_email( AcceptanceTester $I ) {
		$I->amOnPage( '/subscribe/' );
		$I->fillField( '.subscribe-form [name="email"]', 'krya@krya' );
		$I->click( '.subscribe-form [type="submit"]' );
		$I->waitForJqueryAjax( 1 );
		$I->see( 'Invalid email address' );
		$I->seeElement( '.subscribe-message--error' );
		$I->dontSeeElement( '.subscribe-message--success' );
	}
}
