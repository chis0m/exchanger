<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.


## Exchanger

This repository holds Exchanger backend codebase.

## Prerequisites

- Follow this [link](https://laravel.com/docs/8.x/installation#server-requirements) for basic setup
- Follow this [link](https://medium.com/@setkyarwalar/setting-up-phpcs-on-laravel-908bccb82db) to setup PHPCS
- Follow this [link](https://github.com/nunomaduro/larastan) to setup PHPStan

## Start up

To start Exchanger, perform the following step in the order

- Clone the repository by running the command 'git clone https://github.com/chis0m/exchanger.git'
- Run composer install --ignore-platform-reqs
- Run 'cp .env.example .env'
- Fill your configuration settings in the '.env' file you created above
- Run 'php artisan key:generate'
- Run php artisan jwt:secret
- Run 'php artisan migrate --seed'
- Run 'php artisan serve' to startup the application


## For development

To maintain quality, maintainability, reliability, security and uniform coding standards on this codebase, I ran the codebase against a static analysis tools, our choise are PHP Code Sniffer (PHPCS) and PHPStan, and I wrote tests.

- PHPCS  allows a set of rules or a standard to be applied to your codebase, it also helps detect violations of pre-defined coding standards. The good is, it includes an additional tool that can automatically correct those violations

- PHPStan focuses on finding errors in your code without actually running it. It catches whole classes of bugs even before you write tests for the code. It moves PHP closer to compiled languages in the sense that the correctness of each line of the code can be checked before you run the actual line.

## During Development

1. To collaborate in the project, create a branch from the *develop* after development.

2. Run './vendor/bin/phpstan analyse', to analyse the entire codebase OR './vendor/bin/phpstan analyse /path/to/folder' to analyse a particular folder OR './vendor/bin/phpstan analyse /path/to/file.php' to analyse a particular file  against PHPStan. Fix any errors that show up until you have a green stipe with '[OK] No errors' written on it.

3. Run './vendor/bin/phpcs', to analyse the entire codebase OR './vendor/bin/phpcs /path/to/folder' to analyse a particular folder OR './vendor/bin/phpcs /path/to/file.php' to analyse a particular file  against PHPStan. Fix any errors that show up until you have a clean slate of 100%.

4. Run 'php artisan test' to run all your test and make sure they pass.

5. When you are done with PHPstan, PHPCS and Test and everything works fine, please, go ahead and raise a pull request (PR), with *develop* as the target branch. For Every push github actions runs the test

6. Congratulations


## Test
1. create a database **exchanger_test** database as contained in .env.testing file. **Note**: I am using mysql instead of sqlite because it is more stable for testing. You can see more here: [why mysql is better at test](https://owenconti.com/posts/improve-performance-laravel-feature-tests-using-mysql-instead-of-sqlite-or-memory-databases/) 
2. grant permissions accordingly
3. Run **vendor/bin/phpunit** or just **phpunit** (if you added the above to your shell)


### Modules and Packages

- [Tymon](https://jwt-auth.readthedocs.io/en/docs/laravel-installation/)
- [Traits](https://www.php.net/manual/en/language.oop5.traits.php)
- [Api Resources](https://laravel.com/docs/7.x/eloquent-resources)