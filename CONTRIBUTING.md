# Contributing

## Library Organization

The library's directory structure is set up to conform to the
[Standard PHP Skeleton][standard-php-skeleton] specification.

The Composer script names are according to the
[Composer Script Names][composer-script-names] specification.

How the package works is explained below:

- The Laravel services are bootstrapped in a minimal **bootstrap/app.php**.
- Autodiscovered service providers are loaded into
  **bootstrap/cache/packages.php** and **bootstrap/cache/services.php** files by
  the `post-autoload-dump` hook defined in **composer.json**. The contents of
  **bootstrap/cache** are ignored by Git.
- A minimal **.env** is necessary for running tests and migrations. This file
  is not ignored by Git, but included in the package. It does not contain any secrets.
- A **database/database.sqlite** is created automatically after running
  `composer install` using the `post-install-cmd` hook defined in
  **composer.json**. It is referenced by the **.env** file, but ignored by
  Git. It is needed by some services like Cache to store the cache database
  table. That is why a migration for that table is included.
- Tests are run using an in-memory SQLite database.

## Prerequisites

To contribute to this project, you will need:

-   PHP 8.3+
-   XDebug Extension for PHP
-   Composer

For installing additional versions of PHP on the Ubuntu operating system, read
[How to run multiple PHP versions on Ubuntu][multiple-php] on Digital Ocean's community
portal. The article covers PHP 7.0 and 7.2 on Ubuntu 18.04, but it is also
applicable to other PHP and Ubuntu versions.

Composer can just be installed with from the Ubuntu repositories. If the version
in the Ubuntu repositories is too old, you can run:

```bash
composer self-update
```

Also consult [Composer's documentation][composer] for more information.

## Obtain Source Code

Clone the source code from GitHub:

```bash
git clone https://github.com/spoorsny/laravel-model-validating-observer
```

Install the Composer dependencies:

```bash
cd laravel-model-validating-observer
composer install
```

## Code Style

The library follows the [PSR 12][psr12] coding standard. To automatically update the
source code to meet this standard, issue command:

```bash
composer cs-fix
```

## Testing & Code Coverage

The library has tests located in the **tests** that are based on [PHPUnit][phpunit]. To
run the tests, from the root of the repository, issue command:

```bash
composer test
```

To also see what percentage of the source code gets executed when the tests are
run, issue command:

```bash
composer test-coverage
```

## GitHub Actions Workflows

When a pull request is made, a _Continuous Integration_ GitHub Actions workflow
is automatically started, which:

-   lints the source code, fixing the code style and automatically creating a new commit
-   runs the tests
-   checks the code coverage to be 100%

All three jobs must be successful before the pull request can be merged. The
workflow is run again on the `master` branch after the pull request is merged.

[multiple-php]: https://www.digitalocean.com/community/tutorials/how-to-run-multiple-php-versions-on-one-server-using-apache-and-php-fpm-on-ubuntu-18-04
[composer]: https://getcomposer.org
[phpunit]: https://phpunit.de
[standard-php-skeleton]: https://github.com/php-pds/skeleton
[composer-script-names]: https://github.com/php-pds/composer-script-names/tree/1.0.0
[psr12]: https://www.php-fig.org/psr/psr-12/
