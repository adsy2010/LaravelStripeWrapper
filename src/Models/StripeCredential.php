<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

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
    protected $guarded = ['id','value'];


    /**
     * @param array $data
     * @param array $scopes
     * @throws StripeScopeRequiredException
     */
    public function store(array $data)
    {

        $key = $data['key']; //friendly name for key
        $value = $data['value']; //encrypted here

        $encrypted = encrypt($value);

        $this->key = $key;
        $this->value = $encrypted;

        $this->save();

        return $this;
    }

    public function includeScopes($scopes = [StripeScope::PUBLISHABLE], $access = 'r')
    {
        if(count($scopes) === 0) {
            throw new StripeScopeRequiredException();
        }

        foreach ($scopes as $scope) {
            (new StripeCredentialScope)->create(['stripe_credentials_id' => $this->id, 'stripe_scope_id' => $scope, 'access' => $access]);
        }

        return $this;
    }


}
