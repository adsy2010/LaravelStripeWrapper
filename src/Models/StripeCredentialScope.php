<?php

namespace Adsy2010\LaravelStripeWrapper\Models;

use Adsy2010\LaravelStripeWrapper\Exceptions\StripeCredentialsMissingException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stripe\StripeClient;

class StripeCredentialScope extends Model
{
    use HasFactory;

    /**
     * Retrieves all credentials which match the scope and access level
     *
     * @param array $scopes
     * @param string $access r (read), w (write)
     * @return Builder[]|Collection
     */
    public static function retrieve(array $scopes, $access = 'r')
    {
        return StripeCredentialScope::with(['stripeCredential', 'stripeScope' => function ($query) use ($scopes) {
            $query->whereIn('name', $scopes);
        }])->where('access', '=', $access)->get();
    }

    /**
     * Creates a stripe client from the scope and access provided
     *
     * @param array $scopes
     * @param string $access
     * @return StripeClient
     * @throws StripeCredentialsMissingException
     */
    public static function client(array $scopes, $access = 'r'): StripeClient
    {
        $credentials = self::retrieve($scopes, $access);

        if(!(count($credentials) > 0)){
            throw new StripeCredentialsMissingException();
        }

        $credential = $credentials->first();

        return new StripeClient(decrypt($credential->stripeCredential->value));
    }

    /**
     * @return BelongsTo
     */
    public function stripeScope(): BelongsTo
    {
        return $this->belongsTo(StripeScope::class);
    }

    /**
     * @return BelongsTo
     */
    public function stripeCredential(): BelongsTo
    {
        return $this->belongsTo(StripeCredential::class);
    }
}
