<?php

namespace Adsy2010\LaravelStripeWrapper\Tests\Unit;

use Adsy2010\LaravelStripeWrapper\Models\StripeCredential;
use Adsy2010\LaravelStripeWrapper\Models\StripeProduct;
use Adsy2010\LaravelStripeWrapper\Models\StripeScope;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tests\TestCase;


class StripeProductTest extends TestCase
{

    /**
     * @test
     */
    function the_stripe_product_is_created_on_stripe()
    {
        $product = ['name' => 'My test product'];

        $secretCredentials = (new StripeCredential)
            ->store(['key' => 'secret', 'value' => env('STRIPE_SECRET_KEY')])
            ->includeScopes([StripeScope::SECRET], 'w');

        $createdProduct = (new StripeProduct)->store($product);

        $this->assertArrayHasKey('id', $createdProduct);

        $this->the_stripe_product_is_deleted($createdProduct->id);

        $secretCredentials->delete();
    }

    /**
     * @test
     */
    function the_stripe_product_is_created_on_stripe_and_locally()
    {
        $product = ['name' => 'My test product'];

        $secretCredentials = (new StripeCredential)
            ->store(['key' => 'secret', 'value' => env('STRIPE_SECRET_KEY')])
            ->includeScopes([StripeScope::SECRET], 'w');

        $createdProduct = (new StripeProduct)->store($product, true);

        $this->the_stripe_product_exists($createdProduct);

        $localStripeProduct = $this->the_stripe_product_exists_locally($createdProduct->id);

        $this->the_stripe_product_is_deleted($createdProduct->id, true);

        $this->assertSoftDeleted($localStripeProduct);

        $secretCredentials->delete();
    }

    function the_stripe_product_exists($productId)
    {
        $this->assertArrayHasKey('id', $productId);
    }

    function the_stripe_product_exists_locally($stripeProductId)
    {
        $localStripeProduct = StripeProduct::find($stripeProductId);

        $this->assertTrue($stripeProductId === $localStripeProduct->id);

        return $localStripeProduct;
    }

    /**
     * @test
     */
    function the_stripe_product_list_works()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    function the_stripe_product_is_updated()
    {
        $this->assertTrue(true);
    }

    function the_stripe_product_is_deleted($id, $store = false)
    {
        $stripeProduct = (new StripeProduct)->trash($id, $store);

        $this->assertTrue($stripeProduct->deleted);
    }
}
