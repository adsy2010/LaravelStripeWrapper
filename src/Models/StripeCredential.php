<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Adsy2010\LaravelStripeWrapper\Exceptions\StripeCredentialsMissingException;
use Adsy2010\LaravelStripeWrapper\Exceptions\StripeScopeRequiredException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StripeCredential
 * @package Adsy2010\LaravelStripeWrapper\Models
 * @mixin Builder
 */
class StripeCredential extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['key', 'value'];
    protected $guarded = ['id', 'value'];


    /**
     * Stores an encrypted stripe api key value against a custom key name
     *
     * @example StripeCredential::store(['key' => My friendly key', 'value' => 'THE_API_KEY_TO_STORE'])
     *
     * @param array $data A key and value pair in an array
     * @return StripeCredential The created stripe credential
     * @throws StripeCredentialsMissingException
     */
    public function store(array $data): StripeCredential
    {
        if(!isset($data['key']) || !isset($data['value'])) {

            throw new StripeCredentialsMissingException();

        }

        $key = $data['key']; //friendly name for key
        $value = $data['value']; //encrypted here

        //encrypt the api key value
        $encrypted = encrypt($value);

        $this->key = $key;
        $this->value = $encrypted;

        $this->save();

        return $this;
    }

    /**
     * Added scopes to stored credentials. Chainable with store method.
     *
     * @param array $scopes An array of scopes
     * @param string $access The access level of the scopes supplied (read or write). Allowed options: r | w
     * @return $this
     * @throws StripeCredentialsMissingException
     * @throws StripeScopeRequiredException
     *
     * @example StripeCredential::store(...)->includeScopes([StripeScope::PUBLISHABLE], 'w')
     *
     */
    public function includeScopes(array $scopes = [StripeScope::PUBLISHABLE], string $access = 'r'): StripeCredential
    {
        //Check to ensure an id exists
        if (!isset($this->id) || empty($this->id)) {

            throw new StripeCredentialsMissingException();

        }

        //An empty array was supplied
        if (count($scopes) === 0) {

            throw new StripeScopeRequiredException();

        }

        //Create a credential scope for each scope provided with the access type provided
        foreach ($scopes as $scope) {

            (new StripeCredentialScope)->create(['stripe_credentials_id' => $this->id, 'stripe_scope_id' => $scope, 'access' => $access]);

        }

        return $this;
    }


}
