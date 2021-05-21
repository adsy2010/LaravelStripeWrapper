<?php

namespace Adsy2010\LaravelStripeWrapper\Tests\Unit;
use Adsy2010\LaravelStripeWrapper\Models\StripeCredential;
use Adsy2010\LaravelStripeWrapper\Models\StripeCustomer;
use Adsy2010\LaravelStripeWrapper\Models\StripeScope;
use Tests\TestCase;


class StripeCustomerTest extends TestCase
{
    /**
     * @test
     */
    function the_stripe_customer_is_created_on_stripe()
    {
        $customer = ['email' => 'test@example.com', 'name' => 'Bob Smith'];

        $secretCredentials = (new StripeCredential)
            ->store(['key' => 'secret', 'value' => env('STRIPE_SECRET_KEY')])
            ->includeScopes([StripeScope::SECRET], 'w');

        $createdCustomer = (new StripeCustomer)->store($customer);

        $this->the_stripe_customer_exists($createdCustomer);

        $this->the_stripe_customer_is_deleted($createdCustomer->id);

        $secretCredentials->delete();
    }

    /**
     * @test
     */
    function the_stripe_customer_is_created_on_stripe_and_locally()
    {
        $customer = [
            'email' => 'test@example.com',
            'name' => 'Bob Smith',
            'address' => [
                'line1' => 'First line of address',
                'line2' => 'Second line of address',
                'city' => 'Some City',
                'postal_code' => 'AB12 3RD'
            ],
            'shipping' => [
                'name' => 'Bob Smith',
                'address' => [
                    'line1' => 'First line of address',
                    'line2' => 'Second line of address',
                    'city' => 'Some City',
                    'postal_code' => 'AB12 3RD'
                ],
            ]
        ];

        $secretCredentials = (new StripeCredential)
            ->store(['key' => 'secret', 'value' => env('STRIPE_SECRET_KEY')])
            ->includeScopes([StripeScope::SECRET], 'w');

        $createdCustomer = (new StripeCustomer)->store($customer, true);

        $this->the_stripe_customer_exists($createdCustomer);

        $localStripeCustomer = $this->the_stripe_customer_exists_locally($createdCustomer->id);

        $this->the_stripe_customer_is_deleted($createdCustomer->id, true);

        $this->assertSoftDeleted($localStripeCustomer);

        $secretCredentials->delete();
    }

    function the_stripe_customer_address_is_created($customer)
    {
        $this->assertArrayHasKey('address', $customer);
        $this->assertNotEmpty($customer['address']);
    }

    function the_stripe_customer_is_deleted($id, $store = false)
    {
        $stripeCustomer = (new StripeCustomer)->trash($id, $store);

        $this->assertTrue($stripeCustomer->deleted);
    }

    function the_stripe_customer_exists($customer)
    {
        $this->assertArrayHasKey('id', $customer);
    }

    function the_stripe_customer_exists_locally($stripeCustomerId)
    {
        $localStripeProduct = StripeCustomer::find($stripeCustomerId);

        $this->assertTrue($stripeCustomerId === $localStripeProduct->id);

        return $localStripeProduct;
    }
}
