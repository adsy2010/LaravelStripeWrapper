# Laravel Stripe Wrapper
Laravel stripe wrapper intends to take the hassle out of setting up credentials and communicating them to the Stripe API.

To install from composer run the following (not live yet)

    composer require adsy2010/laravelstripewrapper

Add the provider to your service providers array in `config/app.php`

```php
'providers' => [
    ...
    \Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperServiceProvider::class,
    ...
],
```

If you would like to use the full set of migrations without publishing them, add the following service provider
to your service providers array in `config/app.php`

```php
'providers' => [
    ...
    \Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperServiceProvider::class,
    \Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperMigrationServiceProvider::class,
    ...
],
```

Finally, publish the migrations

```bash
php artisan vendor:publish --provider=Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperServiceProvider
```

Optionally, you can skip publishing all migrations and run the tag to publish the required migrations

```bash
php artisan vendor:publish --tag='credential-migrations'
php artisan vendor:publish --tag='customer-migrations'
php artisan vendor:publish --tag='product-migrations'
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

If you only wish to use the credentials feature of this package, you may do so by utilising the following code:

```php
$stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET], 'w');
```

This code will retrieve any api key in the database that matches the specified scopes and create a `\Stripe\StripeClient` instance from the `stripe/stripe-php` library. 

### Products

Coming soon!

### Customers

Coming soon!

### Payments

Coming soon!
