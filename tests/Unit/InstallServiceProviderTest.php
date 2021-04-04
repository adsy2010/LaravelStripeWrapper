<?php

namespace Adsy2010\LaravelStripeWrapper\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tests\TestCase;


class InstallServiceProviderTest extends TestCase
{

    private $migrations =
        [
            'migrations/2021_03_31_192847_create_stripe_products_table.php',
            'migrations/2021_03_31_194629_create_stripe_credentials_table.php',
            'migrations/2021_03_31_195232_create_stripe_credential_scopes_table.php',
            'migrations/2021_03_31_195643_create_stripe_scopes_table.php'
        ];


    /**
     * @test
     */
    function the_publish_command_copies_the_migrations()
    {
        //Ensure none exist
        $this->the_migrations_are_deleted();

        //Publish the provider
        Artisan::call('vendor:publish',['--provider'=>'Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperServiceProvider']);

        $this->the_migrations_exist_in_the_migrations_folder();

        $this->the_migrations_are_deleted();
    }

    function the_migrations_exist_in_the_migrations_folder()
    {
        foreach ($this->migrations as $file) {
            $this->assertTrue(File::exists(database_path($file)));
        }
    }

    /**
     * @test
     */
    function the_migrations_are_deleted()
    {
        foreach ($this->migrations as $file) {
            if (File::exists(database_path($file))) {
                unlink(database_path($file));
            }
        }

        foreach ($this->migrations as $file) {
            $this->assertFalse(File::exists(database_path($file)));
        }
    }

    /**
     * @test
     */
    function the_app_config_contains_the_service_provider()
    {
        $config = include config_path('app.php');

        $providerName = \Adsy2010\LaravelStripeWrapper\LaravelStripeWrapperServiceProvider::class;

        $this->assertTrue(in_array($providerName, $config['providers']));
    }
}
