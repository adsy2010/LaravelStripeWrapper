<?php

namespace Adsy2010\LaravelStripeWrapper\Tests\Unit;

use Adsy2010\LaravelStripeWrapper\Exceptions\StripeCredentialsMissingException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeScopeRequiredException;
use Adsy2010\LaravelStripeWrapper\Models\StripeCredential;
use Adsy2010\LaravelStripeWrapper\Models\StripeCredentialScope;
use Adsy2010\LaravelStripeWrapper\Models\StripeScope;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tests\TestCase;


class StripeCredentialTest extends TestCase
{

    private $credentials;
    private $credentialScopes;

    /**
     * @test
     */
    function the_stripe_credential_without_scopes_is_created()
    {
        /** setup test data */

        //Set a fake API key
        $stripeApiKey = 'pk_test_publishable-key-test-code';

        //Set a friendly key name
        $stripeApiFriendlyKeyName = 'test_friendly_name';

        //Create the credential in the database
        $credential = (new StripeCredential)->store([
            'key' => $stripeApiFriendlyKeyName,
            'value' => $stripeApiKey
        ]);

        //Check the stored friendly key is the same as the one we set
        $key = ($credential->key === $stripeApiFriendlyKeyName);

        //Check the stored encrypted value is not the same as the one we set
        $value = ($credential->value === encrypt($stripeApiKey));

        //Check the decrypted values match
        $decrypted = (decrypt($credential->value) === $stripeApiKey);

        //Run assertions
        $this->assertTrue($key);
        $this->assertFalse($value);
        $this->assertTrue($decrypted);

        //We don't need it stored so delete it
        $credential->forceDelete();

        //Assert deleted
        $this->assertDeleted($credential);
    }

    /**
     * @test
     */
    function the_stripe_credential_with_scopes_is_created()
    {
        /** setup test data */

        //Set a fake API key
        $stripeApiKey = 'pk_test_publishable-key-test-code';

        //Set a friendly key name
        $stripeApiFriendlyKeyName = 'test_friendly_name';

        //Scope list
        $writableScopes = [StripeScope::SECRET, StripeScope::PRODUCTS, StripeScope::CHECKOUT_SESSIONS];
        $readableScopes = [StripeScope::CUSTOMERS];

        //Create the credential in the database with scopes
        $this->credentials = (new StripeCredential)->store([
            'key' => $stripeApiFriendlyKeyName,
            'value' => $stripeApiKey
        ])
            ->includeScopes($writableScopes, 'w')
            ->includeScopes($readableScopes);


        //Check the stored friendly key is the same as the one we set
        $key = ($this->credentials->key === $stripeApiFriendlyKeyName);

        //Check the stored encrypted value is not the same as the one we set
        $value = ($this->credentials->value === encrypt($stripeApiKey));

        //Check the decrypted values match
        $decrypted = (decrypt($this->credentials->value) === $stripeApiKey);

        //Run assertions
        $this->assertTrue($key);
        $this->assertFalse($value);
        $this->assertTrue($decrypted);

        //Check the scopes have been added
        $this->credentials->load('stripeCredentialScope');

        $scopes = $this->credentials->stripeCredentialScope;

        $this->assertTrue((count($scopes) === 4));

        foreach ($scopes as $scope) {
            if($scope->access === 'r') {

                $this->assertTrue(in_array($scope->stripe_scope_id, $readableScopes));

            }

            if($scope->access === 'w') {

                $this->assertTrue(in_array($scope->stripe_scope_id, $writableScopes));

            }

        }


        //We don't need it stored so delete it
        $this->credentials->delete();

        //Assert soft deleted
        $this->assertSoftDeleted($this->credentials->stripeCredentialScope()->withTrashed());
        $this->assertSoftDeleted($this->credentials);

        //Lets load up the trash and delete permanently now
        $this->credentialScopes = StripeCredentialScope::where('stripe_credential_id','=',$this->credentials->id)->withTrashed()->get();

        foreach ($this->credentialScopes as $credentialScope) {

            $credentialScope->forceDelete();

            $this->assertDeleted($credentialScope);
        }

        $this->credentials->forceDelete();

        $this->assertDeleted($this->credentials);
    }

    /**
     * @test
     */
    function the_stripe_credential_exists()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    function the_stripe_credential_is_updated()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    function the_stripe_credential_is_deleted()
    {
        $this->assertTrue(true);
    }
}
