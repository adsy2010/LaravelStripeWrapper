# Laravel Stripe Wrapper
Laravel stripe wrapper intends to take the hassle out of setting up credentials and communicating them to the Stripe API.

To install from composer run the following (not live yet)

    composer require adsy2010/laravelstripewrapper

Add the provider to your service providers array in config/app.php

        'providers' => [
            ...
            \Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperServiceProvider::class,
            ...
        ]

Finally, publish the migrations

    php artisan vendor:publish --provider=Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperServiceProvider


## Usage

Coming soon!

### Products
### Customers
### Payments
