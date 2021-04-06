<?php

namespace Adsy2010\LaravelStripeWrapper;

use Illuminate\Support\ServiceProvider;

class LaravelStripeWrapperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/database/migrations/credentials' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/database/migrations/credentials' => database_path('migrations')
        ], 'credential-migrations');

        $this->publishes([
            __DIR__.'/database/migrations/customers' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/database/migrations/customers' => database_path('migrations')
        ], 'customer-migrations');

        $this->publishes([
            __DIR__.'/database/migrations/products' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/database/migrations/products' => database_path('migrations')
        ], 'product-migrations');
    }
}
