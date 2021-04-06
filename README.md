# Laravel Stripe Wrapper
Laravel stripe wrapper intends to take the hassle out of setting up credentials and communicating them to the Stripe API.

To install from composer run the following (not live yet)

    composer require adsy2010/laravelstripewrapper

Add the provider to your service providers array in config/app.php

```php
'providers' => [
    ...
    \Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperServiceProvider::class,
    ...
],
```

Finally, publish the migrations

```bash 
php artisan vendor:publish --provider=Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperServiceProvider
```


## Usage


### Credentials

To add an api key to the database, you can run the following:

```php
(new StripeCredential)
    ->store(['key' => 'Public Key', 'value' => 'YOUR_STRIPE_PUBLIC_API_KEY_HERE'])
    ->includeScopes([StripeScope::PUBLISHABLE], 'w');

(new StripeCredential)
    ->store(['key' => 'Secret Key', 'value' => 'YOUR_SECRET_OR_RESTRICTED API_KEY'])
    ->includeScopes([StripeScope::SECRET], 'w')
    ->includeScopes([StripeScope::PRODUCTS, StripeScope::CHECKOUT_SESSIONS]);
```

Note that by default, an added scope is read, if 'w' is specified as the access type, the api key scope will be classified as writable.

### Products

Coming soon!

### Customers

Coming soon!

### Payments

Coming soon!
