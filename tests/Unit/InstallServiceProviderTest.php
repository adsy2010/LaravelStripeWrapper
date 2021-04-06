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
            'migrations/2021_03_31_195643_create_stripe_scopes_table.php',
            'migrations/2021_03_31_200019_create_stripe_customers_table.php',
            'migrations/2021_04_06_195700_create_stripe_customers_address_table.php',
            'migrations/2021_04_06_195943_create_stripe_customers_shipping_details_table.php',
            'migrations/2021_04_06_200024_create_stripe_customers_address_types_table.php',
            'migrations/2021_04_06_200403_create_stripe_customers_invoice_settings_table.php',
            'migrations/2021_04_06_200521_create_stripe_customers_payment_sources_table.php',
            'migrations/2021_04_06_200536_create_stripe_customers_subscriptions_table.php',
            'migrations/2021_04_06_200618_create_stripe_customers_tax_ids_table.php',
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

        $this->the_migrations_exist_in_the_migrations_folder($this->migrations);

        $this->the_migrations_are_deleted();
    }

    /**
     * @test
     */
    function the_publish_tag_command_copies_the_product_migrations()
    {
        $productMigrations = ['migrations/2021_03_31_192847_create_stripe_products_table.php'];

        //Ensure none exist
        $this->the_migrations_are_deleted($productMigrations);

        //Publish the provider
        Artisan::call('vendor:publish',['--tag'=>'product-migrations']);

        $this->the_migrations_exist_in_the_migrations_folder($productMigrations);

        $this->the_migrations_are_deleted($productMigrations);
    }

    /**
     * @test
     */
    function the_publish_tag_command_copies_the_customer_migrations()
    {
        $customerMigrations = [
            'migrations/2021_03_31_200019_create_stripe_customers_table.php',
            'migrations/2021_04_06_195700_create_stripe_customers_address_table.php',
            'migrations/2021_04_06_195943_create_stripe_customers_shipping_details_table.php',
            'migrations/2021_04_06_200024_create_stripe_customers_address_types_table.php',
            'migrations/2021_04_06_200403_create_stripe_customers_invoice_settings_table.php',
            'migrations/2021_04_06_200521_create_stripe_customers_payment_sources_table.php',
            'migrations/2021_04_06_200536_create_stripe_customers_subscriptions_table.php',
            'migrations/2021_04_06_200618_create_stripe_customers_tax_ids_table.php',
        ];

        //Ensure none exist
        $this->the_migrations_are_deleted($customerMigrations);

        //Publish the provider
        Artisan::call('vendor:publish',['--tag'=>'customer-migrations']);

        $this->the_migrations_exist_in_the_migrations_folder($customerMigrations);

        $this->the_migrations_are_deleted($customerMigrations);
    }

    /**
     * @test
     */
    function the_publish_tag_command_copies_the_credentials_migrations()
    {
        $credentialsMigrations = [
            'migrations/2021_03_31_194629_create_stripe_credentials_table.php',
            'migrations/2021_03_31_195232_create_stripe_credential_scopes_table.php',
            'migrations/2021_03_31_195643_create_stripe_scopes_table.php',
        ];

        //Ensure none exist
        $this->the_migrations_are_deleted($credentialsMigrations);

        //Publish the provider
        Artisan::call('vendor:publish',['--tag'=>'credential-migrations']);

        $this->the_migrations_exist_in_the_migrations_folder($credentialsMigrations);

        $this->the_migrations_are_deleted($credentialsMigrations);
    }

    function the_migrations_exist_in_the_migrations_folder($migrations)
    {
        foreach ($migrations as $file) {
            $this->assertTrue(File::exists(database_path($file)));
        }
    }

    /**
     * @test
     * @param null $migrations
     */
    function the_migrations_are_deleted($migrations = null)
    {
        if($migrations === null) {

            $migrations = $this->migrations;

        }


        foreach ($migrations as $file) {
            if (File::exists(database_path($file))) {
                unlink(database_path($file));
            }
        }

        foreach ($migrations as $file) {
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
