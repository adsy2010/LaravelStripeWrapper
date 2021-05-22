# Laravel Stripe Wrapper

Laravel stripe wrapper intends to take the hassle out of setting up credentials and communicating them to the Stripe
API.

To install from composer run the following (this is an alpha release and no automatic versions are available yet)

    composer require adsy2010/laravel-stripe-wrapper:v0.0.2-alpha

Add the provider to your service providers array in `config/app.php`

```php
'providers' => [
    ...
    \Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperServiceProvider::class,
    ...
],
```

If you would like to use the full set of migrations without publishing them, add the following service provider to your
service providers array in `config/app.php`

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

Note that by default, an added scope is read, if 'w' is specified as the access type, the api key scope will be
classified as writable.

If you only wish to use the credentials feature of this package, you may do so by utilising the following code:

```php
$stripe = StripeCredentialScope::client([StripeScope::PRODUCTS, StripeScope::SECRET], 'w');
```

This code will retrieve any api key in the database that matches the specified scopes and create
a `\Stripe\StripeClient` instance from the `stripe/stripe-php` library.

### Products

To Create a product on stripe, use the store method

```php
(new StripeProduct)->store(['name'=>'my test product']);
```

If you would like to utilise the local database when handling stripe products, add true to the end of the statement

```php
(new StripeProduct)->store(['name'=>'test product also stored locally'], true);
```

To retrieve a product from stripe, use the retrieve method.

```php
(new StripeProduct)->retrieve('prod_123456789'); //add true to update the local database
```

There is a retrieve all method which can get all products on stripe in one go optionally storing them.
The first argument is a list of parameters to filter by, so for example, all active products is shown below.

```php
(new StripeProduct)->retrieveAll(['active' => 1]);
```

If you want to store but not filter all records, you should enter an empty array with true
```php
(new StripeProduct)->retrieveAll([], true); //retrieve all with no filtering
```

To update a product in stripe, use the change method.

```php
(new StripeProduct)->change('prod_123456789', ['name'=>'new product name', ...]); //add true to update the local database
```

To delete a product from stripe, use the trash method.

```php
(new StripeProduct)->trash('prod_123456789'); //add true to update the local database
```

If you add true to the end of a retrieve statement, it will update records in the database from stripe

NOTE: If you want to use a local stripe products table, you should either use the migration provided or use one with the
same table name. All methods have an optional store attribute which, if set to true will update a local database version
of the product.

### Customers

Stripe customers <strong>are currently limited</strong> on the details that are held locally. Tax id data and payment methods features are not yet implemented. 
The default payment method ID however is included.

To create a customer on stripe, use the store method

```php
$customerDetails = [
    'email' => 'test@example.com',
    'name' => 'Bob Smith'
];

(new StripeCustomer)->store($customerDetails);
```

If you would like to utilise the local database when handling stripe customers, add true to the end of the statement

```php
$customerDetails = [
    'email' => 'test@example.com',
    'name' => 'Bob Smith'
];

(new StripeCustomer)->store($customerDetails, true);
```

To retrieve a customer from stripe use the retrieve method

```php
(new StripeCustomer)->retrieve('cust_123456789'); //add true to update the local database
```

There is a retrieve all method which can get all customers on stripe in one go optionally storing them. 
The first argument is a list of parameters to filter by, so for example, The latest 3 customers are retrieved below.

```php
(new StripeCustomer)->retrieveAll(['limit' => 3]); //add true to update the local database
```

If you want to store but not filter all records, you should enter an empty array with true

```php
(new StripeCustomer)->retrieveAll([], true); //retrieve all with no filtering
```

To update a customer in stripe, use the change method

```php
$newcustomerDetails = [
    'email' => 'test2@example.com',
    'name' => 'Bobby Smith'
];

(new StripeCustomer)->change('cust_123456789', $newCustomerData); //add true to update the local database
```

To delete a customer from stripe, use the trash method

```php
(new StripeCustomer)->trash('cust_123456789'); //add true to update the local database
```

NOTE: If you want to use a local stripe customers table, you should either use the migration provided or use one 
with the same table name. All methods have an optional store attribute which, if set to true will update a local 
database version of the product.

### Payments

Coming soon!
