# Automated testing

## Install project

1. Clone repository to `wp-content/plugins`
2. Run `composer install` inside folder `wp-content/subscribe/`

We are using for automated testing a Codeception library runs all types of PHP tests.

## PHP unit tests

For running use a CLI command:
```
composer unit
```

- Main configuration file `.tests/php/unit.suite.yml`
- Unit tests inside `.tests/php/unit/*` folder.
- Bootstrap file `.tests/php/unit/_bootstrap.php`
- Each filename for test class must have a suffix on `*Test.php`.
- Each test class must extend a `PluginNameUnitTests\TestCase` class.
- You can also add some code to `PluginNameUnitTests\TestCase.php`
- Each test method must have prefix `test_`
- Additional files for autoloading in tests running you can add to `.codeception/_support/*` folder.

Also, unit tests will be checked on a push to repository action and inside the GH Actions pipeline.

## PHP integration tests

- Main configuration file `.tests/php/integration.suite.yml`
- Unit tests inside `.tests/php/integration/*` folder.
- Each filename for test class must have a suffix on `*Test.php`.
- Each test method must have prefix `test_`
- Additional files for autoloading in tests running you can add to `.codeception/_support/*` folder.

Before running, you need to (It needs to make just one time. I hope you can do it):
1. Create a new database. For example, I named a database `codeception_db`
2. Install a clear WordPress
3. Export database to `dump.sql`
4. Move a `dump.sql` file to the `.codeception/_data/` folder.
5. Copy a file `.codeception/_config/params.example.php` to `.codeception/_config/params.local.php`.
6. Update your connection information to the testing site connection in `.codeception/_config/params.local.php` file.
7. Update your `wp-config.php` file:
```php
if ( 
    isset( $_SERVER['HTTP_X_TESTING'] )
    || ( isset( $_SERVER['HTTP_USER_AGENT'] ) && $_SERVER['HTTP_USER_AGENT'] === 'wp-browser' )
    || getenv( 'WPBROWSER_HOST_REQUEST' )
) {
    // Use the test database if the request comes from a test.
    define( 'DB_NAME', 'codeception_db' );
} else {
    // Else use the default one (insert your local DB name here).
    define( 'DB_NAME', 'local' );
}
```

For running use a CLI command:
```
composer integration
```

Also, integration tests will be checked on a push to repository action and inside the GH Actions pipeline.

## PHP acceptance tests

**Warning!** The acceptance tests make REAL actions on your site. Before running need to create another database and create a `dump.sql` file with fresh WP install.

Before running, you need to (It needs to make just one time. I hope you can do it):
1. Install a [ChromeDriver](https://chromedriver.chromium.org/downloads)
2. Create a new database. For example, I named a database `codeception_db`
3. Install a clear WordPress
4. Export database to `dump.sql`
5. Move a `dump.sql` file to the `.codeception/_data/` folder.
6. Copy a file `.codeception/_config/params.example.php` to `.codeception/_config/params.local.php`.
7. Update your connection information to the testing site connection in `.codeception/_config/params.local.php` file.
8. Update your `wp-config.php` file:
```php
if ( 
    isset( $_SERVER['HTTP_X_TESTING'] )
    || ( isset( $_SERVER['HTTP_USER_AGENT'] ) && $_SERVER['HTTP_USER_AGENT'] === 'wp-browser' )
    || getenv( 'WPBROWSER_HOST_REQUEST' )
) {
    // Use the test database if the request comes from a test.
    define( 'DB_NAME', 'codeception_db' );
} else {
    // Else use the default one (insert your local DB name here).
    define( 'DB_NAME', 'local' );
}
```

For running use a CLI command:
```
composer acceptance
```

- Main configuration file `.tests/php/acceptance.suite.yml`
- Unit tests inside `.tests/php/acceptace/*` folder.
- Each filename for test class must have a suffix on `*Cest.php`.
- Each test method must have prefix `test_`
- Each test method must include `AcceptanceTester` as argument.
- You can add some methods to AcceptanceTester in `.codeception/_support/AcceptanceTests.php`.
- Additional files for autoload in tests running you can add to `.codeception/_support/*` folder.
