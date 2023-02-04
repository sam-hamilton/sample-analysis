### Brief

Scientists want to be able to send urine test samples to an algorithm for analysis and then be able to view the responses
in a dashboard.

### Core functionality

The main features are;

* Upload an image of a test strip
* Analysing the uploaded test strips via an API
* Listing all uploaded tests and results

### Technology

* PHP 7.4
* Laravel 8.38.0

### Getting up and running

* run `php artisan storage:link` to symlink the public storage directories
* run the seeders to get some dummy data (including logins for convenience)
* login with jon@example.com or richard@example.com and ‘password’

### Tests

The application has feature and integration tests built using PHPUnit. To run the test suite use `php artisan test` or `php vendor/bin/phpunit`
